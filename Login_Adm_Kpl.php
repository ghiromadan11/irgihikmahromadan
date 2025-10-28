<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Login_Adm_Kpl extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel(); // Inisialisasi model user
    }

    // Tampilkan halaman login admin & kepala
    public function login()
{
    // Jika ada query ?from=admin maka abaikan auto-redirect
    $from = $this->request->getGet('from');

    if (session()->get('logged_in') && !$from) {
        $role = session()->get('role');
        if ($role === 'admin') {
            return redirect()->to('/admin/home');
        } elseif ($role === 'kepala') {
            return redirect()->to('/kepala/home');
        }
    }

    return view('login_adm_kpl'); // Tetap tampilkan form login
}

    // Proses login
    public function loginProcess(): RedirectResponse
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cek apakah input kosong
        if (empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'Email dan password harus diisi');
        }

        // Ambil data user berdasarkan email
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // Set session sesuai role
        $sessionData = [
            'user_id'   => $user['user_id'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true,
        ];

        if ($user['role'] === 'admin') {
            $sessionData['admin_nama'] = $user['nama'];
        } elseif ($user['role'] === 'kepala') {
            $sessionData['kepala_nama'] = $user['nama'];
        }

        session()->set($sessionData);

        // Redirect ke halaman sesuai role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/home');
        } elseif ($user['role'] === 'kepala') {
            return redirect()->to('/kepala/home');
        }

        // Jika role tidak dikenali
        return redirect()->to('/login')->with('error', 'Role tidak dikenali');
    }

    // Digunakan untuk logout dan paksa login ulang
    public function forceLogin(): RedirectResponse
    {
        session()->destroy(); // Hapus semua session sebelumnya
        return redirect()->to(base_url('login')); // Redirect ke halaman login
    }

    // Logout manual biasa
    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'Berhasil logout.');
    }
}
