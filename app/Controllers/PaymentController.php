<?php

namespace App\Controllers;

use Midtrans\Config;
use Midtrans\Notification;
use App\Models\BookingModel;
use App\Models\PaymentModel;

class PaymentController extends BaseController
{
    // ======================
    // CALLBACK MIDTRANS
    // ======================
    public function callback()
    {
        Config::$serverKey = getenv('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;

        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $order_id = $notif->order_id;

        $paymentModel = new PaymentModel();

        // Cari payment berdasarkan order id
        $payment = $paymentModel
            ->where('midtrans_order_id', $order_id)
            ->first();

        if (!$payment) {
            return response()->setJSON([
                'message' => 'Payment tidak ditemukan'
            ]);
        }

        // ======================
        // UPDATE STATUS PAYMENT
        // ======================
        if ($transaction == 'settlement' || $transaction == 'capture') {

            $paymentModel->update($payment['id'], [
                'status' => 'paid',
                'paid_at' => date('Y-m-d H:i:s')
            ]);

            // UPDATE BOOKING
            $bookingModel = new BookingModel();

            $bookingModel->update($payment['booking_id'], [
                'payment_status' => 'paid'
            ]);

        } elseif ($transaction == 'pending') {

            $paymentModel->update($payment['id'], [
                'status' => 'pending'
            ]);

        } elseif ($transaction == 'expire' || $transaction == 'cancel') {

            $paymentModel->update($payment['id'], [
                'status' => 'failed'
            ]);
        }

        return response()->setJSON([
            'status' => 'ok'
        ]);
    }

    // ======================
    // REDIRECT SUCCESS
    // ======================
    public function finish()
    {
        return redirect()->to('/bookings')
            ->with('success', 'Pembayaran berhasil!');
    }

    // ======================
    // REDIRECT BELUM SELESAI
    // ======================
    public function unfinish()
    {
        return redirect()->to('/bookings')
            ->with('warning', 'Pembayaran belum selesai.');
    }

    // ======================
    // REDIRECT ERROR
    // ======================
    public function error()
    {
        return redirect()->to('/bookings')
            ->with('error', 'Pembayaran gagal.');
    }
}