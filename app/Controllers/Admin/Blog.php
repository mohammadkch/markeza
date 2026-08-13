<?php

namespace App\Controllers\Admin;

use App\Models\BlogPostBlockModel;
use App\Models\BlogPostModel;
use CodeIgniter\HTTP\RedirectResponse;
use RuntimeException;
use Throwable;

class Blog extends BaseController
{
    private const MAX_IMAGE_SIZE = 5242880;
    private const UPLOAD_DIRECTORY = 'assets/images/blog/';

    public function index(): string
    {
        $postModel = new BlogPostModel();
        $title = trim((string) $this->request->getGet('title'));
        $status = $this->request->getGet('is_active');

        $postModel->select(
            'blog_post.*, user.full_name AS author_name, '
            . '(SELECT COUNT(*) FROM blog_post_block WHERE blog_post_block.post_id = blog_post.id) AS block_count',
            false
        )->join('user', 'user.id = blog_post.user_id');

        if ($title !== '') {
            $postModel->like('blog_post.title', $title);
        }
        if ($status === '0' || $status === '1') {
            $postModel->where('blog_post.is_active', (int) $status);
        }

        $posts = $postModel
            ->orderBy('blog_post.created_at', 'DESC')
            ->paginate(10);

        $postModel->pager->only(['title', 'is_active']);
        $this->viewData['posts'] = $posts;
        $this->viewData['pager'] = $postModel->pager;
        $this->viewData['filters'] = ['title' => $title, 'is_active' => $status];

        return view($this->viewPath . 'blog/index', $this->viewData);
    }

    public function create(): string
    {
        $this->viewData['post'] = null;
        $this->viewData['validation_errors'] = session('validation_errors') ?? [];

        return view($this->viewPath . 'blog/form', $this->viewData);
    }

    public function store(): RedirectResponse
    {
        return $this->savePost();
    }

    public function edit(int $id): string|RedirectResponse
    {
        $post = (new BlogPostModel())->find($id);
        if ($post === null) {
            $this->flash('blog_not_found');
            return redirect()->to(site_url('admin/blog'));
        }

        $this->viewData['post'] = $post;
        $this->viewData['validation_errors'] = session('validation_errors') ?? [];

        return view($this->viewPath . 'blog/form', $this->viewData);
    }

    public function update(int $id): RedirectResponse
    {
        return $this->savePost($id);
    }

    public function delete(int $id): RedirectResponse
    {
        $postModel = new BlogPostModel();
        $blockModel = new BlogPostBlockModel();
        $post = $postModel->find($id);
        if ($post === null) {
            $this->flash('blog_not_found');
            return redirect()->to(site_url('admin/blog'));
        }

        $files = array_filter([$post['thumbnail'], $post['banner']]);
        foreach ($blockModel->getByPost($id) as $block) {
            if (! empty($block['image_path'])) {
                $files[] = $block['image_path'];
            }
        }

        $db = db_connect();
        $transactionSucceeded = false;
        try {
            if (! $db->transStart()) {
                throw new RuntimeException('Blog delete transaction could not start.');
            }
            $postModel->delete($id);
            $transactionSucceeded = $db->transComplete();
        } catch (Throwable $exception) {
            log_message('error', 'Blog post delete failed: {message}', ['message' => $exception->getMessage()]);
            $db->transRollback();
        }

        if (! $transactionSucceeded) {
            $this->flash('blog_delete_error');
            return redirect()->to(site_url('admin/blog'));
        }

        foreach (array_unique($files) as $file) {
            $this->deleteFileIfUnused($file);
        }
        $this->flash('blog_delete_success');

        return redirect()->to(site_url('admin/blog'));
    }

    public function blocks(int $postId): string|RedirectResponse
    {
        return $this->renderBlocks($postId);
    }

    public function storeBlock(int $postId): RedirectResponse
    {
        return $this->saveBlock($postId);
    }

    public function editBlock(int $postId, int $blockId): string|RedirectResponse
    {
        return $this->renderBlocks($postId, $blockId);
    }

    public function updateBlock(int $postId, int $blockId): RedirectResponse
    {
        return $this->saveBlock($postId, $blockId);
    }

