<?php helper('jalali'); ?>
<?php if (!empty($rows)): ?>
    <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
        <table class="w-full text-sm text-right">
            <thead class="text-xs bg-gray-100 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300 sticky top-0">
                <tr>
                    <th class="px-5 py-4">شناسه</th>
                    <th class="px-5 py-4"><?= $isCategory ? 'عنوان' : 'سوال' ?></th>
                    <?php if (!$isCategory): ?><th class="px-5 py-4">دسته‌بندی</th><?php endif; ?>
                    <th class="px-5 py-4">ترتیب</th>
                    <th class="px-5 py-4">وضعیت</th>
                    <th class="px-5 py-4">تاریخ ایجاد</th>
                    <th class="px-5 py-4">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <?php foreach ($rows as $item): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                        <td class="px-5 py-4 font-bold text-gray-900 dark:text-white"><?= (int) $item['id'] ?></td>
                        <td class="px-5 py-4 font-medium"><?= esc($item[$isCategory ? 'title' : 'question']) ?></td>
                        <?php if (!$isCategory): ?><td class="px-5 py-4"><?= esc($item['category_title']) ?></td><?php endif; ?>
                        <td class="px-5 py-4"><?= (int) $item['sort_order'] ?></td>
                        <td class="px-5 py-4">
                            <?php if ($item['is_active'] == 1): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">فعال</span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300">غیرفعال</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-4"><?= !empty($item['created_at']) ? jdate('Y/m/d', $item['created_at']) : '—' ?></td>
                        <td class="px-5 py-4">
                            <div class="flex space-x-2 rtl:space-x-reverse">
                                <a href="<?= site_url($basePath . '/edit/' . $item['id']) ?>" class="text-primary hover:text-primary-800" title="ویرایش" aria-label="ویرایش <?= esc($item[$isCategory ? 'title' : 'question']) ?>">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form method="post" action="<?= site_url($basePath . '/delete/' . $item['id']) ?>" onsubmit="return confirm('از حذف این مورد مطمئن هستید؟');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="حذف" aria-label="حذف <?= esc($item[$isCategory ? 'title' : 'question']) ?>">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($pager)): ?><div class="pagination-wrapper mt-4"><?= $pager->links() ?></div><?php endif; ?>
<?php else: ?>
    <div class="alert alert-warning text-center py-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
        <svg class="w-12 h-12 text-yellow-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?= $isCategory ? 'دسته‌بندی‌ای یافت نشد' : 'سوالی یافت نشد' ?></h5>
        <p class="text-gray-600 dark:text-gray-400">هیچ موردی با جستجوی شما مطابقت ندارد</p>
    </div>
<?php endif; ?>
