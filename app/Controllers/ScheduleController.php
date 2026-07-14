<?php

namespace App\Controllers;

use App\Models\ScheduleModel;
use App\Models\ServiceModel;

class ScheduleController extends BaseController
{
    // ======================
    // LIST SCHEDULE
    // ======================
    public function index()
    {
        $model = new ScheduleModel();

        $data['schedules'] = $model
            ->select('schedules.*, services.name')
            ->join('services', 'services.id = schedules.service_id')
            ->orderBy('date', 'ASC')
            ->findAll();

        return view('admin/schedules/index', $data);
    }

    // ======================
    // FORM CREATE
    // ======================
    public function create()
    {
        $serviceModel = new ServiceModel();

        $data['services'] = $serviceModel->findAll();

        return view('admin/schedules/create', $data);
    }

    // ======================
    // STORE
    // ======================
    public function store()
    {
        $model = new ScheduleModel();

        // 🔥 VALIDASI
        if (
            !$this->validate([
                'service_id' => 'required',
                'date' => 'required',
                'time' => 'required',
                'capacity' => 'required|greater_than[0]'
            ])
        ) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid');
        }

        $model->save([
            'service_id' => $this->request->getPost('service_id'),
            'date' => $this->request->getPost('date'),
            'time' => $this->request->getPost('time'),
            'capacity' => $this->request->getPost('capacity'),
        ]);

        return redirect()->to('/schedules')->with('success', 'Jadwal berhasil ditambahkan');
    }

    // ======================
    // FORM EDIT
    // ======================
    public function edit($id)
    {
        $model = new ScheduleModel();
        $serviceModel = new ServiceModel();

        $data['schedule'] = $model->find($id);
        $data['services'] = $serviceModel->findAll();

        return view('schedules/edit', $data);
    }

    // ======================
    // UPDATE
    // ======================
    public function update($id)
    {
        $model = new ScheduleModel();

        if (
            !$this->validate([
                'service_id' => 'required',
                'date' => 'required',
                'time' => 'required',
                'capacity' => 'required|greater_than[0]'
            ])
        ) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid');
        }

        $model->update($id, [
            'service_id' => $this->request->getPost('service_id'),
            'date' => $this->request->getPost('date'),
            'time' => $this->request->getPost('time'),
            'capacity' => $this->request->getPost('capacity'),
        ]);

        return redirect()->to('/schedules')->with('success', 'Jadwal berhasil diupdate');
    }

    // ======================
    // DELETE
    // ======================
    public function delete($id)
    {
        $model = new ScheduleModel();

        $model->delete($id);

        return redirect()->to('/schedules')->with('success', 'Jadwal berhasil dihapus');
    }
}