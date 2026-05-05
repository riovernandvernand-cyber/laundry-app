<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Filter sebelum request diproses
     * Cek apakah user sudah login via session
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek session login
        if (!session()->get('logged_in')) {
            // Simpan URL tujuan agar bisa redirect setelah login
            session()->set('redirect_url', current_url());

            return redirect()->to('/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user masih aktif (keamanan tambahan)
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('user_id'));

        if (!$user || $user['status'] == 0) {
            session()->destroy();
            return redirect()->to('/login')
                ->with('error', 'Akun Anda telah dinonaktifkan');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak digunakan
    }
}