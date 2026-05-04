<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laundry App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- 🔥 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">🧺 Laundry App</a>

        <div>
            <a href="/dashboard" class="btn btn-sm btn-outline-light">Dashboard</a>
            <a href="/bookings" class="btn btn-sm btn-outline-light">Booking</a>
            <a href="/logout" class="btn btn-sm btn-danger">Logout</a>
        </div>
    </div>
</nav>

<!-- 🔥 CONTENT -->
<div class="container mt-4">
    <?= $this->renderSection('content') ?>
</div>

</body>
</html>