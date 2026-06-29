<!DOCTYPE html>
<html>

<head>
    <title>Booking Laundry</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- MIDTRANS SNAP -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?= getenv('MIDTRANS_CLIENT_KEY') ?: 'SB-Mid-client-XXXXXXXXXXXXXXXXXXXXXXXX' ?>"></script>

</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">

            <a class="navbar-brand" href="/dashboard">
                <i class="bi bi-bucket"></i> Laundry App
            </a>

            <!-- Toggle button for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>

                    <!-- MENU ADMIN -->
                    <?php if (session()->get('role') == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/services">
                                <i class="bi bi-gear"></i> Layanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/schedules">
                                <i class="bi bi-calendar3"></i> Jadwal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/users">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- MENU SEMUA ROLE -->
                    <li class="nav-item">
                        <a class="nav-link" href="/bookings">
                            <i class="bi bi-cart3"></i> Booking
                        </a>
                    </li>

                </ul>

                <!-- USER INFO & LOGOUT -->
                <div class="d-flex align-items-center">
                    <span class="text-white me-2">
                        <i class="bi bi-person-circle"></i> <?= esc((string) session()->get('name')) ?>
                    </span>
                    <span class="badge bg-info me-3"><?= ucfirst((string) session()->get('role')) ?></span>

                    <a href="/logout" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>

        </div>
    </nav>

    <div class="container mt-4">

        <!-- ALERT SUCCESS -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- ALERT ERROR -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>