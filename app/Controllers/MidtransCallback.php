<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BookingModel;
use App\Models\PaymentModel;

class MidtransCallback extends Controller
{
    public function index()
    {
        try {

            // ======================
            // AMBIL JSON
            // ======================
            $json = $this->request->getBody();
            $data = json_decode($json, true);

            log_message('info', 'MIDTRANS CALLBACK: ' . $json);

            if (!$data) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['error' => 'Invalid JSON']);
            }

            // ======================
            // DATA
            // ======================
            $order_id = $data['order_id'] ?? null;
            $status = $data['transaction_status'] ?? null;

            if (!$order_id) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['error' => 'Order ID kosong']);
            }

            // ======================
            // AMBIL BOOKING ID
            // ======================
            preg_match('/LAUNDRY-(\d+)-/', $order_id, $match);

            if (!isset($match[1])) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['error' => 'Format order salah']);
            }

            $booking_id = $match[1];

            // ======================
            // MODEL
            // ======================
            $paymentModel = new PaymentModel();
            $bookingModel = new BookingModel();

            // ======================
            // CARI PAYMENT
            // ======================
            $payment = $paymentModel
                ->where('booking_id', $booking_id)
                ->first();

            if (!$payment) {
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON(['error' => 'Payment tidak ditemukan']);
            }

            // ======================
            // STATUS
            // ======================
            $paymentStatus = 'pending';

            if ($status == 'capture' || $status == 'settlement') {
                $paymentStatus = 'paid';
            } elseif ($status == 'expire' || $status == 'cancel' || $status == 'deny') {
                $paymentStatus = 'failed';
            }

            // ======================
            // UPDATE PAYMENT
            // ======================
            $paymentModel->update($payment['id'], [
                'status' => $paymentStatus
            ]);

            // ======================
            // UPDATE BOOKING
            // ======================
            if ($paymentStatus == 'paid') {

                $bookingModel->update($booking_id, [
                    'payment_status' => 'paid'
                ]);
            }

            return $this->response->setJSON([
                'success' => true
            ]);

        } catch (\Throwable $e) {

            log_message('error', $e->getMessage());

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'error' => $e->getMessage()
                ]);
        }
    }
}