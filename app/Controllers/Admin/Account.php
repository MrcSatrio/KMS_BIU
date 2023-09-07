<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\RoleModel;

class Account extends BaseController
{
    protected $akunModel;
    protected $roleModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
        $this->roleModel = new RoleModel();
    }
    
    public function read()
    {
        $username = session()->get('username'); // Mengambil username dari session
    
        $data = [
            'user' => $this->akunModel
                ->join('role', 'role.id_role = akun.id_role')
                ->where('username', $username)
                ->first(),
            'users' => $this->akunModel
                ->join('role', 'role.id_role = akun.id_role')
                ->findAll() // Mengambil semua data user (sesuaikan sesuai kebutuhan)
        ];
    
        return view('admin/account/read', $data);
    }
    public function update($account_id)
    {
    
        $akun = $this->akunModel->find($account_id);
        $role = $this->roleModel->findall();
    
        // Ambil data kategori (mungkin perlu menyesuaikan nama model dan metode)
    
        $data = [
            'akun' => $akun,
            'role' => $role,
        ];
    
        return view('admin/account/update', $data);
    }
    public function update_action()
{
    if ($this->request->getMethod() === 'post') {
        // Validasi input
        $validationRules = [
            'nama' => 'required',
            'username' => 'required',
            'email'=> 'required',
            'id_role'=> 'required',
            'account_id'=> 'required',
        ];

        if ($this->validate($validationRules)) {
            // Jika validasi berhasil, ambil nilai dari form
            $nama = $this->request->getPost('nama');
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $id_role = $this->request->getPost('id_role');
            $account_id = $this->request->getPost('account_id');

            // Persiapan data subkategori dalam bentuk array
            $akun = [
                'nama' => $nama,
                'username' => $username,
                'email' => $email,
                'id_role' => $id_role,
            ];

            // Update data subkategori berdasarkan $id_sub_kategori
            $this->akunModel->update($account_id, $akun);

            session()->setFlashdata('success', 'Akun berhasil diperbarui.');

            // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
            return redirect()->to('admin/account');
        } else {
            // Jika validasi gagal, tampilkan pesan kesalahan
            $validationErrors = $this->validator->getErrors();
            session()->setFlashdata('error', $validationErrors);

            // Mengembalikan pengguna ke halaman formulir dengan data input sebelumnya
            return redirect()->back()->withInput();
        }
    }
}
public function delete($account_id)
{
    $akun = $this->akunModel->find($account_id);

    if ($akun) {
        $this->akunModel->delete($account_id);

        // Tampilkan pesan sukses dengan SweetAlert
        session()->setFlashdata('success', 'Akun berhasil diHapus.');

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/account');
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error
        session()->setFlashdata('error', 'Account Gagal Dihapus.');

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/account');
    }

}
}