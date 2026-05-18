<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\BookingModel;

class ApiController extends BaseController
{
    // ======================
    // GET /api/services
    // ======================
    public function services()
    {
        $model = new ServiceModel();

        $data = $model->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'total'  => count($data),
            'data'   => $data
        ]);
    }

    // ======================
    // GET /api/booking-status/{id}
    // ======================
    public function bookingStatus($id)
    {
        $model = new BookingModel();

        $booking = $model
            ->select('bookings.*, services.name as service_name')
            ->join('services', 'services.id = bookings.service_id')
            ->where('bookings.id', $id)
            ->first();

        if (!$booking) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Booking tidak ditemukan'
            ]);
        }

        // 🔥 FORMAT STATUS BIAR LEBIH JELAS
        $statusText = match ($booking['laundry_status']) {
            'pending'    => 'Menunggu Pembayaran',
            'confirmed'  => 'Lunas',
            'processing' => 'Sedang Diproses',
            'done'       => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default => $booking['laundry_status'],
        };

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'id'           => $booking['id'],
                'service'      => $booking['service_name'],
                'date'         => $booking['booking_date'],
                'time'         => $booking['booking_time'],
                'weight'       => $booking['weight'],
                'total'        => $booking['total'],
                'status'       => $booking['laundry_status'],
                'status_text'  => $statusText
            ]
        ]);
    }
}