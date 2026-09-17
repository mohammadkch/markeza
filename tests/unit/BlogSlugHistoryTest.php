<?php

namespace Tests\Unit;

use App\Controllers\Blog;
use App\Database\Migrations\AddBlogSlugHistory;
use App\Database\Migrations\SeparateBlogRedirects;
use App\Models\BlogPostRedirectModel;
use App\Models\BlogPostSlugHistoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Test\CIUnitTestCase;

require_once APPPATH . 'Database/Migrations/2026-09-17-020000_AddBlogSlugHistory.php';
require_once APPPATH . 'Database/Migrations/2026-09-17-030000_SeparateBlogRedirects.php';

final class BlogSlugHistoryTest extends CIUnitTestCase
{

    private $migration;
    private $separation;

    protected function setUp(): void
    {
        parent::setUp();
        helper('url');
        $this->db = db_connect('tests');
        $this->db->query('CREATE TABLE db_user (id INTEGER PRIMARY KEY, full_name TEXT, role TEXT, avatar TEXT)');
        $this->db->query('CREATE TABLE db_blog_post (id INTEGER PRIMARY KEY, user_id INTEGER, slug VARCHAR(255), is_active INTEGER, sort_order INTEGER, created_at INTEGER)');
        $this->db->query('CREATE UNIQUE INDEX db_slug ON db_blog_post(slug)');
        $this->db->table('user')->insert(['id' => 1, 'full_name' => 'Test', 'role' => 'admin', 'avatar' => '']);
        $this->db->table('blog_post')->insert(['id' => 1, 'user_id' => 1, 'slug' => 'original', 'is_active' => 1, 'sort_order' => 0, 'created_at' => 1]);
        $this->migration = new AddBlogSlugHistory(\Config\Database::forge('tests'));
        $this->migration->up();
        $this->separation = new SeparateBlogRedirects(\Config\Database::forge('tests'));
        $this->separation->up();
    }

    protected function tearDown(): void
    {
        $forge = \Config\Database::forge('tests');
        $forge->dropTable('blog_post_redirect', true);
        $forge->dropTable('blog_post_slug_history', true);
        $forge->dropTable('blog_post', true);
        $forge->dropTable('user', true);
        parent::tearDown();
    }

    public function testLegacyUrlKeepsItsOwnerAndRedirectsToLatestSlug(): void
    {
        $this->db->table('blog_post')->where('id', 1)->update(['slug' => 'latest']);
        $this->db->table('blog_post')->insert(['id' => 2, 'user_id' => 1, 'slug' => 'original', 'is_active' => 1]);
        $response = (new Blog())->legacy('original');
        $this->assertSame(301, $response->getStatusCode());
        $this->assertSame(base_url('blog/1/latest'), $response->getHeaderLine('Location'));
    }

    public function testDuplicateSlugsAreAllowed(): void
    {
        $this->assertTrue($this->db->table('blog_post')->insert(['id' => 2, 'user_id' => 1, 'slug' => 'original', 'is_active' => 1]));
    }

    public function testHistoryIsSeparateFromRedirectSettings(): void
    {
        $history = new BlogPostSlugHistoryModel();
        $history->insert(['post_id' => 1, 'old_slug' => 'original', 'new_slug' => 'intermediate', 'created_at' => time()]);
        $model = new BlogPostRedirectModel();
        $this->assertTrue($model->registerSlugChange(1, 'original'));
        $this->assertNull($model->findActive('blog/1/original'));
        $row = $model->where('source_path', 'blog/1/original')->first();
        $before = $history->findAll();
        $model->update($row['id'], ['is_active' => 1]);
        $this->assertSame($before, $history->findAll());
        $this->db->table('blog_post')->where('id', 1)->update(['slug' => 'latest']);
        $response = (new Blog())->show(1, 'original');
        $this->assertSame(301, $response->getStatusCode());
        $this->assertSame(base_url('blog/1/latest'), $response->getHeaderLine('Location'));
        $this->assertTrue($model->registerSlugChange(1, 'original'));
        $this->assertNull($model->findActive('blog/1/original'));
        $this->assertSame(1, $model->where('source_path', 'blog/1/original')->countAllResults());
    }

    public function testMigrationMovesCompatibilityRedirectsOutOfHistory(): void
    {
        $this->assertSame(0, (new BlogPostSlugHistoryModel())->countAllResults());
        $this->assertNotNull((new BlogPostRedirectModel())->findActive('blog/original'));
        $fields = $this->db->getFieldNames('blog_post_slug_history');
        $this->assertNotContains('is_legacy', $fields);
        $this->assertNotContains('is_active', $fields);
    }

