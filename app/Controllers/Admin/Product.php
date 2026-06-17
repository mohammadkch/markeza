<?php

namespace App\Controllers\Admin;

class Product extends BaseController
{
    public function index()
    {
        helper('sanitize');
        $pager = service('pager');
        $productModel = model('App\Models\ProductModel');
        $collectionModel = model('App\Models\CollectionModel');

        $page = (int) $this->request->getGet('page');
        $page = $page > 0 ? $page : 1;

        $title = $this->request->getPost('title', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $collection_id = $this->request->getPost('collection_id', FILTER_VALIDATE_INT);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];
        if (!empty($title)) $condition['title'] = $title;
        if ($collection_id !== '' && $collection_id !== null) $condition['collection_id'] = $collection_id;
        if ($is_active !== '' && $is_active !== null) $condition['is_active'] = $is_active;

        $per_page = 10;
        $total_rows = $productModel->getData($condition, null, 0, true);
        $rowset = $productModel->getData($condition, $per_page, ($page - 1) * $per_page);

        $collections = $collectionModel->orderBy('title', 'ASC')->findAll();
        $collectionOptions = ['' => 'همه کالکشن‌ها'];
        foreach ($collections as $col) {
            $collectionOptions[$col['id']] = $col['title'];
        }

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        $this->viewData['search_fields'] = [
            'title' => [
                'label' => 'عنوان محصول',
                'input' => 'form_input',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'placeholder' => 'عنوان محصول'],
                'type' => 'text'
            ],
            'collection_id' => [
                'label' => 'کالکشن',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white'],
                'options' => $collectionOptions
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
            return view('admin/product/index_data_table', $this->viewData);
        }

        return view('admin/product/index', $this->viewData);
    }

