<?= $this->extend('_layout_/layout') ?>
<?= $this->section('content') ?>

<?php
$homeUrl = base_url('/');
$organizationId = $homeUrl . '#organization';
$homeSchemas = [
    [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => $homeUrl . '#website',
        'url' => $homeUrl,
        'name' => 'مارکزا هوم',
        'inLanguage' => 'fa-IR',
        'publisher' => ['@id' => $organizationId],
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => $organizationId,
        'name' => 'مارکزا هوم',
        'url' => $homeUrl,
        'logo' => [
            '@type' => 'ImageObject',
            'url' => base_url('assets/images/logo/logo-black-trans.png'),
        ],
        'description' => 'طراحی و تولید مبلمان چرمی لوکس و دست‌ساز با الهام از طراحی ایتالیایی.',
        'email' => 'info@markeza.ir',
        'telephone' => '+989128130135',
        'sameAs' => [
            'https://instagram.com/markezahome',
        ],
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => '+989128130135',
            'contactType' => 'sales',
            'availableLanguage' => ['fa'],
        ],
    ],
];
?>

<?php foreach ($homeSchemas as $schema): ?>
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
<?php endforeach; ?>

    <!-- Hero / Slider -->
    <section class="px-4 mb-24">
        <div class="container mx-auto max-w-screen-xl relative pt-5 pl-5 lg:pt-10 lg:pl-10">
            <div class="bg-stone-900 absolute top-0 left-0 h-36 lg:h-[28.4rem] w-52 lg:w-96 rounded-b-3xl"></div>
            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-12 lg:col-span-4 order-2 lg:order-1">
                    <div class="leading-8 mt-8">
                        <span class="font-YekanBakh-Bold bg-orange-200 rounded-full py-1 px-4">مارکزا هوم</span>
                        <h1 class="font-YekanBakh-ExtraBlack text-4xl my-6">طراحی ایتالیایی</h1>
                        <h1 class="font-YekanBakh-ExtraBlack text-4xl my-6">تجلی ظرافت، نوآوری و هنر ماندگار دست‌ساز</h1>
                         
                        <p>ما به طراحی و ساخت مبلمانی با روح اصیل ایتالیایی افتخار می‌کنیم. محصولات ما تلفیقی از هنر، زیبایی و کارایی هستند که از دنیای طراحی ایتالیایی الهام گرفته‌اند. این طراحی‌ها تنها بر زیبایی و راحتی تمرکز ندارند، بلکه روایتی از سنت و نوآوری را در خود جای داده‌اند.</p>
                        <div class="flex justify-end">
                            <a href="<?= base_url('about') ?>" class="mt-4 py-1 px-7 rounded-full bg-orange-200 hover:duration-300 font-YekanBakh-SemiBold">بیشتر بخوانید...</a>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-8 order-1 lg:order-2">
                    <div class="swiper mySwiper relative">
                        <div class="swiper-wrapper">
                            <?php foreach ($banners as $banner): ?>
                                <div class="swiper-slide rounded-xl overflow-hidden" data-caption="<?= esc($banner['alt']) ?>">
                                    <img class="object-cover w-full h-64 md:h-96"
                                         src="<?= esc($banner['image']) ?>"
                                         alt="<?= esc($banner['alt']) ?>"
                                         loading="lazy">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-next after:text-2xl after:text-stone-900 mx-2"></div>
                        <div class="swiper-button-prev after:text-2xl after:text-stone-900 mx-2"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <div id="slider-caption" class="p-3 text-center bg-orange-200 font-YekanBakh-SemiBold text-xs rounded-xl relative z-10"></div>
                </div>
                <?php /*
                <div class="col-span-12 lg:col-span-8 order-1 lg:order-2">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide rounded-xl overflow-hidden">
                                <div class="absolute bottom-0 left-0 right-0 p-3 text-center bg-orange-200 font-YekanBakh-SemiBold text-xs">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است</div>
                                <img class="object-cover w-full" src="<?= $assetsPath ?>images/slider-1.jpg" alt="اسلاید ۱">
                            </div>
                            <div class="swiper-slide rounded-xl overflow-hidden">
                                <div class="absolute bottom-0 left-0 right-0 p-3 text-center bg-orange-200 font-YekanBakh-SemiBold text-xs">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است</div>
                                <img class="object-cover w-full" src="<?= $assetsPath ?>images/slider-2.jpg" alt="اسلاید ۲">
                            </div>
                        </div>
                        <div class="swiper-button-next after:text-2xl after:text-stone-900 mx-2"></div>
                        <div class="swiper-button-prev after:text-2xl after:text-stone-900 mx-2"></div>
                    </div>
                </div>

 */ ?>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="px-4 py-14 bg-gradient-to-t from-orange-100">
        <div class="container mx-auto max-w-screen-xl">
            <div class="flex justify-center relative mb-14">
                <h2 class="font-YekanBakh-ExtraBlack text-3xl">چرا مارکزا هوم؟</h2>
                <div class="absolute -top-6"><span dir="ltr" lang="en" class="font-YekanBakh-ExtraBlack text-6xl text-opacity-10 text-stone-900">why markeza?</span></div>
                <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach ($services as $service): ?>
                    <div class="bg-white p-6 rounded-3xl leading-8 transform hover:-translate-y-1 duration-300 transition-transform cursor-pointer">
                        <div class="w-24 mb-4">
                            <img class="w-24 h-24 object-contain" src="<?= esc($service['icon']) ?>" alt="<?= esc($service['title']) ?>">
                        </div>
                        <div class="flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M13.98 5.31999L10.77 8.52999L8.79999 10.49C7.96999 11.32 7.96999 12.67 8.79999 13.5L13.98 18.68C14.66 19.36 15.82 18.87 15.82 17.92V12.31V6.07999C15.82 5.11999 14.66 4.63999 13.98 5.31999Z" fill="#1a3336"/>
                            </svg>
                            <h3 class="font-YekanBakh-ExtraBold text-base mr-1"><?= esc($service['title']) ?></h3>
                        </div>
                        <p><?= esc($service['summary']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Collections -->
    <section class="pt-20 mb-10 px-4">
        <div class="container mx-auto max-w-screen-xl">
            <div class="flex justify-center relative mb-14">
                <h2 class="font-YekanBakh-ExtraBlack text-3xl">کالکشن تولیدات مارکزا</h2>
                <div class="absolute -top-6"><span class="font-YekanBakh-ExtraBlack text-6xl text-opacity-10 text-stone-900">collections</span></div>
                <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <?php foreach ($collections as $col): ?>
                    <a href="<?= base_url('collection/' . $col['slug']) ?>"
                       class="group relative flex aspect-[1024/614] items-end justify-center overflow-hidden rounded-lg bg-gray-100 shadow-lg">
                        <img src="<?= base_url($col['thumbnail'] ?? 'assets/images/collection/default-collection.webp') ?>"
                             loading="lazy"
                             alt="<?= esc($col['title']) ?>"
                             class="absolute inset-0 h-full w-full object-cover object-center transition duration-300 group-hover:scale-110">
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-gray-800 via-transparent to-transparent opacity-50"></div>
                        <span class="relative mb-4 flex justify-center text-base text-white text-center px-2"><?= esc($col['title']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="px-4 py-20 mb-16 bg-gradient-to-t from-orange-100">
        <div class="container mx-auto max-w-screen-xl">
            <div class="flex justify-center relative mb-14">
                <h2 class="font-YekanBakh-ExtraBlack text-3xl">نظــــــرات مشتریــــــان</h2>
                <div class="absolute -top-6"><span class="font-YekanBakh-ExtraBlack text-6xl text-opacity-10 text-stone-900">customer</span></div>
                <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
            </div>
            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-12 md:col-span-5 relative">
                    <div class="leading-8">
                        <h2 class="font-YekanBakh-ExtraBlack text-3xl my-4">از زبان مشتریان ما بشنوید...</h2>
                        <p class="mb-4">تجربه مشتریان، معیار مهمی برای سنجش کیفیت طراحی، راحتی و دوام محصولات مارکزا هوم است. دیدگاه خریداران به ما کمک می‌کند جزئیات هر محصول و کیفیت خدمات را پیوسته بهبود دهیم.</p>
                        <div class="flex justify-end">
                            <a href="<?= base_url('contact') ?>" class="mt-4 py-1 px-7 rounded-full bg-orange-200 hover:duration-300 font-YekanBakh-SemiBold">بیشتر بخوانید...</a>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-7">
                    <div class="swiper customer">
                        <div class="swiper-wrapper">
                            <?php foreach ($testimonials as $t): ?>
                                <div class="swiper-slide">
                                    <div class="bg-white p-6 leading-8 rounded-3xl">
                                        <div class="flex items-center mb-4">
                                            <div class="avatar ml-4">
                                                <div class="w-20 rounded-full">
                                                    <img src="<?= esc($t['avatar']) ?>" alt="<?= esc($t['name']) ?>">
                                                </div>
                                            </div>
                                            <div class="flex flex-col items-center">
                                                <h3 class="font-YekanBakh-Bold text-slate-800 text-sm"><?= esc($t['name']) ?></h3>
                                                <p><?= esc($t['role']) ?></p>
                                            </div>
                                        </div>
                                        <p><?= esc($t['text']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="px-4 sm:px-0 mb-32">
        <div class="relative pt-20">
            <div aria-hidden="true" class="hidden sm:block">
                <div class="absolute inset-y-0 left-0 w-1/2 bg-stone-900 rounded-r-3xl"></div>
                <svg class="absolute top-8 left-1/2 -ml-8" width="404" height="392" fill="none" viewBox="0 0 404 392">
                    <defs>
                        <pattern id="8228f071-bcee-4ec8-905a-2a059a2cc4fb" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor"></rect>
                        </pattern>
                    </defs>
                    <rect width="404" height="392" fill="url(#8228f071-bcee-4ec8-905a-2a059a2cc4fb)"></rect>
                </svg>
            </div>
            <div class="mx-auto px-4 lg:px-0 max-w-md sm:max-w-3xl lg:max-w-7xl">
                <div class="relative rounded-3xl px-6 py-10 bg-stone-800 overflow-hidden shadow-xl sm:px-12 sm:py-16">
                    <div aria-hidden="true" class="absolute inset-0 -mt-72 sm:-mt-32 md:mt-0">
                        <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1463 360">
                            <path class="text-stone-700 text-opacity-40" fill="currentColor" d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z"></path>
                            <path class="text-stone-900 text-opacity-40" fill="currentColor" d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z"></path>
                        </svg>
                    </div>
                    <div class="relative flex flex-col">
                        <div class="sm:text-center">
                            <h2 class="font-YekanBakh-ExtraBlack text-4xl text-white">با مشـــاوران مـــا در ارتبـــاط باشیــــد...</h2>
                            <p class="mt-6 mx-auto max-w-2xl text-base text-gray-100">برای انتخاب مدل، چرم، رنگ و ابعاد متناسب با فضای خود، از مشاوره تخصصی کارشناسان مارکزا هوم استفاده کنید.</p>
                        </div>
                        <a href="<?= base_url('contact') ?>" class="w-auto inline-block mt-5 mx-auto py-2 px-7 rounded-full bg-orange-200 hover:duration-300 font-YekanBakh-SemiBold">ارتباط با کارشناسان</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog -->
    <section class="px-4 pb-20 bg-gradient-to-t from-orange-100">
        <div class="container mx-auto max-w-screen-xl">
            <div class="flex justify-center relative mb-14">
                <h2 class="font-YekanBakh-ExtraBlack text-3xl">وبـــــــــلاگ</h2>
                <div class="absolute -top-6"><span class="font-YekanBakh-ExtraBlack text-6xl text-opacity-10 text-stone-900">blog</span></div>
                <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach ($latestPosts as $post): ?>
                    <div class="bg-white overflow-hidden rounded-3xl leading-8 transform hover:-translate-y-1 duration-300 transition-transform flex flex-col">
                        <div class="p-6">
                            <div class="flex items-center mb-4 border-b border-dashed pb-4">
                                <div class="avatar ml-2">
                                    <div class="w-14 rounded-full">
                                        <img src="<?= esc($post['author_avatar']) ?>" alt="<?= esc($post['author_name']) ?>">
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <h3 class="font-YekanBakh-Bold text-slate-800 text-sm"><?= esc($post['author_name']) ?></h3>
                                </div>
                            </div>
                            <div class="leading-8">
                                <div class="flex items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M13.98 5.31999L10.77 8.52999L8.79999 10.49C7.96999 11.32 7.96999 12.67 8.79999 13.5L13.98 18.68C14.66 19.36 15.82 18.87 15.82 17.92V12.31V6.07999C15.82 5.11999 14.66 4.63999 13.98 5.31999Z" fill="#1a3336"/>
                                    </svg>
                                    <a href="<?= base_url('blog/' . $post['id'] . '/' . rawurlencode($post['slug'])) ?>">
                                        <h4 class="font-YekanBakh-ExtraBold text-base mr-1"><?= esc($post['title']) ?></h4>
                                    </a>
                                </div>
                                <p><?= esc($post['summary']) ?></p>
                            </div>
                        </div>
                        <div style="margin-top: auto">
                            <a href="<?= base_url('blog/' . $post['id'] . '/' . rawurlencode($post['slug'])) ?>">
                                <img class="rounded-b-lg w-full object-cover" style="height: 14rem" src="<?= esc($post['thumbnail']) ?>" alt="<?= esc($post['title']) ?>">
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Partners -->
    <section class="px-4 pb-20 pt-10 bg-orange-100">
        <div class="container mx-auto max-w-screen-xl">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 lg:col-span-5">
                    <div class="flex flex-col md:flex-row items-center gap-x-16">
                        <div class="leading-8">
                            <h2 class="font-YekanBakh-ExtraBlack text-3xl my-4">تجربـــه هـــای همکــاری</h2>
                            <p class="font-YekanBakh-Bold text-2xl my-4">افتخــــار همکـــــاری داشتـــــه ایـــــم</p>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-7">
                    <div class="swiper partners">
                        <div class="swiper-wrapper">
                            <?php foreach ($partners as $partner): ?>
                                <div class="swiper-slide">
                                    <a class="flex justify-center" href="<?= esc($partner['url']) ?>" target="_blank" rel="noopener noreferrer">
                                        <img class="grayscale hover:grayscale-0 duration-300" src="<?= esc($partner['logo']) ?>" alt="<?= esc($partner['name']) ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
