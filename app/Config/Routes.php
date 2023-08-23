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
$routes->get('/', 'Home::index');


//routes untuk Admin
$routes->get('/admin/', 'Admin::index');
$routes->get('/admin/login-admin', 'Admin::index');
$routes->post('/admin/cek-login-admin', 'Admin::cek_login_admin');
$routes->get('/admin/dashboard-admin', 'Admin::dashboard_admin');
$routes->get('/admin/logout', 'Admin::logout');

//routes Kategori
$routes->get('/admin/master-kategori', 'Admin::master_kategori');
$routes->get('/admin/input-kategori', 'Admin::input_kategori');
$routes->post('/admin/simpan-kategori', 'Admin::simpan_kategori');
$routes->get('/admin/edit-kategori/(:alphanum)', 'Admin::edit_kategori/$1');
$routes->post('/admin/update-kategori', 'Admin::update_kategori');
$routes->get('/admin/hapus-kategori/(:alphanum)', 'Admin::hapus_kategori/$1');

//routes Rak
$routes->get('/admin/master-rak', 'Admin::master_rak');
$routes->get('/admin/input-rak', 'Admin::input_rak');
$routes->post('/admin/simpan-rak', 'Admin::simpan_rak');
$routes->get('/admin/edit-rak/(:alphanum)', 'Admin::edit_rak/$1');
$routes->post('/admin/update-rak', 'Admin::update_rak');
$routes->get('/admin/hapus-rak/(:alphanum)', 'Admin::hapus_rak/$1');

//routes Admin
$routes->get('/admin/master-admin', 'Admin::master_admin');
$routes->get('/admin/input-admin', 'Admin::input_admin');
$routes->post('/admin/simpan-admin', 'Admin::simpan_admin');
$routes->get('/admin/edit-admin/(:alphanum)', 'Admin::edit_admin/$1');
$routes->post('/admin/update-admin', 'Admin::update_admin');
$routes->get('/admin/hapus-admin/(:alphanum)', 'Admin::hapus_admin/$1');

//routes anggota
$routes->get('/admin/master-anggota', 'Admin::master_anggota');
$routes->get('/admin/input-anggota', 'Admin::input_anggota');
$routes->post('/admin/simpan-anggota', 'Admin::simpan_anggota');
$routes->get('/admin/edit-anggota/(:alphanum)', 'Admin::edit_anggota/$1');
$routes->post('/admin/update-anggota', 'Admin::update_anggota');
$routes->get('/admin/hapus-anggota/(:alphanum)', 'Admin::hapus_anggota/$1');

//Routes Buku
$routes->get('/admin/master-buku', 'Admin::master_buku');
$routes->get('/admin/input-buku', 'Admin::input_buku');
$routes->post('/admin/simpan-buku', 'Admin::simpan_buku');
$routes->get('/admin/edit-buku/(:alphanum)', 'Admin::edit_buku/$1');
$routes->post('/admin/update-buku', 'Admin::update_buku');
$routes->get('/admin/hapus-buku/(:alphanum)', 'Admin::hapus_buku/$1');


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
