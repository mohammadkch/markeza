<?= $this->extend('admin/_layout_/layout') ?>
<?php helper('form'); ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= $assetsPath ?>js/plugin/pell/pell.min.css?v=2">

<?php
$editing = $edit_block !== null;
$blockValue = static function (string $field, $default = '') use ($edit_block) {
    return old($field, $edit_block[$field] ?? $default, false);
};
?>

<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>

            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h1 class="font-black text-2xl with-highlight">محتوای مقاله</h1>
                            <p class="text-gray-600 mt-2"><?= esc($post['title']) ?></p>
                        </div>
                        <div class="flex gap-2 mt-4 md:mt-0" style="margin-right: auto">
                            <a href="<?= site_url('blog/' . $post['slug']) ?>" target="_blank" rel="noopener" class="bg-green-600 text-white py-2 px-4 rounded-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                پیش‌نمایش
                            </a>
                            <a href="<?= site_url('admin/blog/edit/' . $post['id']) ?>" class="bg-amber-500 text-white py-2 px-4 rounded-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                اطلاعات مقاله
                            </a>
                            
                        </div>
                    </div>

                    <?php if ($blocks !== []): ?>
                        <form id="reorder-form" method="post" action="<?= site_url('admin/blog/blocks/' . $post['id'] . '/reorder') ?>" class="mb-6">
                            <?= csrf_field() ?>
                            <input id="block-order" type="hidden" name="order">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm text-gray-500">کارت‌ها را بکشید یا با فلش‌ها جابه‌جا کنید، سپس ترتیب را ذخیره کنید.</p>
                                <button class="bg-primary text-white py-2 px-4 rounded-lg" type="submit">ذخیره ترتیب</button>
                            </div>
                        </form>

                        <div id="blocks-list" class="space-y-3 mb-8">
                            <?php foreach ($blocks as $index => $block): ?>
                                <article class="blog-block-card border border-gray-200 rounded-xl p-4 bg-gray-50 dark:bg-gray-800" draggable="true" data-id="<?= (int) $block['id'] ?>">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-3">
                                                <span class="cursor-move text-gray-400" title="جابجایی">☰</span>
                                                <span class="bg-gray-200 rounded-full px-3 py-1 text-xs">
                                                    <?= ['text' => 'متن', 'heading' => 'تیتر', 'image' => 'تصویر', 'quote' => 'نقل‌قول'][$block['block_type']] ?>
                                                </span>
                                                <span class="text-xs text-gray-400">#<?= $index + 1 ?></span>
                                            </div>

                                            <?php if ($block['block_type'] === 'image'): ?>
                                                <div class="flex items-center gap-4">
                                                    <img src="<?= base_url($block['image_path']) ?>" alt="" class="w-24 h-20 object-cover rounded-lg">
                                                    <div>
                                                        <p class="font-medium"><?= esc($block['alt_text']) ?></p>
                                                        <?php if ($block['caption']): ?><p class="text-sm text-gray-500 mt-1"><?= esc($block['caption']) ?></p><?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <p class="leading-7"><?= nl2br(esc(mb_strimwidth(strip_tags((string) $block['content']), 0, 350, '...'))) ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="flex flex-col gap-2">
                                            <div class="flex gap-1">
                                                <button type="button" class="move-up bg-gray-200 px-2 py-1 rounded" aria-label="انتقال به بالا">↑</button>
                                                <button type="button" class="move-down bg-gray-200 px-2 py-1 rounded" aria-label="انتقال به پایین">↓</button>
                                            </div>
                                            <a href="<?= site_url('admin/blog/blocks/' . $post['id'] . '/edit/' . $block['id']) ?>" class="text-primary text-center">ویرایش</a>
                                            <form method="post" action="<?= site_url('admin/blog/blocks/' . $post['id'] . '/delete/' . $block['id']) ?>" onsubmit="return confirm('این بلوک حذف شود؟')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="text-red-600">حذف</button>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-yellow-50 rounded-xl p-5 mb-8 text-center">هنوز بلوکی برای این مقاله ثبت نشده است.</div>
                    <?php endif; ?>
                </div>

                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <h2 class="font-black text-xl mb-6"><?= $editing ? 'ویرایش بلوک' : 'افزودن بلوک جدید' ?></h2>

                    <?php if ($validation_errors !== []): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <?php foreach ($validation_errors as $error): ?><p><?= esc($error) ?></p><?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url($editing ? 'admin/blog/blocks/' . $post['id'] . '/edit/' . $edit_block['id'] : 'admin/blog/blocks/' . $post['id'] . '/create') ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="block_type" class="block text-sm font-medium mb-2">نوع بلوک</label>
                                <select id="block_type" name="block_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    <?php foreach (['text' => 'متن', 'heading' => 'تیتر', 'image' => 'تصویر', 'quote' => 'نقل‌قول'] as $type => $label): ?>
                                        <option value="<?= $type ?>" <?= $blockValue('block_type', 'text') === $type ? 'selected' : '' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="heading-level-field">
                                <label for="heading_level" class="block text-sm font-medium mb-2">سطح تیتر</label>
                                <select id="heading_level" name="heading_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    <option value="2" <?= (string) $blockValue('heading_level', 2) === '2' ? 'selected' : '' ?>>تیتر اصلی H2</option>
                                    <option value="3" <?= (string) $blockValue('heading_level', 2) === '3' ? 'selected' : '' ?>>زیرتیتر H3</option>
                                </select>
                            </div>
                            <div id="content-field" class="md:col-span-2">
                                <label for="content" class="block text-sm font-medium mb-2">محتوا</label>
                                <textarea id="content" name="content" rows="7" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><?= esc($blockValue('content')) ?></textarea>
                                <div id="content-editor" class="hidden border border-gray-300 rounded-lg bg-white text-gray-900"></div>
                                <p id="editor-help" class="hidden text-xs text-gray-500 mt-2">برای ساختار بهتر مقاله از پاراگراف، فهرست و لینک استفاده کنید؛ تیترهای H2 و H3 را به‌صورت بلوک تیتر جدا بسازید.</p>
                            </div>
                            <div id="image-fields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php if ($editing && ! empty($edit_block['image_path'])): ?>
                                    <div class="md:col-span-2"><img src="<?= base_url($edit_block['image_path']) ?>" alt="" class="w-40 h-32 object-cover rounded-lg"></div>
                                <?php endif; ?>
                                <div>
                                    <label for="image" class="block text-sm font-medium mb-2">فایل تصویر <?= $editing ? '' : '*' ?></label>
                                    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="w-full text-sm">
                                    <p class="text-xs text-gray-500 mt-1">حداکثر ۵MB</p>
                                </div>
                                <div>
                                    <label for="alt_text" class="block text-sm font-medium mb-2">متن جایگزین تصویر</label>
                                    <input id="alt_text" name="alt_text" type="text" maxlength="255" value="<?= esc($blockValue('alt_text')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="caption" class="block text-sm font-medium mb-2">کپشن تصویر</label>
                                    <input id="caption" name="caption" type="text" maxlength="500" value="<?= esc($blockValue('caption')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg"><?= $editing ? 'بروزرسانی بلوک' : 'افزودن بلوک' ?></button>
                            <?php if ($editing): ?><a href="<?= site_url('admin/blog/blocks/' . $post['id']) ?>" class="bg-gray-200 py-2 px-6 rounded-lg">انصراف</a><?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= $assetsPath ?>js/plugin/pell/pell.min.js?v=2"></script>
