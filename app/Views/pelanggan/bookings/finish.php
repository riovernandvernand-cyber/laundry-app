<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow p-4 text-center">

    <h3 class="mb-4">Hasil Pembayaran</h3>

    <?php if ($status == 'settlement' || $status == 'capture'): ?>
        <h4 class="text-success">✅ Pembayaran Berhasil</h4>

    <?php elseif ($status == 'pending'): ?>
        <h4 class="text-warning">⏳ Menunggu Pembayaran</h4>

    <?php else: ?>
        <h4 class="text-danger">❌ Pembayaran Gagal</h4>
    <?php endif; ?>

    <p class="mt-3"><strong>Order ID:</strong> <?= $order_id ?></p>
    <p><strong>Status:</strong> <?= $status ?></p>

    <a href="/bookings" class="btn btn-primary mt-3">
        ← Kembali ke Booking
    </a>

</div>

<?= $this->endSection() ?>