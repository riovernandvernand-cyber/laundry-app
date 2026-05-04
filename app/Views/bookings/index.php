<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <h4 class="mb-4">📦 Data Booking</h4>

    <!-- FILTER (ADMIN ONLY) -->
    <?php if ($role == 'admin'): ?>
    <form method="get" class="row mb-3">
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="process">Diproses</option>
                <option value="done">Selesai</option>
            </select>
        </div>

        <div class="col-md-3">
            <input type="date" name="date" class="form-control">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>
    <?php endif; ?>

    <!-- BUTTON USER -->
    <?php if ($role == 'pelanggan'): ?>
        <div class="mb-3 text-end">
            <a href="/bookings/create" class="btn btn-primary">
                + Booking Sekarang
            </a>
        </div>
    <?php endif; ?>

    <!-- TABLE -->
    <div class="card p-3">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Berat</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Laundry</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><?= $b['service_name'] ?></td>
                        <td><?= $b['date'] ?></td>
                        <td><?= $b['time'] ?></td>
                        <td><?= $b['weight'] ?> kg</td>
                        <td class="text-success fw-bold">
                            Rp <?= number_format($b['total'], 0, ',', '.') ?>
                        </td>

                        <!-- PAYMENT -->
                        <td>
                            <?php if ($b['payment_status'] == 'confirmed'): ?>
                                <span class="badge bg-success">Lunas</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Belum</span>
                            <?php endif; ?>
                        </td>

                        <!-- LAUNDRY -->
                        <td>
                            <?php if ($b['laundry_status'] == 'done'): ?>
                                <span class="badge bg-success">Selesai</span>
                            <?php elseif ($b['laundry_status'] == 'process'): ?>
                                <span class="badge bg-primary">Diproses</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Pending</span>
                            <?php endif; ?>
                        </td>

                        <!-- AKSI -->
                        <td>

                            <!-- USER -->
                            <?php if ($role == 'pelanggan'): ?>

                                <?php if ($b['payment_status'] != 'confirmed'): ?>
                                    <a href="/bookings/pay/<?= $b['id'] ?>"
                                       class="btn btn-sm btn-success">
                                       Bayar
                                    </a>
                                <?php endif; ?>

                                <a href="/bookings/print/<?= $b['id'] ?>"
                                   class="btn btn-sm btn-dark">
                                   Struk
                                </a>

                            <!-- ADMIN -->
                            <?php elseif ($role == 'admin'): ?>

                                <!-- APPROVE / REJECT (WAJIB DOSEN) -->
                                <?php if ($b['laundry_status'] == 'pending'): ?>
                                    <a href="/bookings/approve/<?= $b['id'] ?>"
                                       class="btn btn-sm btn-info">
                                       Approve
                                    </a>

                                    <a href="/bookings/reject/<?= $b['id'] ?>"
                                       class="btn btn-sm btn-danger">
                                       Reject
                                    </a>
                                <?php endif; ?>

                                <!-- PROCESS -->
                                <?php if ($b['laundry_status'] == 'process'): ?>
                                    <a href="/bookings/done/<?= $b['id'] ?>"
                                       class="btn btn-sm btn-success">
                                       Selesai
                                    </a>
                                <?php endif; ?>

                                <a href="/bookings/print/<?= $b['id'] ?>"
                                   class="btn btn-sm btn-dark">
                                   Struk
                                </a>

                            <!-- STAFF -->
                            <?php else: ?>

                                <?php if ($b['laundry_status'] != 'done'): ?>
                                    <a href="/bookings/process/<?= $b['id'] ?>"
                                       class="btn btn-sm btn-primary">
                                       Proses
                                    </a>

                                    <a href="/bookings/done/<?= $b['id'] ?>"
                                       class="btn btn-sm btn-success">
                                       Selesai
                                    </a>
                                <?php endif; ?>

                                <a href="/bookings/print/<?= $b['id'] ?>"
                                   class="btn btn-sm btn-dark">
                                   Struk
                                </a>

                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-center mt-4">
            <?= $pager->links('default', 'bootstrap') ?>
        </div>

        <p class="text-center text-muted mt-2">
            Halaman <?= $pager->getCurrentPage() ?> dari <?= $pager->getPageCount() ?>
        </p>

    </div>

</div>

<?= $this->endSection() ?>