<script>
(() => {
    const typeSelect = document.getElementById('block_type');
    const contentField = document.getElementById('content-field');
    const imageFields = document.getElementById('image-fields');
    const headingLevel = document.getElementById('heading-level-field');
    const contentInput = document.getElementById('content');
    const editorElement = document.getElementById('content-editor');
    const editorHelp = document.getElementById('editor-help');

    if (!window.pell || typeof window.pell.init !== 'function') {
        const warning = document.createElement('p');
        warning.className = 'mt-2 text-sm text-red-600';
        warning.textContent = 'فایل ادیتور بارگذاری نشد؛ pell.min.js را در assetهای ادمین بررسی کنید.';
        contentField.appendChild(warning);
        return;
    }

    const editor = window.pell.init({
        element: editorElement,
        defaultParagraphSeparator: 'p',
        actions: [
            'bold',
            'italic',
            'underline',
            'paragraph',
            'olist',
            'ulist',
            'link',
            { name: 'undo', icon: '↶', title: 'بازگشت', result: () => window.pell.exec('undo') },
            { name: 'redo', icon: '↷', title: 'انجام مجدد', result: () => window.pell.exec('redo') },
        ],
        onChange: html => contentInput.value = html,
    });
    editor.content.innerHTML = contentInput.value;

    function updateFields() {
        const type = typeSelect.value;
        contentField.classList.toggle('hidden', type === 'image');
        imageFields.classList.toggle('hidden', type !== 'image');
        headingLevel.classList.toggle('hidden', type !== 'heading');
        const richTextEnabled = type === 'text';
        contentInput.classList.toggle('hidden', richTextEnabled);
        editorElement.classList.toggle('hidden', !richTextEnabled);
        editorHelp.classList.toggle('hidden', !richTextEnabled);
    }
    typeSelect.addEventListener('change', updateFields);
    updateFields();

    const list = document.getElementById('blocks-list');
    const orderInput = document.getElementById('block-order');
    if (!list || !orderInput) return;

    function updateOrder() {
        orderInput.value = JSON.stringify(Array.from(list.querySelectorAll('.blog-block-card')).map(card => Number(card.dataset.id)));
    }
    updateOrder();

    list.addEventListener('click', function (event) {
        const card = event.target.closest('.blog-block-card');
        if (!card) return;
        if (event.target.closest('.move-up') && card.previousElementSibling) {
            list.insertBefore(card, card.previousElementSibling);
        }
        if (event.target.closest('.move-down') && card.nextElementSibling) {
            list.insertBefore(card.nextElementSibling, card);
        }
        updateOrder();
    });

    let dragged = null;
    list.addEventListener('dragstart', event => {
        dragged = event.target.closest('.blog-block-card');
        if (dragged) dragged.style.opacity = '0.5';
    });
    list.addEventListener('dragover', event => {
        event.preventDefault();
        const target = event.target.closest('.blog-block-card');
        if (!dragged || !target || dragged === target) return;
        const box = target.getBoundingClientRect();
        list.insertBefore(dragged, event.clientY < box.top + box.height / 2 ? target : target.nextSibling);
    });
    list.addEventListener('dragend', () => {
        if (dragged) dragged.style.opacity = '';
        dragged = null;
        updateOrder();
    });
})();
</script>

<?= $this->endSection() ?>
