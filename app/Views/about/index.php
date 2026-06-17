<?= $this->extend('_layout_/layout') ?>
<?= $this->section('content') ?>

    <section class="px-4 mb-12">
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                            </svg>
                            <span class="mr-1">درباره ما</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Title -->
            <div class="flex flex-col items-center justify-center relative my-16">
                <h1 class="font-YekanBakh-ExtraBlack text-3xl">درباره مارکزا هوم</h1>
                <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
            </div>

            <!-- Hero Image -->
            <div class="mb-12 rounded-3xl overflow-hidden">
                <img src="<?= base_url('assets/images/about/about-top-1.webp') ?>"
                     alt="نمای کلی کارخانه مارکزا هوم"
                     class="w-full object-cover max-h-[500px]"
                     loading="lazy">
            </div>

            <!-- ROW 1: IMAGE RIGHT - TEXT LEFT -->
            <div class="flex flex-col md:flex-row gap-8 mb-12 items-center">
                <div class="w-full md:w-1/2">
                    <h2 class="font-YekanBakh-ExtraBlack text-2xl mb-6">در مارکزا هوم ما رویاها را به واقعیت تبدیل می‌کنیم</h2>
                    <p class="mb-4 leading-9">ما با هدف خلق مبلمان چرمی دست‌ساز و لوکس فعالیت خود را آغاز کرد و مسیر تازه‌ای را در دنیای طراحی و مبلمان رقم زد. ما در مارکزا هوم تلاش می‌کنیم تا تجربه‌ای منحصربه‌فرد برای مشتریان خود ایجاد کنیم؛ جایی که <strong>راحتی، زیبایی و دوام</strong> در هماهنگی کامل با یکدیگر معنا پیدا می‌کنند.</p>
                    <p class="mb-4 leading-9">هر قطعه از مبلمان مارکزا هوم با <strong>ظرافتی بی‌نظیر و دقتی استادانه</strong> توسط هنرمندان و متخصصان ماهر ساخته می‌شود. استفاده از <strong>بهترین متریال‌ها، از جمله چرم اصیل ایتالیایی</strong>، باعث شده تا محصولات ما تجربه‌ای فراتر از انتظار را به شما هدیه دهند.</p>
                    <p class="font-YekanBakh-Bold text-stone-700 leading-9">تجربه‌ای از کیفیت، اصالت و آرامش جاودانه.</p>
                </div>
                <div class="w-full md:w-1/2">
                    <img src="<?= base_url('assets/images/about/about-1.webp') ?>"
                         alt="خیاطی و طراحی مارکزا هوم"
                         class="rounded-3xl w-full object-cover"
                         loading="lazy">
                </div>
            </div>

            <!-- ROW 2: IMAGE LEFT - TEXT RIGHT -->
            <div class="flex flex-col md:flex-row gap-8 mb-12 items-center">
                <div class="w-full md:w-1/2">
                    <img src="<?= base_url('assets/images/about/about-2.webp') ?>"
                         alt="طراح مارکزا هوم"
                         class="rounded-3xl w-full object-cover"
                         loading="lazy">
                </div>
                <div class="w-full md:w-1/2">
                    <h2 class="font-YekanBakh-ExtraBlack text-2xl mb-6">هنر طراحی ایتالیایی؛ تجلی ظرافت، نوآوری و هنر ماندگار دست‌ساز</h2>
                    <p class="mb-4 leading-9">در مارکزا هوم، ما به طراحی و ساخت مبلمانی با <strong>روح اصیل طراحی ایتالیایی</strong> افتخار می‌کنیم. محصولات ما تلفیقی از <strong>هنر، زیبایی و کارایی</strong> هستند که از دنیای طراحی ایتالیایی الهام گرفته‌اند. این طراحی‌ها تنها بر زیبایی و راحتی تمرکز ندارند، بلکه <strong>روایتی از سنت و نوآوری</strong> را در خود جای داده‌اند.</p>
                    <p class="leading-9">طراحی ایتالیایی در سراسر جهان به‌عنوان <strong>نمادی از ظرافت، دقت و اصالت</strong> شناخته می‌شود. ایتالیا قرن‌هاست که مرزهای طراحی و هنر را بازتعریف کرده و امروزه نیز در صنعت مبلمان، پیشرو باقی مانده است. در قلب طراحی ایتالیایی، <strong>توجه به جزئیات، انتخاب متریال ممتاز و تلفیق سادگی با ظرافت</strong> قرار دارد.</p>
                </div>
            </div>

            <!-- ROW 3: IMAGE RIGHT - TEXT LEFT -->
            <div class="flex flex-col md:flex-row gap-8 mb-12 items-center">
                <div class="w-full md:w-1/2">
                    <h2 class="font-YekanBakh-ExtraBlack text-2xl mb-6">چرم ایتالیایی، نمادی از ظرافت و سنت</h2>
                    <p class="leading-9">چرم ایتالیایی در سراسر جهان به دلیل <strong>کیفیت استثنایی، دوام بالا و حس لوکس و نفیس</strong> خود شناخته شده است. فرآیند تولید این چرم، ریشه در <strong>قرن‌ها سنت و تجربه</strong> دارد و همزمان با <strong>تکنیک‌های نوآورانه</strong> ترکیب شده تا هر قطعه، بالاترین استانداردهای کیفیت را ارائه دهد.</p>
                </div>
                <div class="w-full md:w-1/2">
                    <img src="<?= base_url('assets/images/about/about-3.webp') ?>"
                         alt="چرم طبیعی ایتالیایی"
                         class="rounded-3xl w-full object-cover"
                         loading="lazy">
                </div>
            </div>

            <!-- ROW 4: IMAGE LEFT - TEXT RIGHT -->
            <div class="flex flex-col md:flex-row gap-8 mb-12 items-center">
                <div class="w-full md:w-1/2">
                    <img src="<?= base_url('assets/images/about/about-4.webp') ?>"
                         alt="هنر دست‌ساز مارکزا هوم"
                         class="rounded-3xl w-full object-cover"
                         loading="lazy">
                </div>
                <div class="w-full md:w-1/2">
                    <h2 class="font-YekanBakh-ExtraBlack text-2xl mb-6">پیوند هنر دست با سنت و نوآوری مدرن</h2>
                    <p class="leading-9">در مارکزا هوم، هر دوخت و هر برش <strong>روایتی از مهارت، تجربه و عشق به هنر دست‌ساز</strong> را بیان می‌کند. ما باور داریم که <strong>ترکیب نوآوری با تکنیک‌های سنتی</strong> به ما این امکان را می‌دهد تا مبلمانی خلق کنیم که فراتر از ترندهای زودگذر باشد و <strong>ارزش و اصالت خود را برای سال‌ها حفظ کند.</strong></p>
                </div>
            </div>

            <!-- 4 IMAGES SLIDER (مثل صفحه کالکشن) -->
            <div class="mb-12">
                <div class="flex items-center mb-6">
                    <div class="mr-2">
                        <span class="font-YekanBakh-Bold bg-orange-200 rounded-full px-4 py-1">گالری تصاویر</span>
                        <p class="mt-2">تصاویری از کارخانه و محصولات مارکزا هوم</p>
                    </div>
                </div>
                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper about-main">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img class="rounded-xl cursor-pointer w-full object-cover" src="<?= base_url('assets/images/about/about-in-a-row-banner-1.webp') ?>" alt="تصویر کارخانه مارکزا هوم">
                        </div>
                        <div class="swiper-slide">
                            <img class="rounded-xl cursor-pointer w-full object-cover" src="<?= base_url('assets/images/about/about-in-a-row-banner-2.webp') ?>" alt="تصویر کارخانه مارکزا هوم">
                        </div>
                        <div class="swiper-slide">
                            <img class="rounded-xl cursor-pointer w-full object-cover" src="<?= base_url('assets/images/about/about-in-a-row-banner-3.webp') ?>" alt="تصویر کارخانه مارکزا هوم">
                        </div>
                        <div class="swiper-slide">
                            <img class="rounded-xl cursor-pointer w-full object-cover" src="<?= base_url('assets/images/about/about-in-a-row-banner-4.webp') ?>" alt="تصویر کارخانه مارکزا هوم">
                        </div>
                    </div>
                    <div class="swiper-button-next after:text-sm"></div>
                    <div class="swiper-button-prev after:text-sm"></div>
                </div>
                <div thumbsSlider="" class="swiper about-thumb mt-4">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img class="rounded-xl cursor-pointer w-full object-cover" src="<?= base_url('assets/images/about/about-in-a-row-banner-1.webp') ?>" alt="تصویر کارخانه مارکزا هوم">
                        </div>
                        <div class="swiper-slide">
                            <img class="rounded-xl cursor-pointer w-full object-cover" src="<?= base_url('assets/images/about/about-in-a-row-banner-2.webp') ?>" alt="تصویر کارخانه مارکزا هوم">
                        </div>
                        <div class="swiper-slide">
                            <img class="rounded-xl cursor-pointer w-full object-cover" src="<?= base_url('assets/images/about/about-in-a-row-banner-3.webp') ?>" alt="تصویر کارخانه مارکزا هوم">
                        </div>
                        <div class="swiper-slide">
                            <img class="rounded-xl cursor-pointer w-full object-cover" src="<?= base_url('assets/images/about/about-in-a-row-banner-4.webp') ?>" alt="تصویر کارخانه مارکزا هوم">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 5: IMAGE FULL WIDTH WITH TEXT BELOW -->
            <div class="mb-12">
                <div class="w-full mb-8">
                    <img src="<?= base_url('assets/images/about/about-5.webp') ?>"
                         alt="کارخانه مارکزا هوم"
                         class="rounded-3xl w-full object-cover"
                         loading="lazy">
                </div>
                <div class="text-center">
                    <h2 class="font-YekanBakh-ExtraBlack text-2xl mb-6">ترکیب هنر دست و نوآوری بی‌زمان</h2>
                    <p class="mb-4 leading-9 max-w-3xl mx-auto">در مارکزا هوم، کارخانه ما تنها یک محل تولید نیست؛ بلکه <strong>جایی است که ایده‌ها شکل می‌گیرند، سنت‌ها پاس داشته می‌شوند و نوآوری شکوفا می‌شود</strong> تا مبلمانی بی‌زمان خلق کند که زندگی روزمره شما را به شکلی متمایز ارتقا دهد.</p>
                    <p class="leading-9 max-w-3xl mx-auto">هر قطعه از مبلمان مارکزا هوم با <strong>دقت و ظرافت استادانه</strong> توسط هنرمندان ماهر ساخته می‌شود و از <strong>برترین متریال‌ها، مانند چرم اصیل ایتالیایی</strong> بهره می‌برد تا تجربه‌ای فراتر از انتظار را برای شما رقم زند.</p>
                </div>
            </div>

        </div>
    </section>

<?= $this->endSection() ?>