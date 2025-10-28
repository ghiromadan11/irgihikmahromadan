<?php

namespace App\Controllers;

use App\Models\RiwayatModel; // ✅ Ganti dari HargaModel ke RiwayatModel
use Dompdf\Dompdf;

class UserUnduh extends BaseController
{
    public function index()
    {
        $model = new RiwayatModel();
        $tahun = date('Y');

        $bulanData = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $dataBulan = $model
                ->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun)
                ->findAll();

            $bulanData[] = [
                'nama_bulan' => date('F', mktime(0, 0, 0, $bulan, 10)),
                'status'     => count($dataBulan) > 0 ? 'Lengkap' : 'Belum Lengkap',
                'bulan'      => str_pad($bulan, 2, '0', STR_PAD_LEFT),
            ];
        }

        return view('user/unduh', [
            'bulanData' => $bulanData,
            'tahun'     => $tahun,
        ]);
    }

    public function exportPdf($bulan, $tahun)
    {
        $model = new RiwayatModel();

        $riwayat = $model
            ->select('riwayat_input.*, wilayah.nama_wilayah, komoditas.nama_komoditas, komoditas.satuan')
            ->join('wilayah', 'wilayah.wilayah_id = riwayat_input.wilayah_id')
            ->join('komoditas', 'komoditas.komoditas_id = riwayat_input.komoditas_id')
            ->where('MONTH(riwayat_input.tanggal)', $bulan)
            ->where('YEAR(riwayat_input.tanggal)', $tahun)
            ->orderBy('riwayat_input.tanggal', 'ASC')
            ->findAll();

        $data = [
            'riwayat' => $riwayat,
            'bulan'   => $bulan,
            'tahun'   => $tahun,
        ];

        $html = view('user/pdf', $data); 

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("data_riwayat_{$bulan}_{$tahun}.pdf", ['Attachment' => true]);
    }
}
