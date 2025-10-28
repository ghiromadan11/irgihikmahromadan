<?php

namespace App\Models;

use CodeIgniter\Model;

class KomoditasModel extends Model
{
    protected $table = 'komoditas';
    protected $primaryKey = 'komoditas_id';
    protected $allowedFields = ['nama_komoditas', 'satuan', 'gambar', 'standar_harga'];
    protected $returnType = 'array';
}
