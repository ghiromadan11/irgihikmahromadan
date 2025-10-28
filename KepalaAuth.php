<?php

namespace App\Controllers;

use App\Models\KepalaModel;

class KepalaAuth extends BaseController
{
    public function login()
    {
        return view('/login_adm_kpl');
    }

    public function loginProcess()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $kepalaModel = new KepalaModel();
        $kepala = $kepalaModel->where('email', $email)->first();

        if (!$kepala) {
            return redirect()->to('/kepala/login')->with('error', 'Email tidak ditemukan');
        }

        if (!password_verify($password, $kepala['password'])) {
            return redirect()->to('/kepala/login')->with('error', 'Password salah');
        }

        session()->set([
            'kepala_id'   => $kepala['id'],
            'kepala_nama' => $kepala['nama'],
            'logged_in'   => true
        ]);

        return redirect()->to('/kepala/home'); 
    }

    public function logout()

         {// Cek apakah kepala sudah login
        if (!session()->get('logged_in') || session()->get('role') !== 'kepala') {
    return view('kepala/not_logged_in');
    }
        
        session()->destroy();
        return redirect()->to('/login_adm_kpl');
    }
}
