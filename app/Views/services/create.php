<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Tambah Layanan</h5>
    </div>

    <div class="card-body">

        <!-- ALERT ERROR -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/services/store">
            
            <div class="mb-3">
                <label class="form-label">Nama Layanan</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama layanan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" placeholder="Masukkan harga" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/services" class="btn btn-secondary">← Kembali</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>