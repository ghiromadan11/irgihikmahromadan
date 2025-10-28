<?php

namespace App\Models;
use CodeIgniter\Model;

class KepalaModel extends Model
{
    protected $table = 'kepala';
    protected $allowedFields = ['nama', 'email', 'password'];
}
