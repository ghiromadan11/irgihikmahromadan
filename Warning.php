<?php

namespace App\Controllers;

use App\Models\HargaModel;
use App\Models\RiwayatModel;

class Warning extends BaseController
{
    public function index()
    {
        if (!session()->get('kepala_id')) {
            return view('kepala/not_logged_in');
        }

        $hargaModel = new HargaModel();

        // Ambil data terbaru harga pangan
        $allData = $hargaModel
            ->select('harga_pangan.*, komoditas.nama_komoditas, komoditas.satuan, wilayah.nama_wilayah')
            ->join('komoditas', 'komoditas.komoditas_id = harga_pangan.komoditas_id') // ✅ sesuaikan PK
            ->join('wilayah', 'wilayah.wilayah_id = harga_pangan.wilayah_id')       // ✅ sesuaikan PK
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        $filtered = [];

        foreach ($allData as $item) {
            // Hitung jumlah update naik
            $countNaik = $hargaModel
                ->where('komoditas_id', $item['komoditas_id'])
                ->where('wilayah_id', $item['wilayah_id'])
                ->where('harga >', $item['harga'])
                ->countAllResults(false);

            // Hitung jumlah update turun
            $countTurun = $hargaModel
                ->where('komoditas_id', $item['komoditas_id'])
                ->where('wilayah_id', $item['wilayah_id'])
                ->where('harga <', $item['harga'])
                ->countAllResults(false);

            if ($countNaik >= 3 || $countTurun >= 3) {
                $item['naik'] = $countNaik;
                $item['turun'] = $countTurun;
                $filtered[] = $item;
            }
        }

        return view('admin/warning', [
            'data' => $filtered,
            'filter' => null
        ]);
    }

    public function filter($status)
    {
        if (!session()->get('admin_id')) {
            return view('kepala/not_logged_in');
        }

        $riwayatModel = new RiwayatModel();

        // Ambil data terbaru per komoditas-wilayah
        $latestData = $riwayatModel
            ->select('MAX(riwayat_id) as riwayat_id, komoditas_id, wilayah_id')
            ->groupBy(['komoditas_id', 'wilayah_id'])
            ->findAll();

        $filtered = [];

        foreach ($latestData as $latest) {
            // Ambil data terbaru berdasarkan ID
            $current = $riwayatModel
                ->select('riwayat_input.*, komoditas.nama_komoditas, komoditas.satuan, wilayah.nama_wilayah')
                ->join('komoditas', 'komoditas.komoditas_id = riwayat_input.komoditas_id') // ✅ sesuaikan PK
                ->join('wilayah', 'wilayah.wilayah_id = riwayat_input.wilayah_id')        // ✅ sesuaikan PK
                ->where('riwayat_input.riwayat_id', $latest['riwayat_id'])
                ->first();

            // Ambil riwayat sebelumnya
            $prev = $riwayatModel
                ->where('komoditas_id', $latest['komoditas_id'])
                ->where('wilayah_id', $latest['wilayah_id'])
                ->where('riwayat_id <', $latest['riwayat_id']) // ✅ perbaiki penamaan ID
                ->orderBy('riwayat_id', 'DESC')
                ->first();

            if (!$prev || !$current) continue;

            $selisih = $current['harga'] - $prev['harga'];

            if ($status === 'naik' && $selisih > 0) {
                $filtered[] = $current;
            } elseif ($status === 'turun' && $selisih < 0) {
                $filtered[] = $current;
            } elseif ($status === 'stabil' && $selisih == 0) {
                $filtered[] = $current;
            }
        }

        return view('admin/warning', [
            'data' => $filtered,
            'filter' => $status
        ]);
    }
}
