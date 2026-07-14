<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use CodeIgniter\HTTP\ResponseInterface;

class StaffController extends BaseController
{
    public function index()
    {
        $bookingModel = new BookingModel();
        $role = session()->get('role');

        $bookingModel->select('bookings.*, services.name as service_name')
            ->join('services', 'services.id = bookings.service_id')
            ->where('bookings.status', 'processing')
            ->orderBy('bookings.id', 'ASC');

        // FIX: Gunakan penamaan grup 'staff_tasks' agar pagination melacak query string dengan benar
        return view('staff/tasks/index', [
            'tasks' => $bookingModel->paginate(9, 'staff_tasks'),
            'pager' => $bookingModel->pager,
            'role' => $role
        ]);
    }
}
