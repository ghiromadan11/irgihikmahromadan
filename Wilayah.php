<?php

namespace App\Controllers;

use App\Models\WilayahModel;

class Wilayah extends BaseController
{
    public function index()
    {
         if (!session()->get('admin_id')) {
            return view('admin/not_logged_in');
         }

        $model = new WilayahModel();
        $data['wilayah'] = $model->findAll();
        return view('wilayah/index', $data);
    }

    public function create()
    {
         if (!session()->get('admin_id')) {
            return view('admin/not_logged_in');
         }

        return view('wilayah/create');
    }

    public function store()
    {
         if (!session()->get('admin_id')) {
            return view('admin/not_logged_in');
         }

        $model = new WilayahModel();
        $model->save(['nama_wilayah' => $this->request->getPost('nama_wilayah')]);
        return redirect()->to('/wilayah');
    }

    public function delete($id)
    {
         if (!session()->get('admin_id')) {
            return view('admin/not_logged_in');
         }
         
        $model = new WilayahModel();
        $model->delete($id);
        return redirect()->to('/wilayah');
    }
}
