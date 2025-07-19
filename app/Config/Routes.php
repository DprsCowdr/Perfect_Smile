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

// Admin Appointment Routes
$routes->group('admin/appointments', function($routes) {
    $routes->get('/', 'Appointment::index');
    $routes->get('create', 'Appointment::create');
    $routes->post('store', 'Appointment::store');
    $routes->get('show/(:num)', 'Appointment::show/$1');
    $routes->get('edit/(:num)', 'Appointment::edit/$1');
    $routes->post('update/(:num)', 'Appointment::update/$1');
    $routes->get('delete/(:num)', 'Appointment::delete/$1');
    $routes->post('cancel/(:num)', 'Appointment::cancel/$1');
    $routes->get('search', 'Appointment::search');
    $routes->get('calendar', 'Appointment::calendar');
});

// Staff Appointment Routes (same functionality as admin)
$routes->group('staff/appointments', function($routes) {
    $routes->get('/', 'Appointment::index');
    $routes->get('create', 'Appointment::create');
    $routes->post('store', 'Appointment::store');
    $routes->get('show/(:num)', 'Appointment::show/$1');
    $routes->get('edit/(:num)', 'Appointment::edit/$1');
    $routes->post('update/(:num)', 'Appointment::update/$1');
    $routes->get('delete/(:num)', 'Appointment::delete/$1');
    $routes->post('cancel/(:num)', 'Appointment::cancel/$1');
    $routes->get('search', 'Appointment::search');
    $routes->get('calendar', 'Appointment::calendar');
});

// Doctor Appointment Routes (limited functionality)
$routes->group('doctor/appointments', function($routes) {
    $routes->get('/', 'Appointment::index');
    $routes->get('show/(:num)', 'Appointment::show/$1');
    $routes->get('edit/(:num)', 'Appointment::edit/$1');
    $routes->post('update/(:num)', 'Appointment::update/$1');
    $routes->get('search', 'Appointment::search');
    $routes->get('calendar', 'Appointment::calendar');
});
