<?php

namespace App\Controllers;

use App\Models\HargaModel;
use Dompdf\Dompdf;

class KepalaUnduh extends BaseController
{
    public function index()
    {// Cek apakah kepala sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'kepala') {
    return view('kepala/not_logged_in');
    }

        $hargaModel = new HargaModel();
        $tahun = date('Y');

        $bulanData = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $dataBulan = $hargaModel
                ->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun)
                ->findAll();

            $bulanData[] = [
                'nama_bulan' => date('F', mktime(0, 0, 0, $bulan, 10)),
                'status'     => count($dataBulan) > 0 ? 'Lengkap' : 'Belum Lengkap',
                'bulan'      => str_pad($bulan, 2, '0', STR_PAD_LEFT),
            ];
        }

        return view('kepala/unduh', [
            'bulanData' => $bulanData,
            'tahun'     => $tahun,
        ]);
    }

    public function exportPdf($bulan, $tahun)
    {
         // Cek apakah kepala sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'kepala') {
    return view('kepala/not_logged_in');
    }

        
        $model = new HargaModel();

        $data['harga'] = $model
            ->select('harga_pangan.*, wilayah.nama_wilayah, komoditas.nama_komoditas, komoditas.satuan')
            ->join('wilayah', 'wilayah.wilayah_id = harga_pangan.wilayah_id')
            ->join('komoditas', 'komoditas.komoditas_id = harga_pangan.komoditas_id')
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $html = view('unduh/pdf', $data); 

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("data_harga_{$bulan}_{$tahun}.pdf", ['Attachment' => true]);
    }
}
