<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Manajemen Layanan</h4>
        <p class="text-secondary small mb-0">Kelola daftar jenis jasa laundry, harga, dan durasi pengerjaan.</p>
    </div>
    <a href="/services/create" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Layanan
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary text-uppercase small"
                    style="font-size: 0.75rem; letter-spacing: 0.05em;">
                    <tr>
                        <th class="py-3 px-4">Nama Layanan</th>
                        <th class="py-3">Durasi</th>
                        <th class="py-3">Harga</th>
                        <th class="py-3 text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (!empty($services) && is_array($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td class="py-3 px-4">
                                    <div class="fw-semibold text-dark"><?= esc($service['name']) ?></div>
                                    <div class="text-secondary small"><?= esc($service['description'] ?? '-') ?></div>
                                </td>
                                <td class="py-3 text-secondary">
                                    <i class="bi bi-clock me-1"></i> <?= esc($service['duration']) ?> Menit
                                </td>
                                <td class="py-3 fw-medium text-dark">
                                    Rp <?= number_format($service['price'], 0, ',', '.') ?>
                                </td>
                                <td class="py-3 text-end px-4">
                                    <!-- Gaya Tombol Flat & Modern (Menggunakan Gap dan Outline) -->
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="/services/edit/<?= $service['id'] ?>"
                                            class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1 px-3">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <a href="/services/delete/<?= $service['id'] ?>"
                                            class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1 px-3"
                                            onclick="return confirm('Apakah kamu yakin ingin menghapus layanan ini?')">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-secondary">
                                <i class="bi bi-inbox display-6 d-block mb-2 text-muted"></i>
                                Belum ada data layanan yang tersedia.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>