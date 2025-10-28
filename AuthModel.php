<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';         // Nama tabel
    protected $primaryKey = 'user_id';       // Kolom primary key

    protected $useAutoIncrement = true;

    // Kolom yang bisa diisi
    protected $allowedFields = [
        'nama',
        'email',
        'password',
        'role',
        'created_at',
        'updated_at'
    ];

    // Aktifkan otomatis isi created_at dan updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi otomatis (opsional, bisa dihapus kalau belum dipakai)
    protected $validationRules = [
        'nama'     => 'required|min_length[3]',
        'email'    => 'required|valid_email|is_unique[users.email,user_id,{user_id}]',
        'password' => 'required|min_length[6]',
        'role'     => 'required|in_list[admin,kepala]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email sudah digunakan.',
            'valid_email' => 'Email tidak valid.'
        ],
        'role' => [
            'in_list' => 'Role hanya boleh admin atau kepala.'
        ]
    ];
}
