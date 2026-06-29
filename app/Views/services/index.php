<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Layanan Laundry</h5>
        <a href="/services/create" class="btn btn-light btn-sm">+ Tambah</a>
    </div>

    <div class="card-body">

        <!-- 🔍 SEARCH -->
        <form method="get" class="mb-3">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Cari layanan...">
                <button class="btn btn-primary">Cari</button>
            </div>
        </form>

        <!-- ALERT -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($services)): ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($services as $s): ?>
                        <tr>
                            <td><?= $s['name']; ?></td>
                            <td>Rp <?= number_format($s['price'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="/services/edit/<?= $s['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="/services/delete/<?= $s['id']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">Belum ada data</div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>