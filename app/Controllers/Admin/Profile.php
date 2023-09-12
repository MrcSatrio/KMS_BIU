<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\RoleModel;

class Profile extends BaseController
{
    protected $akunModel;
    protected $roleModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
        $this->roleModel = new RoleModel();
    }
    

    public function update($account_id)
    {
        $username = session()->get('username'); 
        $profie = $this->akunModel->find($username);
        $akun = $this->akunModel->find($account_id);
        $role = $this->roleModel->findall();
    
        // Ambil data kategori (mungkin perlu menyesuaikan nama model dan metode)
    
        $data = [
            'profile' => $profie,
            'akun' => $akun,
            'role' => $role,
        ];
    
        return view('admin/profile/update', $data);
    }
    public function update_action()
    {
        if ($this->request->getMethod() === 'post') {
            // Validasi input
            $validationRules = [
                'nama' => 'required',
                'username' => 'required',
                'email' => 'required',
                'account_id' => 'required',
            ];
    
            if ($this->validate($validationRules)) {
                // Jika validasi berhasil, ambil nilai dari form
                $nama = $this->request->getPost('nama');
                $username = $this->request->getPost('username');
                $email = $this->request->getPost('email');
                $account_id = $this->request->getPost('account_id');
    
                // Persiapan data akun dalam bentuk array
                $akun = [
                    'nama' => $nama,
                    'username' => $username,
                    'email' => $email,
                ];
    
                // Update data akun berdasarkan $account_id
                $this->akunModel->update($account_id, $akun);
    
                session()->setFlashdata('success', 'Akun berhasil diperbarui.');
    
                // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
                return redirect()->back()->withInput();
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal Memperbarui profil.'); // Jika gagal mengunggah berkas, kembali ke halaman upload dengan pesan kesalahan.
            }
        } else {
            // Jika validasi gagal, tampilkan pesan kesalahan
            $validationErrors = $this->validator->getErrors();
            session()->setFlashdata('error', $validationErrors);
    
            // Mengembalikan pengguna ke halaman formulir dengan data input sebelumnya
            return redirect()->back()->withInput();
        }
    }
    public function photo_profile($account_id)
    {
        $username = session()->get('username'); 
        $profie = $this->akunModel->find($username);
        $akun = $this->akunModel->find($account_id);
        $role = $this->roleModel->findall();
    
        // Ambil data kategori (mungkin perlu menyesuaikan nama model dan metode)
    
        $data = [
            'profile' => $profie,
            'akun' => $akun,
            'role' => $role,
        ];
    
        return view('uploader/profile/photo_profile', $data);
    }
    public function photo_update_action()
    {
        if ($this->request->getMethod() === 'post') {
            // Validasi input
            $validationRules = [
                'account_id' => 'required',
            ];
    
            if ($this->validate($validationRules)) {
                $account_id = $this->request->getPost('account_id');
                $foto_profile = $this->request->getFile('foto_profile');
    
                if ($foto_profile) {
                    if ($foto_profile->isValid() && !$foto_profile->hasMoved()) {
                        $newFileName = $foto_profile->getRandomName();
                        $foto_profile->move(ROOTPATH . 'public/uploads', $newFileName);
    
                        // Persiapan data akun dalam bentuk array
                        $akun = [
                            'foto_profile' => $newFileName, // Simpan nama file yang diunggah ke database
                        ];
    
                        // Update data akun berdasarkan $account_id
                        $this->akunModel->update($account_id, $akun);
    
                        session()->setFlashdata('success', 'Akun berhasil diperbarui.');
    
                        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
                        return redirect()->back()->withInput();
                    } else {
                        return redirect()->back()->withInput()->with('error', 'Gagal mengunggah berkas.'); // Jika gagal mengunggah berkas, kembali ke halaman upload dengan pesan kesalahan.
                    }
                } else {
                    // Debugging statement to see if $foto_profile is null
                    echo 'foto_profile is null';
                }
            } else {
                // Jika validasi gagal, tampilkan pesan kesalahan
                $validationErrors = $this->validator->getErrors();
                session()->setFlashdata('error', $validationErrors);
    
                // Mengembalikan pengguna ke halaman formulir dengan data input sebelumnya
                return redirect()->back()->withInput();
            }
        }
    }

}