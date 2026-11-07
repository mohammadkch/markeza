<?php

namespace Tests\Unit;

use App\Database\Migrations\CreateGeneralFaq;
use App\Models\FaqCategoryModel;
use App\Models\FaqModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

require_once APPPATH . 'Database/Migrations/2026-11-07-000002_CreateGeneralFaq.php';

final class FaqTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        helper(['url', 'form']);
        $this->db = db_connect('tests');
        (new CreateGeneralFaq(\Config\Database::forge('tests')))->up();
    }

    protected function tearDown(): void
    {
        (new CreateGeneralFaq(\Config\Database::forge('tests')))->down();
        parent::tearDown();
    }

    public function testSeedIsRepeatableAndCreatesTwoCategories(): void
    {
        (new CreateGeneralFaq(\Config\Database::forge('tests')))->up();
        $this->assertCount(2, (new FaqCategoryModel())->active());
    }

    public function testPublicListingFiltersCategoriesAndBothStatuses(): void
    {
        $categories = (new FaqCategoryModel())->active();
        $a = $categories[0]['id']; $b = $categories[1]['id'];
        $model = new FaqModel();
        $first = $model->insert(['category_id' => $a, 'question' => 'First question', 'answer' => 'Answer', 'sort_order' => 2, 'is_active' => 1]);
        $second = $model->insert(['category_id' => $b, 'question' => 'Second question', 'answer' => 'Answer', 'sort_order' => 1, 'is_active' => 1]);
        $model->insert(['category_id' => $a, 'question' => 'Hidden question', 'answer' => 'Answer', 'is_active' => 0]);
        $this->assertSame([$second, $first], array_column($model->publicQuestions(), 'id'));
        $this->assertSame([$first], array_column($model->publicQuestions((int) $a), 'id'));
        (new FaqCategoryModel())->update($b, ['is_active' => 0]);
        $this->assertSame([$first], array_column($model->publicQuestions(), 'id'));
    }

    public function testCategoryDeletionPreservesQuestionsAndAllowsEmptyCategory(): void
    {
        $categories = new FaqCategoryModel();
        $id = (int) $categories->active()[0]['id'];
        $model = new FaqModel();
        $faq = $model->insert(['category_id' => $id, 'question' => 'Question', 'answer' => 'Answer']);
        $this->assertFalse($categories->deleteIfEmpty($id));
        $this->assertNotNull($model->find($faq));
        $this->assertTrue($model->delete($faq));
        $this->assertTrue($categories->deleteIfEmpty($id));
    }

    public function testFaqPageEscapesContentAndFiltersByTag(): void
    {
        $categories = (new FaqCategoryModel())->active();
        $model = new FaqModel();
        $model->insert(['category_id' => $categories[0]['id'], 'question' => 'Visible first question', 'answer' => '<script>alert(1)</script>', 'is_active' => 1]);
        $model->insert(['category_id' => $categories[1]['id'], 'question' => 'Other category question', 'answer' => 'Other answer', 'is_active' => 1]);
        $all = $this->get('faq');
        $all->assertStatus(200);
        $all->assertSee('Visible first question');
        $all->assertSee('Other category question');
        $this->assertStringNotContainsString('<script>alert(1)</script>', $all->getBody());
        $this->assertStringContainsString('&lt;script&gt;', $all->getBody());
        $filtered = $this->get('faq?category=' . $categories[0]['id']);
        $filtered->assertStatus(200);
        $filtered->assertSee('Visible first question');
        $filtered->assertDontSee('Other category question');
    }

    public function testMissingCategoryIsNotFound(): void
    {
        $this->expectException(\CodeIgniter\Exceptions\PageNotFoundException::class);
        $this->get('faq?category=999999');
    }

    public function testArrayCategoryIsNotFound(): void
    {
        $this->expectException(\CodeIgniter\Exceptions\PageNotFoundException::class);
        $this->get('faq?category[]=1');
    }

    public function testEmptyCategoryHasFriendlyMessage(): void
    {
        $this->get('faq')->assertSee('هنوز سوالی در این بخش ثبت نشده است.');
    }

    public function testAdminRequiresLogin(): void
    {
        $this->get('admin/faq')->assertRedirectTo(site_url('admin/login'));
        $this->get('admin/faq-category')->assertRedirectTo(site_url('admin/login'));
    }

    public function testAdminFormsRender(): void
    {
        $this->withSession(['userID' => 1, 'full_name' => 'Test admin', 'avatar' => '', 'role' => 'admin'])->get('admin/faq/create')->assertSee('افزودن سوال متداول');
        $this->withSession(['userID' => 1, 'full_name' => 'Test admin', 'avatar' => '', 'role' => 'admin'])->get('admin/faq-category')->assertSee('دسته‌بندی سوالات متداول');
    }

    private function adminPost(string $path, array $data = [])
    {
        $data[csrf_token()] = csrf_hash();
        return $this->withSession(['userID' => 1, 'full_name' => 'Test admin', 'avatar' => '', 'role' => 'admin'])->post($path, $data);
    }

    public function testAdminCanCreateUpdateAndDeleteCategoriesAndQuestions(): void
    {
        $this->adminPost('admin/faq-category/create', ['title' => 'New category', 'sort_order' => '2', 'is_active' => '1'])->assertRedirectTo(site_url('admin/faq-category'));
        $categories = new FaqCategoryModel();
        $category = $categories->where('title', 'New category')->first();
        $this->assertNotNull($category);
        $id = $category['id'];
        $this->adminPost('admin/faq-category/edit/' . $id, ['title' => 'Edited category', 'sort_order' => '3', 'is_active' => '1'])->assertRedirect();
        $this->assertSame('Edited category', $categories->find($id)['title']);
        $data = ['category_id' => (string) $id, 'question' => 'New question', 'answer' => 'New answer', 'sort_order' => '0', 'is_active' => '1'];
        $this->adminPost('admin/faq/create', $data)->assertRedirectTo(site_url('admin/faq'));
        $questions = new FaqModel();
        $faq = $questions->where('question', 'New question')->first();
        $this->assertNotNull($faq);
        $this->adminPost('admin/faq-category/delete/' . $id)->assertRedirect();
        $this->assertNotNull($categories->find($id));
        $data['question'] = 'Edited question';
        $data['answer'] = 'Edited answer';
        $this->adminPost('admin/faq/edit/' . $faq['id'], $data)->assertRedirect();
        $this->assertSame('Edited answer', $questions->find($faq['id'])['answer']);
        $this->adminPost('admin/faq/delete/' . $faq['id'])->assertRedirect();
        $this->assertNull($questions->find($faq['id']));
        $this->adminPost('admin/faq-category/delete/' . $id)->assertRedirect();
        $this->assertNull($categories->find($id));
    }

    public function testInvalidCategoryAndEmptyAnswerAreRejected(): void
    {
        $this->adminPost('admin/faq/create', ['category_id' => '99999', 'question' => 'Test question', 'answer' => '', 'sort_order' => '0', 'is_active' => '1'])->assertStatus(200);
        $this->assertSame(0, (new FaqModel())->countAllResults());
        $category = (new FaqCategoryModel())->active()[0];
        $this->adminPost('admin/faq-category/create', ['title' => $category['title'], 'sort_order' => '0', 'is_active' => '1'])->assertStatus(200);
        $this->assertSame(2, (new FaqCategoryModel())->countAllResults());
    }

    public function testPostWithoutCsrfTokenIsRejected(): void
    {
        $this->expectException(\CodeIgniter\Security\Exceptions\SecurityException::class);
        $this->withSession(['userID' => 1])->post('admin/faq-category/create', ['title' => 'Invalid request', 'sort_order' => '0', 'is_active' => '1']);
    }

    public function testFaqMenuSelectionOnListsAndForms(): void
    {
        $category = (new FaqCategoryModel())->active()[0];
        $questionId = (new FaqModel())->insert(['category_id' => $category['id'], 'question' => 'Menu test question', 'answer' => 'Answer']);
        $paths = [
            'admin/faq' => 'admin/faq',
            'admin/faq/create' => 'admin/faq',
            'admin/faq/edit/' . $questionId => 'admin/faq',
            'admin/faq-category' => 'admin/faq-category',
            'admin/faq-category/create' => 'admin/faq-category',
            'admin/faq-category/edit/' . $category['id'] => 'admin/faq-category',
        ];
        foreach ($paths as $path => $activePath) {
            $response = $this->withSession(['userID' => 1, 'full_name' => 'Test admin', 'avatar' => '', 'role' => 'admin'])->get($path);
            $response->assertStatus(200);
            $this->assertActiveFaqMenu($response->getBody(), $activePath);
        }
        $response = $this->adminPost('admin/faq-category/create', ['title' => '', 'sort_order' => '0', 'is_active' => '1']);
        $this->assertActiveFaqMenu($response->getBody(), 'admin/faq-category');
    }

    private function assertActiveFaqMenu(string $html, string $path): void
    {
        $document = new \DOMDocument();
        @$document->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        $links = (new \DOMXPath($document))->query('//a[@aria-current="page"]');
        $this->assertCount(2, $links, 'Desktop and mobile each select one menu item.');
        foreach ($links as $link) {
            $this->assertSame(site_url($path), $link->getAttribute('href'));
        }
    }

    public function testAdminListFiltersQuestionsAndCategories(): void
    {
        $categories = new FaqCategoryModel();
        $first = $categories->active()[0];
        $second = $categories->active()[1];
        $questions = new FaqModel();
        $questions->insert(['category_id' => $first['id'], 'question' => 'Matching active question', 'answer' => 'Answer', 'is_active' => 1]);
        $questions->insert(['category_id' => $second['id'], 'question' => 'Other question', 'answer' => 'Answer', 'is_active' => 0]);
        $response = $this->withSession(['userID' => 1])->get('admin/faq?title=Matching&category_id=' . $first['id'] . '&is_active=1');
        $response->assertSee('Matching active question');
        $response->assertDontSee('Other question');
        $categories->update($second['id'], ['is_active' => 0]);
        $response = $this->withSession(['userID' => 1])->get('admin/faq-category?is_active=0');
        $response->assertSee($second['title']);
        $response->assertDontSee($first['title']);
    }
}
