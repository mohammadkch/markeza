<?php helper('jalali'); ?>

<?php if (isset($rowset) && !empty($rowset)): ?>
    <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
        <table class="w-full text-sm text-right">
            <thead class="text-xs bg-gray-100 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300 sticky top-0">
            <tr>
                <th class="px-5 py-4">شناسه</th>
                <th class="px-5 py-4">تصویر</th>
                <th class="px-5 py-4">عنوان</th>
                <th class="px-5 py-4">کالکشن</th>
                <th class="px-5 py-4">تعداد تصاویر</th>
                <th class="px-5 py-4">slug</th>
                <th class="px-5 py-4">ترتیب</th>
                <th class="px-5 py-4">وضعیت</th>
                <th class="px-5 py-4">تاریخ ایجاد</th>
                <th class="px-5 py-4">عملیات</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php foreach ($rowset as $item): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                    <td class="px-5 py-4 font-bold text-gray-900 dark:text-white"><?= $item['id'] ?></td>
                    <td class="px-5 py-4">
                        <?php if (!empty($item['thumbnail'])): ?>
                            <img src="<?= base_url($item['thumbnail']) ?>"
                                 class="w-12 h-12 object-cover rounded-lg border">
                        <?php else: ?>
                            <span class="text-gray-400 text-xs">بدون تصویر</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4 font-medium"><?= esc($item['title']) ?></td>
                    <td class="px-5 py-4"><?= esc($item['collection_title'] ?? '-') ?></td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                            <?= $item['images_count'] ?? 0 ?> تصویر
                        </span>
                    </td>
                    <td class="px-5 py-4 text-gray-500 text-xs"><?= esc($item['slug']) ?></td>
                    <td class="px-5 py-4"><?= $item['sort_order'] ?></td>
                    <td class="px-5 py-4">
                        <?php if ($item['is_active'] == 1): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">فعال</span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300">غیرفعال</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4"><?= jdate('Y/m/d', $item['created_at']) ?></td>
                    <td class="px-5 py-4">
                        <div class="flex space-x-2 rtl:space-x-reverse">
                            <a href="<?= site_url('admin/product/faqs/' . $item['id']) ?>" class="text-blue-600 hover:text-blue-800" title="مدیریت سوالات">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </a>
                            <a href="<?= site_url('admin/product/materials/' . $item['id']) ?>" class="text-blue-600 hover:text-blue-800" title="مدیریت متریال">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </a>
                            <a href="<?= site_url('admin/product/images/' . $item['id']) ?>" class="text-blue-600 hover:text-blue-800" title="مدیریت تصاویر">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="2" y="2" width="20" height="20" rx="2" ry="2" stroke="currentColor" stroke-width="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="2.5" stroke="currentColor" stroke-width="2"></circle>
                                    <polyline points="21 15 16 10 5 21" stroke="currentColor" stroke-width="2"></polyline>
                                </svg>
                            </a>
                            <a href="<?= site_url('admin/product/edit/' . $item['id']) ?>" class="text-primary hover:text-primary-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <button type="button" class="delete-btn text-red-600 hover:text-red-800" data-id="<?= $item['id'] ?>" data-url="<?= site_url('admin/product/delete') ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($pagination) && $pagination): ?>
        <div class="pagination-wrapper mt-4">
            <?= $pagination ?>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="alert alert-warning text-center py-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
        <svg class="w-12 h-12 text-yellow-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-200">محصولی یافت نشد</h5>
        <p class="text-gray-600 dark:text-gray-400">هیچ محصولی با جستجوی شما مطابقت ندارد</p>
    </div>
<?php endif; ?>