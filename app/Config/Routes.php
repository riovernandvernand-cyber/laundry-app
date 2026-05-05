<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ======================
// DEFAULT (PUBLIC)
// ======================
$routes->get('/', 'Home::index');


// ======================
// API ENDPOINTS (PUBLIC - tanpa login)
// ======================
$routes->group('api', function ($routes) {
    $routes->get('services', 'ApiController::services');
    $routes->get('booking-status/(:num)', 'ApiController::bookingStatus/$1');
});


// ======================
// AUTH (GUEST ONLY - user yg sudah login akan di-redirect)
// ======================
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::storeRegister');
});

// Logout tetap butuh login
$routes->get('logout', 'AuthController::logout', ['filter' => 'auth']);


// ======================
// MIDTRANS WEBHOOK (PUBLIC - dipanggil dari server Midtrans)
// ======================
$routes->post('midtrans/notification', 'MidtransCallback::index');
$routes->get('midtrans/notification', 'MidtransCallback::index');


// ======================
// PROTECTED ROUTES (HARUS LOGIN)
// ======================
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // ======================
    // DASHBOARD (SEMUA ROLE)
    // ======================
    $routes->get('dashboard', 'Dashboard::index');


    // ======================
    // SERVICES - CRUD (ADMIN ONLY)
    // ======================
    $routes->group('services', ['filter' => 'role:admin'], function ($routes) {
        $routes->get('', 'ServiceController::index');
        $routes->get('create', 'ServiceController::create');
        $routes->post('store', 'ServiceController::store');
        $routes->get('edit/(:num)', 'ServiceController::edit/$1');
        $routes->post('update/(:num)', 'ServiceController::update/$1');
        $routes->get('delete/(:num)', 'ServiceController::delete/$1');
    });


    // ======================
    // SCHEDULES - CRUD (ADMIN ONLY)
    // ======================
    $routes->group('schedules', ['filter' => 'role:admin'], function ($routes) {
        $routes->get('', 'ScheduleController::index');
        $routes->get('create', 'ScheduleController::create');
        $routes->post('store', 'ScheduleController::store');
        $routes->get('edit/(:num)', 'ScheduleController::edit/$1');
        $routes->post('update/(:num)', 'ScheduleController::update/$1');
        $routes->get('delete/(:num)', 'ScheduleController::delete/$1');
    });


    // ======================
    // USERS MANAGEMENT (ADMIN ONLY)
    // ======================
    $routes->group('users', ['filter' => 'role:admin'], function ($routes) {
        $routes->get('', 'UserController::index');
        $routes->get('toggle/(:num)', 'UserController::toggleStatus/$1');
    });


    // ======================
    // BOOKINGS (SEMUA ROLE - filter per aksi)
    // ======================
    $routes->group('bookings', function ($routes) {

        // List & Detail (semua role)
        $routes->get('', 'BookingController::index');
        $routes->get('finish', 'BookingController::finish');

        // Create booking (pelanggan)
        $routes->get('create', 'BookingController::create');
        $routes->post('store', 'BookingController::store');

        // Cancel booking (pelanggan - hanya booking sendiri)
        $routes->get('cancel/(:num)', 'BookingController::cancel/$1');

        // Payment (pelanggan)
        $routes->get('pay/(:num)', 'BookingController::pay/$1');

        // Print bukti (semua role)
        $routes->get('print/(:num)', 'BookingController::printBooking/$1');

        // Admin actions
        $routes->get('approve/(:num)', 'BookingController::approve/$1', ['filter' => 'role:admin']);
        $routes->get('reject/(:num)', 'BookingController::reject/$1', ['filter' => 'role:admin']);

        // Admin & Staff actions
        $routes->get('process/(:num)', 'BookingController::process/$1', ['filter' => 'role:admin,staff']);
        $routes->get('done/(:num)', 'BookingController::done/$1', ['filter' => 'role:admin,staff']);
    });

});