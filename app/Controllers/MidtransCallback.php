<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BookingModel;

class MidtransCallback extends Controller
{
    public function index()
    {
        // ======================
        // AMBIL JSON
        // ======================
        $json = $this->request->getBody();
        $data = json_decode($json, true);

        log_message('info', 'MIDTRANS CALLBACK: ' . $json);

        if (!$data) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid JSON']);
        }

        // ======================
        // AMBIL DATA
        // ======================
        $order_id = $data['order_id'] ?? null;
        $status   = $data['transaction_status'] ?? null;

        if (!$order_id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'No order_id']);
        }

        // ======================
        // AMBIL BOOKING ID (LEBIH AMAN)
        // ======================
        $booking_id = $this->extractBookingId($order_id);

        if (!$booking_id) {
            log_message('error', 'BOOKING ID TIDAK VALID: ' . $order_id);
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid order_id']);
        }

        // ======================
        // MAPPING STATUS
        // ======================
        $paymentStatus = 'pending';

        switch ($status) {
            case 'capture':
            case 'settlement':
                $paymentStatus = 'confirmed';
                break;

            case 'pending':
                $paymentStatus = 'pending';
                break;

            case 'expire':
            case 'cancel':
            case 'deny':
                $paymentStatus = 'cancelled';
                break;
        }

        // ======================
        // UPDATE DB
        // ======================
        $bookingModel = new BookingModel();

        $updateData = [
            'payment_status' => $paymentStatus
        ];

        // kalau berhasil bayar
        if ($paymentStatus === 'confirmed') {
            $updateData['laundry_status'] = 'pending';
        }

        $bookingModel->update($booking_id, $updateData);

        // ======================
        // LOG DEBUG
        // ======================
        log_message('info', 'BOOKING UPDATED: ID=' . $booking_id . ' STATUS=' . $paymentStatus);

        return $this->response->setJSON([
            'message' => 'OK',
            'booking_id' => $booking_id,
            'status' => $paymentStatus
        ]);
    }

    private function extractBookingId($order_id)
    {
        // ambil angka dari ORDER-9-xxxx
        if (preg_match('/ORDER-(\d+)/', $order_id, $match)) {
            return $match[1];
        }

        return null;
    }
}