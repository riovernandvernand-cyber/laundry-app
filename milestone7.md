## 1. DEMO ALUR TRANSAKSI DAN SINKRONISASI PAYMENT GATEWAY

Halaman invoice pesanan aktif di browser saat memicu pembayaran sandbox hingga muncul notifikasi konfirmasi.

> "Selamat pagi/siang Bapak/Ibu penguji. Pada Milestone Ketujuh ini, saya mempresentasikan pemenuhan aspek finansial dan komunikasi sistem, di mana aplikasi telah berhasil mengintegrasikan modul Payment Gateway Sandbox secara penuh sekaligus sistem notifikasi konfirmasi otomatis."
>
> "Dapat kita amati langsung pada layar peramban, ketika proses checkout selesai, pelanggan disajikan opsi gerbang pembayaran interaktif. Melalui lingkungan sandbox yang berfungsi 100%, pembayaran dapat diselesaikan dengan berbagai metode instan, di mana status tagihan langsung berstatus lunas dan terkonfirmasi secara aman tanpa intervensi manual kasir."

---

## 2. RESTRUKTURISASI BACKEND PENANGANAN PAYMENT GATEWAY

`app/Controllers/PaymentController.php` atau `app/Controllers/MidtransCallback.php` (Logika pengondisian status transaksi)

> "Untuk mengendalikan alur konfirmasi pembayaran di tingkat backend, saya membangun logika penanganan pada controller. Sistem mendengarkan setiap perubahan status atau callback dari payment gateway."
>
> "Ketika status transaksi dinyatakan valid dan berhasil, kueri database langsung melakukan mutasi data untuk memperbarui riwayat pesanan menjadi terkonfirmasi, sekaligus menyiapkan pemicu untuk modul komunikasi eksternal."

---

## 3. INTEGRASI OPERASIONAL SISTEM NOTIFIKASI OTOMATIS

`app/Helpers/notification_helper.php` atau Controller terkait (Mekanisme pengiriman API WhatsApp atau Email Service)

> "Terakhir, sebagai komponen penutup yang melengkapi poin tertinggi pada milestone ini, aplikasi telah terintegrasi secara penuh dengan web service notifikasi, baik berupa WhatsApp gateway maupun layanan Email."
>
> "Seketika sistem menerima konfirmasi pembayaran yang sah, backend secara asinkron menembak endpoint penyedia notifikasi untuk mengirimkan bukti manifes digital dan rincian pesanan langsung ke nomor atau pos elektronik pelanggan secara otomatis. Terima kasih."