    public function deleteBlock(int $postId, int $blockId): RedirectResponse
    {
        $blockModel = new BlogPostBlockModel();
        $block = $blockModel->where('post_id', $postId)->find($blockId);
        if ($block === null) {
            $this->flash('blog_block_not_found');
            return redirect()->to(site_url('admin/blog/blocks/' . $postId));
        }

        if (! $blockModel->delete($blockId)) {
            $this->flash('blog_block_save_error');
            return redirect()->to(site_url('admin/blog/blocks/' . $postId));
        }

        if (! empty($block['image_path'])) {
            $this->deleteFileIfUnused($block['image_path']);
        }
        $this->flash('blog_block_delete_success');

        return redirect()->to(site_url('admin/blog/blocks/' . $postId));
    }

    public function reorderBlocks(int $postId): RedirectResponse
    {
        if ((new BlogPostModel())->find($postId) === null) {
            $this->flash('blog_not_found');
            return redirect()->to(site_url('admin/blog'));
        }

        $order = json_decode((string) $this->request->getPost('order'), true);
        if (! is_array($order)) {
            $this->flash('blog_block_save_error', 'ترتیب ارسال‌شده معتبر نیست.');
            return redirect()->to(site_url('admin/blog/blocks/' . $postId));
        }

        foreach ($order as $blockId) {
            if (! is_int($blockId) || $blockId < 1) {
                $this->flash('blog_block_save_error', 'شناسه‌های ترتیب بلوک‌ها معتبر نیستند.');
                return redirect()->to(site_url('admin/blog/blocks/' . $postId));
            }
        }

        $normalizedOrder = $order;
        if (count($normalizedOrder) !== count(array_unique($normalizedOrder))) {
            $this->flash('blog_block_save_error', 'شناسه‌های ترتیب بلوک‌ها معتبر نیستند.');
            return redirect()->to(site_url('admin/blog/blocks/' . $postId));
        }

        $orderForComparison = $normalizedOrder;
        $blockModel = new BlogPostBlockModel();
        $existingIds = array_map(
            static fn (array $block): int => (int) $block['id'],
            $blockModel->select('id')->where('post_id', $postId)->findAll()
        );
        sort($orderForComparison);
        sort($existingIds);
        if ($orderForComparison !== $existingIds) {
            $this->flash('blog_block_save_error', 'لیست بلوک‌ها با مقاله مطابقت ندارد.');
            return redirect()->to(site_url('admin/blog/blocks/' . $postId));
        }

        $db = db_connect();
        $transactionSucceeded = false;
        try {
            if (! $db->transStart()) {
                throw new RuntimeException('Blog reorder transaction could not start.');
            }
            foreach ($normalizedOrder as $index => $blockId) {
                $blockModel->update($blockId, ['sort_order' => $index + 1]);
            }
            $transactionSucceeded = $db->transComplete();
        } catch (Throwable $exception) {
            log_message('error', 'Blog block reorder failed: {message}', ['message' => $exception->getMessage()]);
            $db->transRollback();
        }

        $this->flash($transactionSucceeded ? 'blog_blocks_reorder_success' : 'blog_block_save_error');
        return redirect()->to(site_url('admin/blog/blocks/' . $postId));
    }

