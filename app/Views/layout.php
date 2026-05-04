<!DOCTYPE html>
<html>
<head>
    <title>Booking Laundry</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- 🔥 MIDTRANS SNAP (WAJIB) -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="ISI_CLIENT_KEY_KAMU_DI_SINI"></script>

</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">

    <a class="navbar-brand" href="/dashboard">
        <i class="bi bi-bucket"></i> Laundry App
    </a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">

            <li class="nav-item">
                <a class="nav-link" href="/dashboard">Dashboard</a>
            </li>

            <!-- 🔥 ROLE ADMIN -->
            <?php if(session()->get('role') == 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/services">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/schedules">Jadwal</a>
                </li>
            <?php endif; ?>

            <!-- 🔥 SEMUA USER -->
            <li class="nav-item">
                <a class="nav-link" href="/bookings">Booking</a>
            </li>

        </ul>
    </div>

    <!-- USER -->
    <div class="d-flex align-items-center">
        <span class="text-white me-3">
            <i class="bi bi-person-circle"></i> <?= session()->get('name') ?>
        </span>

        <a href="/logout" class="btn btn-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

  </div>
</nav>

<div class="container mt-4">

    <!-- ALERT GLOBAL -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>