<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\BerkasModel;
use App\Models\KategoriModel;
use App\Models\SubkategoriModel;
use App\Models\SorotModel;

class Highlight extends BaseController
{
    protected $akunModel;
    protected $berkasModel;
    protected $kategoriModel;
    protected $subkategoriModel;
    protected $sorotModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
        $this->berkasModel = new BerkasModel();
        $this->kategoriModel = new KategoriModel();
        $this->subkategoriModel = new SubkategoriModel();
        $this->sorotModel = new SorotModel();
    }
    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $validationRules = [
                'judul' => 'required',
                'tgl_awal' => 'required',
                'tgl_akhir' => 'required',
            ];
            $judul = $this->request->getPost('judul');
            $tgl_awal = $this->request->getPost('tgl_awal');
            $tgl_akhir = $this->request->getPost('tgl_akhir');

        // Validasi input data
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            session()->setFlashdata('error', $errors);
            return redirect()->to('admin/highlight'); // Redirect kembali ke halaman upload dengan pesan kesalahan dan data input sebelumnya.
        }
        $sorotan = [
            'judul' => $judul,
            'tgl_mulai' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'status_sorot' => '1',
        ];
        $this->sorotModel->update($judul, $sorotan);
        session()->setFlashdata('success', 'Highlight berhasil ditambahkan.');
        return redirect()->to('admin/highlight');
    } else {
        $username = session()->get('username'); 
        $profie = $this->akunModel->find($username);
        $data = [
            'profile' => $profie,
            'berkas' => $this->berkasModel
                ->join('kategori', 'kategori.id_kategori = berkas.id_kategori')
                ->join('akun', 'akun.account_id = berkas.account_id')
                ->join('sorotan', 'sorotan.id_sorot = berkas.id_sorot')
                ->findAll(),
        ];
        
        return view('admin/highlight/create', $data);
    }
}

    public function read()
    {
        $username = session()->get('username'); 
        $profie = $this->akunModel->find($username);
        $data = [
            'profile' => $profie,
            'berkas' => $this->berkasModel
                ->join('kategori', 'kategori.id_kategori = berkas.id_kategori')
                ->join('akun', 'akun.account_id = berkas.account_id')
                ->join('sorotan', 'sorotan.id_sorot = berkas.id_sorot')
                ->where('status_sorot', '1')
                ->findAll(),
        ];
        

        return view('admin/highlight/read', $data);
    }
    public function delete($id_sorot)
    {
        $sorotan = [
            'tgl_mulai' => '0000-00-00',
            'tgl_akhir' => '0000-00-00',
            'status_sorot' => '0',
        ];
        $this->sorotModel->update($id_sorot, $sorotan);
        session()->setFlashdata('success', 'highlight berhasil dihapus.');

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/highlight');
    }
    public function update($id_sorot)
    {
        $username = session()->get('username'); 
        $profie = $this->akunModel->find($username);
        $sorotan = $this->sorotModel->find($id_sorot);
        $data = [
            'profile' => $profie,
            'sorotan' => $sorotan,
        ];
    
        return view('admin/highlight/update', $data);
    }

    public function update_action()
{
    if ($this->request->getMethod() === 'post') {
        $validationRules = [
            'nama_sorot' => 'required',
            'deskripsi_sorotan' => 'required',
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
            'id_sorot' => 'required',
        ];

        // Menggunakan method validate untuk memeriksa validitas input.
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            session()->setFlashdata('error', $errors);
            // Redirect kembali ke halaman upload dengan pesan kesalahan dan data input sebelumnya.
            return redirect()->to('admin/highlight')->withInput();
        }

        $id_sorot = $this->request->getPost('id_sorot');
        $nama_sorot = $this->request->getPost('nama_sorot');
        $deskripsi_sorotan = $this->request->getPost('deskripsi_sorotan');
        $tgl_awal = $this->request->getPost('tgl_awal');
        $tgl_akhir = $this->request->getPost('tgl_akhir');

        $sorotan = [
            'nama_sorot' => $nama_sorot,
            'deskripsi_sorotan' => $deskripsi_sorotan,
            'tgl_mulai' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
        ];

        // Menggunakan method update dengan dua parameter: ID sorot dan data yang akan diupdate.
        $this->sorotModel->update($id_sorot, $sorotan);
        session()->setFlashdata('success', 'Highlight berhasil ditambahkan.');
        return redirect()->to('admin/highlight');
    }
}
}