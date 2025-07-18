<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::authenticate');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::store');
$routes->get('/dashboard', 'Auth::dashboard');

// Admin Patient Routes
$routes->group('admin/patients', function($routes) {
    $routes->get('/', 'Patient::index');
    $routes->get('create', 'Patient::create');
    $routes->post('store', 'Patient::store');
    $routes->get('show/(:num)', 'Patient::show/$1');
    $routes->get('edit/(:num)', 'Patient::edit/$1');
    $routes->post('update/(:num)', 'Patient::update/$1');
    $routes->get('delete/(:num)', 'Patient::delete/$1');
    $routes->get('search', 'Patient::search');
});

// Staff Patient Routes (same functionality as admin)
$routes->group('staff/patients', function($routes) {
    $routes->get('/', 'Patient::index');
    $routes->get('create', 'Patient::create');
    $routes->post('store', 'Patient::store');
    $routes->get('show/(:num)', 'Patient::show/$1');
    $routes->get('edit/(:num)', 'Patient::edit/$1');
    $routes->post('update/(:num)', 'Patient::update/$1');
    $routes->get('delete/(:num)', 'Patient::delete/$1');
    $routes->get('search', 'Patient::search');
});
