<?php

namespace App\Controllers;

use App\Models\BlogPostBlockModel;
use App\Models\BlogPostModel;
use App\Models\BlogPostRedirectModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

class Blog extends BaseController
{
    public function index(): string
    {
        $postModel = new BlogPostModel();
        $posts = $postModel->publishedWithAuthor()->paginate(8);

        $this->viewData['posts'] = array_map([$this, 'preparePost'], $posts);
        $this->viewData['pager'] = $postModel->pager;
        $currentPage = max(1, $postModel->pager->getCurrentPage());
        $pageCount = max(1, $postModel->pager->getPageCount());
        $canonical = base_url('blog') . ($currentPage > 1 ? '?page=' . $currentPage : '');
        $title = 'مجله مبلمان، چرم و دکوراسیون | مارکزا هوم';
        if ($currentPage > 1) {
            $title .= ' | صفحه ' . $currentPage;
        }

        $this->viewData['currentPage'] = $currentPage;
        $this->viewData['seo'] = [
            'title' => $title,
            'description' => 'مجله مارکزا هوم؛ راهنماها و مطالب تخصصی درباره انتخاب مبلمان چرمی، نگهداری چرم طبیعی، چیدمان منزل و طراحی دکوراسیون داخلی.',
            'canonical' => $canonical,
            'og_image' => $this->viewData['posts'][0]['thumbnail_url'] ?? base_url('assets/images/logo/logo-black-trans.png'),
            'prev' => $currentPage > 1
                ? base_url('blog') . ($currentPage === 2 ? '' : '?page=' . ($currentPage - 1))
                : null,
            'next' => $currentPage < $pageCount ? base_url('blog') . '?page=' . ($currentPage + 1) : null,
        ];

        return view($this->viewPath . 'blog/index', $this->viewData);
    }

    public function show(int $id, string $slug): string|RedirectResponse
    {
        $postModel = new BlogPostModel();
        $post = $postModel->publishedWithAuthor()->where('blog_post.id', $id)->first();

        if ($post === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        if ($slug !== $post['slug']) {
            $redirect = (new BlogPostRedirectModel())->findActive('blog/' . $id . '/' . $slug);
            if ($redirect === null || (int) $redirect['post_id'] !== $id) {
                throw PageNotFoundException::forPageNotFound();
            }
            return redirect()->to(base_url('blog/' . $post['id'] . '/' . rawurlencode($post['slug'])), 301);
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
            'canonical' => base_url('blog/' . $post['id'] . '/' . rawurlencode($post['slug'])),
            'og_type' => 'article',
            'og_image' => base_url($post['banner']),
            'article_published_time' => date(DATE_ATOM, (int) $post['created_at']),
            'article_modified_time' => date(DATE_ATOM, (int) $post['updated_at']),
        ];

        return view($this->viewPath . 'blog/show', $this->viewData);
    }

    public function legacy(string $slug): RedirectResponse
    {
        $redirect = (new BlogPostRedirectModel())->findActive('blog/' . $slug);
        $post = $redirect === null ? null : (new BlogPostModel())->publishedWithAuthor()
            ->where('blog_post.id', $redirect['post_id'])->first();
        if ($post === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        return redirect()->to(base_url('blog/' . $post['id'] . '/' . rawurlencode($post['slug'])), 301);
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
        $post['author_avatar_url'] = $this->viewData['assetsPath'] . 'images/user.jpg';
        $post['author_role_label'] = $roleLabels[$post['author_role']] ?? 'نویسنده';

        return $post;
    }
}
