<?= $this->extend('admin/_layout_/layout') ?>
<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>

            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">مدیریت وبلاگ</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">مقالات، تصاویر اصلی و محتوای بلوکی</p>
                        </div>
                        <a href="<?= site_url('admin/blog/create') ?>" class="mt-4 md:mt-0 bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition shadow-sm flex items-center">
                            <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                            </svg>
                            افزودن مقاله
                        </a>
                    </div>

                    <form method="get" action="<?= site_url('admin/blog') ?>" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">عنوان مقاله</label>
                                <input id="title" name="title" type="text" value="<?= esc($filters['title']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" placeholder="جستجو در عنوان">
                            </div>
                            <div>
                                <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">وضعیت</label>
                                <select id="is_active" name="is_active" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                    <option value="">همه</option>
                                    <option value="1" <?= $filters['is_active'] === '1' ? 'selected' : '' ?>>فعال</option>
                                    <option value="0" <?= $filters['is_active'] === '0' ? 'selected' : '' ?>>غیرفعال</option>
                                </select>
                            </div>
                            <div class="flex items-end gap-2">
                                <button class="bg-primary text-white py-2 px-6 rounded-lg" type="submit">جستجو</button>
                                <a href="<?= site_url('admin/blog') ?>" class="bg-gray-500 text-white py-2 px-6 rounded-lg">ریست</a>
                            </div>
                        </div>
                    </form>

                    <?php if ($posts !== []): ?>
                        <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
                            <table class="w-full text-sm text-right">
                                <thead class="text-xs bg-gray-100 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th class="px-5 py-4">تصویر</th>
                                    <th class="px-5 py-4">عنوان</th>
                                    <th class="px-5 py-4">نویسنده</th>
                                    <th class="px-5 py-4">بلوک‌ها</th>
                                    <th class="px-5 py-4">وضعیت</th>
                                    <th class="px-5 py-4">عملیات</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                <?php foreach ($posts as $post): ?>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                        <td class="px-5 py-4">
                                            <img src="<?= base_url($post['thumbnail']) ?>" alt="" class="w-14 h-14 object-cover rounded-lg border">
                                        </td>
                                        <td class="px-5 py-4">
                                            <strong class="block mb-1"><?= esc($post['title']) ?></strong>
                                            <span class="text-gray-500 text-xs" dir="ltr"><?= esc($post['slug']) ?></span>
                                        </td>
                                        <td class="px-5 py-4"><?= esc($post['author_name']) ?></td>
                                        <td class="px-5 py-4"><?= (int) $post['block_count'] ?></td>
                                        <td class="px-5 py-4">
                                            <?php if ((int) $post['is_active'] === 1): ?>
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">فعال</span>
                                            <?php else: ?>
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">غیرفعال</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <a href="<?= site_url('admin/blog/blocks/' . $post['id']) ?>" class="text-blue-600 hover:text-blue-800" title="مدیریت محتوای مقاله" aria-label="مدیریت محتوای مقاله">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h10"/>
                                                    </svg>
                                                </a>
                                                <a href="<?= site_url('admin/blog/edit/' . $post['id']) ?>" class="text-primary hover:text-primary-800" title="ویرایش مقاله" aria-label="ویرایش مقاله">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                <?php if ((int) $post['is_active'] === 1): ?>
                                                    <a href="<?= site_url('blog/' . $post['slug']) ?>" target="_blank" rel="noopener" class="text-green-600 hover:text-green-800" title="نمایش مقاله" aria-label="نمایش مقاله">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>
                                                <?php endif; ?>
                                                <form method="post" action="<?= site_url('admin/blog/delete/' . $post['id']) ?>" onsubmit="return confirm('مقاله و تمام بلوک‌های آن حذف شوند؟')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="text-red-600 hover:text-red-800" title="حذف مقاله" aria-label="حذف مقاله">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?= $pager->links('default', 'admin_blog_pagination') ?>
                    <?php else: ?>
                        <div class="text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <p class="text-gray-600 dark:text-gray-300">مقاله‌ای پیدا نشد.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
