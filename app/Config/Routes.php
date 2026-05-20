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
// API PUBLIC
// ======================
$routes->group('api', function ($routes) {

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

    // LIST
    $routes->get('', 'BookingController::index');

    // MIDTRANS REDIRECT
    $routes->get('finish', 'PaymentController::finish');
    $routes->get('unfinish', 'PaymentController::unfinish');
    $routes->get('error', 'PaymentController::error');

    // CREATE
    $routes->get('create', 'BookingController::create');
    $routes->post('store', 'BookingController::store');

    // PAYMENT
    $routes->get('pay/(:num)', 'BookingController::pay/$1');

    // CANCEL
    $routes->get('cancel/(:num)', 'BookingController::cancel/$1');

    // PRINT
    $routes->get('print/(:num)', 'BookingController::printBooking/$1');

    // APPROVE / REJECT
    $routes->get('approve/(:num)', 'BookingController::approve/$1', ['filter' => 'role:admin']);
    $routes->get('reject/(:num)', 'BookingController::reject/$1', ['filter' => 'role:admin']);

    // PROCESS
    $routes->get('process/(:num)', 'BookingController::process/$1', ['filter' => 'role:admin,staff']);

    // DONE
    $routes->get('done/(:num)', 'BookingController::done/$1', ['filter' => 'role:admin,staff']);

    });

});

