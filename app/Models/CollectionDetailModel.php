<?php

namespace App\Models;

use CodeIgniter\Model;

class CollectionDetailModel extends Model
{
    protected $table      = 'collection_detail';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'collection_id', 'icon_type', 'label', 'value', 'sort_order'
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