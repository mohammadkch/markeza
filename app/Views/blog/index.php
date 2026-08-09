<?= $this->extend('_layout_/layout') ?>
<?= $this->section('content') ?>

<section class="px-4 mb-24">
    <div class="container mx-auto max-w-screen-xl">
        <nav class="flex mb-5 border-y border-orange-200 py-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="<?= base_url('/') ?>">خانه</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                        </svg>
                        <span class="mr-1">وبلاگ</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col items-center justify-center relative my-16 text-center">
            <h1 class="font-YekanBakh-ExtraBlack text-3xl">وبـــــــــلاگ</h1>
            <div class="absolute -top-6">
                <span class="font-YekanBakh-ExtraBlack text-6xl text-opacity-10 text-stone-900">blog</span>
            </div>
            <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
            <p class="mt-8 text-stone-700 leading-8">راهنمای انتخاب، نگهداری و چیدمان مبلمان برای ساختن خانه‌ای ماندگار</p>
        </div>

        <?php if ($posts !== []): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach ($posts as $post): ?>
                    <article class="bg-white overflow-hidden rounded-3xl leading-8 transform hover:-translate-y-1 duration-300 transition-transform flex flex-col">
                        <div class="p-6">
                            <div class="flex items-center mb-4 border-b border-dashed pb-4">
                                <div class="avatar ml-2">
                                    <div class="w-14 rounded-full overflow-hidden">
                                        <img class="w-full object-cover" style="height: 3.5rem" src="<?= esc($post['author_avatar_url']) ?>" alt="<?= esc($post['author_name']) ?>">
                                    </div>
                                </div>
                                <div class="flex flex-col mt-1">
                                    <span class="font-YekanBakh-Bold text-slate-800 text-sm mb-2"><?= esc($post['author_name']) ?></span>
                                    <span class="text-xs"><?= esc($post['author_role_label']) ?></span>
                                </div>
                            </div>

                            <div class="flex items-start mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="mt-1">
                                    <path d="M13.98 5.31999L10.77 8.52999L8.79999 10.49C7.96999 11.32 7.96999 12.67 8.79999 13.5L13.98 18.68C14.66 19.36 15.82 18.87 15.82 17.92V12.31V6.07999C15.82 5.11999 14.66 4.63999 13.98 5.31999Z" fill="#124f48"/>
                                </svg>
                                <a href="<?= base_url('blog/' . $post['slug']) ?>">
                                    <h2 class="font-YekanBakh-ExtraBold text-base mr-1"><?= esc($post['title']) ?></h2>
                                </a>
                            </div>
                            <p class="text-stone-700"><?= esc($post['excerpt']) ?></p>
                        </div>

                        <a style="margin-top: auto; display: block" href="<?= base_url('blog/' . $post['slug']) ?>">
                            <img class="w-full object-cover" style="height: 14rem" src="<?= esc($post['thumbnail_url']) ?>" alt="<?= esc($post['title']) ?>" loading="lazy">
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>

            <?= $pager->links('default', 'blog_pagination') ?>
        <?php else: ?>
            <div class="bg-white rounded-3xl p-10 text-center max-w-2xl mx-auto leading-8">
                <h2 class="font-YekanBakh-ExtraBlack text-xl mb-3">هنوز مقاله‌ای منتشر نشده است</h2>
                <p>به‌زودی مطالب تخصصی مارکزا هوم در این بخش منتشر می‌شوند.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
