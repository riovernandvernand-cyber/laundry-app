<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table = 'schedules';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'service_id',
        'date',
        'time',
        'capacity'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
}