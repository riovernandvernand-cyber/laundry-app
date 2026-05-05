<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    // ======================
    // LOGIN PAGE
    // ======================
    public function login()
    {
        return view('auth/login');
    }

    // ======================
    // PROSES LOGIN
    // ======================
    public function attemptLogin()
    {
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $pass  = $this->request->getPost('password');

        // Validasi input
        if (!$this->validate([
            'email'    => 'required|valid_email',
            'password' => 'required',
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email dan password harus diisi dengan benar');
        }

        // Cari user berdasarkan email
        $user = $model->findByEmail($email);

        // Cek user ditemukan
        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email tidak terdaftar');
        }

        // Cek password
        if (!password_verify($pass, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password salah');
        }

        // Cek status aktif
        if ($user['status'] == 0) {
            return redirect()->back()
                ->with('error', 'Akun Anda telah dinonaktifkan. Hubungi admin.');
        }

        // Set session (multi-role: admin, staff, pelanggan)
        session()->set([
            'user_id'   => $user['id'],
            'name'      => $user['name'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true,
        ]);

        // Log login berhasil
        log_message('info', 'LOGIN: User ID=' . $user['id'] . ' Role=' . $user['role']);

        // Redirect ke halaman sebelumnya atau dashboard
        $redirectUrl = session()->get('redirect_url') ?? '/dashboard';
        session()->remove('redirect_url');

        return redirect()->to($redirectUrl)
            ->with('success', 'Selamat datang, ' . $user['name'] . '!');
    }

    // ======================
    // REGISTER PAGE
    // ======================
    public function register()
    {
        return view('auth/register');
    }

    // ======================
    // PROSES REGISTER
    // ======================
    public function storeRegister()
    {
        $model = new UserModel();

        // Validasi ketat
        if (!$this->validate([
            'name'     => 'required|min_length[2]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data tidak valid. Pastikan email belum digunakan dan password minimal 6 karakter.');
        }

        $model->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'pelanggan',
            'status'   => 1,
        ]);

        return redirect()->to('/login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // ======================
    // LOGOUT
    // ======================
    public function logout()
    {
        $userId = session()->get('user_id');
        log_message('info', 'LOGOUT: User ID=' . $userId);

        session()->destroy();

        return redirect()->to('/login')
            ->with('success', 'Berhasil logout');
    }
}