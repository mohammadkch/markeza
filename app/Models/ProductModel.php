<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'product';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'collection_id', 'title', 'slug', 'thumbnail', 'description',
        'dimensions_text', 'dimensions_img', 'is_active', 'sort_order'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
            ->where('is_active', 1)
            ->first();
    }

    public function getByCollection(int $collectionId): array
    {
        return $this->where('collection_id', $collectionId)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function getRelatedProducts(int $collectionId, int $excludeProductId): array
    {
        return $this->where('collection_id', $collectionId)
            ->where('id !=', $excludeProductId)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->limit(6)
            ->findAll();
    }
}