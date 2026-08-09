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
                        <a href="<?= base_url('blog') ?>" class="mr-1">وبلاگ</a>
                    </div>
                </li>
                <li class="hidden md:block">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                        </svg>
                        <span class="mr-1"><?= esc($post['title']) ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <article class="max-w-4xl mx-auto">
            <header class="flex flex-col items-center justify-center relative my-16 text-center">
                <h1 class="font-YekanBakh-ExtraBlack text-3xl leading-10"><?= esc($post['title']) ?></h1>
                <div class="bg-orange-200 w-20 h-1.5 rounded-full mt-5"></div>
                <p class="mt-6 leading-8 text-stone-700 max-w-2xl"><?= esc($post['excerpt']) ?></p>

                <div class="flex items-center mt-6">
                    <div class="avatar ml-3">
                        <div class="w-14 rounded-full overflow-hidden">
                            <img class="w-full object-cover" style="height: 3.5rem" src="<?= esc($post['author_avatar_url']) ?>" alt="<?= esc($post['author_name']) ?>">
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-YekanBakh-Bold"><?= esc($post['author_name']) ?></p>
                        <p class="text-xs mt-1"><?= esc($post['author_role_label']) ?> · <?= esc(date('Y/m/d', (int) $post['created_at'])) ?></p>
                    </div>
                </div>
            </header>

            <figure class="mb-12">
                <img class="rounded-3xl w-full object-cover" style="max-height: 34rem" src="<?= esc($post['banner_url']) ?>" alt="<?= esc($post['title']) ?>">
            </figure>

            <div class="leading-9 mb-16">
                <?php foreach ($blocks as $block): ?>
                    <?php if ($block['block_type'] === 'heading'): ?>
                        <?php if ((int) $block['heading_level'] === 3): ?>
                            <h3 class="font-YekanBakh-ExtraBlack text-xl mb-4" style="margin-top: 2.5rem"><?= esc($block['content']) ?></h3>
                        <?php else: ?>
                            <h2 class="font-YekanBakh-ExtraBlack text-2xl mb-5" style="margin-top: 3rem"><?= esc($block['content']) ?></h2>
                        <?php endif; ?>
                    <?php elseif ($block['block_type'] === 'text'): ?>
                        <p class="mb-5 text-base text-stone-700"><?= nl2br(esc($block['content'])) ?></p>
                    <?php elseif ($block['block_type'] === 'image' && ! empty($block['image_path'])): ?>
                        <figure style="margin-top: 2.5rem; margin-bottom: 2.5rem">
                            <img class="rounded-3xl w-full object-cover" src="<?= esc(base_url($block['image_path'])) ?>" alt="<?= esc($block['alt_text'] ?? '') ?>" loading="lazy">
                            <?php if (! empty($block['caption'])): ?>
                                <figcaption class="text-center text-stone-700 mt-3"><?= esc($block['caption']) ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php elseif ($block['block_type'] === 'quote'): ?>
                        <blockquote class="p-6 bg-orange-100 rounded-3xl font-YekanBakh-Bold leading-9" style="margin-top: 2.5rem; margin-bottom: 2.5rem; border-right: 4px solid #b9d8d1; font-size: 1.125rem">
                            <?= esc($block['content']) ?>
                        </blockquote>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <?php if ($relatedPosts !== []): ?>
                <section class="mb-12">
                    <div class="mb-6">
                        <span class="font-YekanBakh-Bold bg-orange-200 rounded-full px-4 py-1">مقالات مشابه</span>
                        <p class="mt-3">مطالب بیشتری از مجله مارکزا هوم بخوانید.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($relatedPosts as $relatedPost): ?>
                            <article class="flex items-center bg-white p-3 rounded-3xl">
                                <div class="w-32 ml-4">
                                    <a href="<?= base_url('blog/' . $relatedPost['slug']) ?>">
                                        <img class="rounded-xl w-full object-cover" style="height: 6rem" src="<?= esc($relatedPost['thumbnail_url']) ?>" alt="<?= esc($relatedPost['title']) ?>" loading="lazy">
                                    </a>
                                </div>
                                <div>
                                    <a href="<?= base_url('blog/' . $relatedPost['slug']) ?>">
                                        <h2 class="font-YekanBakh-ExtraBold text-base"><?= esc($relatedPost['title']) ?></h2>
                                    </a>
                                    <p class="mt-2 text-stone-700"><?= esc($relatedPost['excerpt']) ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </article>
    </div>
</section>

<?= $this->endSection() ?>
