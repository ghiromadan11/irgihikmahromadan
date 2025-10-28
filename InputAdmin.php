<?php

namespace App\Controllers;
require_once ROOTPATH . 'vendor/autoload.php';

use App\Models\HargaModel;
use App\Models\WilayahModel;
use App\Models\KomoditasModel;
use App\Models\RiwayatModel;
use Dompdf\Dompdf;

class InputAdmin extends BaseController
{
    public function input()
    {
      // Cek apakah admin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
    return view('admin/not_logged_in');
        }

        $model = new HargaModel();
        $keyword = $this->request->getGet('tanggal');

        $builder = $model
            ->select('harga_pangan.*, wilayah.nama_wilayah, komoditas.nama_komoditas, komoditas.satuan')
            ->join('wilayah', 'wilayah.id = harga_pangan.wilayah_id')
            ->join('komoditas', 'komoditas.id = harga_pangan.komoditas_id')
            ->orderBy('tanggal', 'DESC');

        if ($keyword) {
            $builder->where('tanggal', $keyword);
        }

        $data['harga'] = $builder->findAll();
        $data['tanggal_filter'] = $keyword;

        return view('admin/index', $data);
    }

    public function exportPdf()
    {
         // Cek apakah admin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
    return view('admin/not_logged_in');
    }
        
        $model = new HargaModel();
        $data['harga'] = $model
            ->select('harga_pangan.*, wilayah.nama_wilayah, komoditas.nama_komoditas, komoditas.satuan')
            ->join('wilayah', 'wilayah.id = harga_pangan.wilayah_id')
            ->join('komoditas', 'komoditas.id = harga_pangan.komoditas_id')
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        // Pastikan view harga/pdf.php tersedia
        $html = view('harga/pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan_harga_pangan.pdf', ['Attachment' => false]);
    }

    public function create()
    {
        // Cek apakah admin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
    return view('admin/not_logged_in');
    }
        $komoditasModel = new KomoditasModel();
        $wilayahModel = new WilayahModel();

        $data = [
            'wilayah'   => $wilayahModel->findAll(),
            'komoditas' => $komoditasModel->findAll()
        ];

        return view('admin/inputadmin', $data);
    }

    public function store()
{
    if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
        return view('admin/not_logged_in');
    }

    $model = new HargaModel();
    $riwayatModel = new RiwayatModel();
    $gambar = $this->request->getFile('gambar');
    $namaGambar = '';

    if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
        $namaGambar = $gambar->getRandomName();
        $gambar->move('assets/img/harga_pangan', $namaGambar);
    }

    $data = [
        'tanggal'      => $this->request->getPost('tanggal'),
        'komoditas_id' => $this->request->getPost('komoditas_id'),
        'harga'        => $this->request->getPost('harga'),
        'wilayah_id'   => $this->request->getPost('wilayah_id'),
        'gambar'       => $namaGambar
    ];

    $model->insert($data);

    // Simpan juga ke riwayat_input dengan tambahan user_id
    $riwayatModel->insert([
        'user_id'      => session()->get('user_id'), // ambil dari session
        'tanggal'      => $data['tanggal'],
        'komoditas_id' => $data['komoditas_id'],
        'harga'        => $data['harga'],
        'wilayah_id'   => $data['wilayah_id']
    ]);

    return redirect()->to('admin/inputadmin')->with('success', 'Komoditas berhasil ditambahkan');
}

    public function edit($id)
    { // Cek apakah admin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
    return view('admin/not_logged_in');
    }

        $hargaModel = new HargaModel();
        $komoditasModel = new KomoditasModel();
        $wilayahModel = new WilayahModel();

        $harga = $hargaModel->find($id);
            if (!$harga) {
         return redirect()->to('/admin/home')->with('error', 'Data tidak ditemukan');
        }
        $data = [
            'harga' => $hargaModel->find($id),
            'komoditas' => $komoditasModel->findAll(),
            'wilayah' => $wilayahModel->findAll()
        ];

        return view('admin/adminedit', $data);
    }

    public function update($id)
    {
        // Cek apakah admin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
    return view('admin/not_logged_in');
    }

        $model = new HargaModel();
        $riwayatModel = new RiwayatModel();

        $dataLama = $model->find($id);
        $gambar = $this->request->getFile('gambar');
        $namaGambar = $dataLama['gambar'];

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            $gambar->move('assets/img/harga_pangan', $namaGambar);
        }

        $dataUpdate = [
            'tanggal' => $this->request->getPost('tanggal'),
            'komoditas_id' => $this->request->getPost('komoditas_id'),
            'harga' => $this->request->getPost('harga'),
            'wilayah_id' => $this->request->getPost('wilayah_id'),
            'gambar' => $namaGambar
        ];

        $model->update($id, $dataUpdate);

        $dataRiwayat = [
    'user_id'      => session()->get('user_id'),
    'tanggal'      => $dataUpdate['tanggal'],
    'komoditas_id' => $dataUpdate['komoditas_id'],
    'harga'        => $dataUpdate['harga'],
    'wilayah_id'   => $dataUpdate['wilayah_id']
];

        return redirect()->to('admin/home')->with('success', 'Data berhasil diperbarui dan disimpan ke riwayat');
    }

    public function delete($id)
    {
        // Cek apakah admin sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
    return view('admin/not_logged_in');
    }

        $model = new HargaModel();
        $model->delete($id);

        return redirect()->to('admin/home')->with('success', 'Data berhasil dihapus');
    }

    
}