    public function testMigrationPreservesChangesAndLatestRedirectSetting(): void
    {
        $this->separation->down();
        foreach ([1, 0] as $active) {
            $this->db->table('blog_post_slug_history')->insert([
                'post_id' => 1, 'old_slug' => 'before', 'new_slug' => 'after',
                'is_active' => $active, 'is_legacy' => 0, 'created_at' => time(),
            ]);
        }
        $this->separation->up();
        $this->assertSame(2, (new BlogPostSlugHistoryModel())->countAllResults());
        $model = new BlogPostRedirectModel();
        $this->assertSame(1, $model->where('source_path', 'blog/1/before')->countAllResults());
        $this->assertNull($model->findActive('blog/1/before'));
        $this->assertNotNull($model->findActive('blog/original'));
    }

    public function testDisabledRedirectReturns404(): void
    {
        (new BlogPostRedirectModel())->registerSlugChange(1, 'before');
        $this->expectException(PageNotFoundException::class);
        (new Blog())->show(1, 'before');
    }

    public function testAdminPagesRenderWithPanelLayout(): void
    {
        helper(['form', 'flash']);
        $post = ['id' => 1, 'title' => 'مقاله آزمایشی', 'slug' => 'اسلاگ-فعلی'];
        $base = [
            'post' => $post, 'assetsPath' => base_url('assets/admin/'), 'className' => 'blog',
            'controllerName' => 'Blog', 'methodName' => 'history', 'title' => 'تاریخچه آدرس‌های مقاله',
            'full_name' => 'مدیر سایت', 'role' => 'مدیر', 'avatar' => 'images/user/1.png',
        ];
        $historyModel = new BlogPostSlugHistoryModel();
        $historyModel->insert(['post_id' => 1, 'old_slug' => 'اسلاگ-قبلی', 'new_slug' => 'اسلاگ-فعلی', 'created_at' => time()]);
        $history = $historyModel->paginate(20);
        $html = view('admin/blog/history', $base + ['history' => $history, 'pager' => $historyModel->pager]);
        $this->assertStringContainsString('dark:border-gray-700', $html);
        $this->assertStringContainsString('تاریخچه آدرس‌های مقاله', $html);
        $this->assertStringContainsString('مدیریت ریدایرکت‌ها', $html);
        $this->assertStringNotContainsString('name="is_active"', $html);
        $redirectModel = new BlogPostRedirectModel();
        $rows = $redirectModel->paginate(20);
        $html = view('admin/blog/redirects', $base + ['redirects' => $rows, 'pager' => $redirectModel->pager, 'status' => null]);
        $this->assertStringContainsString('admin/blog/redirects/1/', $html);
        $this->assertStringContainsString('name="is_active"', $html);
    }

    public function testAdminToggleChangesRedirectWithoutMutatingHistory(): void
    {
        $model = new BlogPostRedirectModel();
        $model->registerSlugChange(1, 'previous');
        $row = $model->where('source_path', 'blog/1/previous')->first();
        $history = (new BlogPostSlugHistoryModel())->findAll();
        $request = service('request');
        $request->setGlobal('post', ['is_active' => '1']);
        $controller = new \App\Controllers\Admin\Blog();
        $controller->initController($request, service('response'), service('logger'));
        $controller->updateRedirect(1, (int) $row['id']);
        $this->assertNotNull($model->findActive('blog/1/previous'));
        $this->assertSame($history, (new BlogPostSlugHistoryModel())->findAll());
        $request->setGlobal('post', ['is_active' => '0']);
        $controller->updateRedirect(1, (int) $row['id']);
        $this->assertNull($model->findActive('blog/1/previous'));
        $this->expectException(PageNotFoundException::class);
        $controller->updateRedirect(2, (int) $row['id']);
    }

    public function testUnknownOrDisabledSlugReturns404(): void
    {
        $this->expectException(PageNotFoundException::class);
        (new Blog())->show(1, 'unknown');
    }

    public function testUnpublishedLegacyArticleDoesNotRedirect(): void
    {
        $this->db->table('blog_post')->where('id', 1)->update(['is_active' => 0]);
        $this->expectException(PageNotFoundException::class);
        (new Blog())->legacy('original');
    }

    public function testRollbackRestoresUniqueConstraint(): void
    {
        $this->separation->down();
        $this->migration->down();
        $indexes = $this->db->getIndexData('blog_post');
        $this->assertTrue((bool) array_filter($indexes, static fn ($index) => $index->type === 'UNIQUE' && $index->fields === ['slug']));
    }
}
