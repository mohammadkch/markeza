<?php

namespace App\Models;

use CodeIgniter\Model;

class CollectionModel extends Model
{
    protected $table      = 'collection';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'title', 'slug', 'subtitle', 'description',
        'thumbnail', 'meta_title', 'meta_description',
        'is_active', 'sort_order'
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

    public function getAllActive(): array
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }
}