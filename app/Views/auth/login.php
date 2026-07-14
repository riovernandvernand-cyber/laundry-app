<!DOCTYPE html>
<html>

<head>
    <title>Login - Laundry App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        background: linear-gradient(135deg, #4e73df, #1cc88a);
        height: 100vh;
    }

    /* CARD */
    .card-login {
        max-width: 400px;
        margin: auto;
        margin-top: 100px;
        border-radius: 15px;
    }

    /* BUTTON HOVER */
    .btn-primary:hover {
        transform: scale(1.02);
    }
</style>

<body>

    <div class="card card-login shadow-lg p-4">

        <!-- 🔥 LOGO -->
        <h3 class="text-center fw-bold">🧺 Laundry App</h3>
        <p class="text-center text-muted mb-4">Login ke akun anda</p>

        <!-- ALERT -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <!-- EMAIL -->
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control shadow-sm" required>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control shadow-sm" required>
            </div>

            <!-- BUTTON -->
            <button class="btn btn-primary w-100 mb-2" style="transition:0.3s;">
                Login
            </button>

            <!-- LINK -->
            <p class="text-center">
                Belum punya akun?
                <a href="/register">Register</a>
            </p>

        </form>

    </div>

</body>

</html>