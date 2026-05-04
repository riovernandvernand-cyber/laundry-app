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
        // 🔥 Kalau sudah login → redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

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

        $user = $model->where('email', $email)->first();

        // ❌ CEK USER
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }

        // ❌ CEK PASSWORD
        if (!password_verify($pass, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // ❌ CEK STATUS AKTIF
        if ($user['status'] == 0) {
            return redirect()->back()->with('error', 'User tidak aktif');
        }

        // ✅ SET SESSION
        session()->set([
            'user_id'   => $user['id'],
            'name'      => $user['name'],
            'role'      => $user['role'], // admin / staff / pelanggan
            'logged_in' => true
        ]);

        // 🔥 BONUS (PRO LEVEL)
        // Redirect sesuai role
        if ($user['role'] == 'admin') {
            return redirect()->to('/dashboard');
        } elseif ($user['role'] == 'staff') {
            return redirect()->to('/dashboard');
        } else {
            return redirect()->to('/dashboard'); // nanti bisa dibedakan kalau mau
        }
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

        // 🔥 VALIDASI (biar aman & sesuai dosen)
        if (!$this->validate([
            'name'     => 'required',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[4]'
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data tidak valid atau email sudah digunakan');
        }

        $model->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'pelanggan', // sesuai DB
            'status'   => 1
        ]);

        return redirect()->to('/login')->with('success', 'Register berhasil');
    }

    // ======================
    // LOGOUT
    // ======================
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}