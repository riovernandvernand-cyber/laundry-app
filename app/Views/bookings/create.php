<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h4 class="mb-4">🧾 Tambah Booking</h4>

            <form action="/bookings/store" method="post">

                <div class="row">

                    <!-- LAYANAN -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Layanan</label>
                        <select name="service_id" class="form-control" required>
                            <option value="">-- Pilih Layanan --</option>

                            <?php foreach ($services as $s): ?>
                                <option value="<?= $s['id'] ?>" data-price="<?= $s['price'] ?>">

                                    <?= $s['name'] ?>
                                    (Rp <?= number_format($s['price'], 0, ',', '.') ?>)

                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- JADWAL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jadwal</label>

                        <select name="schedule_id" class="form-control" required>
                            <option value="">-- Pilih Jadwal --</option>

                            <?php foreach ($schedules as $sc): ?>
                                <option value="<?= $sc['id'] ?>">
                                    <?= $sc['date'] ?> -
                                    <?= $sc['time'] ?>
                                    (<?= $sc['capacity'] ?> slot)
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- BERAT -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Berat (kg)</label>

                        <input type="number" name="weight" class="form-control" placeholder="Masukkan berat" required>
                    </div>

                    <!-- TOTAL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total</label>

                        <input type="text" name="total" class="form-control" readonly>
                    </div>

                    <!-- TANGGAL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal</label>

                        <input type="date" name="booking_date" class="form-control" required>
                    </div>

                    <!-- JAM -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jam</label>

                        <input type="time" name="booking_time" class="form-control" required>
                    </div>

                    <!-- KOTA TUJUAN (RAJAONGKIR INTEGRATION) -->
                    <div class="col-md-12 mb-3">
                        <label for="kota_tujuan" class="form-label">Kota Tujuan Pengiriman Laundry</label>
                        <select class="form-control" id="kota_tujuan" name="kota_tujuan" required>
                            <option value="">Memuat daftar kota...</option>
                        </select>
                    </div>

                    <!-- NOTE -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Catatan Tambahan</label>

                        <textarea name="note" class="form-control" rows="3"
                            placeholder="Contoh: Pisahkan pakaian putih dan berwarna"></textarea>
                    </div>

                </div>

                <button class="btn btn-primary px-4 shadow-sm">
                    💾 Simpan Booking
                </button>

            </form>

        </div>
    </div>

</div>

<!-- LOGIKAL SCRIPT: AJAX KOTA & AUTO HITUNG TOTAL -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // 1. Logika Dropdown Kota via AJAX (RajaOngkir Komerce)
        const selectKota = document.getElementById("kota_tujuan");

        fetch("/bookings/get-kota")
            .then(response => response.json())
            .then(res => {
                selectKota.innerHTML = '<option value="">-- Pilih Kota Tujuan --</option>';
                if (res.status === 200 && res.data) {
                    res.data.forEach(kota => {
                        let option = document.createElement("option");

                        // SINKRONISASI DATA KOMERCE:
                        // 1. Ambil id unik daerah sebagai value option
                        option.value = kota.id;

                        // 2. Gunakan properti label untuk menampilkan string alamat super lengkap
                        // (Contoh output textContent: BOJONGSALAMAN, SEMARANG BARAT, SEMARANG, JAWA TENGAH, 50141)
                        option.textContent = kota.label;

                        // ALTERNATIF JIKA INGIN STRUKTUR CUSTOM SINGKAT:
                        // option.textContent = `${kota.subdistrict_name}, ${kota.city_name} (${kota.zip_code})`;

                        selectKota.appendChild(option);
                    });
                } else {
                    selectKota.innerHTML = '<option value="399">Kota Semarang (Fallback Default)</option>';
                }
            })
            .catch(error => {
                selectKota.innerHTML = '<option value="399">Kota Semarang (Fallback Default)</option>';
            });


        // 2. Logika Auto Hitung Total Pendapatan Layanan
        const service = document.querySelector('[name="service_id"]');
        const weight = document.querySelector('[name="weight"]');
        const total = document.querySelector('[name="total"]');

        function hitungTotal() {
            let price = service.options[
                service.selectedIndex
            ]?.getAttribute('data-price');

            let kg = weight.value;

            if (price && kg) {
                total.value = price * kg;
            } else {
                total.value = '';
            }
        }

        service.addEventListener('change', hitungTotal);
        weight.addEventListener('input', hitungTotal);

    });
</script>

<?= $this->endSection() ?>