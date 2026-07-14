<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class ServiceController extends BaseController
{
    protected $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
    }

    public function index()
    {
        // 1. Ambil data role dari session user yang sedang login
        $role = session()->get('role');

        // 2. Masukkan ke dalam array $data agar bisa dibaca oleh View dan Layout/Navbar
        $data['services'] = $this->serviceModel->findAll();
        $data['role'] = $role;

        return view('admin/services/index', $data);
    }

    public function create()
    {
        return view('admin/services/create');
    }

    public function store()
    {
        $rules = [
            'nama_layanan' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama layanan wajib diisi.',
                    'min_length' => 'Nama layanan minimal 3 karakter.'
                ]
            ],
            'harga' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga wajib diisi.',
                    'numeric' => 'Harga harus berupa angka.'
                ]
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
                'errors' => [
                    'uploaded' => 'Foto layanan wajib diupload.',
                    'is_image' => 'File yang dipilih bukan gambar.',
                    'mime_in' => 'Ekstensi gambar harus jpg, jpeg, atau png.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move('uploads/services', $namaFoto);

        $this->serviceModel->save([
            'name' => $this->request->getPost('nama_layanan'),
            'price' => $this->request->getPost('harga'),
            'description' => $this->request->getPost('description') ?? '',
            'duration' => $this->request->getPost('duration') ?? 24,
            'image' => $namaFoto
        ]);

        return redirect()->to('/services')->with('success', 'Data layanan baru beserta foto berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['service'] = $this->serviceModel->find($id);
        return view('admin/services/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_layanan' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama layanan wajib diisi.',
                    'min_length' => 'Nama layanan minimal 3 karakter.'
                ]
            ],
            'harga' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga wajib diisi.',
                    'numeric' => 'Harga harus berupa angka.'
                ]
            ],
            'foto' => [
                'rules' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
                'errors' => [
                    'is_image' => 'File yang dipilih bukan gambar.',
                    'mime_in' => 'Ekstensi gambar harus jpg, jpeg, atau png.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        $layananLama = $this->serviceModel->find($id);
        $namaFotoLama = $layananLama['image'];

        if ($fileFoto->getError() == 4) {
            $namaFoto = $namaFotoLama;
        } else {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/services', $namaFoto);

            if ($namaFotoLama != '' && file_exists('uploads/services/' . $namaFotoLama)) {
                unlink('uploads/services/' . $namaFotoLama);
            }
        }

        $this->serviceModel->save([
            'id' => $id,
            'name' => $this->request->getPost('nama_layanan'),
            'price' => $this->request->getPost('harga'),
            'description' => $this->request->getPost('description') ?? $layananLama['description'],
            'duration' => $this->request->getPost('duration') ?? $layananLama['duration'],
            'image' => $namaFoto
        ]);

        return redirect()->to('/services')->with('success', 'Data layanan berhasil diperbarui!');
    }

    public function delete($id)
    {
        $layanan = $this->serviceModel->find($id);
        if ($layanan['image'] != '' && file_exists('uploads/services/' . $layanan['image'])) {
            unlink('uploads/services/' . $layanan['image']);
        }
        $this->serviceModel->delete($id);

        return redirect()->to('/services')->with('success', 'Data layanan beserta foto berhasil dihapus!');
    }
}