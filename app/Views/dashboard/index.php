<?php
/**
 * @var string $role
 * @var int $totalBooking
 * @var int|float $totalIncome
 * @var array|null $popularService
 * @var array $recentBookings
 */
?>

<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <!-- ALERT -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <h4>👋 Halo, <?= session()->get('name') ?></h4>

    <!-- CARD -->
    <div class="row mt-4">

        <!-- TOTAL BOOKING -->
        <div class="col-md-4">
            <div class="card bg-primary text-white p-3 shadow-sm">
                <h6>Total Booking</h6>
                <h3><?= $totalBooking ?></h3>
            </div>
        </div>

        <!-- TOTAL INCOME -->
        <?php if ($role == 'admin'): ?>
            <div class="col-md-4">
                <div class="card bg-success text-white p-3 shadow-sm">
                    <h6>Total Pendapatan</h6>
                    <h3>Rp <?= number_format($totalIncome, 0, ',', '.') ?></h3>
                </div>
            </div>
        <?php endif; ?>

        <!-- LAYANAN TERPOPULER -->
        <?php if ($role == 'admin'): ?>
            <div class="col-md-4">
                <div class="card bg-warning text-dark p-3 shadow-sm">
                    <h6>Layanan Terpopuler</h6>
                    <h4><?= $popularService['name'] ?? '-' ?></h4>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- TABLE -->
    <div class="card mt-4 p-3 shadow-sm">

        <h5>
            <?= ($role != 'pelanggan') ? '📋 Semua Booking' : '📋 Booking Saya' ?>
        </h5>

        <table class="table table-bordered mt-3">

            <thead class="table-dark">
                <tr>

                    <th>Layanan</th>

                    <?php if ($role != 'pelanggan'): ?>
                        <th>Pelanggan</th>
                    <?php endif; ?>

                    <th>Tanggal</th>
                    <th>Status</th>

                    <?php if ($role != 'pelanggan'): ?>
                        <th>Aksi</th>
                    <?php endif; ?>

                </tr>
            </thead>

            <tbody>

                <?php if (!empty($recentBookings)): ?>

                    <?php foreach ($recentBookings as $b): ?>

                        <tr>

                            <!-- LAYANAN -->
                            <td>
                                <?= esc($b['service_name'] ?? '-') ?>
                            </td>

                            <!-- PELANGGAN -->
                            <?php if ($role != 'pelanggan'): ?>
                                <td>
                                    <?= esc($b['user_name'] ?? '-') ?>
                                </td>
                            <?php endif; ?>

                            <!-- TANGGAL -->
                            <td>
                                <?= esc($b['date'] ?? '-') ?>
                            </td>

                            <!-- STATUS -->
                            <td>

                                <?php if (($b['laundry_status'] ?? '') == 'pending'): ?>

                                    <span class="badge bg-secondary">
                                        Pending
                                    </span>

                                <?php elseif (($b['laundry_status'] ?? '') == 'confirmed'): ?>

                                    <span class="badge bg-info">
                                        Dikonfirmasi
                                    </span>

                                <?php elseif (($b['laundry_status'] ?? '') == 'processing'): ?>

                                    <span class="badge bg-primary">
                                        Diproses
                                    </span>

                                <?php elseif (($b['laundry_status'] ?? '') == 'done'): ?>

                                    <span class="badge bg-success">
                                        Selesai
                                    </span>

                                <?php elseif (($b['laundry_status'] ?? '') == 'cancelled'): ?>

                                    <span class="badge bg-danger">
                                        Dibatalkan
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-dark">
                                        Unknown
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- AKSI -->
                            <?php if ($role != 'pelanggan'): ?>

                                <td>

                                    <!-- PENDING -->
                                    <?php if (($b['laundry_status'] ?? '') == 'pending'): ?>

                                        <a href="/bookings/approve/<?= $b['id'] ?>" class="btn btn-sm btn-info"
                                            onclick="return confirm('Approve booking ini?')">
                                            Approve
                                        </a>

                                        <a href="/bookings/reject/<?= $b['id'] ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Reject booking ini?')">
                                            Reject
                                        </a>





                                        <!-- CONFIRMED -->
                                    <?php elseif (($b['laundry_status'] ?? '') == 'confirmed'): ?>

                                        <a href="/bookings/process/<?= $b['id'] ?>" class="btn btn-sm btn-primary"
                                            onclick="return confirm('Proses laundry ini?')">
                                            Proses
                                        </a>





                                        <!-- PROCESSING -->
                                    <?php elseif (($b['laundry_status'] ?? '') == 'processing'): ?>

                                        <a href="/bookings/done/<?= $b['id'] ?>" class="btn btn-sm btn-success"
                                            onclick="return confirm('Selesaikan laundry ini?')">
                                            Selesai
                                        </a>





                                        <!-- DONE -->
                                    <?php elseif (($b['laundry_status'] ?? '') == 'done'): ?>

                                        <span class="badge bg-success">
                                            ✔ Sudah selesai
                                        </span>





                                        <!-- CANCELLED -->
                                    <?php elseif (($b['laundry_status'] ?? '') == 'cancelled'): ?>

                                        <span class="badge bg-danger">
                                            Booking dibatalkan
                                        </span>

                                    <?php endif; ?>

                                </td>

                            <?php endif; ?>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="5" class="text-center text-muted">
                            Belum ada data booking
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?= $this->endSection() ?>