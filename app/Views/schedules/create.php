<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h4>Tambah Jadwal</h4>

<form method="post" action="/schedules/store">

    <div class="mb-3">
        <label>Layanan</label>
        <select name="service_id" class="form-control">
            <?php foreach ($services as $s): ?>
                <option value="<?= $s['id'] ?>">
                    <?= $s['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Jam</label>
        <input type="time" name="time" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Kapasitas</label>
        <input type="number" name="capacity" class="form-control" required>
    </div>

    <button class="btn btn-success">Simpan</button>

</form>

<?= $this->endSection() ?>