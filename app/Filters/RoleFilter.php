<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 🔒 1. Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // 🔒 2. Ambil role user dari session
        $userRole = session()->get('role');

        // 🔥 3. Jika route punya batasan role
        if (!empty($arguments)) {

            // arguments = ['admin', 'staff']
            if (!in_array($userRole, $arguments)) {

                // ❌ akses ditolak
                return redirect()->to('/dashboard')
                    ->with('error', 'Akses ditolak! Role tidak diizinkan');
            }
        }

        // ✅ lanjut jika lolos
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak digunakan
    }
}