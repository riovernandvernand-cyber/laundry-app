<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laundry App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons untuk kebutuhan ikon menu -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <!-- Kontainer Utama Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">Laundry App</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="/bookings" class="nav-link">Booking</a>
                    </li>

                    <!-- Filter Menu Khusus Admin -->
                    <?php if (session()->get('role') === 'admin'): ?>
                        <li class="nav-item">
                            <a href="/services" class="nav-link">Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a href="/schedules" class="nav-link">Jadwal</a>
                        </li>
                        <li class="nav-item">
                            <a href="/users" class="nav-link">Manajemen Users</a>
                        </li>
                    <?php endif; ?>

                    <!-- Filter Menu Khusus Staff atau Teknisi -->
                    <?php if (session()->get('role') === 'staff'): ?>
                        <li class="nav-item">
                            <a href="/tasks" class="nav-link">Tugas Harian</a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Informasi Sesi Pengguna dan Tombol Keluar -->
                <div class="d-flex align-items-center gap-3">
                    <span class="text-light small d-none d-lg-inline">
                        Halo, <strong><?= esc(session()->get('name') ?? 'User') ?></strong>
                        (<?= esc(ucfirst(session()->get('role') ?? 'guest')) ?>)
                    </span>
                    <a href="/logout" class="btn btn-sm btn-danger px-3"
                        onclick="return confirm('Yakin ingin logout?')">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Tampilan Pesan Flashdata -->
    <div class="container mt-3">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Konten Dinamis Halaman -->
    <div class="container mb-5">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap Bundle JS untuk interaksi komponen -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>