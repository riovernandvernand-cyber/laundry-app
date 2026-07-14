<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laundry App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
            /* Abu-abu tipis untuk kontras card */
            color: #212529;
            letter-spacing: -0.01em;
        }

        .navbar {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e9ecef;
        }

        .navbar-brand {
            color: #1e3a8a !important;
            font-weight: 700;
        }

        .nav-link {
            color: #495057 !important;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #1e3a8a !important;
        }

        .card {
            border: 1px solid #e9ecef !important;
            border-radius: 12px !important;
        }

        .btn {
            font-weight: 500;
            border-radius: 8px !important;
            padding: 0.5rem 1rem;
        }

        .btn-primary {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }

        .btn-primary:hover {
            background-color: #172554;
            border-color: #172554;
        }
    </style>
</head>

<body>

    <!-- Navigasi Utama (Clean White Style) -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/dashboard">
                <span>Laundry App</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="/bookings" class="nav-link">Booking</a>
                    </li>

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

                    <?php if (session()->get('role') === 'staff'): ?>
                        <li class="nav-item">
                            <!-- MASALAHNYA DI SINI: href menembak ke /tasks, padahal rute kita /staff/tasks -->
                            <a href="/tasks" class="nav-link">Tugas Harian</a>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <span class="text-secondary small d-none d-lg-inline">
                        Halo, <strong><?= esc(session()->get('name') ?? 'User') ?></strong> (<span
                            class="badge bg-light text-dark border"><?= esc(ucfirst(session()->get('role') ?? 'guest')) ?></span>)
                    </span>
                    <a href="/logout" class="btn btn-sm btn-outline-danger px-3"
                        onclick="return confirm('Yakin ingin logout?')">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Notifikasi Sistem -->
    <div class="container mt-4">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Konten Halaman -->
    <div class="container mb-5 mt-2">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>