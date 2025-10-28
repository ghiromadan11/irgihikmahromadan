<?php

namespace App\Controllers;

use App\Models\HargaModel;
use App\Models\RiwayatInputModel;

class HomeAdmin extends BaseController
{
    public function home()
    {
        // Cek apakah admin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
    return view('admin/not_logged_in');
    }

        $hargaModel = new HargaModel();

        // Ambil data harga dan join dengan wilayah & komoditas
        $data = $hargaModel
            ->select('harga_pangan.*, wilayah.nama_wilayah, komoditas.nama_komoditas, komoditas.satuan, komoditas.standar_harga')
            ->join('wilayah', 'wilayah.wilayah_id = harga_pangan.wilayah_id')
            ->join('komoditas', 'komoditas.komoditas_id = harga_pangan.komoditas_id')
            ->orderBy('harga_pangan.tanggal', 'DESC')
            ->findAll();

        // Tambahkan status tren harga: naik/turun/stabil
        $dataWithTrend = [];
        foreach ($data as $item) {
            $hargaSebelumnya = $hargaModel
                ->where('komoditas_id', $item['komoditas_id'])
                ->where('wilayah_id', $item['wilayah_id'])
                ->where('tanggal <', $item['tanggal'])
                ->orderBy('tanggal', 'DESC')
                ->first();

            if ($hargaSebelumnya) {
                if ($item['harga'] > $hargaSebelumnya['harga']) {
                    $item['trend'] = 'naik';
                } elseif ($item['harga'] < $hargaSebelumnya['harga']) {
                    $item['trend'] = 'turun';
                } else {
                    $item['trend'] = 'stabil';
                }
            } else {
                $item['trend'] = 'stabil';
            }

            $dataWithTrend[] = $item;
        }

        return view('admin/home', ['komoditas' => $dataWithTrend]);
    }
public function grafik($komoditas_id)
{
     // Cek apakah admin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
    return view('admin/not_logged_in');
    }
    $riwayatModel = new \App\Models\RiwayatInputModel();

    $data = $riwayatModel
        ->select('riwayat_input.tanggal, riwayat_input.harga, komoditas.standar_harga')
        ->join('komoditas', 'komoditas.id = riwayat_input.komoditas_id')
        ->where('riwayat_input.komoditas_id', $komoditas_id)
        ->orderBy('riwayat_input.tanggal', 'ASC')
        ->findAll();

    $formatted = array_map(function ($row) {
        return [
            'tanggal' => date('d-m-Y', strtotime($row['tanggal'])),
            'harga' => (int) $row['harga'],
            'standar_harga' => (int) $row['standar_harga']
        ];
    }, $data);

    return $this->response->setJSON($formatted);
}

}
