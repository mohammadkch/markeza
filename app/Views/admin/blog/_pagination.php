<?php $pager->setSurroundCount(2) ?>

<?php if ($pager->hasPreviousPage() || $pager->hasNextPage()): ?>
    <nav class="mt-6" aria-label="صفحه‌بندی مقالات">
        <ul class="flex justify-center items-center gap-2">
            <?php if ($pager->hasPreviousPage()): ?>
                <li><a href="<?= $pager->getPreviousPage() ?>" class="px-3 py-2 rounded-lg border border-gray-300">قبلی</a></li>
            <?php endif; ?>
            <?php foreach ($pager->links() as $link): ?>
                <li>
                    <a href="<?= $link['uri'] ?>" class="px-3 py-2 rounded-lg border <?= $link['active'] ? 'bg-primary text-white border-primary' : 'border-gray-300' ?>">
                        <?= esc($link['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <?php if ($pager->hasNextPage()): ?>
                <li><a href="<?= $pager->getNextPage() ?>" class="px-3 py-2 rounded-lg border border-gray-300">بعدی</a></li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
