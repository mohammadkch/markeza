<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductFaqModel extends Model
{
    protected $table      = 'product_faq';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id', 'question', 'answer', 'sort_order'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByProduct(int $productId): array
    {
        return $this->where('product_id', $productId)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }
}