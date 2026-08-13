<?= $this->extend('_layout_/layout') ?>
<?= $this->section('content') ?>

<?php
$branchSchemas = [
    [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'خانه', 'item' => base_url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'نمایندگی‌ها', 'item' => base_url('branches')],
        ],
    ],
];
foreach ($branches as $index => $branch) {
    $locality = trim((string) preg_replace('/\s*\(.*/u', '', $branch['city']));
    $branchSchemas[] = [
        '@context' => 'https://schema.org',
        '@type' => 'FurnitureStore',
        '@id' => base_url('branches') . '#branch-' . ($index + 1),
        'name' => 'نمایندگی مارکزا هوم در ' . $branch['city'],
        'url' => base_url('branches') . '#branch-' . ($index + 1),
        'image' => $branch['image'] ?: $defaultBranchImage,
        'telephone' => '+98' . substr($branch['mobile'], 1),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $branch['address'],
            'addressLocality' => $locality,
            'addressCountry' => 'IR',
        ],
        'parentOrganization' => ['@id' => base_url('/') . '#organization'],
    ];
}
?>

<?php foreach ($branchSchemas as $schema): ?>
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
<?php endforeach; ?>

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
            <?php foreach ($branches as $index => $branch): ?>
                <article id="branch-<?= $index + 1 ?>" class="bg-white rounded-3xl overflow-hidden shadow-lg transform hover:-translate-y-1 duration-300 transition-transform">
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
