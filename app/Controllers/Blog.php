<?php

namespace App\Controllers;

use App\Models\BlogPostBlockModel;
use App\Models\BlogPostModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Blog extends BaseController
{
    public function index(): string
    {
        $postModel = new BlogPostModel();
        $posts = $postModel->publishedWithAuthor()->paginate(8);

        $this->viewData['posts'] = array_map([$this, 'preparePost'], $posts);
        $this->viewData['pager'] = $postModel->pager;
        $this->viewData['seo'] = [
            'title' => 'وبلاگ | مارکزا هوم',
            'description' => 'مطالب تخصصی مارکزا هوم درباره مبلمان، چرم طبیعی و طراحی فضای داخلی',
            'canonical' => base_url('blog'),
        ];

        return view($this->viewPath . 'blog/index', $this->viewData);
    }

    public function show(string $slug): string
    {
        $postModel = new BlogPostModel();
        $post = $postModel->getPublishedBySlug($slug);

        if ($post === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $blockModel = new BlogPostBlockModel();
        $this->viewData['post'] = $this->preparePost($post);
        $this->viewData['blocks'] = $blockModel->getByPost((int) $post['id']);
        $this->viewData['relatedPosts'] = array_map(
            [$this, 'preparePost'],
            $postModel->getRelatedPublished((int) $post['id'])
        );
        $this->viewData['seo'] = [
            'title' => $post['meta_title'] ?: $post['title'] . ' | مارکزا هوم',
            'description' => $post['meta_description'] ?: $post['excerpt'],
            'canonical' => base_url('blog/' . $post['slug']),
            'og_type' => 'article',
            'og_image' => base_url($post['banner']),
        ];

        return view($this->viewPath . 'blog/show', $this->viewData);
    }

    private function preparePost(array $post): array
    {
        $roleLabels = [
            'admin' => 'مدیر محتوا',
            'manager' => 'نویسنده',
            'viewer' => 'همکار تحریریه',
        ];

        $post['thumbnail_url'] = base_url($post['thumbnail']);
        $post['banner_url'] = base_url($post['banner']);
        $post['author_avatar_url'] = base_url('assets/images/user.jpg');
        $post['author_role_label'] = $roleLabels[$post['author_role']] ?? 'نویسنده';

        return $post;
    }
}
