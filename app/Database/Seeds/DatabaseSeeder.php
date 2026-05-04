<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ======================
        // USER SEED
        // ======================
        $this->db->table('users')->insertBatch([
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role' => 'admin',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'User',
                'email' => 'user@mail.com',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role' => 'pelanggan',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}