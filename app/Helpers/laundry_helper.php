<?php

if (!function_exists('format_rupiah')) {
  function format_rupiah(int $angka): string
  {
    return 'Rp ' . number_format($angka, 0, ',', '.');
  }
}

if (!function_exists('get_badge_status')) {
  function get_badge_status(string $status): string
  {
    switch ($status) {
      case 'pending':
        return '<span class="badge bg-secondary">Pending</span>';
      case 'confirmed':
        return '<span class="badge bg-info">Dikonfirmasi</span>';
      case 'processing':
        return '<span class="badge bg-primary">Diproses</span>';
      case 'done':
        return '<span class="badge bg-success">Selesai</span>';
      case 'cancelled':
        return '<span class="badge bg-danger">Dibatalkan</span>';
      default:
        return '<span class="badge bg-dark">Unknown</span>';
    }
  }
}