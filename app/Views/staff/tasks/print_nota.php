<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Nota Laundry #LND-
    <?= $b['id'] ?>
  </title>
  <style>
    body {
      font-family: 'Courier New', Courier, monospace;
      font-size: 12px;
      color: #000;
      margin: 0;
      padding: 10px;
      width: 280px;
      /* Ukuran standar kertas struk thermal */
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .line {
      border-top: 1px dashed #000;
      margin: 8px 0;
    }

    .table-data {
      width: 100%;
      font-size: 11px;
    }

    .table-data td {
      padding: 2px 0;
      vertical-align: top;
    }

    @page {
      size: 58mm auto;
      /* Memaksa browser nge-lock ukuran lebar 58mm dan panjang kertas otomatis mengikuti panjang teks */
      margin: 0;
      /* Menghilangkan margin bawaan browser (Anti Header-Footer) */
    }

    @media print {
      body {
        width: 100%;
        padding: 0;
      }

      .no-print {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="text-center">
    <h3 style="margin: 0 0 4px 0;">LAUNDRY APP</h3>
    <p style="margin: 0; font-size: 10px;">Semarang, Indonesia</p>
    <p style="margin: 0; font-size: 10px;">Telp: 0812-xxxx-xxxx</p>
  </div>

  <div class="line"></div>

  <table class="table-data">
    <tr>
      <td>Nota ID</td>
      <td>: #LND-
        <?= esc($b['id']) ?>
      </td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>:
        <?= date('d/m/Y H:i', strtotime($b['created_at'])) ?>
      </td>
    </tr>
    <tr>
      <td>Pelanggan</td>
      <td>:
        <?= esc($b['customer_name']) ?>
      </td>
    </tr>
    <tr>
      <td>No. WA</td>
      <td>:
        <?= esc($b['customer_phone'] ?? '-') ?>
      </td>
    </tr>
  </table>

  <div class="line"></div>

  <table class="table-data">
    <tr>
      <td colspan="2"><strong>Detail Layanan:</strong></td>
    </tr>
    <tr>
      <td>
        <?= esc($b['service_name']) ?><br><small>
          <?= esc($b['weight']) ?> kg @ Rp
          <?= number_format($b['service_price'], 0, ',', '.') ?>
        </small>
      </td>
      <td class="text-right">Rp
        <?= number_format($b['total'], 0, ',', '.') ?>
      </td>
    </tr>
  </table>

  <div class="line"></div>

  <table class="table-data" style="font-weight: bold;">
    <tr>
      <td>TOTAL BAYAR</td>
      <td class="text-right">Rp
        <?= number_format($b['total'], 0, ',', '.') ?>
      </td>
    </tr>
    <tr>
      <td>STATUS</td>
      <td class="text-right">
        <?= strtoupper(esc($b['status'])) ?>
      </td>
    </tr>
  </table>

  <div class="line"></div>

  <div class="text-center" style="margin-top: 15px; font-size: 10px;">
    <p style="margin: 0;">Terima Kasih Atas Kepercayaan Anda</p>
    <p style="margin: 4px 0 0 0;">Pakaian Bersih, Mood Happy!</p>
  </div>

  <!-- SCRIPT AUTO PRINT & CLOSE -->
  <script>
    window.onload = function () {
      window.print();
      // Menutup jendela tab print otomatis setelah dialog print selesai (opsional)
      setTimeout(function () { window.close(); }, 500);
    }
  </script>
</body>

</html>