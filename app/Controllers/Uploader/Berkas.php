<?php

namespace App\Controllers\Uploader;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\BerkasModel;

class Berkas extends BaseController
{
    protected $akunModel;
    protected $berkasModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
        $this->berkasModel = new BerkasModel();
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
}