    private function savePost(?int $id = null): RedirectResponse
    {
        $postModel = new BlogPostModel();
        $existing = $id === null ? null : $postModel->find($id);
        if ($id !== null && $existing === null) {
            $this->flash('blog_not_found');
            return redirect()->to(site_url('admin/blog'));
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'permit_empty|max_length[255]',
            'excerpt' => 'required|min_length[10]|max_length[500]',
            'meta_title' => 'permit_empty|max_length[255]',
            'meta_description' => 'permit_empty|max_length[500]',
            'is_active' => 'required|in_list[0,1]',
            'sort_order' => 'permit_empty|integer',
        ];
        if (! $this->validate($rules)) {
            return $this->redirectPostForm($id, $this->validator->getErrors());
        }

        $slug = $this->uniqueSlug(
            (string) $this->request->getPost('slug'),
            (string) $this->request->getPost('title'),
            $id
        );
        $newFiles = [];

        try {
            $thumbnail = $this->uploadImage('thumbnail', $existing === null);
            if ($thumbnail !== null) {
                $newFiles[] = $thumbnail;
            }
            $banner = $this->uploadImage('banner', $existing === null);
            if ($banner !== null) {
                $newFiles[] = $banner;
            }
        } catch (RuntimeException $exception) {
            foreach ($newFiles as $file) {
                $this->deletePhysicalFile($file);
            }
            return $this->redirectPostForm($id, [$exception->getMessage()]);
        }

        $data = [
            'title' => trim((string) $this->request->getPost('title')),
            'slug' => $slug,
            'excerpt' => trim((string) $this->request->getPost('excerpt')),
            'meta_title' => trim((string) $this->request->getPost('meta_title')) ?: null,
            'meta_description' => trim((string) $this->request->getPost('meta_description')) ?: null,
            'is_active' => (int) $this->request->getPost('is_active'),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
        ];
        if ($thumbnail !== null) {
            $data['thumbnail'] = $thumbnail;
        }
        if ($banner !== null) {
            $data['banner'] = $banner;
        }
        if ($existing === null) {
            $data['user_id'] = (int) $this->authLib->getUserID();
        }

        $db = db_connect();
        $transactionSucceeded = false;
        try {
            if (! $db->transStart()) {
                throw new RuntimeException('Blog save transaction could not start.');
            }
            if ($existing === null) {
                $id = (int) $postModel->insert($data, true);
            } else {
                $postModel->update($id, $data);
            }
            $transactionSucceeded = $db->transComplete();
        } catch (Throwable $exception) {
            log_message('error', 'Blog post save failed: {message}', ['message' => $exception->getMessage()]);
            $db->transRollback();
        }

        if (! $transactionSucceeded || empty($id)) {
            foreach ($newFiles as $file) {
                $this->deletePhysicalFile($file);
            }
            $this->flash('blog_save_error');
            return redirect()->to(site_url($existing === null ? 'admin/blog/create' : 'admin/blog/edit/' . $id))->withInput();
        }

        if ($existing !== null) {
            if ($thumbnail !== null && $existing['thumbnail'] !== $thumbnail) {
                $this->deleteFileIfUnused($existing['thumbnail']);
            }
            if ($banner !== null && $existing['banner'] !== $banner) {
                $this->deleteFileIfUnused($existing['banner']);
            }
        }

        $this->flash($existing === null ? 'blog_create_success' : 'blog_update_success');
        return redirect()->to(site_url('admin/blog/blocks/' . $id));
    }

    private function renderBlocks(int $postId, ?int $editBlockId = null): string|RedirectResponse
    {
        $post = (new BlogPostModel())->find($postId);
        if ($post === null) {
            $this->flash('blog_not_found');
            return redirect()->to(site_url('admin/blog'));
        }

        $blockModel = new BlogPostBlockModel();
        $editBlock = null;
        if ($editBlockId !== null) {
            $editBlock = $blockModel->where('post_id', $postId)->find($editBlockId);
            if ($editBlock === null) {
                $this->flash('blog_block_not_found');
                return redirect()->to(site_url('admin/blog/blocks/' . $postId));
            }
        }

        $this->viewData['post'] = $post;
        $this->viewData['blocks'] = $blockModel->getByPost($postId);
        $this->viewData['edit_block'] = $editBlock;
        $this->viewData['validation_errors'] = session('validation_errors') ?? [];

        return view($this->viewPath . 'blog/blocks', $this->viewData);
    }

