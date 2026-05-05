<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ======================
        // 1. USERS (3 Role: Admin, Staff, Pelanggan)
        // ======================
        $this->db->table('users')->insertBatch([
            [
                'name'       => 'Administrator',
                'email'      => 'admin@laundry.com',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'status'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Budi Teknisi',
                'email'      => 'staff@laundry.com',
                'password'   => password_hash('staff123', PASSWORD_DEFAULT),
                'role'       => 'staff',
                'status'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Siti Pelanggan',
                'email'      => 'siti@gmail.com',
                'password'   => password_hash('user123', PASSWORD_DEFAULT),
                'role'       => 'pelanggan',
                'status'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Andi Pelanggan',
                'email'      => 'andi@gmail.com',
                'password'   => password_hash('user123', PASSWORD_DEFAULT),
                'role'       => 'pelanggan',
                'status'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Dewi Nonaktif',
                'email'      => 'dewi@gmail.com',
                'password'   => password_hash('user123', PASSWORD_DEFAULT),
                'role'       => 'pelanggan',
                'status'     => 0, // user nonaktif
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        // ======================
        // 2. SERVICES (Jenis Layanan Laundry)
        // ======================
        $this->db->table('services')->insertBatch([
            [
                'name'        => 'Cuci Biasa',
                'price'       => 7000,
                'description' => 'Cuci bersih menggunakan deterjen premium. Cocok untuk pakaian sehari-hari.',
                'duration'    => 48,
                'image'       => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Setrika',
                'price'       => 5000,
                'description' => 'Setrika rapi dengan uap. Pakaian dijamin licin dan wangi.',
                'duration'    => 24,
                'image'       => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Cuci + Setrika',
                'price'       => 10000,
                'description' => 'Paket lengkap cuci dan setrika. Hemat waktu dan biaya.',
                'duration'    => 72,
                'image'       => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Express (Cuci + Setrika)',
                'price'       => 18000,
                'description' => 'Layanan kilat cuci dan setrika. Selesai dalam 6 jam!',
                'duration'    => 6,
                'image'       => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Cuci Bed Cover',
                'price'       => 25000,
                'description' => 'Khusus pencucian bed cover, selimut, dan sprei. Menggunakan mesin khusus.',
                'duration'    => 72,
                'image'       => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ]);

        // ======================
        // 3. SCHEDULES (Jadwal Tersedia)
        // ======================
        $baseDate = date('Y-m-d'); // hari ini
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $dayAfter = date('Y-m-d', strtotime('+2 days'));

        $this->db->table('schedules')->insertBatch([
            [
                'service_id' => 1,
                'date'       => $baseDate,
                'time'       => '08:00:00',
                'capacity'   => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'service_id' => 1,
                'date'       => $baseDate,
                'time'       => '13:00:00',
                'capacity'   => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'service_id' => 3,
                'date'       => $tomorrow,
                'time'       => '09:00:00',
                'capacity'   => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'service_id' => 4,
                'date'       => $tomorrow,
                'time'       => '10:00:00',
                'capacity'   => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'service_id' => 2,
                'date'       => $dayAfter,
                'time'       => '08:00:00',
                'capacity'   => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'service_id' => 5,
                'date'       => $dayAfter,
                'time'       => '14:00:00',
                'capacity'   => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        // ======================
        // 4. BOOKINGS (Data Booking Realistis)
        // ======================
        $this->db->table('bookings')->insertBatch([
            [
                'user_id'        => 3, // Siti
                'service_id'     => 3, // Cuci + Setrika
                'schedule_id'    => 3,
                'weight'         => 5,
                'total'          => 50000,
                'status'         => 'done',
                'note'           => 'Pisahkan pakaian putih dan berwarna',
                'created_at'     => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at'     => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'user_id'        => 3, // Siti
                'service_id'     => 4, // Express
                'schedule_id'    => 4,
                'weight'         => 3,
                'total'          => 54000,
                'status'         => 'processing',
                'note'           => 'Butuh cepat untuk besok pagi',
                'created_at'     => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'        => 4, // Andi
                'service_id'     => 1, // Cuci Biasa
                'schedule_id'    => 1,
                'weight'         => 8,
                'total'          => 56000,
                'status'         => 'confirmed',
                'note'           => null,
                'created_at'     => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at'     => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'user_id'        => 4, // Andi
                'service_id'     => 5, // Bed Cover
                'schedule_id'    => 6,
                'weight'         => 2,
                'total'          => 50000,
                'status'         => 'pending',
                'note'           => 'Bed cover ukuran king size',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ]);

        // ======================
        // 5. PAYMENTS (Riwayat Pembayaran)
        // ======================
        $this->db->table('payments')->insertBatch([
            [
                'booking_id'       => 1,
                'amount'           => 50000,
                'status'           => 'paid',
                'midtrans_order_id' => 'ORDER-1-' . strtotime('-3 days'),
                'snap_token'       => null,
                'payment_method'   => 'bank_transfer',
                'paid_at'          => date('Y-m-d H:i:s', strtotime('-3 days')),
                'created_at'       => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at'       => date('Y-m-d H:i:s', strtotime('-3 days')),
            ],
            [
                'booking_id'       => 2,
                'amount'           => 54000,
                'status'           => 'paid',
                'midtrans_order_id' => 'ORDER-2-' . strtotime('-1 day'),
                'snap_token'       => null,
                'payment_method'   => 'gopay',
                'paid_at'          => date('Y-m-d H:i:s', strtotime('-1 day')),
                'created_at'       => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at'       => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'booking_id'       => 3,
                'amount'           => 56000,
                'status'           => 'paid',
                'midtrans_order_id' => 'ORDER-3-' . strtotime('-2 days'),
                'snap_token'       => null,
                'payment_method'   => 'qris',
                'paid_at'          => date('Y-m-d H:i:s', strtotime('-2 days')),
                'created_at'       => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at'       => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
        ]);
    }
}