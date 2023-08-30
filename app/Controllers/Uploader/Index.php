<?php

namespace App\Controllers\Uploader;

use App\Controllers\BaseController;
use App\Models\BerkasModel; // Make sure to include the correct namespace for your model

class Index extends BaseController
{
    protected $berkasModel;

    public function __construct()
    {
        $this->berkasModel = new BerkasModel();
    }

    public function index(): string
    {
        $data =
        [
            'title' => 'Parking Management System',
            'berkas' => $this->berkasModel
                ->join('akun', 'berkas.account_id = akun.account_id')
                ->join('kategori', 'berkas.id_kategori = kategori.id_kategori')
                ->findAll() // Mengambil semua data user (sesuaikan sesuai kebutuhan)
        ]; 
        return view('uploader/index', $data);
    }
    public function knowledge($id_dokumen)
    {
        $data = [
            'title' => 'Parking Management System',
            'document' => $this->berkasModel
                ->join('akun', 'berkas.account_id = akun.account_id')
                ->join('kategori', 'berkas.id_kategori = kategori.id_kategori')
                ->where('id_dokumen', $id_dokumen)
                ->first() // Use `first()` to get a single row
        ]; 
        return view('uploader/knowledge', $data);
    }

    public function upload(): string
    {
        return view('uploader/upload');
    }

    public function action_upload(): string
    {
        if ($this->request->getMethod() === 'post') {
            $documentTitle = $this->request->getPost('documentTitle');
            $documentVideo = $this->request->getPost('documentVideo');
            $documentType = $this->request->getPost('documentType');
            $documentContent = $this->request->getPost('documentContent');

            // Handle the uploaded document file
            $documentFile = $this->request->getFile('documentFile');
            if ($documentFile->isValid() && !$documentFile->hasMoved()) {
                $newFileName = $documentFile->getRandomName();
                $documentFile->move(ROOTPATH . 'public/uploads', $newFileName);
            }
            $account_id = $_SESSION['account_id'];
            $databerkas = [
                'judul' => $documentTitle,
                'account_id' => $account_id,
                'deskripsi' => $documentContent,
                'id_kategori' => $documentType,
                'video' => $documentVideo,
                'berkas' => $newFileName, // Store the file name in the database
            ];
            
            $this->berkasModel->insert($databerkas);
        }

        return view('uploader/upload');// Redirect after processing
    }
}
