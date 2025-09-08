<?php
use CodeIgniter\Router\RouteCollection;

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// Auth Routes
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');
$routes->get('/logout', 'Auth::logout');

// Admin Routes
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');
    
    $routes->get('kas_masuk', 'Admin\KasMasuk::index');
    $routes->get('kas_masuk/create', 'Admin\KasMasuk::create');
    $routes->post('kas_masuk/store', 'Admin\KasMasuk::store');
    $routes->get('kas_masuk/edit/(:num)', 'Admin\KasMasuk::edit/$1');
    $routes->post('kas_masuk/update/(:num)', 'Admin\KasMasuk::update/$1');
    $routes->get('kas_masuk/delete/(:num)', 'Admin\KasMasuk::delete/$1');
    
    $routes->get('pengajuan', 'Admin\Pengajuan::index');
    $routes->get('pengajuan/approve/(:num)', 'Admin\Pengajuan::approve/$1');
    $routes->get('pengajuan/reject/(:num)', 'Admin\Pengajuan::reject/$1');
    $routes->post('pengajuan/process/(:num)', 'Admin\Pengajuan::process/$1');
});

// User Routes
$routes->group('user', ['filter' => 'auth:teknisi,penagih'], function ($routes) {
    $routes->get('dashboard', 'User\Dashboard::index');
    $routes->get('pengajuan', 'User\Pengajuan::index');
    $routes->get('pengajuan/create', 'User\Pengajuan::create');
    $routes->post('pengajuan/store', 'User\Pengajuan::store');
    $routes->get('pengajuan/history', 'User\Pengajuan::history');
});