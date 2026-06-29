<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-warning text-dark">
            <h5 class="card-title mb-0">Edit Data Layanan Laundry</h5>
        </div>
        <div class="card-body">
            <!-- Atribut enctype wajib ada untuk handle upload file foto -->
            <form action="/services/update/<?= $service['id'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Input Nama Layanan -->
                <div class="mb-3">
                    <label for="nama_layanan" class="form-label">Nama Layanan</label>
                    <input type="text" class="form-control <?= (session('errors.nama_layanan')) ? 'is-invalid' : '' ?>"
                        id="nama_layanan" name="nama_layanan"
                        value="<?= old('nama_layanan', $service['nama_layanan']) ?>">
                    <?php if (session('errors.nama_layanan')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.nama_layanan') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Input Harga -->
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" class="form-control <?= (session('errors.harga')) ? 'is-invalid' : '' ?>"
                        id="harga" name="harga" value="<?= old('harga', $service['harga']) ?>">
                    <?php if (session('errors.harga')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.harga') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Preview Foto Lama & Input Foto Baru -->
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Banner Layanan</label>

                    <!-- Menampilkan preview file foto yang saat ini terdaftar -->
                    <?php if (!empty($service['foto'])): ?>
                        <div class="mb-2">
                            <small class="text-muted d-block mb-1">Foto saat ini:</small>
                            <img src="/uploads/services/<?= $service['foto'] ?>" alt="Foto Layanan" class="img-thumbnail"
                                style="max-height: 150px;">
                        </div>
                    <?php endif; ?>

                    <input type="file" class="form-control <?= (session('errors.foto')) ? 'is-invalid' : '' ?>"
                        id="foto" name="foto">
                    <?php if (session('errors.foto')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.foto') ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-text text-danger">Kosongkan jika tidak ingin mengubah foto banner.</div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/services" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-warning text-dark">Perbarui Layanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>