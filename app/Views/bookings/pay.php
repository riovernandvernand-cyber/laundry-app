<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Booking</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?= getenv('MIDTRANS_CLIENT_KEY') ?>"></script>

    <style>
        body {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-pay {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 40px;
            background: white;
            text-align: center;
            width: 400px;
        }

        .btn-pay {
            transition: 0.3s;
        }

        .btn-pay:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="card-pay">
    <h3 class="mb-3">💳 Pembayaran Booking</h3>
    <p class="text-muted">Klik tombol di bawah untuk melanjutkan pembayaran</p>

    <!-- DEBUG TOKEN -->
    <small class="text-muted d-block mb-3">
        Token: <?= substr($snapToken, 0, 20) ?>...
    </small>

    <button id="pay-button" class="btn btn-primary w-100 btn-pay">
        Bayar Sekarang
    </button>

    <a href="/bookings" class="btn btn-outline-secondary w-100 mt-2">
        Kembali
    </a>
</div>

<script>
document.getElementById('pay-button').onclick = function () {

    console.log("SNAP TOKEN:", "<?= $snapToken ?>");

    snap.pay('<?= $snapToken ?>', {

        onSuccess: function(result){
            alert("Pembayaran berhasil!");

            window.location.href =
                "/payment/finish?order_id=" + result.order_id +
                "&transaction_status=" + result.transaction_status;
        },

        onPending: function(result){
            alert("Menunggu pembayaran...");
        },

        onError: function(result){
            alert("Pembayaran gagal!");
            console.log(result);
        },

        onClose: function(){
            alert("Kamu menutup popup pembayaran");
        }

    });
};
</script>

</body>
</html>