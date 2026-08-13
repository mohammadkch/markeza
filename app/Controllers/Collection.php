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
            'title'       => 'کالکشن‌های مبلمان چرمی لوکس | مارکزا هوم',
            'description' => 'کالکشن‌های مبلمان چرمی لوکس مارکزا هوم را ببینید؛ مجموعه‌هایی دست‌ساز با طراحی ایتالیایی، چرم باکیفیت و مدل‌های متنوع برای فضاهای مسکونی و اداری.',
            'canonical'   => base_url('collection'),
            'og_image'    => ! empty($this->viewData['collections'][0]['thumbnail'])
                ? base_url($this->viewData['collections'][0]['thumbnail'])
                : base_url('assets/images/collection/default-collection.webp'),
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

        $metaTitle = trim((string) ($collection['meta_title'] ?? ''));
        if ($metaTitle === '') {
            $metaTitle = 'کالکشن ' . $collection['title'] . ' | مبلمان چرمی مارکزا هوم';
        }

        $metaDescription = trim((string) ($collection['meta_description'] ?? ''));
        if ($metaDescription === '') {
            $metaDescription = trim((string) ($collection['excerpt'] ?: $collection['subtitle'] ?: strip_tags($collection['description'] ?? '')));
            $metaDescription = mb_substr($metaDescription, 0, 160);
        }

        $ogImage = $collection['thumbnail'] ?? '';
        if ($ogImage === '' && ! empty($this->viewData['images'][0]['image_path'])) {
            $ogImage = $this->viewData['images'][0]['image_path'];
        }

        $this->viewData['seo'] = [
            'title'       => $metaTitle,
            'description' => $metaDescription,
            'canonical'   => base_url('collection/' . $slug),
            'og_image'    => $ogImage !== '' ? base_url($ogImage) : null,
        ];

        return view($this->viewPath . 'collection/show', $this->viewData);
    }
}
