<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\AkunModel;

class Auth extends BaseController
{
    protected $akunModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
    }

    public function login()
{
    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');
    $user = $this->akunModel->where('username', $username)->first();

    if ($user) {
        if (md5($password) == $user['password']) {
            // Session untuk login
            $session = session();
            $sessionData = [
                'username' => $user['username'],
                'nama' => $user['nama'],
                'id_role' => $user['id_role'],
                'account_id' => $user['account_id'],
            ];
            $session->set($sessionData);

            // Redirect berdasarkan peran pengguna (id_role)
            switch ($user['id_role']) {
                case 1:
                    return redirect()->to(base_url('admin/dashboard'));
                case 2:
                    return redirect()->to(base_url('uploader/dashboard'));
                case 3:
                    return redirect()->to('operator/dashboard');
                default:
                session()->setFlashdata('error', 'Username atau Password Salah');
                return redirect()->to(base_url('/'));
            }
        } else {
            session()->setFlashdata('error', 'Username atau Password Salah');
            return redirect()->to(base_url('/'));
        }
    } else {
        session()->setFlashdata('error', 'Username atau Password Salah');
        return redirect()->to(base_url('/'));
    }
}
public function logout()
{
    // Menghancurkan sesi
    $session = session();
    $session->destroy();
    session_write_close();

    // Menyimpan pesan sukses dalam flash data
    session()->setFlashdata('success', 'Berhasil Logout');

    // Mengalihkan pengguna ke halaman beranda (base url)
    return redirect()->to(base_url('/'));
}


public function register()
{
    $validationRules = [
        'username' => 'required|min_length[4]|max_length[20]|is_unique[akun.username]',
        'password' => 'required|min_length[6]',
        'email' => 'required|valid_email|is_unique[akun.email]',
        'name' => 'required|min_length[3]|max_length[50]|is_unique[akun.nama]',
    ];

    if ($this->validate($validationRules)) {
        // Mengambil nilai-nilai dari form
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $email = $this->request->getVar('email');
        $name = $this->request->getVar('name');

        // Menyiapkan data user dalam bentuk array
        $datauser = [
            'nama' => $name,
            'username' => $username,
            'password' => md5($password),
            'email' => $email,
            'id_role' => 2,
        ];

        // Memasukkan data user ke dalam database menggunakan model
        $this->akunModel->insert($datauser);

        // Menyimpan pesan sukses dalam flash data
        session()->setFlashdata('success', 'Registration successful.');

        // Mengalihkan pengguna ke halaman beranda (base url)
        return redirect()->to(base_url('/'));
    } else {
        // Jika validasi gagal, kembali ke halaman registrasi dengan pesan error
        $errorMessages = implode('<br>', $this->validator->getErrors());
        session()->setFlashdata('error', $errorMessages);
        return redirect()->to(base_url('/'));
    }
}
}