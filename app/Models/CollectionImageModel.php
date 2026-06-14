<?php

namespace App\Models;

use CodeIgniter\Model;

class CollectionImageModel extends Model
{
    protected $table      = 'collection_image';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'collection_id', 'image_path', 'alt_text', 'sort_order'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByCollection(int $collectionId): array
    {
        return $this->where('collection_id', $collectionId)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }
}