<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 🔥 Ambil path sekarang (login, dashboard, dll)
        $uri = service('uri')->getPath();

        // 🔥 HALAMAN YANG BOLEH TANPA LOGIN
        $allow = [
            'login',
            'register',
            'api/services',
            'api/booking-status'
        ];

        if (in_array($uri, $allow)) {
            return;
        }

        // 🔒 CEK SESSION LOGIN
        if (!session()->get('logged_in')) {

            // simpan tujuan sebelumnya
            session()->set('redirect_url', current_url());

            return redirect()->to('/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak digunakan
    }
}