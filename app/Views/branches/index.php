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
                        <span class="mr-1">نمایندگی‌ها</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col items-center justify-center relative my-16 text-center">
            <h1 class="font-YekanBakh-ExtraBlack text-3xl">نمایندگی‌های مارکزا هوم</h1>
            <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
            <p class="mt-8 text-stone-700 leading-8">برای بازدید حضوری و دریافت مشاوره، نزدیک‌ترین شعبه مارکزا هوم را انتخاب کنید.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($branches as $branch): ?>
                <article class="bg-white rounded-3xl overflow-hidden shadow-lg transform hover:-translate-y-1 duration-300 transition-transform">
                    <div class="bg-gradient-to-t from-orange-100 flex items-center justify-center p-6" style="min-height: 9rem">
                        <img
                            class="w-20 h-20 object-contain"
                            src="<?= esc($branch['image'] ?: $defaultBranchImage) ?>"
                            alt="نمایندگی مارکزا هوم در <?= esc($branch['city']) ?>"
                            loading="lazy">
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between gap-4 mb-5">
                            <h2 class="font-YekanBakh-ExtraBlack text-xl">شعبه <?= esc($branch['city']) ?></h2>
                            <span class="bg-orange-200 rounded-full py-1 px-3">مارکزا</span>
                        </div>

                        <div class="leading-8">
                            <div class="mb-4">
                                <p class="font-YekanBakh-Bold">آدرس</p>
                                <address class="text-stone-700" style="font-style: normal"><?= esc($branch['address']) ?></address>
                            </div>

                            <div class="flex items-center justify-between gap-4 mb-2">
                                <span class="font-YekanBakh-Bold">تماس</span>
                                <a class="text-left" dir="ltr" href="tel:+98<?= esc(substr($branch['mobile'], 1)) ?>"><?= esc($branch['mobile']) ?></a>
                            </div>

                            <?php if ($branch['phone']): ?>
                                <div class="flex items-center justify-between gap-4 mb-2">
                                    <span class="font-YekanBakh-Bold">تلفن ثابت</span>
                                    <a class="text-left" dir="ltr" href="tel:<?= esc($branch['phone']) ?>"><?= esc($branch['phone']) ?></a>
                                </div>
                            <?php endif; ?>

                            <div class="border-t border-orange-200 mt-5 pt-4">
                                <span class="font-YekanBakh-Bold">مدیریت فروشگاه:</span>
                                <span><?= esc($branch['manager']) ?></span>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
