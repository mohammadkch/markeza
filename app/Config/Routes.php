<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->group('', ['filter' => 'parse_url'], function ($routes) {
    $routes->get('/', 'Home::index');

    $routes->get('collection', 'Collection::index');
    $routes->get('collection/(:segment)', 'Collection::show/$1');

    $routes->get('product/(:segment)', 'Product::show/$1');

    $routes->get('about', 'About::index');

});



// --------------------
// markeza admin routes
// --------------------
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'admin_auth'], function($routes) {
    $routes->get('/', 'Dashboard::index');

    $routes->get('login', 'Login::index');
    $routes->post('login/authenticate', 'Login::authenticate');

    $routes->get('logout', 'Logout::index');
    $routes->post('logout', 'Logout::index');

    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('test', 'Test::index');

    // collection management
    $routes->get('collection', 'Collection::index');
    $routes->post('collection', 'Collection::index');
    $routes->get('collection/create', 'Collection::create');
    $routes->post('collection/create/handle', 'Collection::create/handle');
    $routes->get('collection/edit/(:num)', 'Collection::edit/$1');
    $routes->post('collection/edit/(:num)/handle', 'Collection::edit/$1/handle');
    $routes->delete('collection/delete/(:num)', 'Collection::delete/$1');
    $routes->post('collection/deleteImage', 'Collection::deleteImage');

    // menu_1
    $routes->get('menu1', 'Menu1::index');
    $routes->post('menu1', 'Menu1::index');
    $routes->get('menu1/create', 'Menu1::create');
    $routes->post('menu1/create/handle', 'Menu1::create/handle');
    $routes->get('menu1/edit/(:num)', 'Menu1::edit/$1');
    $routes->post('menu1/edit/(:num)/handle', 'Menu1::edit/$1/handle');
    $routes->delete('menu1/delete/(:num)', 'Menu1::delete/$1');
    $routes->post('menu1/toggleActive/(:num)', 'Menu1::toggleActive/$1');
});