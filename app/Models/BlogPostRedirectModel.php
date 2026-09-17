<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogPostRedirectModel extends Model
{
    protected $table = 'blog_post_redirect';
    protected $returnType = 'array';
    protected $allowedFields = ['post_id', 'source_path', 'is_active', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    public function findActive(string $sourcePath): ?array
    {
        return $this->where('source_path', $sourcePath)->where('is_active', 1)->first();
    }

    public function registerSlugChange(int $postId, string $oldSlug): bool
    {
        $sourcePath = 'blog/' . $postId . '/' . $oldSlug;
        $existing = $this->where('source_path', $sourcePath)->first();
        if ($existing !== null) {
            return $this->update($existing['id'], ['is_active' => 0]);
        }
        return $this->insert(['post_id' => $postId, 'source_path' => $sourcePath, 'is_active' => 0]) !== false;
    }
}
