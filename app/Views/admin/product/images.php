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
                                <h1 class="font-black text-2xl with-highlight dark:text-gray-200">مدیریت تصاویر محصول</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1"><?= esc($product['title']) ?></p>
                            </div>
                            <div class="mt-4 md:mt-0 flex gap-2">
                                <a href="<?= site_url('admin/product/addImage/' . $productId) ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    افزودن تصویر جدید
                                </a>
                                <a href="<?= site_url('admin/product') ?>" class="bg-gray-200 text-gray-800 py-2.5 px-4 rounded-lg hover:bg-gray-300 transition">بازگشت</a>
                            </div>
                        </div>

                        <?php if (empty($images)): ?>
                            <div class="text-center py-8 bg-gray-50 dark:bg-gray-800/40 rounded-lg">
                                <p class="text-gray-500 dark:text-gray-400">هیچ تصویری برای این محصول ثبت نشده است.</p>
                                <a href="<?= site_url('admin/product/addImage/' . $productId) ?>" class="inline-block mt-3 text-primary hover:underline">افزودن اولین تصویر</a>
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <?php foreach ($images as $img): ?>
                                    <div class="relative border border-gray-200 dark:border-gray-700 rounded-lg p-2 bg-gray-50 dark:bg-gray-800/30">
                                        <img src="<?= base_url($img['image_path']) ?>" class="w-full h-32 object-cover rounded-lg">
                                        <div class="mt-2">
                                            <p class="text-xs text-gray-500 truncate"><?= esc($img['alt_text']) ?></p>
                                            <p class="text-xs text-gray-400">ترتیب: <?= $img['sort_order'] ?></p>
                                        </div>
                                        <div class="absolute top-2 left-2 flex gap-1">
                                            <a href="<?= site_url('admin/product/editImage/' . $img['id']) ?>" class="bg-primary text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-primary-600">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <button type="button" class="delete-image-btn bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600" data-id="<?= $img['id'] ?>">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Delete Modal -->
    <div id="deleteImageModal" class="hidden fixed inset-0 z-50 overflow-auto backdrop-blur bg-black/50">
        <div class="relative p-4 w-full max-w-md m-auto flex items-center min-h-screen">
            <div class="bg-white relative w-full dark:bg-custom-dark rounded-2xl shadow-soft p-6">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">آیا اطمینان دارید؟</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">آیا از حذف این تصویر اطمینان دارید؟</p>
                    <div class="flex gap-3 justify-center">
                        <button type="button" id="cancelImageDeleteBtn" class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-400 transition">خیر</button>
                        <button type="button" id="confirmImageDeleteBtn" class="bg-red-500 text-white py-2 px-6 rounded-lg hover:bg-red-600 transition">بله، حذف شود</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Delete image
        let currentImageId = null;

        document.querySelectorAll('.delete-image-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentImageId = this.dataset.id;
                document.getElementById('deleteImageModal').classList.remove('hidden');
            });
        });

        document.getElementById('confirmImageDeleteBtn').addEventListener('click', function() {
            if (currentImageId) {
                fetch('<?= site_url('admin/product/deleteImage') ?>/' + currentImageId, {
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
                        document.getElementById('deleteImageModal').classList.add('hidden');
                    })
                    .catch(error => {
                        showNotification('خطا در حذف تصویر', 'error');
                        document.getElementById('deleteImageModal').classList.add('hidden');
                    });
            }
        });

        document.getElementById('cancelImageDeleteBtn').addEventListener('click', function() {
            document.getElementById('deleteImageModal').classList.add('hidden');
        });

        document.getElementById('deleteImageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>

<?= $this->endSection() ?>