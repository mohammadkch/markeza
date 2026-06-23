<?php

namespace App\Controllers\Admin;

class Collection extends BaseController
{
    public function index()
    {
        helper('sanitize');
        $pager = service('pager');
        $collectionModel = model('App\Models\CollectionModel');

        $page = (int) $this->request->getGet('page');
        $page = $page > 0 ? $page : 1;

        $title = $this->request->getPost('title', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $slug = $this->request->getPost('slug', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];
        if (!empty($title)) $condition['title'] = $title;
        if (!empty($slug)) $condition['slug'] = $slug;
        if ($is_active !== '' && $is_active !== null) $condition['is_active'] = $is_active;

        $per_page = 10;
        $total_rows = $collectionModel->getData($condition, null, 0, true);
        $rowset = $collectionModel->getData($condition, $per_page, ($page - 1) * $per_page);

        foreach ($rowset as &$row) {
            $row['images'] = [];
            if (!empty($row['images_data'])) {
                $imagesParts = explode(';;;', $row['images_data']);
                foreach ($imagesParts as $part) {
                    $data = explode('|||', $part);
                    if (count($data) >= 4 && !empty($data[0])) {
                        $row['images'][] = [
                            'id' => $data[0],
                            'image_path' => $data[1],
                            'alt_text' => $data[2],
                            'sort_order' => $data[3],
                        ];
                    }
                }
            }
            unset($row['images_data']);
        }

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        $this->viewData['search_fields'] = [
            'title' => [
                'label' => 'عنوان کالکشن',
                'input' => 'form_input',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'placeholder' => 'عنوان کالکشن'],
                'type' => 'text'
            ],
            'slug' => [
                'label' => 'slug',
                'input' => 'form_input',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'placeholder' => 'slug'],
                'type' => 'text'
            ],
            'is_active' => [
                'label' => 'وضعیت',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white'],
                'options' => [
                    '' => 'همه',
                    '1' => 'فعال',
                    '0' => 'غیرفعال'
                ]
            ]
        ];

        $this->viewData['pagination'] = $pagination;
        $this->viewData['rowset'] = $rowset;
        $this->viewData['edit_pk'] = 'id';
        $this->viewData['statusLabels'] = [1 => 'فعال', 0 => 'غیرفعال'];

        if ($this->request->isAJAX()) {
            return view('admin/collection/index_data_table', $this->viewData);
        }

