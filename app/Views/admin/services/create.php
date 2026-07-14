<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="/services" class="btn btn-sm btn-light border text-secondary mb-2 d-inline-flex align-items-center gap-1">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h4 class="fw-bold text-dark mb-1">Tambah Layanan Baru</h4>
    <p class="text-secondary small mb-0">Masukkan data layanan laundry baru dengan benar dan teliti.</p>
</div>

<div class="row">
    <div class="col-12 col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="<?= base_url('services/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label small fw-semibold text-secondary">Nama Layanan</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Contoh: Cuci Kering Ekspres" required>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="duration" class="form-label small fw-semibold text-secondary">Durasi Pengerjaan
                                (Menit)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="duration" name="duration"
                                    placeholder="Contoh: 120" required>
                                <span class="input-group-text bg-light text-secondary small">Menit</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="price" class="form-label small fw-semibold text-secondary">Harga
                                (Rupiah)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary small">Rp</span>
                                <input type="number" class="form-control" id="price" name="price"
                                    placeholder="Contoh: 15000" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label small fw-semibold text-secondary">Deskripsi
                            Layanan</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Tuliskan keterangan mengenai layanan ini jika ada..."></textarea>
                    </div>

                    <!-- Tombol Solid dengan Sudut Membulat Kecil Standar -->
                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <button type="reset" class="btn btn-light border text-secondary px-4">Reset</button>
                        <button type="submit" class="btn btn-primary px-4 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-check-lg"></i> Simpan Layanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>