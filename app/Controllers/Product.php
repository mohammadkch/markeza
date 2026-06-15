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

        // SEO
        $this->viewData['seo'] = [
            'title'       => $product['title'] . ' | مارکزا',
            'description' => mb_substr(strip_tags($product['description'] ?? ''), 0, 160),
            'canonical'   => base_url('product/' . $slug),
        ];

        return view($this->viewPath . 'product/show', $this->viewData);
    }
}