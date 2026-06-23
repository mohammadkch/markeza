<?= $this->extend('_layout_/layout') ?>
<?= $this->section('content') ?>

    <section class="px-4 mb-24">
        <div class="container mx-auto max-w-screen-xl">

            <!-- Breadcrumb -->
            <nav class="flex mb-5 border-y border-orange-200 py-3" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('/') ?>">خانه</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            <a href="<?= base_url('product') ?>" class="mr-1">محصولات</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            <span class="mr-1"><?= esc($product['title']) ?></span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Title -->
            <div class="flex flex-col items-center justify-center relative my-16">
                <h1 class="font-YekanBakh-ExtraBlack text-3xl"><?= esc($product['title']) ?></h1>
                <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
            </div>

            <div class="max-w-4xl mx-auto">

                <!-- Gallery -->
                <?php if (!empty($images)): ?>
                    <div class="mb-12">
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #4f46e5" class="swiper product-main">
                            <div class="swiper-wrapper">
                                <?php foreach ($images as $img): ?>
                                    <div class="swiper-slide">
                                        <img class="rounded-xl cursor-pointer w-full object-cover"
                                             src="<?= base_url(esc($img['image_path'])) ?>"
                                             alt="<?= esc($img['alt_text'] ?? $product['title']) ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="swiper-button-next after:text-sm"></div>
                            <div class="swiper-button-prev after:text-sm"></div>
                            <!-- ====== اضافه کن اینجا ====== -->
                            <div class="swiper-pagination product-main-pagination"></div>
                            <!-- ========================== -->
                        </div>

                        <div thumbsSlider="" class="swiper gall-product mt-4">
                            <div class="swiper-wrapper">
                                <?php foreach ($images as $img): ?>
                                    <div class="swiper-slide">
                                        <img class="rounded-xl cursor-pointer w-full object-cover"
                                             src="<?= base_url(esc($img['image_path'])) ?>"
                                             alt="<?= esc($img['alt_text'] ?? $product['title']) ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Tabs -->
                <div role="tablist" class="tabs tabs-bordered mb-14">

                    <!-- Tab: Description -->
                    <input type="radio" name="product_tabs" role="tab"
                           class="tab whitespace-nowrap bg-stone-900 !rounded-full ml-2 !border-b-0 px-8 text-white checked:bg-orange-200 checked:text-stone-900 mb-6 h-10"
                           aria-label="توضیحات" checked/>
                    <div role="tabpanel" class="tab-content">
                        <h2 class="font-YekanBakh-ExtraBold text-2xl mb-4">توضیحات</h2>
                        <div class="leading-8"><?= nl2br(esc($product['description'] ?? '')) ?></div>
                    </div>

                    <!-- Tab: Materials -->
                    <?php if (!empty($materials)): ?>
                        <input type="radio" name="product_tabs" role="tab"
                               class="tab whitespace-nowrap bg-stone-900 !rounded-full px-8 !border-b-0 text-white checked:bg-orange-200 checked:text-stone-900 mb-6 h-10"
                               aria-label="متریال"/>
                        <div role="tabpanel" class="tab-content">
                            <h2 class="font-YekanBakh-ExtraBold text-2xl mb-4">متریال استفاده شده</h2>
                            <!-- Materials Grid - 5 items per row -->
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                <?php foreach ($materials as $material): ?>
                                    <div class="bg-orange-100 rounded-xl p-4 text-center">
                                        <!-- icon will be added later -->
                                        <h3 class="font-YekanBakh-Bold text-base mb-1"><?= esc($material['title']) ?></h3>
                                        <p class="text-xs leading-6"><?= esc($material['description']) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Dimensions Section (text + image in one row) -->
                <?php if (!empty($product['dimensions_text']) || !empty($product['dimensions_img'])): ?>
                    <div class="mb-12">
                        <h2 class="font-YekanBakh-ExtraBold text-2xl mb-6">ابعاد محصول</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <?php if (!empty($product['dimensions_text'])): ?>
                                <div class="bg-orange-100 rounded-xl p-6 leading-8">
                                    <?= nl2br(esc($product['dimensions_text'])) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($product['dimensions_img'])): ?>
                                <div>
                                    <img class="rounded-xl w-full" src="<?= base_url(esc($product['dimensions_img'])) ?>" alt="ابعاد <?= esc($product['title']) ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- FAQ Accordion -->
                <?php if (!empty($faqs)): ?>
                    <div class="mb-12">
                        <h2 class="font-YekanBakh-ExtraBold text-2xl mb-6">سوالات متداول</h2>
                        <?php foreach ($faqs as $faq): ?>
                            <div class="collapse collapse-plus bg-white rounded-3xl my-4">
                                <input type="checkbox" />
                                <div class="collapse-title text-base font-YekanBakh-Bold">
                                    <?= esc($faq['question']) ?>
                                </div>
                                <div class="collapse-content leading-8">
                                    <p><?= nl2br(esc($faq['answer'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Related Products -->
                <?php if (!empty($relatedProducts)): ?>
                    <div class="mb-12">
                        <div class="flex items-center mb-6">
                            <div class="mr-2">
                                <span class="font-YekanBakh-Bold bg-orange-200 rounded-full px-4 py-1">محصولات مرتبط</span>
                                <p class="mt-2">محصولات مشابه از همین کالکشن</p>
                            </div>
                        </div>
                        <div class="swiper related-products">
                            <div class="swiper-wrapper ease-linear">
                                <?php foreach ($relatedProducts as $related): ?>
                                    <div class="swiper-slide">
                                        <div class="group relative overflow-hidden rounded-2xl">
                                            <a href="<?= base_url('product/' . $related['slug']) ?>">
                                                <img class="transition duration-300 ease-in-out group-hover:scale-110 w-full rounded-2xl"
                                                     src="<?= base_url(esc($related['thumbnail'])) ?>"
                                                     alt="<?= esc($related['title']) ?>">
                                                <div class="absolute bottom-0 w-full text-center text-white bg-gradient-to-t from-stone-800 pt-10 pb-3 rounded-b-2xl">
                                                    <h3><?= esc($related['title']) ?></h3>
                                                    <p class="opacity-0 group-hover:opacity-100 transition-all duration-300 group-hover:my-3 text-xs">جهت مشاهده کلیک کنید...</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

<?= $this->endSection() ?>