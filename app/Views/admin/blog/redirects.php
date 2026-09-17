<?= $this->extend('admin/_layout_/layout') ?>
<?php helper('form'); ?>
<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>

            <div class="lg:col-span-3 space-y-8" style="min-width: 0">
                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">مدیریت ریدایرکت‌های مقاله</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1"><?= esc($post['title']) ?></p>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-4 md:mt-0" style="margin-right: auto">
                            <a href="<?= site_url('admin/blog/history/' . $post['id']) ?>" class="bg-primary text-white py-2 px-4 rounded-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H5v14h14v-4M13 3h8v8m0-8L10 14"/>
                                </svg>
                                تاریخچه آدرس‌ها
                            </a>
                            <a href="<?= site_url('admin/blog/edit/' . $post['id']) ?>" class="bg-amber-500 text-white py-2 px-4 rounded-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                ویرایش مقاله
                            </a>
                            <a href="<?= site_url('admin/blog') ?>" class="bg-gray-200 text-gray-800 py-2 px-4 rounded-lg">بازگشت</a>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-xl p-4 mb-6 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">آدرس فعلی مقاله</p>
                        <a href="<?= esc(base_url('blog/' . $post['id'] . '/' . rawurlencode($post['slug']))) ?>" target="_blank" rel="noopener noreferrer" class="text-primary hover:text-primary-800" dir="ltr" style="overflow-wrap: anywhere; display: inline-block"><?= esc('blog/' . $post['id'] . '/' . $post['slug']) ?></a>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">آدرس‌های فعال با ریدایرکت ۳۰۱ مستقیماً به آدرس فعلی مقاله منتقل می‌شوند. ریدایرکت تغییرات جدید، پیش‌فرض غیرفعال است.</p>
                    </div>
                    <form method="get" action="<?= site_url('admin/blog/redirects/' . $post['id']) ?>" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">وضعیت</label>
                                <select id="is_active" name="is_active" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                    <option value="">همه</option>
                                    <option value="1" <?= $status === '1' ? 'selected' : '' ?>>فعال</option>
                                    <option value="0" <?= $status === '0' ? 'selected' : '' ?>>غیرفعال</option>
                                </select>
                            </div>
                            <div class="flex items-end gap-2">
                                <button class="bg-primary text-white py-2 px-6 rounded-lg" type="submit">جستجو</button>
                                <a href="<?= site_url('admin/blog/redirects/' . $post['id']) ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg">ریست</a>
                            </div>
                        </div>
                    </form>

                    <?php if ($redirects !== []): ?>
                        <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
                            <table class="w-full text-sm text-right">
                                <thead class="text-xs bg-gray-100 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th class="px-5 py-4">آدرس مبدأ</th>
                                        <th class="px-5 py-4">زمان ثبت</th>
                                        <th class="px-5 py-4">وضعیت</th>
                                        <th class="px-5 py-4">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    <?php foreach ($redirects as $row): ?>
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                            <td class="px-5 py-4"><span dir="ltr" style="overflow-wrap: anywhere"><?= esc($row['source_path']) ?></span></td>
                                            <td class="px-5 py-4"><span dir="ltr"><?= esc(date('Y/m/d H:i', (int) $row['created_at'])) ?></span></td>
                                            <td class="px-5 py-4">
                                                <?php if ((int) $row['is_active'] === 1): ?>
                                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">فعال</span>
                                                <?php else: ?>
                                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">غیرفعال</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-5 py-4">
                                                <form method="post" action="<?= site_url('admin/blog/redirects/' . $post['id'] . '/' . $row['id']) ?>">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="is_active" value="<?= $row['is_active'] ? '0' : '1' ?>">
                                                    <button type="submit" class="<?= $row['is_active'] ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' ?> flex items-center gap-2" title="<?= $row['is_active'] ? 'غیرفعال کردن ریدایرکت' : 'فعال کردن ریدایرکت' ?>">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <?php if ($row['is_active']): ?>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M6 18L18 6"/>
                                                            <?php else: ?>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            <?php endif; ?>
                                                        </svg>
                                                        <?= $row['is_active'] ? 'غیرفعال کردن' : 'فعال کردن' ?>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?= $pager->links('default', 'admin_blog_pagination') ?>
                    <?php else: ?>
                        <div class="text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <p class="text-gray-600 dark:text-gray-300">ریدایرکتی پیدا نشد.</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
