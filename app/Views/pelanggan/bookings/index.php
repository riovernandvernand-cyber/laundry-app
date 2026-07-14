<?php
/**
 * @var string $role
 * @var array $bookings
 * @var \CodeIgniter\Pager\Pager $pager
 * @var string|null $status
 * @var string|null $date
 */
?>

<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .form-select,
    .form-control {
        border-color: #e2e8f0;
        transition: all 0.2s ease;
    }

    .form-select:focus,
    .form-control:focus {
        border-color: #1e3a8a;
        box-shadow: none;
    }

    .table> :not(caption)>*>* {
        padding: 0.9rem 0.8rem;
        vertical-align: middle;
    }

    .badge-status {
        font-weight: 600;
        padding: 0.4em 0.7em;
        border-radius: 6px;
        font-size: 0.75rem;
        display: inline-block;
    }
</style>

<!-- HEADER UTAMA -->
<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h4 class="fw-bold text-dark mb-1">📦 Data Antrean Booking</h4>
        <p class="text-secondary small mb-0">Memantau dan mengelola riwayat transaksi cucian secara realtime.</p>
    </div>

    <?php if ($role === 'pelanggan'): ?>
        <div>
            <a href="/bookings/create"
                class="btn btn-primary px-4 d-inline-flex align-items-center gap-2 shadow-sm rounded-3 fw-semibold">
                <i class="bi bi-calendar-plus"></i> + Booking Sekarang
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- NOTIFIKASI SUKSES -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill text-success fs-5"></i>
        <div class="small text-dark fw-medium"><?= session()->getFlashdata('success') ?></div>
    </div>
<?php endif; ?>

<!-- AREA FILTER (KHUSUS ADMIN) -->
<?php if ($role === 'admin'): ?>
    <div class="card border-0 shadow-sm p-3 mb-4 bg-white rounded-3">
        <form method="get" class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
                <select name="status" class="form-select rounded-3 text-secondary small">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= ($status === 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="confirmed" <?= ($status === 'confirmed') ? 'selected' : '' ?>>Dikonfirmasi</option>
                    <option value="processing" <?= ($status === 'processing') ? 'selected' : '' ?>>Diproses</option>
                    <option value="done" <?= ($status === 'done') ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <input type="date" name="date" value="<?= esc($date ?? '') ?>"
                    class="form-control rounded-3 text-secondary small">
            </div>
            <div class="col-12 col-md-4">
                <button type="submit" class="btn btn-dark w-100 rounded-3">
                    <i class="bi bi-funnel"></i> Aplikasikan Filter
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<!-- TABEL UTAMA -->
<div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="ps-4">Layanan</th>
                    <?php if ($role !== 'pelanggan'): ?>
                        <th>Pelanggan</th>
                    <?php endif; ?>
                    <th>Waktu Masuk</th>
                    <th>Berat</th>
                    <th>Total Biaya</th>
                    <th>Pembayaran</th>
                    <th>Status Laundry</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-dark small">
                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada riwayat data booking terdaftar.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bookings as $b): ?>
                        <tr>
                            <td class="ps-4 fw-semibold text-dark"><?= esc($b['service_name']) ?></td>

                            <?php if ($role !== 'pelanggan'): ?>
                                <td>
                                    <div class="fw-medium text-dark"><?= esc((string) $b['user_name']) ?></div>
                                </td>
                            <?php endif; ?>

                            <td>
                                <div class="fw-medium"><?= esc($b['date'] ?? '-') ?></div>
                                <div class="text-muted" style="font-size: 0.75rem;"><?= esc($b['time'] ?? '-') ?> WIB</div>
                            </td>

                            <td class="fw-medium"><?= esc($b['weight']) ?> kg</td>

                            <td>
                                <?= format_rupiah((int) $b['total']) ?>
                                <!-- class="text-dark fw-bold">Rp <?= number_format($b['total'], 0, ',', '.') ?> -->

                            </td>

                            <td>
                                <?php
                                // Asumsi di helper kamu menambahkan fungsi pembantu get_badge_payment()
                                // Jika belum, kamu bisa memakai fungsi custom/kondisi bawaan helper
                                $p_status = $b['payment_status'] ?? '';
                                if ($p_status === 'paid') {
                                    echo '<span class="badge-status bg-success-subtle text-success">Lunas</span>';
                                } elseif ($p_status === 'failed') {
                                    echo '<span class="badge-status bg-danger-subtle text-danger">Gagal</span>';
                                } else {
                                    echo '<span class="badge-status bg-warning-subtle text-warning">Belum Bayar</span>';
                                }
                                ?>
                            </td>

                            <td>
                                <?= get_badge_status($b['laundry_status'] ?? 'pending') ?>
                            </td>

                            <td class="pe-4 text-end">
                                <div class="d-inline-flex gap-1">
                                    <?php if ($role === 'pelanggan'): ?>
                                        <?php if (($b['payment_status'] ?? '') !== 'paid'): ?>
                                            <a href="/bookings/pay/<?= $b['id'] ?>" class="btn btn-sm btn-success rounded-2 px-2 py-1"
                                                style="font-size: 0.75rem;">Bayar</a>
                                        <?php endif; ?>

                                    <?php elseif ($role === 'admin'): ?>
                                        <?php $lst = $b['laundry_status'] ?? 'pending'; ?>
                                        <?php if ($lst === 'pending'): ?>
                                            <a href="/bookings/approve/<?= $b['id'] ?>"
                                                class="btn btn-sm btn-info text-white rounded-2 px-2 py-1"
                                                style="font-size: 0.75rem;">Approve</a>
                                            <a href="/bookings/reject/<?= $b['id'] ?>"
                                                class="btn btn-sm btn-light border rounded-2 px-2 py-1"
                                                style="font-size: 0.75rem;">Reject</a>
                                        <?php elseif ($lst === 'confirmed'): ?>
                                            <a href="/bookings/process/<?= $b['id'] ?>"
                                                class="btn btn-sm btn-primary rounded-2 px-2 py-1"
                                                style="font-size: 0.75rem;">Proses</a>
                                        <?php elseif ($lst === 'processing'): ?>
                                            <a href="/bookings/done/<?= $b['id'] ?>" class="btn btn-sm btn-success rounded-2 px-2 py-1"
                                                style="font-size: 0.75rem;">Selesai</a>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <?php if (($b['laundry_status'] ?? 'pending') === 'processing'): ?>
                                            <a href="/bookings/done/<?= $b['id'] ?>" class="btn btn-sm btn-success rounded-2 px-2 py-1"
                                                style="font-size: 0.75rem;">Selesai</a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <a href="/bookings/print/<?= $b['id'] ?>"
                                        class="btn btn-sm btn-light border rounded-2 px-2 py-1" style="font-size: 0.75rem;"><i
                                            class="bi bi-printer"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- PAGINATION CLUSTER -->
<div class="d-flex flex-column align-items-center mt-4 mb-5">
    <div>
        <?= $pager->links('default', 'bootstrap') ?>
    </div>
    <p class="text-muted mt-2" style="font-size: 0.75rem;">
        Menampilkan Halaman <?= $pager->getCurrentPage() ?> dari <?= $pager->getPageCount() ?>
    </p>
</div>

<?= $this->endSection() ?>