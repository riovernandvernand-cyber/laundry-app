<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\ScheduleModel;
use App\Models\ServiceModel;
use App\Models\PaymentModel;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends BaseController
{
    // ======================
    // LIST BOOKING + FILTER
    // ======================
    public function index()
    {
        $model = new \App\Models\BookingModel();

        $status = $this->request->getGet('status');
        $date = $this->request->getGet('date');

        $userId = session()->get('user_id');
        $role = session()->get('role');

        // 1. Filter status menggunakan nama kolom 'status' asli database
        if ($status) {
            $model->where('bookings.status', $status);
        }

        // 2. Filter tanggal lewat join schedules sesuai cetak biru
        $model->join('schedules', 'schedules.id = bookings.schedule_id', 'left');
        if ($date) {
            $model->where('schedules.date', $date);
        }

        // 3. Filter kepemilikan pelanggan
        if ($role === 'pelanggan') {
            $model->where('bookings.user_id', $userId);
        }

        // 4. Proyeksikan kolom agar alias-nya pas dengan komponen di View index
        $model->select('bookings.*,
                    bookings.status as laundry_status,
                    schedules.date as date,
                    schedules.time as time,
                    payments.status as payment_status,
                    services.name as service_name,
                    users.name as user_name')
            ->join('services', 'services.id = bookings.service_id')
            ->join('payments', 'payments.booking_id = bookings.id', 'left')
            ->join('users', 'users.id = bookings.user_id', 'left')
            ->orderBy('bookings.id', 'DESC');

        return view('pelanggan/bookings/index', [
            'bookings' => $model->paginate(10, 'default'),
            'pager' => $model->pager,
            'status' => $status,
            'date' => $date,
            'role' => $role,

            // Metrik pelengkap agar dashboard tidak blank
            'totalBooking' => $totalBooking ?? 0,
            'totalIncome' => $totalIncome ?? 0,
            'popularService' => $popularService ?? null
        ]);
    }

    // ======================
    // PAYMENT (MIDTRANS)
    // ======================
    public function pay(int|string $id)
    {
        $model = new BookingModel();

        $booking = $model
            ->select('bookings.*, services.name as service_name')
            ->join('services', 'services.id = bookings.service_id')
            ->find($id);

        if (!$booking) {
            return redirect()->to('/bookings')->with('error', 'Booking tidak ditemukan');
        }

        // Pelanggan hanya bisa bayar booking miliknya
        if (session()->get('role') === 'pelanggan') {
            if ((int) $booking['user_id'] !== (int) session()->get('user_id')) {
                return redirect()->to('/bookings')->with('error', 'Akses ditolak');
            }
        }

        Config::$serverKey = getenv('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        Config::$curlOptions = [
            \CURLOPT_SSL_VERIFYPEER => false,
            \CURLOPT_SSL_VERIFYHOST => false,
            \CURLOPT_HTTPHEADER => []
        ];

        $order_id = 'LAUNDRY-' . $booking['id'] . '-' . time() . '-' . rand(100, 999);

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => (int) $booking['total'],
            ],
            'customer_details' => [
                // Gunakan operator ?? untuk memberikan nama cadangan jika session kosong
                'first_name' => session()->get('name') ?? 'Pelanggan Laundry',
                'email' => session()->get('email') ?: 'pelanggan@mail.com',
                'phone' => '081234567890', // Tambahkan nomor telepon dummy standar
            ],
            'callbacks' => [
                'finish' => base_url('pelanggan/payment/finish'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

        } catch (\Exception $e) {
            // Log pesan error tetap dicatat di latar belakang
            log_message('error', 'MIDTRANS ERROR: ' . $e->getMessage());

            return redirect()->to('/bookings')
                ->with('error', 'Gagal membuat transaksi pembayaran. Coba lagi nanti.');
        }

        // Simpan payment record
        $paymentModel = new PaymentModel();

        $existingPayment = $paymentModel
            ->where('booking_id', $booking['id'])
            ->where('status', 'pending')
            ->first();

        if ($existingPayment) {
            return view('pelanggan/bookings/pay', [
                'snapToken' => $existingPayment['snap_token'],
                'booking' => $booking,
            ]);
        }

        $paymentModel->insert([
            'booking_id' => $booking['id'],
            'amount' => (int) $booking['total'],
            'status' => 'pending',
            'midtrans_order_id' => $order_id,
            'snap_token' => $snapToken,
        ]);
        return view('pelanggan/bookings/pay', [
            'snapToken' => $snapToken,
            'booking' => $booking,
        ]);
    }
    // ======================
    // FINISH (redirect setelah bayar)
    // ======================
    public function finish()
    {
        return redirect()->to('/bookings')
            ->with('success', 'Pembayaran sedang diproses...');
    }

    // ======================
    // APPROVE (ADMIN)
    // ======================
    public function approve(int|string $id)
    {
        (new BookingModel())->update($id, [
            'laundry_status' => 'confirmed',
        ]);

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi');
    }

    // ======================
    // REJECT (ADMIN)
    // ======================
    public function reject(int|string $id)
    {
        (new BookingModel())->update($id, [
            'laundry_status' => 'cancelled',
        ]);

        return redirect()->back()->with('success', 'Booking berhasil ditolak');
    }

    // ======================
    // PROCESS (ADMIN/STAFF)
    // ======================
    public function process(int|string $id)
    {
        (new BookingModel())->update($id, [
            'laundry_status' => 'processing',
        ]);

        return redirect()->back()->with('success', 'Laundry sedang diproses');
    }

    /**
     * Mengubah status booking menjadi 'done' (Selesai)
     * URL: /tasks/done/(:num)
     */
    public function done($id)
    {
        $bookingModel = new BookingModel();

        // 1. Cek apakah data booking dengan ID tersebut eksis
        $booking = $bookingModel->find($id);
        if (!$booking) {
            return redirect()->to('/tasks')->with('error', 'Data antrean laundry tidak ditemukan.');
        }

        // 2. Pastikan statusnya memang sedang diproses ('processing')
        if ($booking['status'] !== 'processing') {
            return redirect()->to('/tasks')->with('error', 'Status pesanan tidak valid untuk diselesaikan.');
        }

        // 3. Update status menjadi 'completed' dan isi timestamp updated_at
        $bookingModel->update($id, [
            'status' => 'completed',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // 4. Redirect kembali ke halaman tugas harian dengan flash message sukses
        return redirect()->to('/tasks')->with('success', 'Tugas #LND-' . $id . ' berhasil diselesaikan! Pelanggan segera dinotifikasi.');
    }

    // ======================
    // CANCEL (PELANGGAN - hanya booking sendiri yg belum dikonfirmasi)
    // ======================
    public function cancel(int|string $id)
    {
        $model = new BookingModel();
        $booking = $model->find($id);

        if (!$booking) {
            return redirect()->to('/bookings')->with('error', 'Booking tidak ditemukan');
        }

        // Pelanggan hanya bisa cancel booking miliknya
        if (!$model->isOwnedBy($id, (int) session()->get('user_id'))) {
            return redirect()->to('/bookings')->with('error', 'Akses ditolak');
        }

        // Tidak bisa cancel kalau sudah dibayar
        $paymentModel = new PaymentModel();
        $payment = $paymentModel->where('booking_id', $id)->first();

        if ($payment && $payment['status'] === 'paid') {
            return redirect()->to('/bookings')
                ->with('error', 'Booking yang sudah dibayar tidak bisa dibatalkan');
        }

        $model->update($id, [
            'laundry_status' => 'cancelled',
        ]);

        return redirect()->to('/bookings')->with('success', 'Booking berhasil dibatalkan');
    }

    /**
     * Menampilkan halaman cetak struk nota minimalis
     * URL: /bookings/print/(:num)
     */
    public function printBooking($id)
    {
        $bookingModel = new BookingModel();

        // Ambil detail booking beserta nama layanan dan data usernya
        $booking = $bookingModel->select('bookings.*, services.name as service_name, services.price as service_price, users.name as customer_name, users.phone as customer_phone')
            ->join('services', 'services.id = bookings.service_id')
            ->join('users', 'users.id = bookings.user_id')
            ->where('bookings.id', $id)
            ->first();

        if (!$booking) {
            return "<h3>Error: Nota tidak ditemukan.</h3>";
        }

        // Tampilkan view khusus cetak struk nota tanpa layout navbar utama
        return view('staff/tasks/print_nota', [
            'b' => $booking
        ]);
    }

    // ======================
    // CREATE FORM
    // ======================
    public function create()
    {
        // Cukup lempar data layanan dan daftar provinsi statis (untuk hemat limit total)
        $provinces = [
            ['province_id' => '10', 'province' => 'Jawa Tengah'],
            ['province_id' => '11', 'province' => 'Jawa Timur'],
            ['province_id' => '9', 'province' => 'Jawa Barat'],
            ['province_id' => '5', 'province' => 'DI Yogyakarta'],
            ['province_id' => '6', 'province' => 'DKI Jakarta']
        ];

        return view('pelanggan/bookings/create', [
            'services' => (new ServiceModel())->findAll(),
            'schedules' => (new ScheduleModel())->getWithService(),
            'provinces' => $provinces
        ]);
    }

    public function getCitiesByProvince()
    {
        $provinceId = $this->request->getVar('province_id');

        if (!$provinceId) {
            return $this->response->setJSON(['status' => 400, 'data' => []]);
        }

        // Mapping ID Provinsi statis ke String Nama Provinsi untuk pencarian API Komerce
        $provinceNames = [
            '10' => 'Jawa Tengah',
            '11' => 'Jawa Timur',
            '9' => 'Jawa Barat',
            '5' => 'DI Yogyakarta',
            '6' => 'DKI Jakarta'
        ];

        $provinceName = $provinceNames[$provinceId] ?? '';

        $cache = \Config\Services::cache();
        $cacheKey = 'rajaongkir_cities_prov_' . $provinceId;
        $cachedData = $cache->get($cacheKey);

        if ($cachedData) {
            return $this->response->setJSON([
                'status' => 200,
                'source' => 'cache (aman 100%)',
                'data' => json_decode($cachedData, true)
            ]);
        }

        $apiKey = env('RAJAONGKIR_API_KEY') ?: '';
        $client = \Config\Services::curlrequest();

        try {
            // Solusi 422: Gunakan parameter 'search' berisi nama provinsi
            $response = $client->request('GET', 'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
                'headers' => ['key' => $apiKey],
                'query' => [
                    'search' => $provinceName,
                    'limit' => 50, // Ambil borongan data wilayah di provinsi tersebut
                    'offset' => 0
                ],
                'verify' => false,
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_CONNECTTIMEOUT => 10,
                ]
            ]);

            $body = json_decode($response->getBody(), true);

            if (isset($body['data']) && is_array($body['data'])) {
                $cities = $body['data'];

                // Simpan borongan ke cache lokal permanen agar hemat kuota total
                $cache->save($cacheKey, json_encode($cities), 0);

                return $this->response->setJSON([
                    'status' => 200,
                    'source' => 'api (berkurang -1)',
                    'data' => $cities
                ]);
            }

            throw new \Exception($body['message'] ?? 'Format respon API tidak dikenal.');

        } catch (\Exception $e) {
            // Kembalikan ke fallback lokal jika API bermasalah di kemudian hari
            $fallback = [
                '10' => [
                    ['id' => '399', 'label' => 'Jawa Tengah, Semarang, Kota Semarang'],
                    ['id' => '400', 'label' => 'Jawa Tengah, Semarang, Kabupaten Semarang'],
                    ['id' => '392', 'label' => 'Jawa Tengah, Surakarta, Kota Surakarta']
                ]
            ];

            $dataFallback = $fallback[$provinceId] ?? [['id' => '999', 'label' => 'Data kota offline']];

            return $this->response->setJSON([
                'status' => 200,
                'source' => 'fallback (offline terpaksa)',
                'message' => $e->getMessage(),
                'data' => $dataFallback
            ]);
        }
    }

    // ======================
    // STORE (SIMPAN BOOKING)
    // ======================
    public function store()
    {
        $formData = $this->request->getPost();
        $session = session();

        if (empty($formData['service_id']) || empty($formData['weight'])) {
            return redirect()->back()->withInput()->with('error', 'Layanan dan berat wajib diisi.');
        }

        // Ambil harga layanan dari database untuk kalkulasi total harga otomatis
        $serviceModel = new ServiceModel(); // Sesuaikan nama model layenamu jika berbeda
        $service = $serviceModel->find($formData['service_id']);
        $price = $service['price'] ?? 0;
        $totalPrice = (int) $formData['weight'] * (int) $price;

        // Susun array data HANYA untuk kolom yang diijinkan oleh skema database bookings
        $dataToInsert = [
            'user_id' => $session->get('user_id'),
            'service_id' => $formData['service_id'],
            'schedule_id' => $formData['schedule_id'] ?? null, // Dipasang null jika opsional
            'weight' => $formData['weight'],
            'total' => $totalPrice > 0 ? $totalPrice : 50000, // fallback nominal jika harga layanan kosong
            'status' => 'pending',
            'note' => $formData['address'] ?? '', // Alamat form sementara diamankan ke kolom note agar tidak hilang
        ];

        try {
            $bookingModel = new BookingModel();
            $bookingModel->insert($dataToInsert);

            return redirect()->to('/bookings')->with('success', 'Booking laundry berhasil dibuat! Pesanan Anda sedang masuk antrean.');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan ke database: ' . $e->getMessage());
        }
    }
}