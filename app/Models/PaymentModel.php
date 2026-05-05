<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table         = 'payments';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'booking_id', 'amount', 'status',
        'midtrans_order_id', 'snap_token',
        'payment_method', 'paid_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ======================
    // VALIDASI
    // ======================
    protected $validationRules = [
        'booking_id' => 'required|integer',
        'amount'     => 'required|integer|greater_than[0]',
    ];

    // ======================
    // HELPER METHODS
    // ======================

    /**
     * Cari payment berdasarkan booking_id
     */
    public function findByBookingId(int $bookingId)
    {
        return $this->where('booking_id', $bookingId)->first();
    }

    /**
     * Cari payment berdasarkan midtrans_order_id
     */
    public function findByOrderId(string $orderId)
    {
        return $this->where('midtrans_order_id', $orderId)->first();
    }
}
