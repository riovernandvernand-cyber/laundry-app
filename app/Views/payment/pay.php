<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?= env('MIDTRANS_CLIENT_KEY') ?>">
    </script>
</head>
<body>

<h2>Pembayaran</h2>

<button id="pay-button">Bayar Sekarang</button>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('<?= $snapToken ?>');
};
</script>

</body>
</html>