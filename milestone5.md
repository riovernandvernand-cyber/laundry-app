## 1. STRUKTUR UTAMA DAN DEMO ANTARMUKA KONSUMSI API

Menu **"Tambah Pesanan"** pada portal pelanggan di dalam browser yang menampilkan integrasi data wilayah.

> "Selamat pagi/siang Bapak/Ibu penguji. Pada Milestone Kelima ini, saya mempresentasikan pembaruan sistem transaksional laundry dari lapis Webservice Client, di mana aplikasi kini telah berhasil mengonsumsi dan mengintegrasikan **API RajaOngkir** secara penuh untuk menampilkan data wilayah pengiriman langsung di dalam view."
>
> "Dapat kita amati bersama pada layar browser, ketika halaman **Tambah Pesanan** ini dimuat, sistem bertindak sebagai client yang secara aktif mengambil data provinsi dan kota langsung dari web service RajaOngkir. Data tersebut langsung dipetakan secara rapi ke dalam pilihan dropdown regional pelanggan tanpa terjadi kendala _error_ ataupun kegagalan pemuatan, sehingga siap digunakan untuk kalkulasi ongkos kirim laundry secara real-time."

---

## 2. PENANGANAN ERROR HANDLING KONSUMSI WEB SERVICE

`app/Controllers/BookingController.php` _(atau nama controller tempat Anda mengolah form booking)_

> "Untuk mengantisipasi kegagalan koneksi, kegagalan SSL, atau pembatasan kuota (rate limit) dari server RajaOngkir, saya mengimplementasikan Error Handling yang ketat pada sisi controller menggunakan blok `try-catch` dan pengecekan status respons HTTP Client CodeIgniter 4."
>
> "Jika web service RajaOngkir mengalami gangguan atau token API tidak merespons, aplikasi tidak akan mengalami _crash_ atau menampilkan halaman kosong. Sistem secara proaktif menangkap kegagalan tersebut dan mengalirkannya secara aman ke dalam _flash message_ peringatan yang informatif kepada pengguna, memastikan _user experience_ tetap terjaga."

---

## 3. MEKANISME CACHING DATA UNTUK OPTIMALISASI KINERJA

`app/Controllers/BookingController.php` _(atau controller terkait)_ dan driver cache bawaan framework.

> "Terakhir, karena data wilayah seperti Provinsi dan Kota dari RajaOngkir bersifat statis dan jarang berubah, saya menerapkan sistem **Caching Data** menggunakan library Cache bawaan CodeIgniter 4. Payload data yang berhasil ditarik pada request pertama akan disimpan ke dalam memori cache lokal selama durasi tertentu (misalnya 24 jam)."
>
> "Dengan mekanisme ini, saat pelanggan melakukan _refresh_ halaman atau ada pelanggan lain yang mengakses formulir tambah pesanan, aplikasi tidak perlu melakukan _handshake_ ulang ke internet atau menembak server RajaOngkir kembali. Aplikasi langsung membaca data dari cache lokal, yang secara signifikan menghemat kuota request API kita dan mempercepat waktu pemuatan halaman (_response time_) menjadi jauh lebih instan. Terima kasih."
