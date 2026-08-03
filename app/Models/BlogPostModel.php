<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogPostModel extends Model
{
    protected $table = 'blog_post';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'thumbnail',
        'banner',
        'meta_title',
        'meta_description',
        'is_active',
        'sort_order',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function publishedWithAuthor(): self
    {
        return $this->select('blog_post.*, user.full_name AS author_name, user.role AS author_role, user.avatar AS author_avatar')
            ->join('user', 'user.id = blog_post.user_id')
            ->where('blog_post.is_active', 1)
            ->orderBy('blog_post.sort_order', 'ASC')
            ->orderBy('blog_post.created_at', 'DESC');
    }

    public function getLatestPublished(int $limit = 4): array
    {
        return $this->publishedWithAuthor()->findAll($limit);
    }

    public function getPublishedBySlug(string $slug): ?array
    {
        return $this->publishedWithAuthor()
            ->where('blog_post.slug', $slug)
            ->first();
    }

    public function getRelatedPublished(int $postId, int $limit = 2): array
    {
        return $this->publishedWithAuthor()
            ->where('blog_post.id !=', $postId)
            ->findAll($limit);
    }
}
