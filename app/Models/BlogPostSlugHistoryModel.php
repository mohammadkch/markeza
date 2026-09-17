<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogPostSlugHistoryModel extends Model
{
    protected $table = 'blog_post_slug_history';
    protected $returnType = 'array';
    protected $allowedFields = ['post_id', 'old_slug', 'new_slug', 'created_at'];
}
