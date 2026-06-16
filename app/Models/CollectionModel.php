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

    /**
     * Get collection by slug (frontend)
     */
    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
            ->where('is_active', 1)
            ->first();
    }

    /**
     * Get all active collections (frontend)
     */
    public function getAllActive(): array
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    /**
     * Get data with images for admin panel (like Menu1Model)
     */
    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('collection.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['title']) && !empty($where['title'])) {
            $builder->like('collection.title', $where['title']);
            unset($where['title']);
        }

        if (isset($where['slug']) && !empty($where['slug'])) {
            $builder->like('collection.slug', $where['slug']);
            unset($where['slug']);
        }

        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('collection.is_active', $where['is_active']);
            unset($where['is_active']);
        }

        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        $builder->select('
            collection.*,
            COUNT(collection_image.id) as images_count,
            GROUP_CONCAT(
                CONCAT_WS("|||", 
                    collection_image.id,
                    collection_image.image_path,
                    collection_image.alt_text,
                    collection_image.sort_order
                ) SEPARATOR ";;;"
            ) as images_data
        ');
        $builder->join('collection_image', 'collection_image.collection_id = collection.id', 'left');
        $builder->groupBy('collection.id');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('collection.sort_order', 'ASC');

        return $builder->get()->getResultArray();
    }
}