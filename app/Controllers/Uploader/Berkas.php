<?php

namespace App\Controllers\Uploader;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\BerkasModel;
use App\Models\KategoriModel;
use App\Models\SubkategoriModel;

class Berkas extends BaseController
{
    protected $akunModel;
    protected $berkasModel;
    protected $kategoriModel;
    protected $subkategoriModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
        $this->berkasModel = new BerkasModel();
        $this->kategoriModel = new KategoriModel();
        $this->subkategoriModel = new SubkategoriModel();
    }

    public function read()
    {
        $username = session()->get('username'); // Mengambil username dari session
        $id_account = session()->get('account_id'); 
        $data = [
            'user' => $this->akunModel
                ->join('role', 'role.id_role = akun.id_role')
                ->where('username', $username)
                ->first(),
            'berkas' => $this->berkasModel
                ->join('kategori', 'kategori.id_kategori = berkas.id_kategori')
                ->join('akun', 'akun.account_id = berkas.account_id')
                ->where('akun.account_id', $id_account) // Mengambil semua data user (sesuaikan sesuai kebutuhan)
                ->findAll(), // Use findAll() to get all results
        ];

        return view('uploader/materi', $data);
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
            return redirect()->to('uploader/upload'); // Redirect kembali ke halaman upload dengan pesan kesalahan dan data input sebelumnya.
        }
        
        

        // Handle the uploaded document file
        if ($documentFile->isValid() && !$documentFile->hasMoved()) {
            $newFileName = $documentFile->getRandomName();
            $documentFile->move(ROOTPATH . 'public/uploads', $newFileName);
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah berkas.'); // Jika gagal mengunggah berkas, kembali ke halaman upload dengan pesan kesalahan.
        }

        $account_id = $_SESSION['account_id'];
        $databerkas = [
            'judul' => $documentTitle,
            'account_id' => $account_id,
            'deskripsi' => $documentContent,
            'video' => $documentVideo,
            'id_kategori' => $documentType,
            'id_sub_kategori' => $sub_kategori,
            'berkas' => $newFileName, // Simpan nama berkas dalam database
        ];

        $this->berkasModel->insert($databerkas);
        session()->setFlashdata('success', 'Berkas berhasil diunggah.');
        return redirect()->to('uploader/materi');
    } else {
        $data = [
            'kategori' => $this->kategoriModel
            ->join('sub_kategori', 'sub_kategori.id_kategori = kategori.id_kategori')
            ->findAll(),
        ];
        
        return view('uploader/upload', $data);
    }
}

}
