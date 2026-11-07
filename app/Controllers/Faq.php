<?php

namespace App\Controllers;

use App\Models\FaqCategoryModel;
use App\Models\FaqModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Faq extends BaseController
{
    public function index(): string
    {
        $categories = (new FaqCategoryModel())->active();
        $selected = $this->request->getGet('category');
        $categoryId = null;
        if ($selected !== null && $selected !== '') {
            if (!is_string($selected) || !ctype_digit($selected) || !in_array((int) $selected, array_column($categories, 'id'))) {
                throw PageNotFoundException::forPageNotFound();
            }
            $categoryId = (int) $selected;
        }
        $this->viewData['categories'] = $categories;
        $this->viewData['selectedCategory'] = $categoryId;
        $this->viewData['faqs'] = (new FaqModel())->publicQuestions($categoryId);
        $this->viewData['seo'] = [
            'title' => 'سوالات متداول | مارکزا هوم',
            'description' => 'پاسخ سوالات متداول درباره محصولات و خدمات مارکزا هوم، به تفکیک دسته‌بندی.',
            'canonical' => base_url('faq'),
        ];
        return view('faq/index', $this->viewData);
    }
}
