<?php

namespace App\Controllers;

use App\Models\BlogPostModel;
use App\Models\CollectionModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class Sitemap extends BaseController
{
    public function index(): ResponseInterface
    {
        $urls = [
            ['loc' => base_url('/')],
            ['loc' => base_url('collection')],
            ['loc' => base_url('product')],
            ['loc' => base_url('blog')],
            ['loc' => base_url('about')],
            ['loc' => base_url('branches')],
            ['loc' => base_url('contact')],
        ];

        $collections = (new CollectionModel())
            ->select('slug, updated_at')
            ->where('is_active', 1)
            ->where("TRIM(slug) <> ''", null, false)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
        foreach ($collections as $collection) {
            $urls[] = $this->dynamicUrl('collection', $collection);
        }

        $products = (new ProductModel())
            ->select('product.slug, product.updated_at')
            ->join('collection', 'collection.id = product.collection_id')
            ->where('product.is_active', 1)
            ->where('collection.is_active', 1)
            ->where("TRIM(product.slug) <> ''", null, false)
            ->orderBy('product.sort_order', 'ASC')
            ->findAll();
        foreach ($products as $product) {
            $urls[] = $this->dynamicUrl('product', $product);
        }

        $posts = (new BlogPostModel())
            ->select('slug, updated_at')
            ->where('is_active', 1)
            ->where("TRIM(slug) <> ''", null, false)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll();
        foreach ($posts as $post) {
            $urls[] = $this->dynamicUrl('blog', $post);
        }

        return $this->response
            ->setContentType('application/xml', 'UTF-8')
            ->setBody(view('sitemap/index', ['urls' => $urls], ['debug' => false]));
    }

    private function dynamicUrl(string $section, array $row): array
    {
        $url = [
            'loc' => base_url($section . '/' . rawurlencode((string) $row['slug'])),
        ];

        if (filter_var($row['updated_at'] ?? null, FILTER_VALIDATE_INT) !== false && (int) $row['updated_at'] > 0) {
            $url['lastmod'] = gmdate('Y-m-d\TH:i:s\Z', (int) $row['updated_at']);
        }

        return $url;
    }
}
