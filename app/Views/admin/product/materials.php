<?= $this->extend('admin/_layout_/layout') ?>
<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

                <?= $this->include('admin/_layout_/layout_sidebar') ?>

                <div class="lg:col-span-3 space-y-8">

                    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                                <h1 class="font-black text-2xl with-highlight dark:text-gray-200">مدیریت متریال محصول</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1"><?= esc($product['title']) ?></p>
                            </div>
                            <div class="mt-4 md:mt-0 flex gap-2">
                                <a href="<?= site_url('admin/product/addMaterial/' . $productId) ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    افزودن متریال جدید
                                </a>
                                <a href="<?= site_url('admin/product') ?>" class="bg-gray-200 text-gray-800 py-2.5 px-4 rounded-lg hover:bg-gray-300 transition">بازگشت</a>
                            </div>
                        </div>

                        <?php if (empty($materials)): ?>
                            <div class="text-center py-8 bg-gray-50 dark:bg-gray-800/40 rounded-lg">
                                <p class="text-gray-500 dark:text-gray-400">هیچ متریالی برای این محصول ثبت نشده است.</p>
                                <a href="<?= site_url('admin/product/addMaterial/' . $productId) ?>" class="inline-block mt-3 text-primary hover:underline">افزودن اولین متریال</a>
                            </div>
                        <?php else: ?>
                            <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
                                <table class="w-full text-sm text-right">
                                    <thead class="text-xs bg-gray-100 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300 sticky top-0">
                                    <tr>
                                        <th class="px-5 py-4">شناسه</th>
                                        <th class="px-5 py-4">عنوان</th>
                                        <th class="px-5 py-4">توضیحات</th>
                                        <th class="px-5 py-4">ترتیب</th>
                                        <th class="px-5 py-4">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    <?php foreach ($materials as $item): ?>
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                            <td class="px-5 py-4 font-bold text-gray-900 dark:text-white"><?= $item['id'] ?></td>
                                            <td class="px-5 py-4 font-medium"><?= esc($item['title']) ?></td>
                                            <td class="px-5 py-4"><?= esc($item['description']) ?></td>
                                            <td class="px-5 py-4"><?= $item['sort_order'] ?></td>
                                            <td class="px-5 py-4">
                                                <div class="flex space-x-2 rtl:space-x-reverse">
                                                    <a href="<?= site_url('admin/product/editMaterial/' . $item['id']) ?>" class="text-primary hover:text-primary-800">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <button type="button" class="delete-material-btn text-red-600 hover:text-red-800" data-id="<?= $item['id'] ?>">
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
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Delete Modal -->
    <div id="deleteMaterialModal" class="hidden fixed inset-0 z-50 overflow-auto backdrop-blur bg-black/50">
        <div class="relative p-4 w-full max-w-md m-auto flex items-center min-h-screen">
            <div class="bg-white relative w-full dark:bg-custom-dark rounded-2xl shadow-soft p-6">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">آیا اطمینان دارید؟</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">آیا از حذف این متریال اطمینان دارید؟</p>
                    <div class="flex gap-3 justify-center">
                        <button type="button" id="cancelMaterialDeleteBtn" class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-400 transition">خیر</button>
                        <button type="button" id="confirmMaterialDeleteBtn" class="bg-red-500 text-white py-2 px-6 rounded-lg hover:bg-red-600 transition">بله، حذف شود</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentMaterialId = null;

        document.querySelectorAll('.delete-material-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentMaterialId = this.dataset.id;
                document.getElementById('deleteMaterialModal').classList.remove('hidden');
            });
        });

        document.getElementById('confirmMaterialDeleteBtn').addEventListener('click', function() {
            if (currentMaterialId) {
                fetch('<?= site_url('admin/product/deleteMaterial') ?>/' + currentMaterialId, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            showNotification(data.message, 'success');
                            location.reload();
                        } else {
                            showNotification(data.message, 'error');
                        }
                        document.getElementById('deleteMaterialModal').classList.add('hidden');
                    })
                    .catch(error => {
                        showNotification('خطا در حذف', 'error');
                        document.getElementById('deleteMaterialModal').classList.add('hidden');
                    });
            }
        });

        document.getElementById('cancelMaterialDeleteBtn').addEventListener('click', function() {
            document.getElementById('deleteMaterialModal').classList.add('hidden');
        });

        document.getElementById('deleteMaterialModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>

<?= $this->endSection() ?>