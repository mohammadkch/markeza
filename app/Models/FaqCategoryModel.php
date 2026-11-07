<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqCategoryModel extends Model
{
    protected $table = 'faq_category';
    protected $allowedFields = ['title', 'sort_order', 'is_active'];
    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    public function active(): array
    {
        return $this->where('is_active', 1)->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll();
    }

    public function deleteIfEmpty(int $id): bool
    {
        if ((new FaqModel($this->db))->where('category_id', $id)->countAllResults() > 0) {
            return false;
        }
        return $this->delete($id);
    }
}
