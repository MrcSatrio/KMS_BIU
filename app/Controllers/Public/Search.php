<?php

namespace App\Controllers\Public;

use App\Controllers\Admin\Kategori;
use \App\Controllers\BaseController;
use App\Models\BerkasModel;
use App\Models\AkunModel;

class Search extends BaseController
{
    protected $berkasModel;
    protected $akunModel;

    public function __construct()
    {
        $this->berkasModel = new BerkasModel();
        $this->akunModel = new AkunModel();
    }
    public function search($id_kategori)
    {

        $username = session()->get('username'); 
        $profile = $this->akunModel->find($username);
        $akun = $this->akunModel->find($username);
        $data =
        [
            'profile' => $profile,
            'akun' => $akun,
            'berkas' => $this->berkasModel
                ->join('akun', 'berkas.account_id = akun.account_id')
                ->join('kategori', 'berkas.id_kategori = kategori.id_kategori')
                ->where('kategori.nama_kategori', $id_kategori)
                ->findAll(),
        ]; 
        return view('public/search', $data);
    }
    public function find()
{
    if ($this->request->getMethod() === 'post') {
        $pencarian = $this->request->getPost('pencarian');
        $username = session()->get('username');
        $profile = $this->akunModel->find($username);
        $databerkas = [
            'profile' => $profile,
            'berkas' => $this->berkasModel
                ->join('akun', 'berkas.account_id = akun.account_id')
                ->join('kategori', 'berkas.id_kategori = kategori.id_kategori')
                ->like('berkas.judul', $pencarian)
                ->findAll(),
        ];
        return view('public/search', $databerkas);
    }
}

}