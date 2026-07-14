<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    // ======================
    // LIST USERS (ADMIN)
    // ======================
    public function index()
    {
        $model = new UserModel();

        return view('admin/users/index', [
            'users' => $model->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    // ======================
    // TOGGLE STATUS AKTIF/NONAKTIF (ADMIN)
    // ======================
    public function toggleStatus($id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Admin tidak bisa menonaktifkan diri sendiri
        if ((int) $id === (int) session()->get('user_id')) {
            return redirect()->back()->with('error', 'Tidak bisa menonaktifkan akun sendiri');
        }

        $newStatus = $user['status'] == 1 ? 0 : 1;
        $model->update($id, ['status' => $newStatus]);

        $statusText = $newStatus == 1 ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', 'User ' . $user['name'] . ' berhasil ' . $statusText);
    }
}
