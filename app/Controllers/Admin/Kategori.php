<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }
    
    public function read()
    {
    
        $data = [
            'kategori' => $this->kategoriModel
                ->findAll()
        ];
    
        return view('admin/kategori/read', $data);
    }
    public function create()
{
    if ($this->request->getMethod() === 'post') {
        // Validasi input
        $validationRules = [
            'nama_kategori' => 'required',
        ];

        if ($this->validate($validationRules)) {
            // Jika validasi berhasil, ambil nilai dari form
            $nama_kategori = $this->request->getPost('nama_kategori');

            // Menyiapkan data kategori dalam bentuk array
            $kategori = [
                'nama_kategori' => $nama_kategori,
            ];

            // Simpan data kategori ke dalam database menggunakan model
            $this->kategoriModel->insert($kategori);

            // Menyimpan pesan sukses dalam flash data
            session()->setFlashdata('success', 'Kategori berhasil ditambahkan.');

            // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
            return redirect()->to('admin/kategori');
        } else {
            // Jika validasi gagal, tampilkan pesan kesalahan
            $validationErrors = $this->validator->getErrors();
            session()->setFlashdata('error', $validationErrors);
        }
    }

    // Tampilkan view formulir jika permintaan adalah POST atau validasi gagal
    return view('admin/kategori/create');
}
public function delete($id_kategori)
{
    $kategori = $this->kategoriModel->find($id_kategori);

    if ($kategori) {
        $this->kategoriModel->delete($id_kategori);

        // Tampilkan pesan sukses dengan SweetAlert
        session()->setFlashdata('success', 'Kategori berhasil diHapus.');

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/kategori');
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error
        session()->setFlashdata('error', 'Kategori Gagal Dihapus.');

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/kategori');
    }

}
public function update($id_kategori)
{

    $kategori = $this->kategoriModel->find($id_kategori);

    // Ambil data kategori (mungkin perlu menyesuaikan nama model dan metode)

    $data = [
        'kategori' => $kategori,
    ];

    return view('admin/kategori/update', $data);
}

public function update_action()
{
    if ($this->request->getMethod() === 'post') {
        // Validasi input
        $validationRules = [
            'nama_kategori' => 'required',
            'id_kategori' => 'required',
        ];

        if ($this->validate($validationRules)) {
            // Jika validasi berhasil, ambil nilai dari form
            $id_kategori = $this->request->getPost('id_kategori');
            $nama_kategori = $this->request->getPost('nama_kategori');

            // Persiapan data subkategori dalam bentuk array
            $kategori = [
                'nama_kategori' => $nama_kategori,
                'id_kategori' => $id_kategori,
            ];

            // Update data subkategori berdasarkan $id_sub_kategori
            $this->kategoriModel->update($id_kategori, $kategori);

            session()->setFlashdata('success', 'Kategori berhasil diperbarui.');

            // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
            return redirect()->to('admin/kategori');
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