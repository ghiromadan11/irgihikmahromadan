<?php

namespace App\Controllers;

use App\Models\KomoditasModel;

class Komoditas extends BaseController
{
    public function index()
    {
        $model = new KomoditasModel();
        $data['komoditas'] = $model->findAll();

        return view('komoditas/index', $data);
    }

    public function create()
    {
        return view('komoditas/create');
    }

    public function store()
    {
        $model = new KomoditasModel();
        $model->insert([
            'nama_komoditas' => $this->request->getPost('nama_komoditas'),
            'satuan' => $this->request->getPost('satuan'),
        ]);

        return redirect()->to('/komoditas');
    }

    public function edit($id)
    {
        $model = new KomoditasModel();
        $data['komoditas'] = $model->find($id);

        return view('komoditas/edit', $data);
    }

    public function update($id)
    {
        $model = new KomoditasModel();
        $model->update($id, [
            'nama_komoditas' => $this->request->getPost('nama_komoditas'),
            'satuan' => $this->request->getPost('satuan'),
        ]);

        return redirect()->to('/komoditas');
    }

    public function delete($id)
    {
        $model = new KomoditasModel();
        $model->delete($id);

        return redirect()->to('/komoditas');
    }
}
