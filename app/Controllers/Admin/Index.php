<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\BerkasModel;

class Index extends BaseController
{
protected $berkasModel;

    public function __construct()
    {
        $this->berkasModel = new BerkasModel();
    }

    public function index()
    {
        $data =
        [
            'berkas' => $this->berkasModel
                ->join('akun', 'berkas.account_id = akun.account_id')
                ->join('kategori', 'berkas.id_kategori = kategori.id_kategori')
                ->findAll() // Mengambil semua data user (sesuaikan sesuai kebutuhan)
        ]; 
        return view('admin/index', $data);
    }
    public function knowledge($id_dokumen)
    {
        $data = [
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