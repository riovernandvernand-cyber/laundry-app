<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\ServiceModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $bookingModel = new BookingModel();
        $serviceModel = new ServiceModel();

        $role   = session()->get('role');
        $userId = session()->get('user_id');

        // ======================
        // TOTAL BOOKING
        // ======================
        if ($role == 'admin') {
            $totalBooking = $bookingModel->countAll();
        } else {
            $totalBooking = $bookingModel
                ->where('user_id', $userId)
                ->countAllResults();
        }

        // ======================
        // TOTAL INCOME (ADMIN ONLY)
        // ======================
        $totalIncome = 0;
        if ($role == 'admin') {
            $totalIncome = $bookingModel
                ->where('payment_status', 'confirmed')
                ->selectSum('total')
                ->first()['total'] ?? 0;
        }

        // ======================
        // LAYANAN TERPOPULER
        // ======================
        $popularService = null;

        if ($role == 'admin') {
            $popularService = $bookingModel
                ->select('service_id, COUNT(*) as total')
                ->groupBy('service_id')
                ->orderBy('total', 'DESC')
                ->first();

            if ($popularService) {
                $service = $serviceModel->find($popularService['service_id']);
                $popularService['name'] = $service['name'] ?? '-';
            }
        }

        // ======================
        // RECENT BOOKINGS (🔥 FIX DI SINI)
        // ======================
        if ($role == 'admin') {
            $recentBookings = $bookingModel
                ->select('bookings.*, 
                          bookings.booking_date as date,
                          bookings.booking_time as time,
                          services.name as service_name')
                ->join('services', 'services.id = bookings.service_id')
                ->orderBy('bookings.id', 'DESC')
                ->limit(5)
                ->find();
        } else {
            $recentBookings = $bookingModel
                ->select('bookings.*, 
                          bookings.booking_date as date,
                          bookings.booking_time as time,
                          services.name as service_name')
                ->join('services', 'services.id = bookings.service_id')
                ->where('bookings.user_id', $userId)
                ->orderBy('bookings.id', 'DESC')
                ->limit(5)
                ->find();
        }

        return view('dashboard/index', [
            'totalBooking'   => $totalBooking,
            'totalIncome'    => $totalIncome,
            'popularService' => $popularService,
            'recentBookings' => $recentBookings,
            'role'           => $role
        ]);
    }
}