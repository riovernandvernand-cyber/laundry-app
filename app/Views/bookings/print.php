<!DOCTYPE html>
<html>
<head>
    <title>Struk Laundry</title>
    <style>
        body { font-family: Arial; text-align:center; }
        .box { border:1px dashed #000; width:300px; margin:auto; padding:15px; }
    </style>
</head>
<body onload="window.print()">

<div class="box">
    <h3>LAUNDRY APP</h3>
    <hr>

    <p>ID: <?= $booking['id'] ?></p>
    <p>Total: Rp <?= number_format($booking['total']) ?></p>
    <p>Status: <?= ucfirst($booking['status']) ?></p>
    <p>Tanggal: <?= $booking['booking_date'] ?></p>

    <hr>
    <p>Terima kasih 🙏</p>
</div>

</body>
</html>