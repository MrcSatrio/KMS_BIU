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
        return view('uploader/index');
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
                'id_account' => $account_id,
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
