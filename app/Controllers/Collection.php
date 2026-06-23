<?php

namespace App\Controllers;

use App\Models\CollectionModel;
use App\Models\CollectionImageModel;
use App\Models\CollectionDetailModel;
use App\Models\ProductModel;

class Collection extends BaseController
{
    protected $collectionModel;
    protected $imageModel;
    protected $detailModel;
    protected $productModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->collectionModel = new CollectionModel();
        $this->imageModel      = new CollectionImageModel();
        $this->detailModel     = new CollectionDetailModel();
        $this->productModel    = new ProductModel();
    }

    public function index(): string
    {
        $this->viewData['collections'] = $this->collectionModel->getAllActive();


        $this->viewData['seo'] = [
            'title'       => 'کالکشن‌ها | مارکزا',
            'description' => 'مجموعه کالکشن‌های مبلمان چرم لوکس مارکزا',
            'canonical'   => base_url('collection'),
        ];

        return view($this->viewPath . 'collection/index', $this->viewData);
    }

    public function show(string $slug): string
    {
        $collection = $this->collectionModel->getBySlug($slug);

        if (!$collection) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->viewData['collection'] = $collection;
        $this->viewData['images']     = $this->imageModel->getByCollection($collection['id']);
        $this->viewData['details']    = $this->detailModel->getByCollection($collection['id']);
        $this->viewData['products']   = $this->productModel->getByCollection($collection['id']);

        $this->viewData['seo'] = [
            'title'       => $collection['meta_title'] ?? $collection['title'] . ' | مارکزا',
            'description' => $collection['meta_description'] ?? $collection['subtitle'] ?? '',
            'canonical'   => base_url('collection/' . $slug),
        ];

        return view($this->viewPath . 'collection/show', $this->viewData);
    }
}