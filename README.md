# Laundry Booking App

## Deskripsi

Aplikasi booking layanan laundry berbasis web menggunakan CodeIgniter 4.
Sistem ini memungkinkan pelanggan melakukan pemesanan layanan, pembayaran online melalui Midtrans, serta monitoring status laundry oleh admin/staff.

---

## Fitur Utama

### 🔐 Auth & Role

* Login & Register
* Multi role: Admin, Staff, Pelanggan
* Proteksi route menggunakan filter

### 📦 Booking

* Booking layanan laundry
* Pilih jadwal & berat
* Auto hitung total
* Status:

  * Pending
  * Diproses
  * Selesai

### 💳 Payment (Midtrans)

* Snap Payment (sandbox)
* Redirect finish
* Webhook callback
* Update otomatis status pembayaran

### 🧾 Admin Panel

* CRUD layanan
* CRUD jadwal
* Manajemen booking
* Update status laundry

### 📊 Dashboard

* Total booking
* Total pendapatan
* Layanan terpopuler

### 🌐 API

* GET /api/services
* GET /api/booking-status/{id}

---

## 🛠️ Teknologi

* CodeIgniter 4
* MySQL
* Midtrans Sandbox
* Bootstrap

---

## ⚙️ Cara Instalasi

1. Clone project

2. Install dependency
   composer install

3. Copy file env
   cp env .env

4. Setting database di `.env`

5. Jalankan migration & seeder
   php spark migrate --seed

6. Jalankan server
   php spark serve

---

## 👤 Akun Login

### Admin

* Email: [admin@mail.com](mailto:admin@mail.com)
* Password: 123

### User

* Email: [user@mail.com](mailto:user@mail.com)
* Password: 123

---

## 🗄️ Database

Database menggunakan migration & seeder sehingga dapat langsung dijalankan dengan:
php spark migrate --seed

---

## 📊 ERD

![ERD](ERD.png)

---

## 📸 Screenshot

* Dashboard
* Booking
* Payment Midtrans
* Service & Schedule

---

## 👨‍💻 Author

Project ini dibuat untuk memenuhi tugas Pemrograman Web Lanjut.
