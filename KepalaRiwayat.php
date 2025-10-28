<?php

namespace App\Controllers;

use App\Models\RiwayatModel;
use App\Models\KomoditasModel;

class KepalaRiwayat extends BaseController
{
    public function index()
    
       {// Cek apakah kepala sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'kepala') {
    return view('kepala/not_logged_in');
    }

    $riwayatModel = new RiwayatModel();
    $komoditasModel = new KomoditasModel();

    $riwayat = $riwayatModel
        ->select('riwayat_input.*, komoditas.nama_komoditas, komoditas.satuan, wilayah.nama_wilayah')
        ->join('komoditas', 'komoditas.komoditas_id = riwayat_input.komoditas_id')
        ->join('wilayah', 'wilayah.wilayah_id = riwayat_input.wilayah_id')
        ->orderBy('riwayat_input.tanggal', 'DESC')
        ->findAll();

    $standar = $komoditasModel
        ->select('nama_komoditas, satuan, standar_harga')
        ->orderBy('nama_komoditas', 'ASC')
        ->findAll();

    return view('kepala/riwayat', [
        'riwayat' => $riwayat,
        'standar' => $standar
    ]);
}
}
