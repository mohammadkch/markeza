<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table = 'faq';
    protected $allowedFields = ['category_id', 'question', 'answer', 'sort_order', 'is_active'];
    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    public function publicQuestions(?int $categoryId = null): array
    {
        $this->select('faq.*, faq_category.title AS category_title')
            ->join('faq_category', 'faq_category.id = faq.category_id')
            ->where('faq.is_active', 1)->where('faq_category.is_active', 1);
        if ($categoryId !== null) {
            $this->where('faq.category_id', $categoryId);
        }
        return $this->orderBy('faq.sort_order', 'ASC')->orderBy('faq.id', 'ASC')->findAll();
    }
}
