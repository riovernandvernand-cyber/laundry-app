# Sistem Pemesanan Layanan Laundry (Laundry Service Booking App)

Aplikasi manajemen dan pemesanan layanan laundry berbasis web yang dibangun menggunakan framework CodeIgniter 4. Aplikasi ini dirancang untuk memfasilitasi tiga aktor utama (Admin, Staff Operasional, dan Pelanggan) dalam mengelola alur transaksi pencucian secara digital, mulai dari estimasi pengiriman, pembayaran otomatis, hingga pemantauan tugas harian staff.

## Komponen Penilaian Proyek Pemrograman Web Lanjut

Proyek ini disusun untuk memenuhi rubrik penilaian mata kuliah Pemrograman Web Lanjut Universitas Dian Nuswantoro dengan implementasi komponen sebagai berikut:

- **Arsitektur MVC & Kode Bersih:** Pemisahan logika yang ketat antara Controllers, Models, dan komponen Views.
- **Autentikasi & Otorisasi Mutakhir:** Manajemen session aman yang memisahkan hak akses multi-role menggunakan Filter CodeIgniter 4.
- **Basis Data Dinamis:** Skema database yang dibangun penuh menggunakan berkas Migration, Database Seeding, serta menjaga Referential Integrity.
- **Integrasi Webservice API:** Konsumsi API eksternal dengan mengimplementasikan mekanisme error handling yang baik.

---

## Fitur Utama Sistem

### 1. Sisi Pelanggan (Customer Side)

- Melakukan registrasi dan autentikasi akun secara mandiri.
- Memesan layanan laundry secara online dengan pemilihan jadwal kuota yang dinamis.
- Integrasi Webservice API RajaOngkir untuk kalkulasi otomatis biaya pengiriman kurir berdasarkan provinsi dan kota, dilengkapi optimasi Server-Side Data Caching untuk efisiensi bandwidth.
- Pembayaran digital aman terintegrasi penuh dengan Gateway Midtrans Snap (Sandbox Mode).
- Memantau riwayat pesanan pribadi dan mengecek status pembayaran secara realtime.

### 2. Sisi Staff Operasional (Staff Side)

- Dashboard manajemen antrean tugas harian dengan antarmuka berbasis Flat Minimalist.
- Pembaruan status operasional pengerjaan laundry (Pending, Diproses, Selesai) secara instan.
- Fitur otomatisasi cetak struk nota fisik yang presisi untuk ukuran kertas printer thermal kasir (58mm/80mm).

### 3. Sisi Administrator (Admin Side)

- Dashboard interaktif untuk pemantauan statistik akumulasi pesanan, total pendapatan, dan layanan terpopuler.
- Manajemen master data layanan laundry (CRUD Jenis Layanan, Deskripsi, Harga, Kapasitas, dan Foto).
- Manajemen kuota dan kapasitas jadwal operasional toko.
- Kontrol aktivasi status akun pengguna untuk melakukan blokir atau mengaktifkan kembali akun (Manajemen Users).

---

## Arsitektur Basis Data (ERD)

Aplikasi ini menggunakan skema database relasional dengan menjaga integritas data melalui batasan kunci tamu (Foreign Key Referential Integrity).

![ERD](ERD.png)

---

## Panduan Instalasi Aplikasi

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal (localhost) Anda dari nol:

### Prasyarat Sistem

- PHP versi 8.1 atau versi 8.2 (Pastikan ekstensi intl, mbstring, dan mysqli aktif di php.ini)
- Composer versi 2.x
- MySQL / MariaDB Server

### Langkah-Langkah Setup

1. **Clone Repositori**
   Unduh source code proyek ini ke direktori lokal Anda:

   ```bash
   git clone [https://github.com/riovernandvernand-cyber/laundry-app.git](https://github.com/riovernandvernand-cyber/laundry-app.git)
   cd laundry-app
   ```

2. **Instalasi Dependensi Vendor**
   Jalankan Composer untuk mengunduh seluruh library pihak ketiga yang dibutuhkan (termasuk SDK Midtrans):

   ```bash
   composer install
   ```

3. **Konfigurasi Environment (.env)**
   Salin berkas template env bawaan menjadi berkas .env aktif:

   ```bash
   cp env .env
   ```

   Buka berkas `.env` tersebut menggunakan text editor, lalu sesuaikan nilai variabel konfigurasi sesuai panduan di bawah.

4. **Eksekusi Migrasi dan Database Seeding**
   Buat database baru di MySQL dengan nama `db_laundry`. Setelah database dibuat, jalankan perintah Spark CLI untuk membangun struktur tabel beserta data bawaannya secara otomatis:

   ```bash
   php spark migrate --seed
   ```

5. **Jalankan Server Lokal**
   Nyalakan server pengembangan bawaan CodeIgniter 4 melalui terminal:
   ```bash
   php spark serve
   ```
   Aplikasi kini dapat diakses melalui browser di alamat: http://localhost:8080

---

## Panduan Konfigurasi Berkas Environment (.env)

Pastikan variabel-variabel di bawah ini telah disesuaikan dengan kredensial lokal dan key sandbox Anda:

