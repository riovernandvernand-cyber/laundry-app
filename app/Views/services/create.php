<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Tambah Layanan Laundry Baru</h5>
        </div>
        <div class="card-body">
            <!-- Atribut enctype wajib ada untuk handle upload file foto -->
            <form action="/services/store" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Input Nama Layanan -->
                <div class="mb-3">
                    <label for="nama_layanan" class="form-label">Nama Layanan</label>
                    <input type="text" class="form-control <?= (session('errors.nama_layanan')) ? 'is-invalid' : '' ?>"
                        id="nama_layanan" name="nama_layanan" value="<?= old('nama_layanan') ?>"
                        placeholder="Contoh: Cuci Kering Setrika">
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
                        id="harga" name="harga" value="<?= old('harga') ?>" placeholder="Contoh: 7000">
                    <?php if (session('errors.harga')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.harga') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Input File Foto -->
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Banner Layanan</label>
                    <input type="file" class="form-control <?= (session('errors.foto')) ? 'is-invalid' : '' ?>"
                        id="foto" name="foto">
                    <?php if (session('errors.foto')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.foto') ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-text">Format: JPG, JPEG, PNG. Maksimal ukuran file 2MB.</div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/services" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Layanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>