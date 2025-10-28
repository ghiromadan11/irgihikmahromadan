<?php

namespace App\Controllers;

use App\Models\RiwayatModel;

class KepalaWarning extends BaseController
{
    public function index()
    {// Cek apakah kepala sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'kepala') {
    return view('kepala/not_logged_in');
    }
        
        // Saat pertama kali halaman warning dibuka, tidak tampilkan data
        return view('kepala/warning', [
            'data' => [],
            'filter' => null
        ]);
    }

    public function filter($status)

   {// Cek apakah kepala sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'kepala') {
    return view('kepala/not_logged_in');
    }

    $riwayatModel = new \App\Models\RiwayatModel();

    // Ambil semua data dari riwayat_input lengkap
    $semuaData = $riwayatModel
        ->select('riwayat_input.*, komoditas.nama_komoditas, komoditas.satuan, wilayah.nama_wilayah, komoditas.standar_harga')
        ->join('komoditas', 'komoditas.komoditas_id = riwayat_input.komoditas_id')
        ->join('wilayah', 'wilayah.wilayah_id = riwayat_input.wilayah_id')
        ->orderBy('tanggal', 'DESC')
        ->findAll();

    $filtered = [];

    foreach ($semuaData as $item) {
        $standar = floatval($item['standar_harga'] ?? 0);
        $harga = floatval($item['harga']);
        $selisih = $harga - $standar;

        if ($status === 'naik' && $harga > $standar) {
            $item['selisih'] = $selisih; // positif
            $filtered[] = $item;
        } elseif ($status === 'turun' && $harga < $standar) {
            $item['selisih'] = $selisih; // negatif (lebih kecil dari standar)
            $filtered[] = $item;
        } elseif ($status === 'stabil' && $harga == $standar) {
            $item['selisih'] = 0;
            $filtered[] = $item;
        }
    }

    // Urutkan selisih harga
    usort($filtered, function ($a, $b) use ($status) {
        if ($status === 'naik') {
            return ($b['selisih'] ?? 0) <=> ($a['selisih'] ?? 0); // urutan menurun
        } elseif ($status === 'turun') {
            return ($a['selisih'] ?? 0) <=> ($b['selisih'] ?? 0); // urutan naik (karena selisih negatif)
        } else {
            return 0; // stabil tidak diurutkan
        }
    });

    return view('kepala/warning', [
        'data' => $filtered,
        'filter' => $status
    ]);
}


}