```env
# Konfigurasi Utama Aplikasi
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

# Database Connection Settings
database.default.hostname = localhost
database.default.database = db_laundry
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port     = 3306

# Midtrans Payment Gateway Configuration (Sandbox Mode)
MIDTRANS_SERVER_KEY = "Masukan_Server_Key_Sandbox_Midtrans_Anda"
MIDTRANS_CLIENT_KEY = "Masukan_Client_Key_Sandbox_Midtrans_Anda"
MIDTRANS_IS_PRODUCTION = false
MIDTRANS_IS_SANITIZED = true
MIDTRANS_IS_3DS = true

# RajaOngkir API Configuration (Free Tier)
RAJAONGKIR_API_KEY = "Masukan_API_Key_RajaOngkir_Anda"

# Notifikasi Email via SMTP
email.protocol = smtp
email.SMTPHost = smtp.mailtrap.io
email.SMTPUser = 'username_anda'
email.SMTPPass = 'password_anda'
email.SMTPPort = 2525
```

_Catatan Keamanan: Berkas `.env` asli yang berisi key rahasia telah didaftarkan ke dalam `.gitignore` sehingga tidak akan ikut ter-push ke repositori publik demi menjaga keamanan sistem._

---

## Kredensial Akun Akses Demo

Gunakan akun default hasil dari DatabaseSeeder di bawah ini untuk menguji fungsionalitas sistem pada masing-masing role:

1. **Role: Administrator (Admin)**
   - Email: admin@laundry.com
   - Password: admin123
   - Hak Akses: CRUD Layanan, CRUD Jadwal, Manajemen Booking, Aktivasi Akun User, Monitoring Pendapatan.

2. **Role: Staff Operasional**
   - Email: staff@laundry.com
   - Password: staff123
   - Hak Akses: Memantau Daftar Booking Masuk, Memproses Tugas Harian, Mengubah Status Menjadi Selesai, Cetak Struk Nota Termal.

3. **Role: Pelanggan (Customer / User)**
   - Email: siti@gmail.com atau andi@gmail.com
   - Password: user123
   - Hak Akses: Melakukan Pemesanan Laundry, Menggunakan Cek Ongkir Kurir Otomatis, Membayar via Midtrans Snap, Riwayat Pesanan.

4. **Role: Akun Pelanggan Nonaktif**
   - Email: dewi@gmail.com
   - Password: user123
   - Status: Akun ditangguhkan (Tidak diberikan izin masuk ke dalam sistem oleh filter keamanan).

---

## Dokumentasi Antarmuka Aplikasi (Screenshots)

Berikut adalah lampiran tampilan visual dari sistem pemesanan dan operasional laundry:

### Panel Administrator

- **Dashboard Monitoring Statistik Admin**
  ![Dashboard Admin](./screenshots/admin/DashboardAdmin.png)
- **Manajemen Master Data Layanan**
  ![Admin Page](./screenshots/admin/admin.png)

### Panel Staff Operasional

- **Dashboard Tugas Harian Staff**
  ![Dashboard Staff](./screenshots/staff/dashboard.png)
- **Daftar Log Riwayat Antrean Booking**
  ![Booking Staff](./screenshots/staff/booking.png)

### Antarmuka Pelanggan (Customer Interface)

- **Dashboard Status Pemesanan Aktif**
  ![Dashboard User](./screenshots/user/dashboard.png)
- **Form Pengisian Detail Booking Laundry**
  ![Tambah Booking](./screenshots/user/tambah%20booking.png)
- **Pop-up Pembayaran Digital Midtrans Snap**
  ![Payment](./screenshots/user/payment.png)

---

## Struktur Folder Proyek (Simplified)

```bash
app/
 ├── Config/      # Berkas Konfigurasi Aplikasi & Filter Otorisasi Route
 ├── Controllers/ # Logika Bisnis Aktor (Admin, Staff, Booking, Auth)
 ├── Database/    # Berkas Migrasi Struktur Tabel & Seeder Data Default
 ├── Filters/     # Layer Keamanan Interseptor Akses Kontrol Role
 ├── Models/      # Query Terstruktur Entitas Database
 └── Views/       # Layout Tampilan Aplikasi (Bootstrap 5)
public/           # Berkas Aset Publik (CSS, JS, Favicon)
screenshots/      # Dokumentasi Lampiran Fitur Aplikasi
```

---

## Lapisan Keamanan Sistem (Security Layer)

Aplikasi ini mengimplementasikan standar keamanan web dasar guna mencegah eksploitasi celah keamanan:

- **Hashing Kriptografi:** Keamanan data kredensial password dijamin menggunakan algoritma hashing aman `password_hash()`.
- **Mitigasi Serangan CSRF:** Setiap form pengiriman data (POST) dilindungi secara ketat menggunakan injeksi token bawaan `csrf_field()`.
- **Otorisasi Berlapis:** Pemisahan batasan akses URL menggunakan Filter khusus yang memeriksa kesesuaian session role pengguna secara realtime.
- **Pencegahan SQL Injection & XSS:** Memanfaatkan mekanisme query binding bawaan model CodeIgniter 4 serta fungsi penapis output data `esc()`.

---

## Lisensi dan Hak Cipta

Proyek ini dikembangkan sebagai hasil karya akademik pada mata kuliah Pemrograman Web Lanjut - Universitas Dian Nuswantoro.