    private function saveBlock(int $postId, ?int $blockId = null): RedirectResponse
    {
        $post = (new BlogPostModel())->find($postId);
        if ($post === null) {
            $this->flash('blog_not_found');
            return redirect()->to(site_url('admin/blog'));
        }

        $blockModel = new BlogPostBlockModel();
        $existing = $blockId === null ? null : $blockModel->where('post_id', $postId)->find($blockId);
        if ($blockId !== null && $existing === null) {
            $this->flash('blog_block_not_found');
            return redirect()->to(site_url('admin/blog/blocks/' . $postId));
        }

        $type = (string) $this->request->getPost('block_type');
        if (! in_array($type, ['text', 'heading', 'image', 'quote'], true)) {
            return $this->redirectBlockForm($postId, $blockId, ['نوع بلوک معتبر نیست.']);
        }

        $content = trim((string) $this->request->getPost('content'));
        if ($type === 'text') {
            helper('blog_content');
            $content = sanitize_blog_rich_text($content);
        } else {
            $content = trim(strip_tags($content));
        }
        if ($type !== 'image' && trim(strip_tags($content)) === '') {
            return $this->redirectBlockForm($postId, $blockId, ['محتوای بلوک الزامی است.']);
        }
        if ($type === 'heading' && mb_strlen($content) > 255) {
            return $this->redirectBlockForm($postId, $blockId, ['عنوان بلوک نباید بیشتر از ۲۵۵ کاراکتر باشد.']);
        }
        if ($type !== 'heading' && mb_strlen(strip_tags($content)) > 10000) {
            return $this->redirectBlockForm($postId, $blockId, ['محتوای بلوک بیش از حد طولانی است.']);
        }

        $altText = trim((string) $this->request->getPost('alt_text'));
        $caption = trim((string) $this->request->getPost('caption'));
        if (mb_strlen($altText) > 255 || mb_strlen($caption) > 500) {
            return $this->redirectBlockForm($postId, $blockId, ['متن جایگزین یا کپشن تصویر بیش از حد طولانی است.']);
        }

        $newImage = null;
        try {
            if ($type === 'image') {
                $newImage = $this->uploadImage('image', $existing === null || empty($existing['image_path']));
            }
        } catch (RuntimeException $exception) {
            return $this->redirectBlockForm($postId, $blockId, [$exception->getMessage()]);
        }

        $data = [
            'post_id' => $postId,
            'block_type' => $type,
            'content' => $type === 'image' ? null : $content,
            'image_path' => $type === 'image' ? ($newImage ?? $existing['image_path'] ?? null) : null,
            'alt_text' => $type === 'image' ? $altText : null,
            'caption' => $type === 'image' ? ($caption ?: null) : null,
            'heading_level' => $type === 'heading' && (int) $this->request->getPost('heading_level') === 3 ? 3 : 2,
        ];
        if ($type === 'image' && $data['alt_text'] === '') {
            if ($newImage !== null) {
                $this->deletePhysicalFile($newImage);
            }
            return $this->redirectBlockForm($postId, $blockId, ['متن جایگزین تصویر الزامی است.']);
        }

        $db = db_connect();
        $transactionSucceeded = false;
        try {
            if (! $db->transStart()) {
                throw new RuntimeException('Blog block transaction could not start.');
            }
            if ($existing === null) {
                $db->query('SELECT id FROM blog_post WHERE id = ? FOR UPDATE', [$postId]);
                $last = $db->table('blog_post_block')
                    ->selectMax('sort_order')
                    ->where('post_id', $postId)
                    ->get()
                    ->getRowArray();
                $data['sort_order'] = ((int) ($last['sort_order'] ?? 0)) + 1;
                $blockModel->insert($data);
            } else {
                $blockModel->update($blockId, $data);
            }
            $transactionSucceeded = $db->transComplete();
        } catch (Throwable $exception) {
            log_message('error', 'Blog block save failed: {message}', ['message' => $exception->getMessage()]);
            $db->transRollback();
        }

        if (! $transactionSucceeded) {
            if ($newImage !== null) {
                $this->deletePhysicalFile($newImage);
            }
            $this->flash('blog_block_save_error');
            return redirect()->to(site_url('admin/blog/blocks/' . $postId));
        }

        if ($existing !== null && ! empty($existing['image_path']) && $existing['image_path'] !== ($data['image_path'] ?? null)) {
            $this->deleteFileIfUnused($existing['image_path']);
        }
        $this->flash($existing === null ? 'blog_block_create_success' : 'blog_block_update_success');

        return redirect()->to(site_url('admin/blog/blocks/' . $postId));
    }

    private function uploadImage(string $field, bool $required): ?string
    {
        $file = $this->request->getFile($field);
        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            if ($required) {
                throw new RuntimeException('انتخاب تصویر الزامی است.');
            }
            return null;
        }
        if (! $file->isValid()) {
            throw new RuntimeException('آپلود تصویر با خطا مواجه شد.');
        }
        if ($file->getSize() > self::MAX_IMAGE_SIZE) {
            throw new RuntimeException('حجم تصویر نباید بیشتر از ۵ مگابایت باشد.');
        }

