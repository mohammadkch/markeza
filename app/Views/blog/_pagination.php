<?php $pager->setSurroundCount(2) ?>

<?php if ($pager->hasPreviousPage() || $pager->hasNextPage()): ?>
    <nav style="margin-top: 2.5rem" aria-label="صفحه‌بندی مقالات">
        <ul class="flex justify-center items-center gap-2 list-none p-0">
            <?php if ($pager->hasPreviousPage()): ?>
                <li><a href="<?= $pager->getPreviousPage() ?>" class="px-4 py-2 rounded-full border border-orange-200">قبلی</a></li>
            <?php endif; ?>

            <?php foreach ($pager->links() as $link): ?>
                <li>
                    <a href="<?= $link['uri'] ?>" class="px-4 py-2 rounded-full border border-orange-200 <?= $link['active'] ? 'bg-stone-900 text-orange-200' : 'bg-white' ?>">
                        <?= esc($link['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <?php if ($pager->hasNextPage()): ?>
                <li><a href="<?= $pager->getNextPage() ?>" class="px-4 py-2 rounded-full border border-orange-200">بعدی</a></li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
