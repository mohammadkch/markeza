<?php

namespace App\Controllers\Admin;

use App\Models\FaqCategoryModel;
use App\Models\FaqModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Faq extends BaseController
{
    protected $helpers = ['flash', 'form'];

    public function index()
    {
        $model = new FaqModel();
        $filters = $this->filters();
        $model->select('faq.*, faq_category.title AS category_title')
            ->join('faq_category', 'faq_category.id = faq.category_id');
        if ($filters['title'] !== '') { $model->like('faq.question', $filters['title']); }
        if ($filters['category_id'] !== '') { $model->where('faq.category_id', $filters['category_id']); }
        if ($filters['is_active'] !== '') { $model->where('faq.is_active', $filters['is_active']); }
        $this->viewData['rows'] = $model->orderBy('faq.sort_order', 'ASC')->orderBy('faq.id', 'DESC')->paginate(20);
        $model->pager->only(['title', 'category_id', 'is_active']);
        $this->viewData['pager'] = $model->pager;
        $this->viewData['filters'] = $filters;
        $this->viewData['categories'] = (new FaqCategoryModel())->orderBy('sort_order', 'ASC')->findAll();
        return $this->listing(false);
    }

    public function categories()
    {
        $model = new FaqCategoryModel();
        $filters = $this->filters();
        if ($filters['title'] !== '') { $model->like('title', $filters['title']); }
        if ($filters['is_active'] !== '') { $model->where('is_active', $filters['is_active']); }
        $this->viewData['rows'] = $model->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->paginate(20);
        $model->pager->only(['title', 'is_active']);
        $this->viewData['pager'] = $model->pager;
        $this->viewData['filters'] = $filters;
        return $this->listing(true);
    }

    private function filters(): array
    {
        $title = $this->request->getGet('title');
        $status = $this->request->getGet('is_active');
        $category = $this->request->getGet('category_id');
        return [
            'title' => is_string($title) ? trim($title) : '',
            'is_active' => in_array($status, ['0', '1'], true) ? $status : '',
            'category_id' => is_string($category) && ctype_digit($category) && (int) $category > 0 ? $category : '',
        ];
    }

    private function listing(bool $isCategory)
    {
        $this->viewData['isCategory'] = $isCategory;
        $this->viewData['basePath'] = $isCategory ? 'admin/faq-category' : 'admin/faq';
        $this->viewData['title'] = $isCategory ? 'دسته‌بندی سوالات متداول' : 'مدیریت سوالات متداول';
        return view('admin/faq/index', $this->viewData);
    }

    public function create() { return $this->form(false); }
    public function edit($id) { return $this->form(false, (int) $id); }
    public function createCategory() { return $this->form(true); }
    public function editCategory($id) { return $this->form(true, (int) $id); }

    private function form(bool $isCategory, ?int $id = null, array $errors = [], array $values = [])
    {
        $model = $isCategory ? new FaqCategoryModel() : new FaqModel();
        $row = $id === null ? ['is_active' => 1, 'sort_order' => 0] : $model->find($id);
        if ($row === null) { throw PageNotFoundException::forPageNotFound(); }
        $basePath = $isCategory ? 'admin/faq-category' : 'admin/faq';
        return view('admin/faq/form', array_merge($this->viewData, [
            'title' => ($id === null ? 'افزودن ' : 'ویرایش ') . ($isCategory ? 'دسته‌بندی سوالات' : 'سوال متداول'),
            'isCategory' => $isCategory, 'basePath' => $basePath,
            'formAction' => $basePath . ($id === null ? '/create' : '/edit/' . $id),
            'row' => array_merge($row, $values), 'errors' => $errors,
            'categories' => (new FaqCategoryModel())->orderBy('sort_order', 'ASC')->findAll(),
        ]));
    }

    public function store() { return $this->save(false); }
    public function update($id) { return $this->save(false, (int) $id); }
    public function storeCategory() { return $this->save(true); }
    public function updateCategory($id) { return $this->save(true, (int) $id); }

    private function save(bool $isCategory, ?int $id = null)
    {
        $model = $isCategory ? new FaqCategoryModel() : new FaqModel();
        if ($id !== null && !$model->find($id)) { throw PageNotFoundException::forPageNotFound(); }
        $data = [
            'sort_order' => trim((string) $this->request->getPost('sort_order')),
            'is_active' => $this->request->getPost('is_active'),
        ];
        $rules = [
            'sort_order' => ['label' => 'ترتیب نمایش', 'rules' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[2147483647]'],
            'is_active' => ['label' => 'وضعیت', 'rules' => 'required|in_list[0,1]'],
        ];
        if ($isCategory) {
            $data['title'] = trim((string) $this->request->getPost('title'));
            $rules['title'] = ['label' => 'عنوان دسته‌بندی', 'rules' => 'required|max_length[150]|is_unique[faq_category.title,id,' . ($id ?? 0) . ']'];
        } else {
            $data['category_id'] = $this->request->getPost('category_id');
            $data['question'] = trim((string) $this->request->getPost('question'));
            $data['answer'] = trim((string) $this->request->getPost('answer'));
            $rules['category_id'] = ['label' => 'دسته‌بندی', 'rules' => 'required|is_natural_no_zero|is_not_unique[faq_category.id]'];
            $rules['question'] = ['label' => 'سوال', 'rules' => 'required|max_length[500]'];
            $rules['answer'] = ['label' => 'پاسخ', 'rules' => 'required|max_length[20000]'];
        }
        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->run($data)) {
            return $this->form($isCategory, $id, $validation->getErrors(), $data);
        }
        $saved = $id === null ? $model->insert($data) : $model->update($id, $data);
        if (!$saved) {
            return $this->form($isCategory, $id, ['ذخیره اطلاعات انجام نشد. دوباره تلاش کنید.'], $data);
        }
        return redirect()->to(site_url($isCategory ? 'admin/faq-category' : 'admin/faq'))->with('faq_message', 'اطلاعات با موفقیت ذخیره شد.');
    }

    public function delete($id)
    {
        $model = new FaqModel();
        if (!$model->find($id)) { throw PageNotFoundException::forPageNotFound(); }
        $ok = $model->delete($id);
        return redirect()->to(site_url('admin/faq'))->with('faq_message', $ok ? 'سوال حذف شد.' : 'حذف سوال انجام نشد.');
    }

    public function deleteCategory($id)
    {
        $model = new FaqCategoryModel();
        if (!$model->find($id)) { throw PageNotFoundException::forPageNotFound(); }
        try {
            $ok = $model->deleteIfEmpty((int) $id);
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $ok = false;
        }
        return redirect()->to(site_url('admin/faq-category'))->with('faq_message', $ok ? 'دسته‌بندی حذف شد.' : 'این دسته‌بندی دارای سوال است؛ ابتدا سوال‌ها را حذف کنید یا به دسته‌بندی دیگری منتقل کنید.');
    }
}
