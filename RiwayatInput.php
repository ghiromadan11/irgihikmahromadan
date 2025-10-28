<?php

namespace App\Controllers;

use App\Models\RiwayatModel;

class RiwayatInput extends BaseController
{
    public function index()
    {
        // Cek apakah admin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return view('admin/not_logged_in');
        }

        $riwayatModel = new RiwayatModel();
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $builder = $riwayatModel
            ->select('riwayat_input.*, komoditas.nama_komoditas, wilayah.nama_wilayah')
            ->join('komoditas', 'komoditas.komoditas_id = riwayat_input.komoditas_id')
            ->join('wilayah', 'wilayah.wilayah_id = riwayat_input.wilayah_id');
            

        if ($bulan && $tahun) {
            $builder->where("MONTH(tanggal)", $bulan);
            $builder->where("YEAR(tanggal)", $tahun);
        }

        $data['riwayat'] = $builder->orderBy('tanggal', 'DESC')->findAll();
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        return view('admin/riwayatinput', $data);
    }

    public function grafik($komoditas_id)
    {
       // Boleh diakses siapa pun (tanpa login), tapi validasi param aman
    if (!is_numeric($komoditas_id)) {
        return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid ID']);
    }

        $model = new RiwayatModel();
        $data = $model
            ->select('riwayat_input.tanggal, riwayat_input.harga, komoditas.standar_harga')
            ->join('komoditas', 'komoditas.komoditas_id = riwayat_input.komoditas_id')
            ->where('riwayat_input.komoditas_id', $komoditas_id)
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        return $this->response->setJSON($data);
    }

    public function delete($riwayat_id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return view('admin/not_logged_in');
        }

        $model = new RiwayatModel();
        $model->delete($riwayat_id);

        return redirect()->to('admin/riwayatinput')->with('success', 'Data berhasil dihapus');
    }
}
