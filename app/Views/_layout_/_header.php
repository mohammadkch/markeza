<section class="px-4 static">
    <div class="container mx-auto max-w-screen-xl">
        <div class="flex justify-between items-center py-6">

            <!-- Mobile Drawer -->
            <div class="lg:hidden leading-none z-10">
                <div class="drawer">
                    <input id="my-drawer" type="checkbox" class="drawer-toggle"/>
                    <div class="drawer-content">
                        <label for="my-drawer" class="drawer-button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-black swap-off fill-current">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                            </svg>
                        </label>
                    </div>
                    <div class="drawer-side">
                        <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                        <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
                            <div class="drawer-content text-left">
                                <label for="my-drawer" class="swap swap-rotate drawer-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </label>
                            </div>
                            <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'home' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('/') ?>">صفحه اصلی</a></li>
                            <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'collection' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('collection') ?>">کالکشن‌</a></li>
                            <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'services' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('services') ?>">خدمات</a></li>
                            <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'blog' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('blog') ?>">وبلاگ</a></li>
                            <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'about' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('about') ?>">درباره ما</a></li>
                            <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'contact' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('contact') ?>">تماس با ما</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Logo + Desktop Nav -->
            <div class="flex items-center gap-8">
                <div>
                    <a href="<?= base_url('/') ?>">
                        <img src="<?= $assetsPath ?>images/logo/logo-black-trans.png" alt="لوگو مارکزا">
                    </a>
                </div>
                <div class="hidden lg:block">
                    <ul class="flex menu lg:menu-horizontal">
                        <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'home' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('/') ?>">صفحه اصلی</a></li>
                        <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'collection' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('collection') ?>">کالکشن‌ها</a></li>
                        <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'services' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('services') ?>">خدمات</a></li>
                        <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'blog' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('blog') ?>">وبلاگ</a></li>
                        <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'about' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('about') ?>">درباره ما</a></li>
                        <li><a class="hover:border-b hover:border-orange-200 pb-1 duration-300 <?= $className === 'contact' ? 'border-b border-orange-200' : '' ?>" href="<?= base_url('contact') ?>">تماس با ما</a></li>
                    </ul>
                </div>
            </div>

            <!-- CTA -->
            <div class="border bg-stone-900 text-orange-200 hover:bg-orange-200 hover:text-stone-900 duration-300 rounded-full">
                <a href="<?= base_url('login') ?>" class="flex py-2.5 px-7 rounded-full font-YekanBakh-Regular">ورود | ثبت نام</a>
            </div>

        </div>
    </div>
</section>