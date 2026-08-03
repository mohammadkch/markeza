<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogPostBlockModel extends Model
{
    protected $table = 'blog_post_block';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'post_id',
        'block_type',
        'content',
        'image_path',
        'alt_text',
        'caption',
        'heading_level',
        'sort_order',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getByPost(int $postId): array
    {
        return $this->where('post_id', $postId)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }
}
