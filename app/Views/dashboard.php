<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h3 class="mb-4">📊 Dashboard Laundry</h3>

<div class="row">

    <!-- Total Layanan -->
    <div class="col-md-4 mb-3">
        <div class="card shadow border-0 text-center">
            <div class="card-body">
                <h6 class="text-muted">Total Layanan</h6>
                <h2><?= $totalServices ?></h2>
            </div>
        </div>
    </div>

    <!-- Total Booking -->
    <div class="col-md-4 mb-3">
        <div class="card shadow border-0 text-center">
            <div class="card-body">
                <h6 class="text-muted">Total Booking</h6>
                <h2><?= $totalBookings ?></h2>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan -->
    <div class="col-md-4 mb-3">
        <div class="card shadow border-0 text-center bg-success text-white">
            <div class="card-body">
                <h6>Total Pendapatan</h6>
                <h2>Rp <?= number_format($totalIncome) ?></h2>
            </div>
        </div>
    </div>

</div>

<!-- 🔥 TAMBAHAN BIAR LEBIH KEREN -->
<div class="row mt-3">

    <div class="col-md-6 mb-3">
        <div class="card shadow border-0">
            <div class="card-body text-center">
                <h6 class="text-muted">Status Booking</h6>
                <p class="mb-1">Pending: <b><?= $pending ?? 0 ?></b></p>
                <p class="mb-1">Diproses: <b><?= $processing ?? 0 ?></b></p>
                <p class="mb-1">Selesai: <b><?= $done ?? 0 ?></b></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card shadow border-0">
            <div class="card-body text-center">
                <h6 class="text-muted">Menu Cepat</h6>
                <a href="/bookings" class="btn btn-primary btn-sm mb-1">Kelola Booking</a>
                <a href="/services" class="btn btn-secondary btn-sm mb-1">Kelola Layanan</a>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>