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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                            </svg>
                            <span class="mr-1">محصولات</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col items-center justify-center relative my-16">
                <h1 class="font-YekanBakh-ExtraBlack text-3xl">محصولات مارکزا</h1>
                <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
                <p class="mt-4 text-gray-600">مجموعه‌ای از مبلمان چرم لوکس با طراحی ایتالیایی</p>
            </div>

            <?php foreach ($collections as $collection): ?>
                <?php if (empty($collection['products'])) continue; ?>

                <div class="mb-6 mt-16">
                    <h2 class="font-YekanBakh-ExtraBlack text-2xl">
                        <a href="<?= base_url('collection/' . $collection['slug']) ?>" class="hover:text-orange-600 transition">
                            <?= esc($collection['title']) ?>
                        </a>
                    </h2>
                    <?php if (!empty($collection['subtitle'])): ?>
                        <p class="text-orange-600 font-YekanBakh-Bold text-sm"><?= esc($collection['subtitle']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($collection['products'] as $product): ?>
                        <div class="group relative overflow-hidden rounded-2xl">
                            <a href="<?= base_url('product/' . $product['slug']) ?>">
                                <img class="transition duration-300 ease-in-out group-hover:scale-110 w-full rounded-2xl"
                                     src="<?= base_url(esc($product['thumbnail'] ?? 'assets/images/product/default-product.webp')) ?>"
                                     alt="<?= esc($product['title']) ?>"
                                     loading="lazy">
                                <div class="absolute bottom-0 w-full text-center text-white bg-gradient-to-t from-stone-800 pt-10 pb-3 rounded-b-2xl">
                                    <h3 class="text-sm"><?= esc($product['title']) ?></h3>
                                    <p class="opacity-0 group-hover:opacity-100 transition-all duration-300 group-hover:my-3 text-xs">جهت مشاهده کلیک کنید...</p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($collection !== end($collections)): ?>
                    <hr style="border-color: #e5e7eb; margin-top: 30px; margin-bottom: 30px;">
                <?php endif; ?>

            <?php endforeach; ?>

            <?php if (empty($collections)): ?>
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg">هیچ محصولی یافت نشد.</p>
                </div>
            <?php endif; ?>

        </div>
    </section>

<?= $this->endSection() ?>