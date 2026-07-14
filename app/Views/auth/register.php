<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
    body {
        background: linear-gradient(135deg, #36b9cc, #f6c23e);
    }

    .register-card {
        max-width: 400px;
        margin: 80px auto;
        border-radius: 15px;
    }
</style>

<div class="card register-card shadow-lg p-4">

    <h3 class="text-center mb-2">Register</h3>
    <p class="text-center text-muted mb-4">Buat akun baru</p>

    <!-- ALERT -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('register') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-success w-100 mb-2">Register</button>

        <p class="text-center">
            Sudah punya akun?
            <a href="/login">Login</a>
        </p>

    </form>
</div>

<?= $this->endSection() ?>