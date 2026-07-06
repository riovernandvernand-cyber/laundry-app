<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ======================
// DEFAULT
// ======================
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

// ======================
// API RESTFUL SERVER (PROTECTED BY API-AUTH)
// ======================
$routes->group('api', ['filter' => 'api-auth'], function ($routes) {

    $routes->get('services', 'ApiController::services');
    $routes->get('booking-status/(:num)', 'ApiController::bookingStatus/$1');

});

// ======================
// AUTH GUEST
// ======================
$routes->group('', ['filter' => 'guest'], function ($routes) {

    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::attemptLogin');

    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::storeRegister');

});

// ======================
// LOGOUT
// ======================
$routes->get('logout', 'AuthController::logout', ['filter' => 'auth']);

// ======================
// MIDTRANS
// ======================
$routes->post('midtrans/notification', 'MidtransCallback::index');
$routes->get('midtrans/notification', 'MidtransCallback::index');

// ======================
// PAYMENT REDIRECT
// ======================
$routes->get('payment/finish', 'PaymentController::finish');
$routes->get('payment/unfinish', 'PaymentController::unfinish');
$routes->get('payment/error', 'PaymentController::error');

// ======================
// PROTECTED ROUTES
// ======================
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // ======================
    // DASHBOARD
    // ======================
    $routes->get('dashboard', 'Dashboard::index');

    // ======================
    // OPERASIONAL STAFF & ADMIN
    // ======================
    $routes->get('tasks', '\App\Controllers\StaffController::index', ['filter' => 'role:admin,staff']);
    $routes->get('tasks/done/(:num)', '\App\Controllers\BookingController::done/$1', ['filter' => 'role:admin,staff']);

    // ======================
    // SERVICES
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
    // SCHEDULES
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
    // USERS
    // ======================
    $routes->group('users', ['filter' => 'role:admin'], function ($routes) {

        $routes->get('', 'UserController::index');
        $routes->get('toggle/(:num)', 'UserController::toggleStatus/$1');

    });

    // ======================
    // BOOKINGS
    // ======================
    $routes->group('bookings', function ($routes) {

        // --- 1. AJAX ENDPOINTS & STATIC ROUTES (Taruh paling atas) ---
        $routes->get('getCitiesByProvince', 'BookingController::getCitiesByProvince');
        $routes->get('create', 'BookingController::create');
        $routes->post('store', 'BookingController::store');
        $routes->get('', 'BookingController::index');

        // --- 2. MIDTRANS REDIRECT CALLBACKS ---
        $routes->get('finish', 'PaymentController::finish');
        $routes->get('unfinish', 'PaymentController::unfinish');
        $routes->get('error', 'PaymentController::error');

        // --- 3. DYNAMIC ROUTES WITH PARAMETERS (:num) ---
        $routes->get('pay/(:num)', 'BookingController::pay/$1');
        $routes->get('cancel/(:num)', 'BookingController::cancel/$1');
        $routes->get('print/(:num)', 'BookingController::printBooking/$1');

        // --- 4. PROTECTED ROUTES (ADMIN & STAFF FILTER) ---
        // Catatan: Pastikan filter 'role' kamu mendukung penulisan parameter terpisah atau array sesuai konfigurasi App/Filters
        $routes->get('approve/(:num)', 'BookingController::approve/$1', ['filter' => 'role:admin']);
        $routes->get('reject/(:num)', 'BookingController::reject/$1', ['filter' => 'role:admin']);

        $routes->get('process/(:num)', 'BookingController::process/$1', ['filter' => 'role:admin,staff']);
        $routes->get('done/(:num)', 'BookingController::done/$1', ['filter' => 'role:admin,staff']);

    });

});