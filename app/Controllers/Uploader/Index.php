<?php

namespace App\Controllers\Uploader;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\BerkasModel; // Make sure to include the correct namespace for your model

class Index extends BaseController
{
    protected $berkasModel;
    protected $akunModel;

    public function __construct()
    {
        $this->berkasModel = new BerkasModel();
        $this->akunModel = new AkunModel();
    }

    public function index(): string
    {   
        $username = session()->get('username'); 
        $profile = $this->akunModel->find($username);
        $currentDate = date('Y-m-d');
        $data =
        [
            'profile' => $profile,
            'berkas' => $this->berkasModel
                ->join('akun', 'berkas.account_id = akun.account_id')
                ->join('kategori', 'berkas.id_kategori = kategori.id_kategori')
                ->findAll(), // Mengambil semua data user (sesuaikan sesuai kebutuhan)
                'event' => $this->berkasModel
                ->join('kategori', 'berkas.id_kategori = kategori.id_kategori')
                ->where('nama_kategori', 'EVENT')
                ->orderBy('updated_at', 'DESC') // Menyortir data berdasarkan tanggal_upload secara descending
                ->limit(5) // Mengambil hanya 5 data terbaru
                ->findAll(),
                'highlight' => $this->berkasModel
                ->join('kategori', 'berkas.id_kategori = kategori.id_kategori')
                ->join('sorotan', 'berkas.id_sorot = sorotan.id_sorot')
                ->where('status_sorot', '1')
                ->where('tgl_mulai <=', $currentDate)
                ->where('tgl_akhir >=', $currentDate)
                ->limit(2)
                ->findAll(),
                

        ]; 
        return view('uploader/index', $data);
    }
    public function knowledge($id_dokumen)
    {
        $username = session()->get('username'); 
        $profile = $this->akunModel->find($username);
        $data = [
            'profile' => $profile,
            'document' => $this->berkasModel
                ->join('akun', 'berkas.account_id = akun.account_id')
                ->join('kategori', 'berkas.id_kategori = kategori.id_kategori')
                ->where('id_dokumen', $id_dokumen)
                ->first(), // Use `first()` to get a single row
            'bk' => $this->berkasModel
            ->where('id_dokumen', $id_dokumen)
            ->first()
        ]; 
        return view('uploader/knowledge', $data);
    }
}
