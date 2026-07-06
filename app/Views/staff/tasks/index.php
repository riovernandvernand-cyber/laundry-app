<?php
/**
 * @var array $tasks
 * @var \CodeIgniter\Pager\Pager $pager
 */
?>

<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .task-card {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    transition: transform 0.2s ease, border-color 0.2s ease;
    background-color: #ffffff;
  }

  .task-card:hover {
    border-color: #cbd5e1;
  }

  .badge-status {
    font-weight: 600;
    padding: 0.4em 0.7em;
    border-radius: 6px;
    font-size: 0.75rem;
  }

  .info-label {
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
</style>

<!-- HEADER HALAMAN -->
<div class="mb-4">
  <h4 class="fw-bold text-dark mb-1">📋 Panel Tugas Operasional Staff</h4>
  <p class="text-secondary small mb-0">Daftar antrean cucian aktif yang sedang diproses. Perbarui status tugas secara
    realtime setelah pencucian selesai.</p>
</div>

<!-- NOTIFIKASI FLASH MESSAGES -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-2">
    <i class="bi bi-check-circle-fill text-success fs-5"></i>
    <div class="small text-dark fw-medium">
      <?= session()->getFlashdata('success') ?>
    </div>
  </div>
<?php endif; ?>

<!-- GRID TUGAS LAUNDRY -->
<div class="row g-3">
  <?php if (empty($tasks)): ?>
    <div class="col-12">
      <div class="card text-center p-5 border-0 bg-white rounded-3 shadow-sm">
        <i class="bi bi-clipboard-x text-muted fs-1 mb-2"></i>
        <h6 class="fw-semibold text-dark mb-1">Tidak Ada Tugas Aktif</h6>
        <p class="text-secondary small mb-0">Semua antrean cucian kosong atau sudah diselesaikan oleh tim staff.</p>
      </div>
    </div>
  <?php else: ?>
    <?php foreach ($tasks as $t): ?>
      <div class="col-12 col-md-6 col-xl-4">
        <div class="task-card p-4 d-flex flex-column h-100 justify-content-between">
          <div>
            <!-- Atas: ID & Status -->
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div>
                <span class="info-label">Order ID</span>
                <div class="fw-bold text-dark">#LND-
                  <?= esc($t['id']) ?>
                </div>
              </div>
              <span class="badge-status bg-primary-subtle text-primary">
                <i class="bi bi-arrow-repeat me-1"></i> Diproses
              </span>
            </div>

            <hr class="my-3 text-black-50" style="opacity: 0.1;">

            <!-- Tengah: Detail Cucian -->
            <div class="mb-2">
              <span class="info-label">Jenis Layanan</span>
              <div class="fw-semibold text-dark fs-6">
                <?= esc($t['service_name']) ?>
              </div>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-6">
                <span class="info-label">Berat Beban</span>
                <div class="fw-medium text-dark">
                  <?= esc($t['weight']) ?> kg
                </div>
              </div>
              <div class="col-6">
                <span class="info-label">Target Selesai</span>
                <div class="fw-medium text-dark">
                  <?= esc($t['date'] ?? date('Y-m-d')) ?>
                </div>
              </div>
            </div>

            <!-- Catatan Khusus/Alamat -->
            <?php if (!empty($t['note'])): ?>
              <div class="bg-light p-2 rounded-3 mb-3">
                <span class="info-label d-block mb-1"><i class="bi bi-sticky me-1"></i> Catatan/Alamat:</span>
                <p class="text-secondary small mb-0 text-truncate" style="max-width: 100%;">
                  <?= esc($t['note']) ?>
                </p>
              </div>
            <?php endif; ?>
          </div>

          <!-- Bawah: Tombol Aksi Kerja -->
          <div class="mt-3 pt-3 border-top d-flex gap-2">
            <a href="/bookings/print/<?= $t['id'] ?>" class="btn btn-sm btn-light border rounded-3 px-3 align-self-center"
              title="Cetak Struk">
              <i class="bi bi-printer text-secondary"></i>
            </a>
            <a href="/bookings/done/<?= $t['id'] ?>"
              class="btn btn-sm btn-success w-100 rounded-3 fw-semibold py-2 d-inline-flex align-items-center justify-content-center gap-2">
              <i class="bi bi-check2-all"></i> Tandai Selesai
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- PAGINATION -->
<?php if (!empty($tasks)): ?>
  <div class="d-flex flex-column align-items-center mt-4">
    <div>
      <?= $pager->links('default', 'bootstrap') ?>
    </div>
    <p class="text-muted mt-2" style="font-size: 0.75rem;">
      Menampilkan Halaman
      <?= $pager->getCurrentPage() ?> dari
      <?= $pager->getPageCount() ?>
    </p>
  </div>
<?php endif; ?>

<?= $this->endSection() ?>