<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'name', 'email', 'password', 'role', 'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ======================
    // VALIDASI
    // ======================
    protected $validationRules = [
        'name'     => 'required|min_length[2]|max_length[100]',
        'email'    => 'required|valid_email|max_length[100]',
        'password' => 'required|min_length[6]',
        'role'     => 'required|in_list[admin,staff,pelanggan]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama harus diisi',
            'min_length' => 'Nama minimal 2 karakter',
        ],
        'email' => [
            'required'    => 'Email harus diisi',
            'valid_email' => 'Format email tidak valid',
        ],
        'password' => [
            'required'   => 'Password harus diisi',
            'min_length' => 'Password minimal 6 karakter',
        ],
    ];

    // ======================
    // HELPER METHODS
    // ======================

    /**
     * Cari user berdasarkan email
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Ambil semua user aktif
     */
    public function getActiveUsers()
    {
        return $this->where('status', 1)->findAll();
    }

    /**
     * Ambil user berdasarkan role
     */
    public function getByRole(string $role)
    {
        return $this->where('role', $role)->where('status', 1)->findAll();
    }
}