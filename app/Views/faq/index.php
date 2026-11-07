<?= $this->extend('_layout_/layout') ?>
<?= $this->section('content') ?>
<section class="px-4 py-14 mb-16">
    <div class="container mx-auto max-w-screen-xl">
        <nav class="mb-8" aria-label="مسیر صفحه"><a href="<?= base_url('/') ?>">خانه</a><span class="mx-2" aria-hidden="true">/</span><span>سوالات متداول</span></nav>
        <div class="text-center mb-10">
            <h1 class="font-YekanBakh-ExtraBlack text-3xl mb-4">سوالات متداول</h1>
            <p class="leading-8">پاسخ سوال‌های خود را پیدا کنید یا دسته‌بندی موردنظرتان را انتخاب کنید.</p>
        </div>
        <nav class="flex flex-wrap justify-center gap-3 mb-10" aria-label="دسته‌بندی سوالات">
            <a href="<?= base_url('faq') ?>" class="rounded-full px-4 py-2 <?= $selectedCategory === null ? 'bg-stone-900 text-white' : 'bg-orange-200' ?>" <?= $selectedCategory === null ? 'aria-current="page"' : '' ?>>همه سوالات</a>
            <?php foreach ($categories as $category): ?>
                <a href="<?= base_url('faq') . '?category=' . (int) $category['id'] ?>" class="rounded-full px-4 py-2 <?= $selectedCategory === (int) $category['id'] ? 'bg-stone-900 text-white' : 'bg-orange-200' ?>" <?= $selectedCategory === (int) $category['id'] ? 'aria-current="page"' : '' ?>><?= esc($category['title']) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="max-w-3xl mx-auto">
            <?php if (empty($faqs)): ?>
                <p class="text-center bg-white p-6 rounded-3xl leading-8">هنوز سوالی در این بخش ثبت نشده است.</p>
            <?php endif; ?>
            <?php foreach ($faqs as $faq): ?>
                <article class="bg-white rounded-3xl p-6 mb-4">
                    <a class="inline-block bg-orange-100 rounded-full px-3 py-1 mb-3 text-xs" href="<?= base_url('faq') . '?category=' . (int) $faq['category_id'] ?>"><?= esc($faq['category_title']) ?></a>
                    <details>
                        <summary class="font-YekanBakh-Bold text-lg cursor-pointer leading-8"><?= esc($faq['question']) ?></summary>
                        <div class="mt-4 leading-8 text-stone-700"><?= nl2br(esc($faq['answer'])) ?></div>
                    </details>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
