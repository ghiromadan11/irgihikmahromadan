<?php

namespace App\Controllers;

use App\Models\HargaModel;
use App\Models\RiwayatModel;

class KepalaHome extends BaseController
{
    public function index()
    {// Cek apakah kepala sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'kepala') {
    return view('kepala/not_logged_in');
    }

       $hargaModel = new HargaModel();

        // Ambil data dari harga_pangan + standar harga
        $dataHarga = $hargaModel
            ->select('harga_pangan.*, komoditas.nama_komoditas, komoditas.satuan, komoditas.standar_harga, wilayah.nama_wilayah')
            ->join('komoditas', 'komoditas.komoditas_id = harga_pangan.komoditas_id') 
            ->join('wilayah', 'wilayah.wilayah_id = harga_pangan.wilayah_id')         
            ->orderBy('harga_pangan.tanggal', 'DESC')
            ->findAll();

        $dataWithTrend = [];

        foreach ($dataHarga as $item) {
            $hargaSekarang = $item['harga'];
            $standar = $item['standar_harga'] ?? 0;

            // Default nilai
            $item['trend'] = 'stabil';
            $item['persentase'] = 0;

            if ($standar > 0) {
                if ($hargaSekarang > $standar) {
                    $item['trend'] = 'naik';
                    $item['persentase'] = (($hargaSekarang - $standar) / $standar) * 100;
                } elseif ($hargaSekarang < $standar) {
                    $item['trend'] = 'turun';
                    $item['persentase'] = (($standar - $hargaSekarang) / $standar) * 100;
                }
            }

            $dataWithTrend[] = $item;
        }
        return view('kepala/home', ['komoditas' => $dataWithTrend]);
    }
}
