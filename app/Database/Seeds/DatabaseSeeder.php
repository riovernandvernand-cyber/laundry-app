<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // 1. DATA SEEDER: USERS
        // ==========================================
        $this->db->table('users')->insertBatch([
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Budi Teknisi',
                'email' => 'staff@gmail.com',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'staff',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Siti Pelanggan',
                'email' => 'siti@gmail.com',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'pelanggan',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Andi Pelanggan',
                'email' => 'andi@gmail.com',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'pelanggan',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Dewi Nonaktif',
                'email' => 'dewi@gmail.com',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'pelanggan',
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        // ==========================================
        // 2. DATA SEEDER: SERVICES
        // ==========================================
        $this->db->table('services')->insertBatch([
            [
                'name' => 'Cuci Biasa',
                'price' => 7000,
                'description' => 'Cuci bersih menggunakan deterjen premium. Cocok untuk pakaian sehari-hari.',
                'duration' => 48,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Setrika',
                'price' => 5000,
                'description' => 'Setrika rapi dengan uap. Pakaian dijamin licin dan wangi.',
                'duration' => 24,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cuci + Setrika',
                'price' => 10000,
                'description' => 'Paket lengkap cuci dan setrika. Hemat waktu dan biaya.',
                'duration' => 72,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Express (Cuci + Setrika)',
                'price' => 18000,
                'description' => 'Layanan kilat cuci dan setrika. Selesai dalam 6 jam!',
                'duration' => 6,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cuci Bed Cover',
                'price' => 25000,
                'description' => 'Khusus pencucian bed cover, selimut, dan sprei. Menggunakan mesin khusus.',
                'duration' => 72,
                'image' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        $baseDate = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $dayAfter = date('Y-m-d', strtotime('+2 days'));

        // ==========================================
        // 3. DATA SEEDER: SCHEDULES
        // ==========================================
        $this->db->table('schedules')->insertBatch([
            [
                'service_id' => 1,
                'date' => $baseDate,
                'time' => '08:00:00',
                'capacity' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'service_id' => 1,
                'date' => $baseDate,
                'time' => '13:00:00',
                'capacity' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'service_id' => 3,
                'date' => $tomorrow,
                'time' => '09:00:00',
                'capacity' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'service_id' => 4,
                'date' => $tomorrow,
                'time' => '10:00:00',
                'capacity' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'service_id' => 2,
                'date' => $dayAfter,
                'time' => '08:00:00',
                'capacity' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'service_id' => 5,
                'date' => $dayAfter,
                'time' => '14:00:00',
                'capacity' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        // ==========================================
        // 4. DATA SEEDER: BOOKINGS
        // ==========================================
        $this->db->table('bookings')->insertBatch([
            [
                'user_id' => 3,
                'service_id' => 3,
                'schedule_id' => null, // Simulasi booking Drop-off tanpa pilih jadwal
                'weight' => 7.7,
                'total' => 77000,
                'status' => 'done', // PERBAIKAN: Berubah ke kolom 'status' & bernilai 'done'
                'note' => 'asdads',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ],
            [
                'user_id' => 3,
                'service_id' => 3,
                'schedule_id' => null,
                'weight' => 5.5,
                'total' => 55000,
                'status' => 'done',
                'note' => 'askdkajds',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            ],
            [
                'user_id' => 3,
                'service_id' => 2,
                'schedule_id' => null,
                'weight' => 5.25,
                'total' => 52500,
                'status' => 'done',
                'note' => 'saad',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'user_id' => 4,
                'service_id' => 5,
                'schedule_id' => 6,
                'weight' => 2.5,
                'total' => 62500,
                'status' => 'pending',
                'note' => 'Bed cover ukuran king size',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'user_id' => 4,
                'service_id' => 1,
                'schedule_id' => 1,
                'weight' => 8.0,
                'total' => 56000,
                'status' => 'confirmed',
                'note' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
            ],
        ]);

        // ==========================================
        // 5. DATA SEEDER: PAYMENTS
        // ==========================================
        $this->db->table('payments')->insertBatch([
            [
                'booking_id' => 1,
                'amount' => 77000,
                'status' => 'paid',
                'midtrans_order_id' => 'LAUNDRY-1-' . time() . '-111',
                'snap_token' => 'dummy-token-111',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            ],
            [
                'booking_id' => 2,
                'amount' => 55000,
                'status' => 'paid',
                'midtrans_order_id' => 'LAUNDRY-2-' . time() . '-222',
                'snap_token' => 'dummy-token-222',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
            ],
            [
                'booking_id' => 3,
                'amount' => 52500,
                'status' => 'paid',
                'midtrans_order_id' => 'LAUNDRY-3-' . time() . '-333',
                'snap_token' => 'dummy-token-333',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
        ]);
    }
}