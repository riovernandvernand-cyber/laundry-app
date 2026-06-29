<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h4>Data Jadwal</h4>

<a href="/schedules/create" class="btn btn-primary mb-2">+ Tambah</a>

<table class="table table-bordered">
    <tr>
        <th>Layanan</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Kapasitas</th>
    </tr>

    <?php foreach ($schedules as $s): ?>
        <tr>
            <td><?= $s['name'] ?></td>
            <td><?= $s['date'] ?></td>
            <td><?= $s['time'] ?></td>
            <td><?= $s['capacity'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>