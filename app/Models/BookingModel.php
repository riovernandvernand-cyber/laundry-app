<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'user_id',
        'service_id',
        'schedule_id',
        'weight',
        'total',
        'payment_status',
        'status',
        'booking_date',
        'booking_time',
        'note',
        'order_id',
        'rating',
        'review'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // ======================
    // VALIDASI
    // ======================
    protected $validationRules = [
        'user_id' => 'required|integer',
        'service_id' => 'required|integer',
        'weight' => 'required|integer|greater_than[0]',
        'total' => 'required|integer|greater_than[0]',
    ];

    protected $validationMessages = [
        'weight' => [
            'greater_than' => 'Berat harus lebih dari 0 kg',
        ],
        'total' => [
            'greater_than' => 'Total harga tidak valid',
        ],
    ];

    // ======================
    // HELPER METHODS
    // ======================

    /**
     * Ambil booking dengan join ke services
     */
    public function getWithService($userId = null, $role = 'pelanggan')
    {
        $builder = $this->select('
        bookings.id,
        bookings.user_id,
        bookings.service_id,
        bookings.schedule_id,
        bookings.weight,
        bookings.total,
        bookings.status AS laundry_status,
        bookings.note,
        bookings.created_at,
        bookings.updated_at,
        services.name AS service_name,
        users.name AS user_name
    ')
            ->join('services', 'services.id = bookings.service_id', 'left')
            ->join('users', 'users.id = bookings.user_id', 'left');

        if ($role === 'pelanggan') {
            $this->where('bookings.user_id', $userId);
        }

        return $builder->orderBy('bookings.id', 'DESC');
    }

    /**
     * Hitung total pendapatan (booking yang sudah dibayar)
     */
    public function getTotalIncome()
    {
        $paymentModel = new PaymentModel();
        $result = $paymentModel->where('status', 'paid')
            ->selectSum('amount')
            ->first();
        return $result['amount'] ?? 0;
    }

    /**
     * Ambil layanan terpopuler
     */
    public function getPopularService()
    {
        return $this->select('service_id, COUNT(*) as total_booking')
            ->groupBy('service_id')
            ->orderBy('total_booking', 'DESC')
            ->first();
    }

    /**
     * Cek apakah booking milik user tertentu
     */
    public function isOwnedBy(int $bookingId, int $userId): bool
    {
        $booking = $this->find($bookingId);
        return $booking && (int) $booking['user_id'] === $userId;
    }
}