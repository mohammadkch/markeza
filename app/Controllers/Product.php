<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\ProductMaterialModel;
use App\Models\ProductFaqModel;

class Product extends BaseController
{
    protected $productModel;
    protected $productImageModel;
    protected $productMaterialModel;
    protected $productFaqModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->productModel = new ProductModel();
        $this->productImageModel = new ProductImageModel();
        $this->productMaterialModel = new ProductMaterialModel();
        $this->productFaqModel = new ProductFaqModel();
    }

    public function index(): string
    {
        $collectionModel = model('App\Models\CollectionModel');
        $productModel = model('App\Models\ProductModel');

        $collections = $collectionModel->getAllActive();

        foreach ($collections as &$collection) {
            $collection['products'] = $productModel->getByCollection($collection['id']);
        }

        $this->viewData['collections'] = $collections;
        $productListOgImage = null;
        foreach ($collections as $collection) {
            if (! empty($collection['products'][0]['thumbnail'])) {
                $productListOgImage = base_url($collection['products'][0]['thumbnail']);
                break;
            }
        }

        $this->viewData['seo'] = [
            'title'       => 'مبلمان چرمی لوکس | محصولات مارکزا هوم',
            'description' => 'مجموعه محصولات مارکزا هوم؛ مبلمان چرمی لوکس و دست‌ساز با طراحی ماندگار، متریال باکیفیت و جزئیات دقیق برای فضاهای مسکونی و اداری.',
            'canonical'   => base_url('product'),
            'og_image'    => $productListOgImage,
        ];

        return view($this->viewPath . 'product/index', $this->viewData);
    }


    /**
     * Show product detail page
     */
    public function show(string $slug): string
    {
        $product = $this->productModel->getBySlug($slug);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get related data
        $images = $this->productImageModel->getByProduct($product['id']);
        $materials = $this->productMaterialModel->getByProduct($product['id']);
        $faqs = $this->productFaqModel->getByProduct($product['id']);
        $relatedProducts = $this->productModel->getRelatedProducts($product['collection_id'], $product['id']);
        $collection = model('App\Models\CollectionModel')->find($product['collection_id']);

        // Move thumbnail image to first position in gallery
        if (!empty($product['thumbnail']) && !empty($images)) {
            $thumbnailIndex = null;
            foreach ($images as $index => $img) {
                if ($img['image_path'] === $product['thumbnail']) {
                    $thumbnailIndex = $index;
                    break;
                }
            }

            if ($thumbnailIndex !== null && $thumbnailIndex > 0) {
                $thumbnailImage = $images[$thumbnailIndex];
                unset($images[$thumbnailIndex]);
                array_unshift($images, $thumbnailImage);
                $images = array_values($images);
            }
        }

        // Pass data to view
        $this->viewData['product'] = $product;
        $this->viewData['images'] = $images;
        $this->viewData['materials'] = $materials;
        $this->viewData['faqs'] = $faqs;
        $this->viewData['relatedProducts'] = $relatedProducts;
        $this->viewData['collection'] = $collection;

        // SEO
        $metaTitle = trim((string) ($product['meta_title'] ?? ''));
        if ($metaTitle === '') {
            $metaTitle = $product['title'] . ' | مبلمان چرمی مارکزا هوم';
        }
        $metaDescription = trim((string) ($product['meta_description'] ?? ''));
        if ($metaDescription === '') {
            $metaDescription = mb_substr(trim(strip_tags((string) ($product['description'] ?? ''))), 0, 160);
        }
        $this->viewData['seo'] = [
            'title'       => $metaTitle,
            'description' => $metaDescription,
            'canonical'   => base_url('product/' . $slug),
            'og_type'     => 'product',
            'og_image'    => ! empty($product['thumbnail']) ? base_url($product['thumbnail']) : null,
        ];

        return view($this->viewPath . 'product/show', $this->viewData);
    }
}
