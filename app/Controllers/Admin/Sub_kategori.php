<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\SubkategoriModel;

class Sub_kategori extends BaseController
{
    protected $kategoriModel;
    protected $subkategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->subkategoriModel = new SubkategoriModel();
    }
    
    public function read()
    {
    
        $data = [
            'kategori' => $this->kategoriModel
            ->join('sub_kategori', 'sub_kategori.id_kategori = kategori.id_kategori')
                ->findAll()
        ];
    
        return view('admin/sub_kategori/read', $data);
    }
    public function create()
{
    if ($this->request->getMethod() === 'post') {
        // Validasi input
        $validationRules = [
            'id_kategori' => 'required',
            'nama_sub_kategori' => 'required',
        ];

        if ($this->validate($validationRules)) {
            // Jika validasi berhasil, ambil nilai dari form
            $nama_sub_kategori = $this->request->getPost('nama_sub_kategori');
            $id_kategori = $this->request->getPost('id_kategori');

            $subkategori = [
                'nama_sub_kategori' => $nama_sub_kategori,
                'id_kategori' => $id_kategori,
            ];

            // Insert data subkategori
            $this->subkategoriModel->insert($subkategori);

            session()->setFlashdata('success', 'Sub Kategori berhasil ditambahkan.');

            // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
            return redirect()->to('admin/sub_kategori');
        } else {
            // Jika validasi gagal, tampilkan pesan kesalahan
            $validationErrors = $this->validator->getErrors();
            session()->setFlashdata('error', $validationErrors);

            // Mengembalikan pengguna ke halaman formulir dengan data input sebelumnya
            return redirect()->to('admin/sub_kategori/create')->withInput();
        }
    }

    $data = [
        'kategori' => $this->kategoriModel->findAll(),
    ];

    return view('admin/sub_kategori/create', $data);
}
public function delete($id_sub_kategori)
{
    $sub_kategori = $this->subkategoriModel->find($id_sub_kategori);

    if ($sub_kategori) {
        $this->subkategoriModel->delete($id_sub_kategori);

        // Tampilkan pesan sukses dengan SweetAlert
        session()->setFlashdata('success', 'Sub Kategori berhasil diHapus.');

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/sub_kategori');
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error
        session()->setFlashdata('error', 'Sub Kategori Gagal Dihapus.');

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/sub_kategori');
    }

}
public function update($id_sub_kategori)
{


    // Ambil data subkategori berdasarkan $id_sub_kategori
    $subkategori = $this->subkategoriModel->find($id_sub_kategori);
    $kategori = $this->kategoriModel->findall();

    // Ambil data kategori (mungkin perlu menyesuaikan nama model dan metode)

    $data = [
        'subkategori' => $subkategori,
        'kategori' => $kategori,
    ];

    return view('admin/sub_kategori/update', $data);
}

public function update_action()
{
    if ($this->request->getMethod() === 'post') {
        // Validasi input
        $validationRules = [
            'nama_sub_kategori' => 'required',
            'id_kategori' => 'required',
        ];

        if ($this->validate($validationRules)) {
            // Jika validasi berhasil, ambil nilai dari form
            $nama_sub_kategori = $this->request->getPost('nama_sub_kategori');
            $id_kategori = $this->request->getPost('id_kategori');
            $id_sub_kategori = $this->request->getPost('id_sub_kategori');

            // Persiapan data subkategori dalam bentuk array
            $subkategori = [
                'nama_sub_kategori' => $nama_sub_kategori,
                'id_kategori' => $id_kategori,
            ];

            // Update data subkategori berdasarkan $id_sub_kategori
            $this->subkategoriModel->update($id_sub_kategori, $subkategori);

            session()->setFlashdata('success', 'Sub Kategori berhasil diperbarui.');

            // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
            return redirect()->to('admin/sub_kategori');
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