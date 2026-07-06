<?php /** @var array $users */ ?>
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-people"></i> Manajemen User</h3>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $i => $user): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc((string)$user['name']) ?></td>
                        <td><?= esc((string)$user['email']) ?></td>
                        <td>
                            <?php
                                $badgeClass = match($user['role']) {
                                    'admin'     => 'bg-danger',
                                    'staff'     => 'bg-warning text-dark',
                                    'pelanggan' => 'bg-primary',
                                    default     => 'bg-secondary',
                                };
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= ucfirst((string)$user['role']) ?></span>
                        </td>
                        <td>
                            <?php if ($user['status'] == 1): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <?php if ((int)$user['id'] !== (int)session()->get('user_id')): ?>
                                <a href="/users/toggle/<?= $user['id'] ?>"
                                   class="btn btn-sm <?= $user['status'] == 1 ? 'btn-outline-danger' : 'btn-outline-success' ?>"
                                   onclick="return confirm('Yakin ingin mengubah status user ini?')">
                                    <?php if ($user['status'] == 1): ?>
                                        <i class="bi bi-x-circle"></i> Nonaktifkan
                                    <?php else: ?>
                                        <i class="bi bi-check-circle"></i> Aktifkan
                                    <?php endif; ?>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
