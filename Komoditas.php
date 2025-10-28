<?php

namespace App\Controllers;

use App\Models\KomoditasModel;
use App\Models\HargaModel;

class HomeAdmin extends BaseController
{
    public function index()
    {

        if (!session()->get('admin_id')) {
        return view('admin/not_logged_in');
    }

        $komoditasModel = new KomoditasModel();
        $hargaModel     = new HargaModel();

        $data = [
            'komoditas'       => $komoditasModel->findAll(),
            'data_terbaru'    => $hargaModel
                ->select('harga_pangan.*, wilayah.nama_wilayah')
                ->join('wilayah', 'wilayah.id = harga_pangan.wilayah_id', 'left')
                ->orderBy('tanggal', 'DESC')
                ->findAll(5),
        ];

        return view('dashboard/index', $data);
    }
}
