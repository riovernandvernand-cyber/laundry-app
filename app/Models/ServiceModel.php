<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table         = 'services';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'name', 'price', 'description', 'duration', 'image'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ======================
    // VALIDASI
    // ======================
    protected $validationRules = [
        'name'  => 'required|min_length[2]|max_length[100]',
        'price' => 'required|integer|greater_than[0]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama layanan harus diisi',
        ],
        'price' => [
            'required'     => 'Harga harus diisi',
            'greater_than' => 'Harga harus lebih dari 0',
        ],
    ];

    // ======================
    // HELPER METHODS
    // ======================

    /**
     * Cari layanan berdasarkan keyword
     */
    public function search(string $keyword)
    {
        return $this->like('name', $keyword)
                    ->orLike('description', $keyword)
                    ->findAll();
    }

    /**
     * Ambil layanan dengan format harga (Rupiah)
     */
    public function getFormatted()
    {
        $services = $this->findAll();
        foreach ($services as &$service) {
            $service['price_formatted'] = 'Rp ' . number_format($service['price'], 0, ',', '.');
        }
        return $services;
    }
}