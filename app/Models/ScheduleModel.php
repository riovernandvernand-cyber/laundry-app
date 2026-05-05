<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table         = 'schedules';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'service_id', 'date', 'time', 'capacity'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ======================
    // VALIDASI
    // ======================
    protected $validationRules = [
        'service_id' => 'required|integer',
        'date'       => 'required|valid_date',
        'time'       => 'required',
        'capacity'   => 'required|integer|greater_than[0]',
    ];

    protected $validationMessages = [
        'date' => [
            'required'   => 'Tanggal harus diisi',
            'valid_date' => 'Format tanggal tidak valid',
        ],
        'capacity' => [
            'greater_than' => 'Kapasitas harus lebih dari 0',
        ],
    ];

    // ======================
    // HELPER METHODS
    // ======================

    /**
     * Ambil jadwal beserta nama layanan
     */
    public function getWithService()
    {
        return $this->select('schedules.*, services.name as service_name')
                    ->join('services', 'services.id = schedules.service_id')
                    ->orderBy('schedules.date', 'ASC')
                    ->orderBy('schedules.time', 'ASC')
                    ->findAll();
    }

    /**
     * Ambil jadwal yang tersedia (belum penuh)
     */
    public function getAvailable()
    {
        $schedules = $this->getWithService();
        $bookingModel = new BookingModel();

        foreach ($schedules as $key => &$schedule) {
            $booked = $bookingModel->where('schedule_id', $schedule['id'])
                                   ->where('status !=', 'cancelled')
                                   ->countAllResults(false);
            $schedule['booked']    = $booked;
            $schedule['available'] = $schedule['capacity'] - $booked;

            // Hapus jadwal yang sudah penuh
            if ($schedule['available'] <= 0) {
                unset($schedules[$key]);
            }
        }

        return array_values($schedules);
    }
}