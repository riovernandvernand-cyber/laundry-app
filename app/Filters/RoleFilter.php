<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Filter proteksi route berdasarkan role user
     * Penggunaan di Routes: ['filter' => 'role:admin'] atau ['filter' => 'role:admin,staff']
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek login terlebih dahulu
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // 2. Ambil role user dari session
        $userRole = session()->get('role');

        // 3. Jika route punya batasan role (arguments dari Routes.php)
        if (!empty($arguments)) {
            // arguments = ['admin', 'staff'] dari 'role:admin,staff'
            if (!in_array($userRole, $arguments)) {
                // Log akses ditolak untuk audit
                log_message('warning', 'AKSES DITOLAK: User ID=' . session()->get('user_id')
                    . ' Role=' . $userRole
                    . ' mencoba akses: ' . current_url());

                return redirect()->to('/dashboard')
                    ->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk halaman tersebut.');
            }
        }

        // Lanjut jika role sesuai
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak digunakan
    }
}