        return view('admin/collection/index', $this->viewData);
    }

    public function create($task = null)
    {
        helper('fields');

        if ($task == 'handle') {
            return $this->formHandler('create', 0);
        }

        $this->viewData['inputs'] = [
            'title' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'title', 'name' => 'title', 'placeholder' => 'عنوان کالکشن'],
                'type' => 'text'
            ],
            'slug' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'slug', 'name' => 'slug', 'placeholder' => 'slug (لینک دستی) - خالی بگذارید خودکار می‌شود'],
                'type' => 'text'
            ],
            'subtitle' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'subtitle', 'name' => 'subtitle', 'placeholder' => 'زیر عنوان'],
                'type' => 'text'
            ],
            'excerpt' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'excerpt', 'name' => 'excerpt', 'placeholder' => 'متن کوتاه لیست کالکشن‌ها', 'rows' => 3],
                'type' => 'textarea'
            ],
            'description' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'description', 'name' => 'description', 'placeholder' => 'توضیحات کامل', 'rows' => 5],
                'type' => 'textarea'
            ],
            'meta_title' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'meta_title', 'name' => 'meta_title', 'placeholder' => 'عنوان سئو'],
                'type' => 'text'
            ],
            'meta_description' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'meta_description', 'name' => 'meta_description', 'placeholder' => 'توضیحات سئو', 'rows' => 3],
                'type' => 'textarea'
            ],
            'sort_order' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'sort_order', 'name' => 'sort_order', 'placeholder' => 'ترتیب نمایش', 'type' => 'number'],
                'type' => 'text'
            ],
            'is_active' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'is_active', 'name' => 'is_active'],
                'options' => [
                    '1' => 'فعال',
                    '0' => 'غیرفعال'
                ]
            ]
        ];

        $this->viewData['fields_name'] = [
            'title' => 'عنوان کالکشن',
            'slug' => 'slug',
            'subtitle' => 'زیر عنوان',
            'description' => 'توضیحات',
            'excerpt' => 'متن کوتاه (خلاصه)',
            'meta_title' => 'عنوان سئو',
            'meta_description' => 'توضیحات سئو',
            'sort_order' => 'ترتیب نمایش',
            'is_active' => 'وضعیت'
        ];

        $this->viewData['form_action'] = 'admin/collection/create/handle';

        return view($this->viewPath . 'collection/create', $this->viewData);
    }

    public function edit($id, $task = null)
    {
        $id = (int) $id;

        if ($task == 'handle') {
            return $this->formHandler('edit', $id);
        }

        $collectionModel = model('App\Models\CollectionModel');
        $collectionImageModel = model('App\Models\CollectionImageModel');

        $edit_row = $collectionModel->find($id);

        if ($edit_row == null) {
            $this->flash('collection_not_found');
            return redirect()->to('admin/collection');
        }

        $existingImages = $collectionImageModel
            ->where('collection_id', $id)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        $this->viewData['existingImages'] = $existingImages;
        $this->viewData['form_action'] = 'admin/collection/edit/' . $id . '/handle';
        $this->viewData['edit_row'] = $edit_row;
        $this->viewData['inputs'] = [
            'title' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'title', 'name' => 'title', 'placeholder' => 'عنوان کالکشن'],
                'type' => 'text'
            ],
            'slug' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'slug', 'name' => 'slug', 'placeholder' => 'slug (لینک دستی) - خالی بگذارید خودکار می‌شود'],
                'type' => 'text'
            ],
            'subtitle' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'subtitle', 'name' => 'subtitle', 'placeholder' => 'زیر عنوان'],
                'type' => 'text'
            ],
            'description' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'description', 'name' => 'description', 'placeholder' => 'توضیحات کامل', 'rows' => 5],
                'type' => 'textarea'
            ],
            'excerpt' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'excerpt', 'name' => 'excerpt', 'placeholder' => 'متن کوتاه لیست کالکشن‌ها', 'rows' => 3],
                'type' => 'textarea'
            ],
            'meta_title' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'meta_title', 'name' => 'meta_title', 'placeholder' => 'عنوان سئو'],
                'type' => 'text'
            ],
            'meta_description' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'meta_description', 'name' => 'meta_description', 'placeholder' => 'توضیحات سئو', 'rows' => 3],
                'type' => 'textarea'
            ],
            'sort_order' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'sort_order', 'name' => 'sort_order', 'placeholder' => 'ترتیب نمایش', 'type' => 'number'],
                'type' => 'text'
            ],
            'is_active' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'is_active', 'name' => 'is_active'],
                'options' => [
                    '1' => 'فعال',
                    '0' => 'غیرفعال'
                ]
            ]
        ];

        $this->viewData['fields_name'] = [
            'title' => 'عنوان کالکشن',
            'slug' => 'slug',
            'subtitle' => 'زیر عنوان',
            'description' => 'توضیحات',
            'meta_title' => 'عنوان سئو',
            'meta_description' => 'توضیحات سئو',
            'sort_order' => 'ترتیب نمایش',
            'is_active' => 'وضعیت'
        ];

        return view($this->viewPath . 'collection/create', $this->viewData);
    }

    public function formHandler($task, $id = 0)
    {
        if (!in_array($task, ['create', 'edit'])) {
            return redirect()->to('admin/collection');
        }

        helper('sanitize');
        $validation = \Config\Services::validation();
        $collectionModel = model('App\Models\CollectionModel');
        $collectionImageModel = model('App\Models\CollectionImageModel');

        $rules = [
            'title' => [
                'label' => 'عنوان کالکشن',
                'rules' => 'required|min_length[2]|max_length[255]'
            ],
            'is_active' => [
                'label' => 'وضعیت',
                'rules' => 'required|in_list[0,1]'
            ],
            'sort_order' => [
                'label' => 'ترتیب نمایش',
                'rules' => 'permit_empty|integer'
            ]
        ];

        if (!$this->validate($rules)) {
            $this->viewData['validation_errors'] = $validation->getErrors();
            $this->flash('validation_error');

            if ($task == 'edit') {
                return $this->edit($id);
            } else {
                return $this->create();
            }
        }

        $slug = $this->request->getPost('slug', FILTER_SANITIZE_STRING);
        if (empty($slug)) {
            $slug = $this->slugify($this->request->getPost('title', FILTER_SANITIZE_STRING));
        }

        $model_data = [
            'title' => $this->request->getPost('title', FILTER_SANITIZE_STRING),
            'slug' => $slug,
            'subtitle' => $this->request->getPost('subtitle', FILTER_SANITIZE_STRING),
            'description' => $this->request->getPost('description'),
            'excerpt' => $this->request->getPost('excerpt', FILTER_SANITIZE_STRING),
            'meta_title' => $this->request->getPost('meta_title', FILTER_SANITIZE_STRING),
            'meta_description' => $this->request->getPost('meta_description', FILTER_SANITIZE_STRING),
            'sort_order' => (int) $this->request->getPost('sort_order') ?: 0,
            'is_active' => (int) $this->request->getPost('is_active'),
            'updated_at' => time()
        ];

        if ($task == 'create') {
            $model_data['created_at'] = time();
            $collectionId = $collectionModel->insert($model_data);

            if (!$collectionId) {
                $this->flash('collection_create_error');
                return redirect()->to('admin/collection/create');
            }
        } else {
            $collectionId = $id;
            $update_result = $collectionModel->update($collectionId, $model_data);

            if (!$update_result) {
                $this->flash('collection_update_error');
                return redirect()->to('admin/collection/edit/' . $collectionId);
            }
        }

        if ($task == 'create') {
            $this->flash('collection_create_success');
        } else {
            $this->flash('collection_update_success');
        }

        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail && $thumbnail->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($thumbnail->isValid()) {
                $uploadPath = FCPATH . 'assets/images/collection/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $newName = time() . '_' . $thumbnail->getClientName();
                $thumbnail->move($uploadPath, $newName);

                $collectionModel->update($collectionId, [
                    'thumbnail' => 'assets/images/collection/' . $newName
                ]);
            }
        }

        // Handle gallery images upload
        $galleryImages = $this->request->getFileMultiple('gallery_images');
        if ($galleryImages) {
            $uploadPath = FCPATH . 'assets/images/collection/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Get current max sort_order
            $existingImages = $collectionImageModel
                ->where('collection_id', $collectionId)
                ->orderBy('sort_order', 'DESC')
                ->first();
            $nextSortOrder = ($existingImages ? $existingImages['sort_order'] + 1 : 1);

            foreach ($galleryImages as $file) {
                if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE && $file->isValid()) {
                    $newName = time() . '_' . $file->getClientName();
                    $file->move($uploadPath, $newName);

                    $collectionImageModel->insert([
                        'collection_id' => $collectionId,
                        'image_path' => 'assets/images/collection/' . $newName,
                        'alt_text' => $this->request->getPost('title'),
                        'sort_order' => $nextSortOrder++
                    ]);
                }
            }
        }

        // Handle alt text updates for existing images
        $existingImageIds = $this->request->getPost('existing_images');
        if ($existingImageIds) {
            foreach ($existingImageIds as $imgId) {
                $altText = $this->request->getPost('alt_' . $imgId);
                if ($altText !== null) {
                    $collectionImageModel->update($imgId, ['alt_text' => $altText]);
                }
            }
        }

        return redirect()->to('admin/collection');
    }

    public function delete($id)
    {
        $collectionModel = model('App\Models\CollectionModel');

        $collection = $collectionModel->find($id);

        if (!$collection) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'کالکشن یافت نشد'
            ]);
        }

        try {
            if ($collectionModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'کالکشن با موفقیت حذف شد'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'خطا در حذف کالکشن'
                ]);
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'این کالکشن دارای محصول یا تصویر می‌باشد. ابتدا زیرمجموعه‌های آن را حذف کنید.'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در حذف: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteImage()
    {
        $imageId = (int) $this->request->getPost('id');

        if (!$imageId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'شناسه تصویر معتبر نیست'
            ]);
        }

        $collectionImageModel = model('App\Models\CollectionImageModel');
        $image = $collectionImageModel->find($imageId);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        // Delete file from server
        $filePath = FCPATH . $image['image_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete from database
        if ($collectionImageModel->delete($imageId)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت حذف شد'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'خطا در حذف تصویر'
        ]);
    }

    /////////////////////////////////////////////////////////////////////////////////////////

    public function manageDetails($collectionId)
    {
        $collectionId = (int) $collectionId;
        $collectionModel = model('App\Models\CollectionModel');
        $collection = $collectionModel->find($collectionId);

        if (!$collection) {
            $this->flash('collection_not_found');
            return redirect()->to('admin/collection');
        }

        $detailModel = model('App\Models\CollectionDetailModel');
        $details = $detailModel->getByCollection($collectionId);

        $this->viewData['collection'] = $collection;
        $this->viewData['details'] = $details;
        $this->viewData['collectionId'] = $collectionId;

        return view($this->viewPath . 'collection/details', $this->viewData);
    }

    public function addDetail($collectionId)
    {
        $collectionId = (int) $collectionId;
        $collectionModel = model('App\Models\CollectionModel');
        $collection = $collectionModel->find($collectionId);

        if (!$collection) {
            $this->flash('collection_not_found');
            return redirect()->to('admin/collection');
        }

        $method = $this->request->getMethod();
        if ($method === 'post' || $method === 'POST') {
            helper('sanitize');
            $detailModel = model('App\Models\CollectionDetailModel');

            $data = [
                'collection_id' => $collectionId,
                'label' => $this->request->getPost('label', FILTER_SANITIZE_STRING),
                'value' => $this->request->getPost('value', FILTER_SANITIZE_STRING),
                'icon_type' => $this->request->getPost('icon_type', FILTER_SANITIZE_STRING),
                'sort_order' => (int) $this->request->getPost('sort_order') ?: 0,
                'created_at' => time(),
                'updated_at' => time()
            ];

            if ($detailModel->insert($data)) {
                $this->flash('detail_create_success');
            } else {
                $this->flash('detail_create_error');
            }

            return redirect()->to('admin/collection/details/' . $collectionId);
        }

        $this->viewData['collection'] = $collection;
        $this->viewData['collectionId'] = $collectionId;
        $this->viewData['form_action'] = 'admin/collection/addDetail/' . $collectionId;

        return view($this->viewPath . 'collection/detail_form', $this->viewData);
    }

    public function editImage($imageId)
    {
        $imageId = (int) $imageId;
        $imageModel = model('App\Models\ProductImageModel');
        $image = $imageModel->find($imageId);

        if (!$image) {
            $this->flash('image_not_found');
            return redirect()->to('admin/product');
        }

        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($image['product_id']);

        if ($this->request->is('post')) {
            $data = [
                'alt_text' => $this->request->getPost('alt_text'),
                'sort_order' => (int) $this->request->getPost('sort_order') ?: 0,
                'updated_at' => time()
            ];

            if ($imageModel->update($imageId, $data)) {
                $this->flash('image_update_success');
            } else {
                $this->flash('image_update_error');
            }

            return redirect()->to('admin/product/images/' . $image['product_id']);
        }

        $this->viewData['image'] = $image;
        $this->viewData['product'] = $product;
        $this->viewData['productId'] = $image['product_id'];
        $this->viewData['form_action'] = 'admin/product/editImage/' . $imageId;

        return view($this->viewPath . 'product/image_form', $this->viewData);
    }

    public function deleteDetail($detailId)
    {
        $detailId = (int) $detailId;
        $detailModel = model('App\Models\CollectionDetailModel');
        $detail = $detailModel->find($detailId);

        if (!$detail) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'آیتم یافت نشد'
            ]);
        }

        if ($detailModel->delete($detailId)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'آیتم با موفقیت حذف شد'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'خطا در حذف آیتم'
        ]);
    }

    private function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

}