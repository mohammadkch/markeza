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

    /**
     * Get product by slug (frontend)
     */
    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
            ->where('is_active', 1)
            ->first();
    }

    /**
     * Get products by collection (frontend)
     */
    public function getByCollection(int $collectionId): array
    {
        return $this->where('collection_id', $collectionId)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    /**
     * Get related products (frontend)
     */
    public function getRelatedProducts(int $collectionId, int $excludeProductId): array
    {
        return $this->where('collection_id', $collectionId)
            ->where('id !=', $excludeProductId)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->limit(6)
            ->findAll();
    }

    /**
     * Get data for admin panel
     */
    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('product.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['title']) && !empty($where['title'])) {
            $builder->like('product.title', $where['title']);
            unset($where['title']);
        }

        if (isset($where['slug']) && !empty($where['slug'])) {
            $builder->like('product.slug', $where['slug']);
            unset($where['slug']);
        }

        if (isset($where['collection_id']) && !empty($where['collection_id'])) {
            $builder->where('product.collection_id', $where['collection_id']);
            unset($where['collection_id']);
        }

        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('product.is_active', $where['is_active']);
            unset($where['is_active']);
        }

        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        $builder->select('
        product.*,
        collection.title as collection_title,
        COUNT(product_image.id) as images_count
        ');
        $builder->join('collection', 'collection.id = product.collection_id', 'left');
        $builder->join('product_image', 'product_image.product_id = product.id', 'left');
        $builder->groupBy('product.id');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('product.sort_order', 'ASC');

        return $builder->get()->getResultArray();
    }
}