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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                            </svg>
                            <span class="mr-1">کالکشن‌ها</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Title -->
            <div class="flex flex-col items-center justify-center relative my-16">
                <h1 class="font-YekanBakh-ExtraBlack text-3xl">کالکشن‌های مارکزا</h1>
                <div class="bg-orange-200 w-20 h-1.5 rounded-full absolute top-10"></div>
                <p class="mt-4 text-gray-600">مجموعه‌ای از مبلمان چرم لوکس با طراحی ایتالیایی</p>
            </div>

            <!-- Collections List -->
            <?php foreach ($collections as $index => $collection): ?>
                <?php
                $isEven = ($index % 2 == 0);

                // Get thumbnail
                $thumbnail = '';
                if (!empty($collection['thumbnail'])) {
                    $thumbnail = base_url($collection['thumbnail']);
                } elseif (!empty($collection['images']) && is_array($collection['images'])) {
                    $thumbnail = base_url($collection['images'][0]['image_path'] ?? '');
                } else {
                    $thumbnail = base_url('assets/images/collection/default-collection.webp');
                }
                ?>

                <!-- Single row with margin bottom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-start <?= $isEven ? '' : 'md:flex-row-reverse' ?>" style="margin-bottom: 70px">

                    <!-- Image -->
                    <div class="<?= $isEven ? 'md:order-1' : 'md:order-2' ?>">
                        <a href="<?= base_url('collection/' . $collection['slug']) ?>" class="block group overflow-hidden rounded-3xl">
                            <img src="<?= $thumbnail ?>"
                                 alt="<?= esc($collection['title']) ?>"
                                 class="w-full h-72 md:h-80 object-cover rounded-3xl transition duration-500 group-hover:scale-105"
                                 loading="lazy">
                        </a>
                    </div>

                    <!-- Text -->
                    <div class="<?= $isEven ? 'md:order-2' : 'md:order-1' ?> flex flex-col h-full">
                        <h2 class="font-YekanBakh-ExtraBlack text-2xl md:text-3xl mb-3">
                            <a href="<?= base_url('collection/' . $collection['slug']) ?>" class="hover:text-orange-600 transition">
                                <?= esc($collection['title']) ?>
                            </a>
                        </h2>

                        <?php if (!empty($collection['subtitle'])): ?>
                            <p class="text-orange-600 font-YekanBakh-Bold text-sm mb-3"><?= esc($collection['subtitle']) ?></p>
                        <?php endif; ?>

                        <!-- Description with 400 character limit -->
                        <div class="leading-8 text-gray-700 flex-1">
                            <?php
                            $description = !empty($collection['excerpt'])
                                    ? $collection['excerpt']
                                    : strip_tags($collection['description'] ?? '');
                            if (mb_strlen($description) > 400) {
                                echo esc(mb_substr($description, 0, 700)) . '...';
                            } else {
                                echo esc($description);
                            }
                            ?>
                        </div>

                        <div class="mt-6">
                            <a href="<?= base_url('collection/' . $collection['slug']) ?>"
                               class="inline-flex items-center gap-2 bg-stone-900 text-orange-200 hover:bg-orange-200 hover:text-stone-900 transition duration-300 rounded-full py-2.5 px-7 font-YekanBakh-Regular text-sm">
                                مشاهده کالکشن
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Divider between rows (except last) -->
                <?php if ($index < count($collections) - 1): ?>
                    <hr class="border-gray-200 dark:border-gray-700" style="margin-bottom: 70px">
                <?php endif; ?>

            <?php endforeach; ?>

            <!-- Empty state -->
            <?php if (empty($collections)): ?>
                <div class="text-center py-16">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="2" y="2" width="20" height="20" rx="2" ry="2" stroke="currentColor" stroke-width="2"></rect>
                        <circle cx="8.5" cy="8.5" r="2.5" stroke="currentColor" stroke-width="2"></circle>
                        <polyline points="21 15 16 10 5 21" stroke="currentColor" stroke-width="2"></polyline>
                    </svg>
                    <p class="text-gray-500 text-lg">هیچ کالکشنی یافت نشد.</p>
                </div>
            <?php endif; ?>

        </div>
    </section>

<?= $this->endSection() ?>