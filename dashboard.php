<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\KomoditasModel;
use App\Models\HargaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $komoditasModel = new KomoditasModel();
        $hargaModel = new HargaModel();

        $data = [
            'title' => 'Dashboard Admin',
            'total_komoditas' => $komoditasModel->countAll(),
            'total_harga' => $hargaModel->countAll(),
            'data_terbaru' => $hargaModel->orderBy('tanggal', 'DESC')->findAll(5)
        ];

        return view('dashboard/index', $data);
    }
}
