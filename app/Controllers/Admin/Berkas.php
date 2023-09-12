<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\BerkasModel;
use App\Models\KategoriModel;
use App\Models\SubkategoriModel;
use App\Models\SorotModel;

class Berkas extends BaseController
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

    public function read()
    {
        $username = session()->get('username'); // Mengambil username dari session
        $profie = $this->akunModel->find($username);
        $data = [
            'profile' => $profie,
            'user' => $this->akunModel
                ->join('role', 'role.id_role = akun.id_role')
                ->where('username', $username)
                ->first(),
            'berkas' => $this->berkasModel
                ->join('kategori', 'kategori.id_kategori = berkas.id_kategori')
                ->join('akun', 'akun.account_id = berkas.account_id')
                ->findAll(), // Use findAll() to get all results
        ];

        return view('admin/berkas/read', $data);
    }
    public function upload()
{
    if ($this->request->getMethod() === 'post') {
        $validationRules = [
            'documentTitle' => 'required',
            'documentType' => 'required',
            'documentContent' => 'required',
            'sub_kategori' => 'required',
        ];

        $documentTitle = $this->request->getPost('documentTitle');
        $documentVideo = $this->request->getPost('documentVideo');
        $documentType = $this->request->getPost('documentType');
        $documentContent = $this->request->getPost('documentContent');
        $sub_kategori = $this->request->getPost('sub_kategori');
        $documentFile = $this->request->getFile('documentFile');

        // Validasi input data
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            session()->setFlashdata('error', $errors);
            return redirect()->to('admin/upload'); // Redirect kembali ke halaman upload dengan pesan kesalahan dan data input sebelumnya.
        }
        
        

        // Handle the uploaded document file
        if ($documentFile->isValid() && !$documentFile->hasMoved()) {
            $newFileName = $documentFile->getRandomName();
            $documentFile->move(ROOTPATH . 'public/uploads', $newFileName);
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah berkas.'); // Jika gagal mengunggah berkas, kembali ke halaman upload dengan pesan kesalahan.
        }

        $id_sorot = mt_rand(1000000, 9999999); // Menghasilkan nilai integer acak dalam rentang tertentu
        $account_id = $_SESSION['account_id'];
        $databerkas = [
            'judul' => $documentTitle,
            'account_id' => $account_id,
            'deskripsi' => $documentContent,
            'video' => $documentVideo,
            'id_kategori' => $documentType,
            'id_sorot' => $id_sorot,
            'id_sub_kategori' => $sub_kategori,
            'berkas' => $newFileName, // Simpan nama berkas dalam database
        ];
        $datasorotan = [
            'id_sorot' => $id_sorot,
            'nama_sorot' => $documentTitle,
            'deskripsi_sorotan' => $documentContent,
            'status_sorot' => 0
        ];
        
        $this->sorotModel->insert($datasorotan);
        $this->berkasModel->insert($databerkas);
        
        session()->setFlashdata('success', 'Berkas berhasil diunggah.');
        return redirect()->to('uploader/materi');
    } else {
        $username = session()->get('username'); 
        $profie = $this->akunModel->find($username);
        $data = [
            'profile' => $profie,
            'kategori' => $this->kategoriModel
            ->join('sub_kategori', 'sub_kategori.id_kategori = kategori.id_kategori')
            ->findAll(),
        ];
        
        return view('admin/berkas/upload', $data);
    }
}
public function delete($id_dokumen)
{
    $dokumen = $this->berkasModel->find($id_dokumen);

    if ($dokumen) {
        $this->berkasModel->delete($id_dokumen);

        // Tampilkan pesan sukses dengan SweetAlert
        session()->setFlashdata('success', 'Materi berhasil diHapus.');

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/materi');
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/materi');
    }

}
public function update($id_dokumen)
{
    $id_account = session()->get('account_id'); 
    $dokumen = $this->berkasModel->find($id_dokumen);
    $username = session()->get('username'); 
    $profie = $this->akunModel->find($username);
    // Ambil data kategori (mungkin perlu menyesuaikan nama model dan metode)

    $data = [
        'profile' => $profie,
        'user' => $this->akunModel
        ->where('account_id', $id_account)
        ->findAll(),
        'dokumen' => $dokumen,
        'kategori' => $this->kategoriModel
        ->join('sub_kategori', 'sub_kategori.id_kategori = kategori.id_kategori')
        ->findAll(),
    ];

    return view('admin/berkas/update', $data);
}
public function update_action()
{
    if ($this->request->getMethod() === 'post') {
        // Validasi input
        $validationRules = [
            'documentTitle' => 'required',
            'documentType' => 'required',
            'documentVideo' => 'required',
            'documentContent'=> 'required',
            'sub_kategori'=> 'required',

        ];

        if ($this->validate($validationRules)) {
            // Jika validasi berhasil, ambil nilai dari form
            $documentTitle = $this->request->getPost('documentTitle');
            $documentVideo = $this->request->getPost('documentVideo');
            $documentType = $this->request->getPost('documentType');
            $documentContent = $this->request->getPost('documentContent');
            $sub_kategori = $this->request->getPost('sub_kategori');
            $id_dokumen = $this->request->getPost('id_dokumen');
            $account_id = $_SESSION['account_id'];

            // Persiapan data subkategori dalam bentuk array
            $berkas = [
                'judul' => $documentTitle,
                'account_id' => $account_id,
                'deskripsi' => $documentContent,
                'video' => $documentVideo,
                'id_kategori' => $documentType,
                'id_sub_kategori' => $sub_kategori,
            ];

            // Update data subkategori berdasarkan $id_sub_kategori
            $this->berkasModel->update($id_dokumen, $berkas);

            session()->setFlashdata('success', 'Kategori berhasil diperbarui.');

            // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
            return redirect()->to('admin/materi');
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