        $mimeExtensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];
        $mime = $file->getMimeType();
        $dimensions = @getimagesize($file->getTempName());
        if (! isset($mimeExtensions[$mime]) || $dimensions === false) {
            throw new RuntimeException('فقط تصاویر معتبر JPG، PNG و WebP پذیرفته می‌شوند.');
        }
        if ($dimensions[0] > 8000 || $dimensions[1] > 8000 || ($dimensions[0] * $dimensions[1]) > 40000000) {
            throw new RuntimeException('ابعاد تصویر بیش از حد مجاز است.');
        }

        $relativeDirectory = self::UPLOAD_DIRECTORY;
        $absoluteDirectory = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $relativeDirectory);
        if (! is_dir($absoluteDirectory) && ! mkdir($absoluteDirectory, 0755, true) && ! is_dir($absoluteDirectory)) {
            throw new RuntimeException('امکان ساخت پوشه تصاویر وجود ندارد.');
        }

        $name = bin2hex(random_bytes(16)) . '.' . $mimeExtensions[$mime];
        if (! $file->move($absoluteDirectory, $name)) {
            throw new RuntimeException('ذخیره تصویر با خطا مواجه شد.');
        }

        return $relativeDirectory . $name;
    }

    private function uniqueSlug(string $requestedSlug, string $title, ?int $ignoreId): string
    {
        $slug = mb_strtolower(trim($requestedSlug !== '' ? $requestedSlug : $title));
        $slug = preg_replace('/[\s_]+/u', '-', $slug) ?? '';
        $slug = preg_replace('/[^\p{L}\p{N}-]+/u', '', $slug) ?? '';
        $slug = trim(preg_replace('/-+/u', '-', $slug) ?? '', '-');
        if ($slug === '') {
            $slug = 'post-' . bin2hex(random_bytes(4));
        }

        $base = $slug;
        $suffix = 2;
        $model = new BlogPostModel();
        while (true) {
            $model->where('slug', $slug);
            if ($ignoreId !== null) {
                $model->where('id !=', $ignoreId);
            }
            if ($model->first() === null) {
                return $slug;
            }
            $suffixText = '-' . $suffix++;
            $slug = mb_substr($base, 0, 255 - mb_strlen($suffixText)) . $suffixText;
        }
    }

    private function redirectPostForm(?int $id, array $errors): RedirectResponse
    {
        return redirect()
            ->to(site_url($id === null ? 'admin/blog/create' : 'admin/blog/edit/' . $id))
            ->withInput()
            ->with('validation_errors', $errors);
    }

    private function redirectBlockForm(int $postId, ?int $blockId, array $errors): RedirectResponse
    {
        $path = 'admin/blog/blocks/' . $postId;
        if ($blockId !== null) {
            $path .= '/edit/' . $blockId;
        }

        return redirect()->to(site_url($path))->withInput()->with('validation_errors', $errors);
    }

    private function deleteFileIfUnused(string $path): void
    {
        if (! str_starts_with(str_replace('\\', '/', $path), self::UPLOAD_DIRECTORY)) {
            return;
        }

        try {
            $db = db_connect();
            $postReferences = $db->table('blog_post')
                ->groupStart()
                ->where('thumbnail', $path)
                ->orWhere('banner', $path)
                ->groupEnd()
                ->countAllResults();
            $blockReferences = $db->table('blog_post_block')->where('image_path', $path)->countAllResults();
            if ($postReferences === 0 && $blockReferences === 0) {
                $this->deletePhysicalFile($path);
            }
        } catch (Throwable $exception) {
            log_message('error', 'Blog file cleanup failed: {message}', ['message' => $exception->getMessage()]);
        }
    }

    private function deletePhysicalFile(string $path): void
    {
        $normalized = str_replace('\\', '/', $path);
        if (! str_starts_with($normalized, self::UPLOAD_DIRECTORY) || str_contains($normalized, '..')) {
            return;
        }

        $absolutePath = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $normalized);
        try {
            if (is_file($absolutePath) && ! @unlink($absolutePath)) {
                log_message('error', 'Blog file could not be removed: {path}', ['path' => $normalized]);
                return;
            }

            $directory = dirname($absolutePath);
            $uploadRoot = rtrim(FCPATH . str_replace('/', DIRECTORY_SEPARATOR, self::UPLOAD_DIRECTORY), DIRECTORY_SEPARATOR);
            if ($directory !== $uploadRoot && is_dir($directory)) {
                $entries = scandir($directory);
                if ($entries === ['.', '..']) {
                    @rmdir($directory);
                }
            }
        } catch (Throwable $exception) {
            log_message('error', 'Blog physical file cleanup failed: {message}', ['message' => $exception->getMessage()]);
        }
    }
}
