<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url): ?>
    <url>
        <loc><?= htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></loc>
<?php if (! empty($url['lastmod'])): ?>
        <lastmod><?= htmlspecialchars($url['lastmod'], ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></lastmod>
<?php endif; ?>
    </url>
<?php endforeach; ?>
</urlset>
