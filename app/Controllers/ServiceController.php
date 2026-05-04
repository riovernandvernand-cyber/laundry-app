<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class ServiceController extends BaseController
{
    public function index()
    {
        $model = new ServiceModel();
        $data['services'] = $model->findAll();

        return view('services/index', $data);
    }

    public function create()
    {
        return view('services/create');
    }

    public function store()
    {
        $model = new ServiceModel();

        $model->save([
        'name'        => $this->request->getPost('name'),
        'price'       => $this->request->getPost('price'),
        'description' => $this->request->getPost('description'),
        'duration'    => $this->request->getPost('duration'),
        ]);

        return redirect()->to('/services')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new ServiceModel();
        $data['service'] = $model->find($id);

        return view('services/edit', $data);
    }

    public function update($id)
    {
        $model = new ServiceModel();

        $model->update($id, [
        'name'        => $this->request->getPost('name'),
        'price'       => $this->request->getPost('price'),
        'description' => $this->request->getPost('description'),
        'duration'    => $this->request->getPost('duration'),
        ]);

        return redirect()->to('/services')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new ServiceModel();
        $model->delete($id);

        return redirect()->to('/services')->with('success', 'Data berhasil dihapus');
    }
}