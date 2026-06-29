<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ServiceModel;
use App\Models\BookingModel;

class ApiController extends ResourceController
{
    protected $format = 'json';

    public function services()
    {
        $serviceModel = new ServiceModel();
        $data = $serviceModel->findAll();

        return $this->respond([
            'status' => 200,
            'message' => 'Daftar layanan laundry berhasil diambil.',
            'data' => $data
        ], 200);
    }

    public function bookingStatus($id = null)
    {
        $bookingModel = new BookingModel();
        $booking = $bookingModel->find($id);

        if (!$booking) {
            return $this->failNotFound('Data pemesanan dengan ID ' . $id . ' tidak ditemukan.');
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Status pemesanan berhasil ditemukan.',
            'data' => [
                'id_booking' => $booking['id'],
                'status_order' => $booking['status'] ?? 'pending',
                'total_harga' => $booking['total'] ?? 0,
                'updated_at' => $booking['updated_at'] ?? null
            ]
        ], 200);
    }
}