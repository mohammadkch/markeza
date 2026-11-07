const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');
const source = fs.readFileSync(path.join(__dirname, '../../public/assets/admin/custom.js'), 'utf8');

function setup(section = 'product') {
    const form = { values: [['title', 'Sofa'], ['is_active', '0'], ['slug', '']] };
    const result = { innerHTML: 'original', setAttribute() {}, removeAttribute() {} };
    class FormData {
        constructor(element) { this.values = element ? [...element.values] : []; }
        entries() { return this.values.values(); }
        append(key, value) { this.values.push([key, value]); }
    }
    const history = [];
    const context = vm.createContext({ URL, FormData, AbortController,
        console: { error() {} },
        document: { addEventListener() {}, getElementById: id => id === 'searchForm' ? form : result },
        window: { location: { href: `http://localhost/admin/${section}?page=2` }, history: { pushState: (_, __, url) => history.push(url) } },
    });
    vm.runInContext(source, context);
    context.bindDeleteButtons = () => {};
    context.bindToggleActiveButtons = () => {};
    context.showNotification = () => {};
    return { context, form, result, history };
}

for (const section of ['product', 'collection']) {
    test(`${section}: page 3 is sent in URL and replaces table without reload`, async () => {
        const { context, result, history } = setup(section);
        context.fetch = async (url, options) => {
            assert.equal(new URL(url).searchParams.get('page'), '3');
            assert.equal(options.method, 'POST');
            assert.equal(options.headers['X-Requested-With'], 'XMLHttpRequest');
            assert.deepEqual(options.body.values, [['title', 'Sofa'], ['is_active', '0']]);
            return { ok: true, text: async () => 'page 3 records' };
        };
        await context.showPage(`http://localhost/admin/${section}?page=3`);
        assert.equal(result.innerHTML, 'page 3 records');
        assert.equal(new URL(history[0]).searchParams.get('page'), '3');
    });
}

test('new search resets to page 1', async () => {
    const { context, history } = setup();
    context.fetch = async url => {
        assert.equal(new URL(url).searchParams.get('page'), '1');
        return { ok: true, text: async () => 'new results' };
    };
    await context.showPage(null, 'searchForm', 'search-result', true);
    assert.equal(new URL(history[0]).searchParams.has('page'), false);
});

test('failed request preserves the table and URL', async () => {
    const { context, result, history } = setup();
    context.fetch = async () => ({ ok: false });
    await context.showPage('http://localhost/admin/product?page=3');
    assert.equal(result.innerHTML, 'original');
    assert.equal(history.length, 0);
});

test('late response from a previous click cannot replace the newest page', async () => {
    const { context, result, history } = setup();
    let resolveOld;
    context.fetch = async url => ({ ok: true, text: () => new URL(url).searchParams.get('page') === '2'
        ? new Promise(resolve => { resolveOld = resolve; }) : Promise.resolve('page 3 records') });
    const oldRequest = context.showPage('http://localhost/admin/product?page=2');
    await Promise.resolve();
    await context.showPage('http://localhost/admin/product?page=3');
    resolveOld('page 2 records');
    await oldRequest;
    assert.equal(result.innerHTML, 'page 3 records');
    assert.equal(history.length, 1);
});
