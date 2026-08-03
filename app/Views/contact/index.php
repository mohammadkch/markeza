<?= $this->extend('_layout_/layout') ?>
<?= $this->section('content') ?>

<section class="px-4 mb-16">
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
                        <span class="mr-1">تماس با ما</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col items-center justify-center relative my-16">
            <h1 class="font-YekanBakh-ExtraBlack text-3xl">تماس با مارکزا هوم</h1>
            <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
        </div>

        <div class="flex flex-col md:flex-row gap-8 mb-12 items-stretch">
            <div class="w-full md:w-1/2 bg-white p-6 rounded-3xl">
                <h2 class="font-YekanBakh-ExtraBlack text-2xl mb-6">ارسال پیام</h2>

                <?php if (session('success')): ?>
                    <div class="mb-6 p-4 rounded-xl bg-orange-100 leading-7" role="status">
                        <?= esc(session('success')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session('error')): ?>
                    <div class="mb-6 p-4 rounded-xl border border-orange-200 leading-7" role="alert">
                        <?= esc(session('error')) ?>
                    </div>
                <?php endif; ?>

                <?php if ($errors = session('errors')): ?>
                    <div class="mb-6 p-4 rounded-xl border border-orange-200 leading-7" role="alert">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('contact') ?>">
                    <?= csrf_field() ?>

                    <div class="form-control mb-4">
                        <label class="font-YekanBakh-Bold mb-2" for="full_name">نام و نام خانوادگی</label>
                        <input class="input border border-orange-200 w-full" id="full_name" name="full_name" type="text" maxlength="100" value="<?= old('full_name') ?>" autocomplete="name" required>
                    </div>

                    <div class="form-control mb-4">
                        <label class="font-YekanBakh-Bold mb-2" for="mobile">شماره موبایل</label>
                        <input class="input border border-orange-200 w-full text-left" id="mobile" name="mobile" type="tel" inputmode="numeric" dir="ltr" minlength="11" maxlength="11" pattern="09[0-9]{9}" value="<?= old('mobile') ?>" autocomplete="tel" placeholder="09123456789" required>
                    </div>

                    <div class="form-control mb-4">
                        <label class="font-YekanBakh-Bold mb-2" for="email">ایمیل</label>
                        <input class="input border border-orange-200 w-full text-left" id="email" name="email" type="email" dir="ltr" maxlength="254" value="<?= old('email') ?>" autocomplete="email" placeholder="name@example.com" required>
                    </div>

                    <div class="form-control mb-6">
                        <label class="font-YekanBakh-Bold mb-2" for="message">متن پیام</label>
                        <textarea class="textarea border border-orange-200 w-full" id="message" name="message" rows="6" minlength="10" maxlength="2000" required><?= old('message') ?></textarea>
                    </div>

                    <button class="py-3 px-8 rounded-full bg-stone-900 text-orange-200 hover:bg-orange-200 hover:text-stone-900 duration-300 font-YekanBakh-Bold" type="submit">
                        ارسال پیام
                    </button>
                </form>
            </div>

            <div class="w-full md:w-1/2 bg-stone-900 text-white p-8 rounded-3xl flex flex-col justify-center">
                <span class="text-orange-200 mb-3">ارتباط مستقیم</span>
                <h2 class="font-YekanBakh-ExtraBlack text-2xl mb-8">مدیر بازرگانی</h2>

                <div class="mb-8">
                    <p class="text-orange-200 mb-2">خانم علیخانی</p>
                    <a class="text-xl" dir="ltr" href="tel:+989128130135">09128130135</a>
                </div>

                <div>
                    <p class="text-orange-200 mb-2">ایمیل</p>
                    <a class="text-xl" dir="ltr" href="mailto:info@markeza.ir">info@markeza.ir</a>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-8 items-stretch">
            <div class="w-full md:w-1/2 rounded-3xl overflow-hidden bg-white">
                <iframe
                    src="https://www.google.com/maps?q=36.7730486,50.8043941&z=16&output=embed"
                    title="موقعیت کارخانه مارکزا هوم"
                    class="w-full"
                    style="height: 420px; border: 0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen></iframe>
                <p class="p-6 leading-8 font-YekanBakh-Bold">
                    آدرس کارخانه: مازندران – تنکابن – شهرک صنعتی البرز – شرکت آسا چوب ارژن
                </p>
            </div>

            <div class="w-full md:w-1/2 p-8 rounded-3xl bg-gradient-to-t from-orange-100 flex flex-col justify-center">
                <h2 class="font-YekanBakh-ExtraBlack text-2xl mb-6">با ما در ارتباط باشید</h2>
                <p class="leading-9 mb-6">
                    در مارکزا، ارتباط با شما بخشی از تجربه‌ی خاص ماست. اگر درباره محصولات، همکاری تجاری، یا سفارش سفارشی سؤالی دارید، تیم ما آماده پاسخ‌گویی به شما است.
                </p>
                <div class="bg-white p-6 rounded-3xl leading-8">
                    <p class="font-YekanBakh-Bold mb-2">ساعات پاسخ‌گویی:</p>
                    <p>شنبه تا پنج‌شنبه – <span dir="ltr">08:00 تا 17:30</span></p>
                    <p>(جمعه‌ها و تعطیلات رسمی با هماهنگی قبلی)</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
