<?= $this->extend('admin/_layout_/layout') ?>
<?php helper('form'); ?>

<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

                <?= $this->include('admin/_layout_/layout_sidebar') ?>

                <div class="lg:col-span-3 space-y-8">

                    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">
                                <?= isset($edit_row) ? 'ویرایش کالکشن' : 'افزودن کالکشن جدید' ?>
                            </h1>
                            <div class="mt-4 md:mt-0">
                                <a href="<?= site_url('admin/collection') ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block">
                                    بازگشت به لیست
                                </a>
                            </div>
                        </div>

                        <?php if (isset($validation_errors) && !empty($validation_errors)): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                                <ul class="mb-0">
                                    <?php foreach ($validation_errors as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= site_url($form_action) ?>" enctype="multipart/form-data">
                            <div class="space-y-4">
                                <?php foreach ($inputs as $input_key => $input): ?>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <?= $fields_name[$input_key] ?? $input_key ?>
                                        </label>
                                        <?php
                                        $value = set_value($input_key, isset($edit_row[$input_key]) ? $edit_row[$input_key] : '');

                                        if ($input['input'] == 'form_input'):
                                            echo form_input(array_merge($input['data'], ['value' => $value, 'class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                        elseif ($input['input'] == 'form_textarea'):
                                            echo form_textarea(array_merge($input['data'], ['value' => $value, 'class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                        elseif ($input['input'] == 'form_dropdown'):
                                            echo form_dropdown($input_key, $input['options'], $value, array_merge($input['data'], ['class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                        endif;
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <hr class="my-6 border-gray-200 dark:border-gray-700">

                            <div class="space-y-4">
                                <h3 class="font-black text-lg with-highlight dark:text-gray-200">تصاویر کالکشن</h3>
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                تصویر شاخص (Thumbnail)
                                            </label>
                                            <?php if (isset($edit_row) && !empty($edit_row['thumbnail'])): ?>
                                                <div class="mb-2">
                                                    <img src="<?= base_url($edit_row['thumbnail']) ?>" class="w-20 h-20 object-cover rounded-lg border">
                                                </div>
                                            <?php endif; ?>
                                            <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/gif,image/webp" class="w-full text-sm">
                                            <p class="text-xs text-gray-500 mt-1">حداکثر: 2MB</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 mt-4">
                                    <h4 class="font-bold text-md mb-3 dark:text-gray-200">تصاویر گالری</h4>
                                    <?php if (isset($existingImages) && !empty($existingImages)): ?>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                            <?php foreach ($existingImages as $img): ?>
                                                <div class="relative border rounded-lg p-2">
                                                    <img src="<?= base_url($img['image_path']) ?>" class="w-full h-24 object-cover rounded">
                                                    <input type="hidden" name="existing_images[]" value="<?= $img['id'] ?>">
                                                    <input type="text" name="alt_<?= $img['id'] ?>" value="<?= esc($img['alt_text']) ?>" class="w-full mt-2 text-xs px-2 py-1 border rounded" placeholder="Alt text">
                                                    <button type="button" class="delete-image-btn absolute top-1 left-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs" data-id="<?= $img['id'] ?>">×</button>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mt-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">افزودن تصاویر جدید</label>
                                        <input type="file" name="gallery_images[]" accept="image/jpeg,image/png,image/gif,image/webp" class="w-full text-sm" multiple>
                                        <p class="text-xs text-gray-500 mt-1">می‌توانید چند تصویر همزمان انتخاب کنید</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">
                                    <?= isset($edit_row) ? 'بروزرسانی' : 'ذخیره' ?>
                                </button>
                                <a href="<?= site_url('admin/collection') ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        // Delete image AJAX
        document.querySelectorAll('.delete-image-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('آیا از حذف این تصویر اطمینان دارید؟')) {
                    const imgId = this.dataset.id;
                    fetch('<?= site_url('admin/collection/deleteImage') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: 'id=' + imgId
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        });
                }
            });
        });
    </script>

<?= $this->endSection() ?>