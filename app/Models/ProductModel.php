<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'product';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'collection_id', 'title', 'slug', 'thumbnail',
        'is_active', 'sort_order'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByCollection(int $collectionId): array
    {
        return $this->where('collection_id', $collectionId)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }
}