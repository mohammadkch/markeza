<?php

namespace App\Filters;

use \CodeIgniter\Filters\FilterInterface;
use \CodeIgniter\HTTP\RequestInterface;
use \CodeIgniter\HTTP\ResponseInterface;


class UrlFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $titles = [
            'home/index' => 'ماکزا | مبلمان چرم',
            'collection/index' => 'مارکزا | کالکشن‌ها',
            'collection/show'  => 'مارکزا | جزئیات کالکشن',
            'about/index' => 'درباره ما | مارکزا هوم',
        ];

        $url = service('url');
        $router = service('router');

        $controllerName = $router->controllerName();
        $className = str_replace('_', '-', strtolower(basename(str_replace('\\', '/', $controllerName))));
        $methodName = $router->methodName();
        $fullRoute = $className . '/' . $methodName;
        $title = $titles[$fullRoute] ?? 'فروشگاه لباس';

        $url->setControllerName($controllerName);
        $url->setClassName($className);
        $url->setMethodName($methodName);
        $url->setTitle($title);

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}