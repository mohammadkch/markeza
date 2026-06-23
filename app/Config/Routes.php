<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->group('', ['filter' => 'parse_url'], function ($routes) {
    $routes->get('/', 'Home::index');

    $routes->get('collection', 'Collection::index');
    $routes->get('collection/(:segment)', 'Collection::show/$1');

    $routes->get('product', 'Product::index');
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

    // collection and images management
    $routes->get('collection', 'Collection::index');
    $routes->post('collection', 'Collection::index');
    $routes->get('collection/create', 'Collection::create');
    $routes->post('collection/create/handle', 'Collection::create/handle');
    $routes->get('collection/edit/(:num)', 'Collection::edit/$1');
    $routes->post('collection/edit/(:num)/handle', 'Collection::edit/$1/handle');
    $routes->delete('collection/delete/(:num)', 'Collection::delete/$1');
    $routes->post('collection/deleteImage', 'Collection::deleteImage');
    // collection detail management
    $routes->get('collection/details/(:num)', 'Collection::manageDetails/$1');
    $routes->get('collection/addDetail/(:num)', 'Collection::addDetail/$1');
    $routes->post('collection/addDetail/(:num)', 'Collection::addDetail/$1');
    $routes->get('collection/editDetail/(:num)', 'Collection::editDetail/$1');
    $routes->post('collection/editDetail/(:num)', 'Collection::editDetail/$1');
    $routes->delete('collection/deleteDetail/(:num)', 'Collection::deleteDetail/$1');

    // product management
    $routes->get('product', 'Product::index');
    $routes->post('product', 'Product::index');
    $routes->get('product/create', 'Product::create');
    $routes->post('product/create/handle', 'Product::create/handle');
    $routes->get('product/edit/(:num)', 'Product::edit/$1');
    $routes->post('product/edit/(:num)/handle', 'Product::edit/$1/handle');
    $routes->delete('product/delete/(:num)', 'Product::delete/$1');
    // product image management
    $routes->get('product/images/(:num)', 'Product::manageImages/$1');
    $routes->get('product/addImage/(:num)', 'Product::addImage/$1');
    $routes->post('product/addImage/(:num)', 'Product::addImage/$1');
    $routes->get('product/editImage/(:num)', 'Product::editImage/$1');
    $routes->post('product/editImage/(:num)', 'Product::editImage/$1');
    $routes->delete('product/deleteImage/(:num)', 'Product::deleteImage/$1');
    // product material management
    $routes->get('product/materials/(:num)', 'Product::manageMaterials/$1');
    $routes->get('product/addMaterial/(:num)', 'Product::addMaterial/$1');
    $routes->post('product/addMaterial/(:num)', 'Product::addMaterial/$1');
    $routes->get('product/editMaterial/(:num)', 'Product::editMaterial/$1');
    $routes->post('product/editMaterial/(:num)', 'Product::editMaterial/$1');
    $routes->delete('product/deleteMaterial/(:num)', 'Product::deleteMaterial/$1');
    // product faq management
    $routes->get('product/faqs/(:num)', 'Product::manageFaqs/$1');
    $routes->get('product/addFaq/(:num)', 'Product::addFaq/$1');
    $routes->post('product/addFaq/(:num)', 'Product::addFaq/$1');
    $routes->get('product/editFaq/(:num)', 'Product::editFaq/$1');
    $routes->post('product/editFaq/(:num)', 'Product::editFaq/$1');
    $routes->delete('product/deleteFaq/(:num)', 'Product::deleteFaq/$1');

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