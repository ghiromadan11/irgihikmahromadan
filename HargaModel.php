<?php
namespace App\Models;

use CodeIgniter\Model;

class HargaModel extends Model
{
    protected $table = 'harga_pangan';
    protected $allowedFields = ['tanggal', 'komoditas_id', 'harga', 'wilayah_id', 'gambar'];
    protected $useTimestamps = false;
}
