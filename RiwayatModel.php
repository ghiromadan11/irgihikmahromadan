<?php

namespace App\Models;
use CodeIgniter\Model;

class RiwayatModel extends Model
{
    protected $table = 'riwayat_input';
    protected $primaryKey = 'riwayat_id'; 
    protected $allowedFields = ['komoditas_id', 'harga', 'wilayah_id', 'tanggal', 'gambar'];

   
    protected $useTimestamps = false;
    protected $returnType    = 'array';
}

