<?php

namespace App\Controllers;

use App\Models\RiwayatModel;
use Dompdf\Dompdf;

class DownloadAdmin extends BaseController
{
    public function download()
    {
        $riwayatModel = new RiwayatModel();
        $tahun = date('Y');

        $bulanData = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $dataBulan = $riwayatModel
                ->where('MONTH(tanggal)', $bulan)
                ->where('YEAR(tanggal)', $tahun)
                ->findAll();

            $bulanData[] = [
                'nama_bulan' => date('F', mktime(0, 0, 0, $bulan, 10)),
                'status'     => count($dataBulan) > 0 ? 'Lengkap' : 'Belum Lengkap',
                'bulan'      => str_pad($bulan, 2, '0', STR_PAD_LEFT),
            ];
        }

        return view('download/download', [
            'bulanData' => $bulanData,
            'tahun'     => $tahun
        ]);
    }

    public function exportPdf($bulan, $tahun)
    {
        $riwayatModel = new RiwayatModel();

        $data['riwayat'] = $riwayatModel
            ->select('riwayat_input.*, wilayah.nama_wilayah, komoditas.nama_komoditas, komoditas.satuan')
            ->join('wilayah', 'wilayah.wilayah_id = riwayat_input.wilayah_id')
            ->join('komoditas', 'komoditas.komoditas_id = riwayat_input.komoditas_id')
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $html = view('download/PDF', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("riwayat_pangan_{$bulan}_{$tahun}.pdf", ['Attachment' => false]);
    }
}
