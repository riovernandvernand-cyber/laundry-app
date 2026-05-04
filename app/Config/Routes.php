<?php 

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ======================
// DEFAULT
// ======================
$routes->get('/', 'Home::index');


// ======================
// API (WAJIB DOSEN)
// ======================
$routes->group('api', function($routes) {
    $routes->get('services', 'ApiController::services');
    $routes->get('booking-status/(:num)', 'ApiController::bookingStatus/$1');
});


// ======================
// AUTH
// ======================
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');

$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::storeRegister');

$routes->get('logout', 'AuthController::logout');


// ======================
// MIDTRANS (PUBLIC)
// ======================
$routes->post('midtrans/notification', 'MidtransCallback::index');
$routes->get('midtrans/notification', 'MidtransCallback::index');

// 🔥 FINISH (HARUS SAMA DENGAN CONTROLLER)
$routes->get('bookings/finish', 'BookingController::finish');


// ======================
// PROTECTED (LOGIN)
// ======================
$routes->group('', ['filter' => 'auth'], function($routes) {

    // ======================
    // DASHBOARD
    // ======================
    $routes->get('dashboard', 'Dashboard::index');


    // ======================
    // SERVICES (ADMIN)
    // ======================
    $routes->group('services', ['filter' => 'role:admin'], function($routes) {
        $routes->get('', 'ServiceController::index');
        $routes->get('create', 'ServiceController::create');
        $routes->post('store', 'ServiceController::store');
        $routes->get('edit/(:num)', 'ServiceController::edit/$1');
        $routes->post('update/(:num)', 'ServiceController::update/$1');
        $routes->get('delete/(:num)', 'ServiceController::delete/$1');
    });


    // ======================
    // SCHEDULES (ADMIN)
    // ======================
    $routes->group('schedules', ['filter' => 'role:admin'], function($routes) {
        $routes->get('', 'ScheduleController::index');
        $routes->get('create', 'ScheduleController::create');
        $routes->post('store', 'ScheduleController::store');
        $routes->get('edit/(:num)', 'ScheduleController::edit/$1');
        $routes->post('update/(:num)', 'ScheduleController::update/$1');
        $routes->get('delete/(:num)', 'ScheduleController::delete/$1');
    });


    // ======================
    // BOOKINGS
    // ======================
    $routes->group('bookings', function($routes) {

        // LIST
        $routes->get('', 'BookingController::index');

        // CREATE
        $routes->get('create', 'BookingController::create');
        $routes->post('store', 'BookingController::store');

        // PAYMENT
        $routes->get('pay/(:num)', 'BookingController::pay/$1');

        // ======================
        // ADMIN ACTION (SOAL DOSEN)
        // ======================
        $routes->get('approve/(:num)', 'BookingController::approve/$1', ['filter' => 'role:admin']);
        $routes->get('reject/(:num)', 'BookingController::reject/$1', ['filter' => 'role:admin']);

        // ======================
        // PROCESS & DONE
        // ======================
        $routes->get('process/(:num)', 'BookingController::process/$1', ['filter' => 'role:admin,staff']);
        $routes->get('done/(:num)', 'BookingController::done/$1', ['filter' => 'role:admin,staff']);

        // PRINT
        $routes->get('print/(:num)', 'BookingController::printBooking/$1');
    });

});