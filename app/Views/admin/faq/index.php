<?= $this->extend('admin/_layout_/layout') ?>
<?= $this->section('content') ?>
<?php $inputClass = 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white'; ?>

<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>
            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200"><?= esc($title) ?></h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1"><?= $isCategory ? 'لیست تمام دسته‌بندی‌های سوالات متداول' : 'لیست تمام سوالات متداول سایت' ?></p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="<?= site_url($basePath . '/create') ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                <?= $isCategory ? 'افزودن دسته‌بندی جدید' : 'افزودن سوال جدید' ?>
                            </a>
                        </div>
                    </div>

                    <?php if ($message = session()->getFlashdata('faq_message')): ?>
                        <p role="status" class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-4"><?= esc($message) ?></p>
                    <?php endif; ?>

                    <div class="search-filters mb-6">
                        <form method="get" action="<?= site_url($basePath) ?>">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label for="filter_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= $isCategory ? 'عنوان دسته‌بندی' : 'متن سوال' ?></label>
                                    <input type="text" id="filter_title" name="title" value="<?= esc($filters['title']) ?>" placeholder="<?= $isCategory ? 'عنوان دسته‌بندی' : 'متن سوال' ?>" class="<?= $inputClass ?>">
                                </div>
                                <?php if (!$isCategory): ?>
                                    <div>
                                        <label for="filter_category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">دسته‌بندی</label>
                                        <select id="filter_category" name="category_id" class="<?= $inputClass ?>">
                                            <option value="">همه دسته‌بندی‌ها</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= (int) $category['id'] ?>" <?= (string) $category['id'] === $filters['category_id'] ? 'selected' : '' ?>><?= esc($category['title']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <label for="filter_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">وضعیت</label>
                                    <select id="filter_status" name="is_active" class="<?= $inputClass ?>">
                                        <option value="">همه</option>
                                        <option value="1" <?= $filters['is_active'] === '1' ? 'selected' : '' ?>>فعال</option>
                                        <option value="0" <?= $filters['is_active'] === '0' ? 'selected' : '' ?>>غیرفعال</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">جستجو</button>
                                <a href="<?= site_url($basePath) ?>" class="bg-gray-500 text-white py-2 px-6 rounded-lg hover:bg-gray-600 transition">ریست</a>
                            </div>
                        </form>
                    </div>

                    <?= $this->include('admin/faq/index_data_table') ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
