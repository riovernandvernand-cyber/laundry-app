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
                                    <?= $s['name'] ?> (Rp <?= number_format($s['price'],0,',','.') ?>)
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
                                    <?= $sc['date'] ?> - <?= $sc['time'] ?> (<?= $sc['capacity'] ?> slot)
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

                </div>

                <button class="btn btn-primary px-4 shadow-sm">
                    💾 Simpan Booking
                </button>

            </form>

        </div>
    </div>

</div>


<!-- 🔥 AUTO HITUNG TOTAL -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const service = document.querySelector('[name="service_id"]');
    const weight  = document.querySelector('[name="weight"]');
    const total   = document.querySelector('[name="total"]');

    function hitungTotal() {
        let price = service.options[service.selectedIndex]?.getAttribute('data-price');
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