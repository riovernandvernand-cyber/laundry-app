# Panduan Demo & Presentasi: Milestone 5 & 6

## 1. Milestone 5: Integrasi Webservice Client (Konsumsi API)

> **Kriteria Nilai 4:** API terintegrasi, memiliki _error handling_, dan data disimpan dalam _cache_.

### Hal Penting untuk Dijelaskan (Teori & Konsep)

- **Mekanisme Caching:** Aplikasi tidak melakukan _request_ ulang ke API pihak ketiga (RajaOngkir) setiap kali halaman dimuat. Data wilayah/ongkir disimpan di memori lokal server menggunakan _library Cache_ bawaan CodeIgniter 4.
- **Efisiensi Server:** _Caching_ diterapkan untuk memotong waktu _loading_ halaman (meningkatkan _User Experience_) dan menghemat penggunaan kuota limit _request_ pada API eksternal.
- **Resiliensi & Error Handling:** Sistem dilengkapi dengan penanganan kesalahan (_error handling_) menggunakan blok `try-catch`. Jika koneksi API eksternal terputus atau terjadi masalah SSL (`verify => false`), sistem tidak akan _crash_, melainkan beralih ke data cadangan (_fallback_) lokal.

### Skenario Alur Demo (Praktik)

1. Buka halaman **Form Booking** pada browser.
2. Tunjukkan kepada dosen bahwa _dropdown_ daerah tujuan langsung memuat data dengan cepat.
3. Buka _Developer Tools_ browser (F12) -> masuk ke tab **Network**, atau tunjukkan log respons JSON lokal yang memuat penanda `"source": "cache"` sebagai bukti data diambil dari penyimpanan _cache_ server.

---

## 2. Milestone 6: Webservice Server (Expose API Endpoint)

> **Kriteria Nilai 4:** RESTful lengkap, menggunakan _auth token/API key_, dan memiliki dokumentasi endpoint yang rapi.

### Hal Penting untuk Dijelaskan (Teori & Konsep)

- **Keamanan Endpoint:** Akses ke API server (`/api/services` dan `/api/booking-status/{id}`) diamankan secara ketat menggunakan `ApiAuthFilter.php`. Endpoint tidak dapat ditembak secara anonim dari luar.
- **Validasi Token:** Sistem membaca dan memvalidasi _Auth Token_ atau _API Key_ yang dikirimkan melalui _Header Request_. Jika token tidak valid atau kosong, akses langsung ditolak.
- **Arsitektur RESTful Standar:** Respons dari server diformat dalam bentuk JSON bersih dan menggunakan kode status HTTP standar (`200 OK` untuk sukses, `401 Unauthorized` untuk token salah/kosong).

### Skenario Alur Demo (Praktik)

1. **Buka Aplikasi Postman / Insomnia.**
2. **Demo Pengujian Proteksi (Gagal):** Lakukan _request_ `GET` ke endpoint `/api/services` tanpa menyertakan token pada _header_. Tunjukkan bahwa sistem menolak akses dan mengembalikan respons `401 Unauthorized`.
3. **Demo Pengujian Akses (Sukses):** Masukkan _API Key/Token_ yang valid pada bagian _Headers_ di Postman, lalu lakukan _request_ kembali. Tunjukkan bahwa respons JSON yang berisi daftar layanan laundry berhasil keluar dengan struktur yang rapi.
4. **Dokumentasi Endpoint:** Tunjukkan file _Postman Collection_ yang telah di-_export_ sebagai dokumen teknis pengujian endpoint API.

---

### Tips Persiapan Layar Sebelum Maju Presentasi:

- **Tab Browser 1:** Halaman Form Booking (Siap demonstrasi _caching_ & _dropdown_).
- **Aplikasi Postman:** Buka dua tab _request_ yang sudah siap eksekusi (satu tanpa token, satu dengan token valid).
- **Kode Editor (VS Code):** Posisikan layar pada file `ApiController.php` dan `ApiAuthFilter.php` untuk berjaga-gaga jika dosen ingin memeriksa struktur logika kodenya secara langsung.
