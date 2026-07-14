<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .form-control,
    .form-select {
        border-color: #e2e8f0;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1e3a8a;
        box-shadow: none;
    }
</style>

<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Buat Booking Laundry</h4>
    <p class="text-secondary small mb-0">Silakan pilih layanan dan tentukan wilayah pengiriman dengan sistem berjenjang.
    </p>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <form action="<?= base_url('bookings/store') ?>" method="post">
                    <?= csrf_field() ?>

                    <h5 class="fw-bold text-dark mb-3 small text-uppercase tracking-wider text-secondary">Informasi
                        Pakaian & Layanan</h5>

                    <div class="mb-3">
                        <label for="service_id" class="form-label small fw-semibold text-secondary">Pilih Jenis
                            Jasa</label>
                        <select class="form-select form-select-lg fs-6 rounded-3" id="service_id" name="service_id"
                            required>
                            <option value="" selected disabled>-- Pilih Layanan --</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= $service['id'] ?>"><?= esc($service['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="weight" class="form-label small fw-semibold text-secondary">Estimasi Bobot
                            (Kg)</label>
                        <div class="input-group">
                            <input type="number" step="0.1" class="form-control form-control-lg fs-6 rounded-start-3"
                                id="weight" name="weight" placeholder="0.0" required>
                            <span class="input-group-text bg-light text-secondary rounded-end-3">Kg</span>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mb-3 mt-4 small text-uppercase tracking-wider text-secondary">Destinasi
                        Wilayah Tujuan</h5>

                    <div class="row">
                        <!-- Dropdown 1: Provinsi -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="province" class="form-label small fw-semibold text-secondary">Provinsi</label>
                            <select class="form-select rounded-3" id="province" name="province" required>
                                <option value="" selected disabled>Pilih Provinsi</option>
                                <?php foreach ($provinces as $prov): ?>
                                    <option value="<?= $prov['province_id'] ?>"><?= esc($prov['province']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Dropdown 2: Kota -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="city" class="form-label small fw-semibold text-secondary">Kota /
                                Kabupaten</label>
                            <select class="form-select rounded-3" id="city" name="city_id" required disabled>
                                <option value="" selected disabled>Pilih Kota</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div id="api_badge_status" class="small text-secondary"></div>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label small fw-semibold text-secondary">Detail Alamat
                            Rumah</label>
                        <textarea class="form-control rounded-3" id="address" name="address" rows="3"
                            placeholder="Nama jalan, nomor rumah, RT/RW..." required></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-4">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-calendar-plus"></i> Konfirmasi Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
            <h6 class="fw-bold text-dark d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-cpu text-primary bg-light border p-2 rounded"></i> Arsitektur Sinkronisasi Data
            </h6>
            <p class="text-secondary small mb-3" style="line-height: 1.6;">
                Aplikasi ini menerapkan metode <strong>Server-Side Caching</strong> untuk manajemen integrasi Web
                Service RajaOngkir.
            </p>
            <ul class="text-secondary small ps-3 mb-0" style="line-height: 1.6;">
                <li class="mb-1"><strong>Efisiensi Bandwidth:</strong> Query wilayah hanya dieksekusi sekali per
                    provinsi untuk memangkas redundansi *request*.</li>
                <li><strong>Akselerasi Performa:</strong> Pembacaan data kota berikutnya diambil langsung dari memori
                    lokal (Cache) guna mempercepat waktu respons UI.</li>
            </ul>
            <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between">
                <span class="text-muted"
                    style="font-size: 0.7rem; letter-spacing: 0.02em; text-transform: uppercase;">Status
                    Subsistem:</span>
                <div id="api_badge_status">
                    <span class="text-secondary fw-medium" style="font-size: 0.75rem;">
                        <i class="bi bi-hdd-network me-1"></i> Standby
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const apiBadgeStatus = document.getElementById('api_badge_status');

    provinceSelect.addEventListener('change', function () {
        const provinceId = this.value;
        if (!provinceId) return;

        citySelect.disabled = true;
        citySelect.innerHTML = '<option value="" selected disabled>Memuat data kota...</option>';
        apiBadgeStatus.innerHTML = '<span class="text-muted small">Mengecek cache/API...</span>';

        // Hit rute baru berdasarkan id provinsi terpilih
        fetch(`/bookings/getCitiesByProvince?province_id=${provinceId}`)
            .then(response => response.json())
            .then(res => {
                if (res.status === 200 && res.data) {
                    citySelect.innerHTML = '<option value="" selected disabled>Pilih Kota</option>';

                    // Tampilkan indikator resource
                    apiBadgeStatus.innerHTML = `<span class="text-secondary" style="font-size: 0.75rem; letter-spacing: 0.02em;">
                                                    <i class="bi bi-cpu-fill me-1"></i> Data core: <span class="fw-semibold text-dark">${res.source.toUpperCase()}</span>
                                                </span>`;

                    res.data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id || item.value;
                        option.textContent = item.label || item.destination_name;
                        citySelect.appendChild(option);
                    });

                    citySelect.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                citySelect.innerHTML = '<option value="" selected disabled>Gagal memuat kota</option>';
            });
    });
</script>
<?= $this->endSection() ?>