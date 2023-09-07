<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Public\Index::index');
$routes->get('knowledge/(:num)', 'Public\index::knowledge/$1');

//autentikasi
$routes->post('auth/login', 'Auth\Auth::login');
$routes->post('auth/register', 'Auth\Auth::register');
$routes->get('logout', 'Auth\Auth::logout');

//admin
$routes->group('admin', ['filter' => 'roleFilter'], function ($routes) {
    $routes->get('dashboard', 'Admin\Index::index');

    //akun
    $routes->get('account', 'Admin\Account::read');
    $routes->get('account/update/(:num)', 'Admin\Account::update/$1');
    $routes->post('account/update_action', 'Admin\Account::update_action');
    $routes->get('account/delete/(:num)', 'Admin\Account::delete/$1');

    //kategori
    $routes->get('kategori', 'Admin\Kategori::read');
    $routes->get('kategori/create', 'Admin\Kategori::create');
    $routes->post('kategori/create', 'Admin\Kategori::create');
    $routes->get('kategori/delete/(:num)', 'Admin\kategori::delete/$1');
    $routes->get('kategori/update/(:num)', 'Admin\kategori::update/$1');
    $routes->post('kategori/update_action', 'Admin\kategori::update_action');

    //sub kategori
    $routes->get('sub_kategori', 'Admin\Sub_kategori::read');
    $routes->get('sub_kategori/create', 'Admin\Sub_kategori::create');
    $routes->post('sub_kategori/create', 'Admin\Sub_kategori::create');
    $routes->get('sub_kategori/delete/(:num)', 'Admin\Sub_kategori::delete/$1');
    $routes->get('sub_kategori/update/(:num)', 'Admin\Sub_kategori::update/$1');
    $routes->post('sub_kategori/update_action', 'Admin\Sub_kategori::update_action');

    $routes->get('knowledge/(:num)', 'Admin\index::knowledge/$1');
});


$routes->group('uploader', ['filter' => 'roleFilter'], function ($routes) {
    $routes->get('dashboard', 'Uploader\Index::index');
    $routes->get('upload', 'Uploader\Berkas::upload');
    $routes->post('upload', 'Uploader\Berkas::upload');
    $routes->get('knowledge/(:num)', 'Uploader\index::knowledge/$1');
    $routes->get('materi', 'Uploader\Berkas::read');
    $routes->get('materi/delete/(:num)', 'Uploader\Berkas::delete/$1');
    $routes->get('materi/update/(:num)', 'Uploader\Berkas::update/$1');
    $routes->post('materi/update_action', 'Uploader\Berkas::update_action');

    $routes->get('materi', 'Uploader\Index::materi');

    
});




/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
