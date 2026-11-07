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
                        <h1 class="font-black text-2xl with-highlight dark:text-gray-200"><?= esc($title) ?></h1>
                        <div class="mt-4 md:mt-0">
                            <a href="<?= site_url($basePath) ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block">بازگشت به لیست</a>
                        </div>
                    </div>
        <?php if ($errors): ?><ul role="alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6"><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul><?php endif; ?>
        <?php if (!$isCategory && empty($categories)): ?><p class="mb-4">ابتدا <a class="text-primary" href="<?= site_url('admin/faq-category/create') ?>">یک دسته‌بندی ایجاد کنید</a>.</p><?php endif; ?>
        <form method="post" action="<?= site_url($formAction) ?>" class="space-y-4">
            <?= csrf_field() ?>
            <?php if ($isCategory): ?>
                <div><label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">عنوان دسته‌بندی</label><input id="title" name="title" placeholder="عنوان دسته‌بندی" class="<?= $inputClass ?>" value="<?= esc($row['title'] ?? '') ?>" maxlength="150" required></div>
            <?php else: ?>
                <div><label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">دسته‌بندی</label><select id="category_id" name="category_id" class="<?= $inputClass ?>" required>
                    <option value="">انتخاب دسته‌بندی</option>
                    <?php foreach ($categories as $category): ?><option value="<?= (int) $category['id'] ?>" <?= (string) ($row['category_id'] ?? '') === (string) $category['id'] ? 'selected' : '' ?>><?= esc($category['title']) ?><?= $category['is_active'] ? '' : ' (غیرفعال)' ?></option><?php endforeach; ?>
                </select></div>
                <div><label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">سوال</label><input id="question" name="question" placeholder="سوال کاربر..." class="<?= $inputClass ?>" value="<?= esc($row['question'] ?? '') ?>" maxlength="500" required></div>
                <div><label for="answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">پاسخ</label><textarea id="answer" name="answer" placeholder="پاسخ به سوال..." rows="6" maxlength="20000" class="<?= $inputClass ?>" required><?= esc($row['answer'] ?? '') ?></textarea></div>
            <?php endif; ?>
            <div><label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ترتیب نمایش</label><input type="number" id="sort_order" name="sort_order" class="<?= $inputClass ?>" value="<?= esc($row['sort_order']) ?>" min="0" max="2147483647" required></div>
            <div><label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">وضعیت</label><select id="is_active" name="is_active" class="<?= $inputClass ?>"><option value="1" <?= (string) $row['is_active'] === '1' ? 'selected' : '' ?>>فعال</option><option value="0" <?= (string) $row['is_active'] === '0' ? 'selected' : '' ?>>غیرفعال</option></select></div>
            <p class="text-sm text-gray-500 dark:text-gray-400"><?= $isCategory ? 'با غیرفعال شدن دسته‌بندی، سوال‌های آن هم در سایت نمایش داده نمی‌شوند.' : 'پاسخ به‌صورت متن نمایش داده می‌شود؛ برای جدا کردن پاراگراف‌ها از خط جدید استفاده کنید.' ?></p>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition"><?= isset($row['id']) ? 'بروزرسانی' : 'ذخیره' ?></button>
                <a href="<?= site_url($basePath) ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
