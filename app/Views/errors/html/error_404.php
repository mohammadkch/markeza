<?php
$assetsPath = base_url('assets/');
$className = '';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>صفحه پیدا نشد | مارکزا هوم</title>

    <?php include APPPATH . 'Views/_layout_/_favicon.php'; ?>
    <link rel="stylesheet" href="<?= esc($assetsPath) ?>modules/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= esc($assetsPath) ?>build/style.css">
</head>
<body class="font-YekanBakh-Regular text-sm bg-[#f5f1e4]">

<?php include APPPATH . 'Views/_layout_/_header.php'; ?>

<main>
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
                            <span class="mr-1">خطای ۴۰۴</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="container mx-auto max-w-screen-md text-center leading-10">
                <img class="w-3/4 mb-8 mx-auto" src="<?= base_url('assets/images/404.png') ?>" alt="صفحه مورد نظر پیدا نشد">

                <div class="bg-white rounded-3xl p-6 shadow-lg">
                    <span class="font-YekanBakh-ExtraBlack text-6xl text-stone-900">۴۰۴</span>
                    <h1 class="font-YekanBakh-ExtraBlack text-2xl mt-4 mb-3">صفحه مورد نظر شما یافت نشد!</h1>
                    <p class="text-base text-stone-700 mb-6">
                        ممکن است آدرس صفحه تغییر کرده باشد یا محتوای مورد نظر دیگر در دسترس نباشد.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <a class="bg-stone-800 text-white hover:bg-orange-200 hover:text-stone-900 duration-300 py-2.5 px-6 rounded-full" href="<?= base_url('/') ?>">
                            بازگشت به صفحه اصلی
                        </a>
                        <a class="border border-stone-800 text-stone-900 hover:bg-stone-800 hover:text-white duration-300 py-2.5 px-6 rounded-full" href="<?= base_url('contact') ?>">
                            تماس با ما
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include APPPATH . 'Views/_layout_/_footer.php'; ?>

</body>
</html>
