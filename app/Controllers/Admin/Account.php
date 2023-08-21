<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AkunModel;

class Account extends BaseController
{
    protected $akunModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
    }
    
    public function read()
    {
        $username = session()->get('username'); // Mengambil username dari session
    
        $data = [
            'user' => $this->akunModel
                ->join('role', 'role.id_role = akun.id_role')
                ->where('username', $username)
                ->first(),
            'users' => $this->akunModel
                ->join('role', 'role.id_role = akun.id_role')
                ->findAll() // Mengambil semua data user (sesuaikan sesuai kebutuhan)
        ];
    
        return view('admin/account_read', $data);
    }
    
}