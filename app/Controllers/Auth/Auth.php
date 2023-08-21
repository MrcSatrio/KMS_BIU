<?php

namespace App\Controllers\Auth;

use \App\Controllers\BaseController;

class Auth extends BaseController
{
    protected $akunModel;
public function login()
    {
        $username= $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $this->akunModel->where('username', $username)->first();
        if ($user) {
            if (md5($password) == $user['password']) {
                //Session untuk login
                $session = session();
                $sessionData = [
                    'username' => $user['username'],
                    'nama' => $user['nama'],
                    'id_role' => $user['id_role']
                ];
                $session->set($sessionData);
                // Redirect sesuai dengan peran user
                if ($user['id_role'] == 1) {
                    return redirect()->to('/admin/dashboard');
                } elseif ($user['id_role'] == 2) {
                    return redirect()->to('/keuangan/dashboard');
                } elseif ($user['id_role'] == 3) {
                    return redirect()->to('/operator/dashboard');
            } else {
                return redirect()->to('/')->withInput()->with('msg', 'Username atau Password Salah');
            }
        } else {
            return redirect()->to('/')->withInput()->with('msg', 'Username atau Password Salah');
        }
    }}}