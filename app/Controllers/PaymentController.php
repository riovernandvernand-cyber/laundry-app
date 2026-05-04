<?php

namespace App\Controllers;

use Midtrans\Config;
use Midtrans\Notification;
use App\Models\BookingModel;

class Payment extends BaseController
{
    public function callback()
    {
        Config::$serverKey = getenv('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;

        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $order_id = $notif->order_id;

        $model = new BookingModel();

        // 🔥 Update status sesuai transaksi
        if ($transaction == 'settlement' || $transaction == 'capture') {
            $model->update($order_id, ['status' => 'paid']);
        } elseif ($transaction == 'pending') {
            $model->update($order_id, ['status' => 'pending']);
        } elseif ($transaction == 'expire' || $transaction == 'cancel') {
            $model->update($order_id, ['status' => 'failed']);
        }

        return response()->setJSON(['status' => 'ok']);
    }
}