<?php

namespace App\Controllers;

use App\Models\BlogPostModel;
use App\Models\CollectionModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class Sitemap extends BaseController
{
    private const SITE_URL = 'https://www.markeza.ir';

    public function index(): ResponseInterface
    {
        $urls = [
            ['loc' => self::SITE_URL . '/'],
            ['loc' => self::SITE_URL . '/collection'],
            ['loc' => self::SITE_URL . '/product'],
            ['loc' => self::SITE_URL . '/blog'],
            ['loc' => self::SITE_URL . '/about'],
            ['loc' => self::SITE_URL . '/branches'],
            ['loc' => self::SITE_URL . '/contact'],
        ];

        $collections = (new CollectionModel())
            ->select('slug, updated_at')
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
        foreach ($collections as $collection) {
            $urls[] = $this->dynamicUrl('collection', $collection);
        }

        $products = (new ProductModel())
            ->select('slug, updated_at')
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
        foreach ($products as $product) {
            $urls[] = $this->dynamicUrl('product', $product);
        }

        $posts = (new BlogPostModel())
            ->select('slug, updated_at')
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll();
        foreach ($posts as $post) {
            $urls[] = $this->dynamicUrl('blog', $post);
        }

        return $this->response
            ->setContentType('application/xml', 'UTF-8')
            ->setBody(view('sitemap/index', ['urls' => $urls]));
    }

    private function dynamicUrl(string $section, array $row): array
    {
        $url = [
            'loc' => self::SITE_URL . '/' . $section . '/' . rawurlencode((string) $row['slug']),
        ];

        if (! empty($row['updated_at'])) {
            $url['lastmod'] = gmdate('Y-m-d\TH:i:s\Z', (int) $row['updated_at']);
        }

        return $url;
    }
}
