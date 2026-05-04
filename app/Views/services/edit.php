<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Edit Layanan</h5>
    </div>

    <div class="card-body">

        <!-- ALERT ERROR -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/services/update/<?= $service['id']; ?>">
            
            <div class="mb-3">
                <label class="form-label">Nama Layanan</label>
                <input type="text" name="name" class="form-control" value="<?= $service['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" value="<?= $service['price']; ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/services" class="btn btn-secondary">← Kembali</a>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>

        </form>

    </div>
</div>

<?= $this->endSection() ?>