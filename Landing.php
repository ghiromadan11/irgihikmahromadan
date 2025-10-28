<?php

namespace App\Controllers;

class Landing extends BaseController
{
    public function index()
    {
        if (session()->get('admin_id')) {
            return redirect()->to('/dashboard'); // admin
        }

        // Tampilkan halaman publik user tanpa login
        return view('user/home'); 
    }
}
