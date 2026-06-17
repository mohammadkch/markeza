<?= $this->extend('admin/_layout_/layout') ?>
<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

                <?= $this->include('admin/_layout_/layout_sidebar') ?>

                <div class="lg:col-span-3 space-y-8">

                    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">
                                <?= isset($faq) ? 'ویرایش سوال' : 'افزودن سوال جدید' ?>
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">(<?= esc($product['title']) ?>)</span>
                            </h1>
                            <div class="mt-4 md:mt-0">
                                <a href="<?= site_url('admin/product/faqs/' . $productId) ?>" class="bg-gray-200 text-gray-800 py-2.5 px-4 rounded-lg hover:bg-gray-300 transition">بازگشت</a>
                            </div>
                        </div>

                        <form method="post" action="<?= site_url($form_action) ?>">
                            <?= csrf_field() ?>
                            <div class="space-y-4">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">سوال</label>
                                    <input type="text" name="question" value="<?= isset($faq) ? esc($faq['question']) : '' ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" placeholder="سوال کاربر..." required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">پاسخ</label>
                                    <textarea name="answer" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" placeholder="پاسخ به سوال..." required><?= isset($faq) ? esc($faq['answer']) : '' ?></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ترتیب نمایش</label>
                                    <input type="number" name="sort_order" value="<?= isset($faq) ? $faq['sort_order'] : 0 ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                </div>

                            </div>

                            <div class="mt-6 flex gap-3">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">
                                    <?= isset($faq) ? 'بروزرسانی' : 'ذخیره' ?>
                                </button>
                                <a href="<?= site_url('admin/product/faqs/' . $productId) ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>