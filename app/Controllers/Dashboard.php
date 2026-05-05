<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\ServiceModel;
use App\Models\UserModel;

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
        if ($role === 'admin' || $role === 'staff') {
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
        if ($role === 'admin') {
            $totalIncome = $bookingModel->getTotalIncome();
        }

        // ======================
        // LAYANAN TERPOPULER (ADMIN)
        // ======================
        $popularService = null;
        if ($role === 'admin') {
            $popular = $bookingModel->getPopularService();
            if ($popular) {
                $service = $serviceModel->find($popular['service_id']);
                $popularService = [
                    'name'  => $service['name'] ?? '-',
                    'total' => $popular['total_booking'],
                ];
            }
        }

        // ======================
        // TOTAL USERS (ADMIN)
        // ======================
        $totalUsers = 0;
        if ($role === 'admin') {
            $totalUsers = (new UserModel())->where('role', 'pelanggan')->countAllResults();
        }

        // ======================
        // RECENT BOOKINGS
        // ======================
        $builder = $bookingModel->getWithService($userId, $role);
        $recentBookings = $builder->limit(5)->find();

        return view('dashboard/index', [
            'totalBooking'   => $totalBooking,
            'totalIncome'    => $totalIncome,
            'popularService' => $popularService,
            'totalUsers'     => $totalUsers,
            'recentBookings' => $recentBookings,
            'role'           => $role,
        ]);
    }
}