    public function create($task = null)
    {
        helper('fields');
        $collectionModel = model('App\Models\CollectionModel');
        $collections = $collectionModel->where('is_active', 1)->orderBy('title', 'ASC')->findAll();
        $collectionOptions = [];
        foreach ($collections as $col) {
            $collectionOptions[$col['id']] = $col['title'];
        }

        if ($task == 'handle') {
            return $this->formHandler('create', 0);
        }

        $this->viewData['inputs'] = [
            'collection_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'collection_id', 'name' => 'collection_id'],
                'options' => $collectionOptions
            ],
            'title' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'title', 'name' => 'title', 'placeholder' => 'عنوان محصول'],
                'type' => 'text'
            ],
            'slug' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'slug', 'name' => 'slug', 'placeholder' => 'slug (لینک دستی) - خالی بگذارید خودکار می‌شود'],
                'type' => 'text'
            ],
            'description' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'description', 'name' => 'description', 'placeholder' => 'توضیحات کامل محصول', 'rows' => 6],
                'type' => 'textarea'
            ],
            'dimensions_text' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'dimensions_text', 'name' => 'dimensions_text', 'placeholder' => 'متن ابعاد محصول (مثلاً: ارتفاع: ۹۰ سانتی‌متر)', 'rows' => 4],
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
            'collection_id' => 'کالکشن',
            'title' => 'عنوان محصول',
            'slug' => 'slug',
            'description' => 'توضیحات',
            'dimensions_text' => 'متن ابعاد',
            'sort_order' => 'ترتیب نمایش',
            'is_active' => 'وضعیت'
        ];

        $this->viewData['form_action'] = 'admin/product/create/handle';

        return view($this->viewPath . 'product/create', $this->viewData);
    }

    public function edit($id, $task = null)
    {
        $id = (int) $id;

        if ($task == 'handle') {
            return $this->formHandler('edit', $id);
        }

        $productModel = model('App\Models\ProductModel');
        $collectionModel = model('App\Models\CollectionModel');

        $edit_row = $productModel->find($id);

        if ($edit_row == null) {
            $this->flash('product_not_found');
            return redirect()->to('admin/product');
        }

        $collections = $collectionModel->where('is_active', 1)->orderBy('title', 'ASC')->findAll();
        $collectionOptions = [];
        foreach ($collections as $col) {
            $collectionOptions[$col['id']] = $col['title'];
        }

        $this->viewData['form_action'] = 'admin/product/edit/' . $id . '/handle';
        $this->viewData['edit_row'] = $edit_row;
        $this->viewData['inputs'] = [
            'collection_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'collection_id', 'name' => 'collection_id'],
                'options' => $collectionOptions
            ],
            'title' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'title', 'name' => 'title', 'placeholder' => 'عنوان محصول'],
                'type' => 'text'
            ],
            'slug' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'slug', 'name' => 'slug', 'placeholder' => 'slug (لینک دستی) - خالی بگذارید خودکار می‌شود'],
                'type' => 'text'
            ],
            'description' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'description', 'name' => 'description', 'placeholder' => 'توضیحات کامل محصول', 'rows' => 6],
                'type' => 'textarea'
            ],
            'dimensions_text' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'dimensions_text', 'name' => 'dimensions_text', 'placeholder' => 'متن ابعاد محصول (مثلاً: ارتفاع: ۹۰ سانتی‌متر)', 'rows' => 4],
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
            'collection_id' => 'کالکشن',
            'title' => 'عنوان محصول',
            'slug' => 'slug',
            'description' => 'توضیحات',
            'dimensions_text' => 'متن ابعاد',
            'sort_order' => 'ترتیب نمایش',
            'is_active' => 'وضعیت'
        ];

        return view($this->viewPath . 'product/create', $this->viewData);
    }

    public function formHandler($task, $id = 0)
    {
        if (!in_array($task, ['create', 'edit'])) {
            return redirect()->to('admin/product');
        }

        helper('sanitize');
        $validation = \Config\Services::validation();
        $productModel = model('App\Models\ProductModel');

        $rules = [
            'collection_id' => [
                'label' => 'کالکشن',
                'rules' => 'required|integer|is_not_unique[collection.id]'
            ],
            'title' => [
                'label' => 'عنوان محصول',
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
            'collection_id' => (int) $this->request->getPost('collection_id'),
            'title' => $this->request->getPost('title', FILTER_SANITIZE_STRING),
            'slug' => $slug,
            'description' => $this->request->getPost('description'),
            'dimensions_text' => $this->request->getPost('dimensions_text'),
            'sort_order' => (int) $this->request->getPost('sort_order') ?: 0,
            'is_active' => (int) $this->request->getPost('is_active'),
            'updated_at' => time()
        ];

        if ($task == 'create') {
            $model_data['created_at'] = time();
            $productId = $productModel->insert($model_data);

            if (!$productId) {
                $this->flash('product_create_error');
                return redirect()->to('admin/product/create');
            }
        } else {
            $productId = $id;
            $update_result = $productModel->update($productId, $model_data);

            if (!$update_result) {
                $this->flash('product_update_error');
                return redirect()->to('admin/product/edit/' . $productId);
            }
        }

        // Handle thumbnail upload
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail && $thumbnail->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($thumbnail->isValid()) {
                $uploadPath = FCPATH . 'assets/images/product/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $newName = time() . '_' . $thumbnail->getClientName();
                $thumbnail->move($uploadPath, $newName);

                $productModel->update($productId, [
                    'thumbnail' => 'assets/images/product/' . $newName
                ]);
            }
        }

        if ($task == 'create') {
            $this->flash('product_create_success');
        } else {
            $this->flash('product_update_success');
        }

        return redirect()->to('admin/product');
    }

    public function delete($id)
    {
        $productModel = model('App\Models\ProductModel');

        $product = $productModel->find($id);

        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'محصول یافت نشد'
            ]);
        }

        try {
            if ($productModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'محصول با موفقیت حذف شد'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'خطا در حذف محصول'
                ]);
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'این محصول دارای تصویر یا زیرمجموعه می‌باشد. ابتدا زیرمجموعه‌ها را حذف کنید.'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در حذف: ' . $e->getMessage()
            ]);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////

    public function manageImages($productId)
    {
        $productId = (int) $productId;
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found');
            return redirect()->to('admin/product');
        }

        $imageModel = model('App\Models\ProductImageModel');
        $images = $imageModel->getByProduct($productId);

        $this->viewData['product'] = $product;
        $this->viewData['images'] = $images;
        $this->viewData['productId'] = $productId;

        return view($this->viewPath . 'product/images', $this->viewData);
    }

    public function addImage($productId)
    {
        $productId = (int) $productId;
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found');
            return redirect()->to('admin/product');
        }

        $method = $this->request->getMethod();
        if ($method === 'post' || $method === 'POST') {
            $file = $this->request->getFile('image');

            if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE) {
                $this->flash('image_upload_error', 'لطفاً یک فایل انتخاب کنید.');
                return redirect()->to('admin/product/images/' . $productId);
            }

            if (!$file->isValid()) {
                $this->flash('image_upload_error', 'فایل آپلود شده معتبر نیست.');
                return redirect()->to('admin/product/images/' . $productId);
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                $this->flash('image_upload_error', 'فرمت فایل مجاز نیست. (jpeg, png, gif, webp)');
                return redirect()->to('admin/product/images/' . $productId);
            }

            if ($file->getSize() > 2048 * 1024) {
                $this->flash('image_upload_error', 'حجم فایل بیشتر از ۲ مگابایت است.');
                return redirect()->to('admin/product/images/' . $productId);
            }

            $uploadPath = FCPATH . 'assets/images/product/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $imageModel = model('App\Models\ProductImageModel');

            // Get current max sort_order
            $existingImages = $imageModel
                ->where('product_id', $productId)
                ->orderBy('sort_order', 'DESC')
                ->first();
            $nextSortOrder = ($existingImages ? $existingImages['sort_order'] + 1 : 1);

            $newName = time() . '_' . $file->getClientName();
            $file->move($uploadPath, $newName);

            $data = [
                'product_id' => $productId,
                'image_path' => 'assets/images/product/' . $newName,
                'alt_text' => $this->request->getPost('alt_text') ?: $product['title'],
                'sort_order' => $nextSortOrder,
                'created_at' => time(),
                'updated_at' => time()
            ];

            if ($imageModel->insert($data)) {
                $this->flash('image_create_success');
            } else {
                $this->flash('image_create_error');
            }

            return redirect()->to('admin/product/images/' . $productId);
        }

        $this->viewData['product'] = $product;
        $this->viewData['productId'] = $productId;
        $this->viewData['form_action'] = 'admin/product/addImage/' . $productId;

        return view($this->viewPath . 'product/image_form', $this->viewData);
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


        $method = $this->request->getMethod();
        if ($method === 'post' || $method === 'POST') {
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

    public function deleteImage($imageId)
    {
        $imageId = (int) $imageId;
        $imageModel = model('App\Models\ProductImageModel');
        $image = $imageModel->find($imageId);

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

        if ($imageModel->delete($imageId)) {
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

    //////////////////////////////////////////

    public function manageMaterials($productId)
    {
        $productId = (int) $productId;
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found');
            return redirect()->to('admin/product');
        }

        $materialModel = model('App\Models\ProductMaterialModel');
        $materials = $materialModel->getByProduct($productId);

        $this->viewData['product'] = $product;
        $this->viewData['materials'] = $materials;
        $this->viewData['productId'] = $productId;

        return view($this->viewPath . 'product/materials', $this->viewData);
    }

    public function addMaterial($productId)
    {
        $productId = (int) $productId;
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found');
            return redirect()->to('admin/product');
        }

        if ($this->request->is('post')) {
            $materialModel = model('App\Models\ProductMaterialModel');

            $data = [
                'product_id' => $productId,
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'sort_order' => (int) $this->request->getPost('sort_order') ?: 0,
                'created_at' => time(),
                'updated_at' => time()
            ];

            if ($materialModel->insert($data)) {
                $this->flash('material_create_success');
            } else {
                $this->flash('material_create_error');
            }

            return redirect()->to('admin/product/materials/' . $productId);
        }

        $this->viewData['product'] = $product;
        $this->viewData['productId'] = $productId;
        $this->viewData['form_action'] = 'admin/product/addMaterial/' . $productId;

        return view($this->viewPath . 'product/material_form', $this->viewData);
    }

    public function editMaterial($materialId)
    {
        $materialId = (int) $materialId;
        $materialModel = model('App\Models\ProductMaterialModel');
        $material = $materialModel->find($materialId);

        if (!$material) {
            $this->flash('material_not_found');
            return redirect()->to('admin/product');
        }

        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($material['product_id']);

        if ($this->request->is('post')) {
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'sort_order' => (int) $this->request->getPost('sort_order') ?: 0,
                'updated_at' => time()
            ];

            if ($materialModel->update($materialId, $data)) {
                $this->flash('material_update_success');
            } else {
                $this->flash('material_update_error');
            }

            return redirect()->to('admin/product/materials/' . $material['product_id']);
        }

        $this->viewData['material'] = $material;
        $this->viewData['product'] = $product;
        $this->viewData['productId'] = $material['product_id'];
        $this->viewData['form_action'] = 'admin/product/editMaterial/' . $materialId;

        return view($this->viewPath . 'product/material_form', $this->viewData);
    }

    public function deleteMaterial($materialId)
    {
        $materialId = (int) $materialId;
        $materialModel = model('App\Models\ProductMaterialModel');
        $material = $materialModel->find($materialId);

        if (!$material) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'متریال یافت نشد'
            ]);
        }

        if ($materialModel->delete($materialId)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'متریال با موفقیت حذف شد'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'خطا در حذف متریال'
        ]);
    }

    ///////////////////////////////////////

    public function manageFaqs($productId)
    {
        $productId = (int) $productId;
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found');
            return redirect()->to('admin/product');
        }

        $faqModel = model('App\Models\ProductFaqModel');
        $faqs = $faqModel->getByProduct($productId);

        $this->viewData['product'] = $product;
        $this->viewData['faqs'] = $faqs;
        $this->viewData['productId'] = $productId;

        return view($this->viewPath . 'product/faqs', $this->viewData);
    }

    public function addFaq($productId)
    {
        $productId = (int) $productId;
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found');
            return redirect()->to('admin/product');
        }

        if ($this->request->is('post')) {
            $faqModel = model('App\Models\ProductFaqModel');

            $data = [
                'product_id' => $productId,
                'question' => $this->request->getPost('question'),
                'answer' => $this->request->getPost('answer'),
                'sort_order' => (int) $this->request->getPost('sort_order') ?: 0,
                'created_at' => time(),
                'updated_at' => time()
            ];

            if ($faqModel->insert($data)) {
                $this->flash('faq_create_success');
            } else {
                $this->flash('faq_create_error');
            }

            return redirect()->to('admin/product/faqs/' . $productId);
        }

        $this->viewData['product'] = $product;
        $this->viewData['productId'] = $productId;
        $this->viewData['form_action'] = 'admin/product/addFaq/' . $productId;

        return view($this->viewPath . 'product/faq_form', $this->viewData);
    }

    public function editFaq($faqId)
    {
        $faqId = (int) $faqId;
        $faqModel = model('App\Models\ProductFaqModel');
        $faq = $faqModel->find($faqId);

        if (!$faq) {
            $this->flash('faq_not_found');
            return redirect()->to('admin/product');
        }

        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($faq['product_id']);

        if ($this->request->is('post')) {
            $data = [
                'question' => $this->request->getPost('question'),
                'answer' => $this->request->getPost('answer'),
                'sort_order' => (int) $this->request->getPost('sort_order') ?: 0,
                'updated_at' => time()
            ];

            if ($faqModel->update($faqId, $data)) {
                $this->flash('faq_update_success');
            } else {
                $this->flash('faq_update_error');
            }

            return redirect()->to('admin/product/faqs/' . $faq['product_id']);
        }

        $this->viewData['faq'] = $faq;
        $this->viewData['product'] = $product;
        $this->viewData['productId'] = $faq['product_id'];
        $this->viewData['form_action'] = 'admin/product/editFaq/' . $faqId;

        return view($this->viewPath . 'product/faq_form', $this->viewData);
    }

    public function deleteFaq($faqId)
    {
        $faqId = (int) $faqId;
        $faqModel = model('App\Models\ProductFaqModel');
        $faq = $faqModel->find($faqId);

        if (!$faq) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'سوال یافت نشد'
            ]);
        }

        if ($faqModel->delete($faqId)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'سوال با موفقیت حذف شد'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'خطا در حذف سوال'
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