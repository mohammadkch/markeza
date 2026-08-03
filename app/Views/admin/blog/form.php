<?= $this->extend('admin/_layout_/layout') ?>
<?php helper('form'); ?>
<?= $this->section('content') ?>

<?php
$isEdit = $post !== null;
$value = static function (string $field, $default = '') use ($post) {
    return old($field, $post[$field] ?? $default, false);
};
?>

<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>

            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <h1 class="font-black text-2xl with-highlight dark:text-gray-200"><?= $isEdit ? 'ویرایش مقاله' : 'افزودن مقاله' ?></h1>
                        <div class="flex gap-2 mt-4 md:mt-0" style="margin-right: auto">
                            <a href="<?= site_url('admin/blog') ?>" class="bg-gray-500 text-white py-2 px-4 rounded-lg">بازگشت</a>
                            <?php if ($isEdit): ?>
                                <a href="<?= site_url('admin/blog/blocks/' . $post['id']) ?>" class="bg-amber-500 text-white py-2 px-4 rounded-lg flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h10"/>
                                    </svg>
                                    ویرایش محتوا
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($validation_errors !== []): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <ul>
                                <?php foreach ($validation_errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url($isEdit ? 'admin/blog/edit/' . $post['id'] : 'admin/blog/create') ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium mb-2">عنوان مقاله</label>
                                <input id="title" name="title" type="text" maxlength="255" required value="<?= esc($value('title')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600">
                            </div>
                            <div class="md:col-span-2">
                                <label for="slug" class="block text-sm font-medium mb-2">Slug</label>
                                <input id="slug" name="slug" type="text" maxlength="255" value="<?= esc($value('slug')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600" dir="ltr" placeholder="خالی بگذارید تا از عنوان ساخته شود">
                            </div>
                            <div class="md:col-span-2">
                                <label for="excerpt" class="block text-sm font-medium mb-2">خلاصه مقاله</label>
                                <textarea id="excerpt" name="excerpt" rows="4" maxlength="500" required class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600"><?= esc($value('excerpt')) ?></textarea>
                            </div>
                            <div>
                                <label for="meta_title" class="block text-sm font-medium mb-2">عنوان SEO</label>
                                <input id="meta_title" name="meta_title" type="text" maxlength="255" value="<?= esc($value('meta_title')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600">
                            </div>
                            <div>
                                <label for="meta_description" class="block text-sm font-medium mb-2">توضیحات SEO</label>
                                <textarea id="meta_description" name="meta_description" rows="3" maxlength="500" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600"><?= esc($value('meta_description')) ?></textarea>
                            </div>
                            <div>
                                <label for="sort_order" class="block text-sm font-medium mb-2">ترتیب نمایش</label>
                                <input id="sort_order" name="sort_order" type="number" value="<?= esc($value('sort_order', 0)) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600">
                            </div>
                            <div>
                                <label for="is_active" class="block text-sm font-medium mb-2">وضعیت</label>
                                <select id="is_active" name="is_active" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600">
                                    <option value="1" <?= (string) $value('is_active', 1) === '1' ? 'selected' : '' ?>>فعال</option>
                                    <option value="0" <?= (string) $value('is_active', 1) === '0' ? 'selected' : '' ?>>غیرفعال</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="border border-gray-200 rounded-xl p-4">
                                <label for="thumbnail" class="block font-bold mb-3">تصویر Thumbnail <?= $isEdit ? '' : '*' ?></label>
                                <?php if ($isEdit): ?><img src="<?= base_url($post['thumbnail']) ?>" alt="" class="w-full h-40 object-cover rounded-lg mb-3"><?php endif; ?>
                                <input id="thumbnail" name="thumbnail" type="file" accept="image/jpeg,image/png,image/webp" <?= $isEdit ? '' : 'required' ?> class="w-full text-sm">
                                <p class="text-xs text-gray-500 mt-2">JPG، PNG یا WebP، حداکثر ۵MB</p>
                            </div>
                            <div class="border border-gray-200 rounded-xl p-4">
                                <label for="banner" class="block font-bold mb-3">تصویر Banner <?= $isEdit ? '' : '*' ?></label>
                                <?php if ($isEdit): ?><img src="<?= base_url($post['banner']) ?>" alt="" class="w-full h-40 object-cover rounded-lg mb-3"><?php endif; ?>
                                <input id="banner" name="banner" type="file" accept="image/jpeg,image/png,image/webp" <?= $isEdit ? '' : 'required' ?> class="w-full text-sm">
                                <p class="text-xs text-gray-500 mt-2">JPG، PNG یا WebP، حداکثر ۵MB</p>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg"><?= $isEdit ? 'بروزرسانی' : 'ذخیره و ویرایش محتوا' ?></button>
                            <a href="<?= site_url('admin/blog') ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg">انصراف</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
