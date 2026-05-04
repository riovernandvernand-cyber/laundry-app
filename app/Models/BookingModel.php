<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table      = 'bookings';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
    'user_id',
    'service_id',
    'schedule_id',
    'weight',
    'total',
    'status',
    'payment_status',
    'laundry_status',
    'booking_date',
    'booking_time',
    'note'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'user_id'     => 'required|integer',
        'service_id'  => 'required|integer',
        'schedule_id' => 'required|integer',
        'weight'      => 'required|greater_than[0]',
        'total'       => 'required|greater_than[0]'
    ];

    protected $validationMessages = [
        'weight' => [
            'greater_than' => 'Berat harus lebih dari 0'
        ],
        'total' => [
            'greater_than' => 'Total tidak valid'
        ]
    ];
}