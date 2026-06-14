<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <title><?= esc($seo['title'] ?? $title ?? 'مارکزا') ?></title>
    <meta name="description" content="<?= esc($seo['description'] ?? '') ?>">
    <meta name="robots" content="<?= !empty($seo['noindex']) ? 'noindex, nofollow' : 'index, follow' ?>">
    <?php if (!empty($seo['canonical'])): ?>
        <link rel="canonical" href="<?= esc($seo['canonical']) ?>">
    <?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:title" content="<?= esc($seo['title'] ?? $title ?? 'مارکزا') ?>">
    <meta property="og:description" content="<?= esc($seo['description'] ?? '') ?>">
    <meta property="og:type" content="<?= esc($seo['og_type'] ?? 'website') ?>">
    <meta property="og:url" content="<?= current_url() ?>">
    <?php if (!empty($seo['og_image'])): ?>
        <meta property="og:image" content="<?= esc($seo['og_image']) ?>">
    <?php endif; ?>

    <?= $this->include('_layout_/_favicon') ?>

    <!-- Assets -->
    <link rel="stylesheet" href="<?= $assetsPath ?>modules/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= $assetsPath ?>build/style.css">
</head>
<body class="font-YekanBakh-Regular text-sm bg-[#f5f1e4]">

<?= $this->include('_layout_/_header') ?>

<main>
    <?= $this->renderSection('content') ?>
</main>

<?= $this->include('_layout_/_footer') ?>

</body>
</html>