<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\AkunModel;

class Auth extends BaseController
{
    protected $akunModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
    }

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $this->akunModel->where('username', $username)->first();
    
        if ($user) {
            if ($user['id_status_akun'] == 1) {
                // Akun dengan id_status_akun 1 dianggap gagal login
                session()->setFlashdata('error', 'Akun tidak aktif. Silakan Aktivasi Akun Terlebih Dahulu.');
                return redirect()->to(base_url('/'));
            }
    
            if (md5($password) == $user['password']) {
                // Session untuk login
                $session = session();
                $sessionData = [
                    'username' => $user['username'],
                    'nama' => $user['nama'],
                    'id_role' => $user['id_role'],
                    'account_id' => $user['account_id'],
                ];
                $session->set($sessionData);
    
                // Redirect berdasarkan peran pengguna (id_role)
                switch ($user['id_role']) {
                    case 1:
                        return redirect()->to(base_url('admin/dashboard'));
                    case 2:
                        return redirect()->to(base_url('uploader/dashboard'));
                    case 3:
                        return redirect()->to('operator/dashboard');
                    default:
                        session()->setFlashdata('error', 'Username atau Password Salah');
                        return redirect()->to(base_url('/'));
                }
            } else {
                session()->setFlashdata('error', 'Username atau Password Salah');
                return redirect()->to(base_url('/'));
            }
        } else {
            session()->setFlashdata('error', 'Username atau Password Salah');
            return redirect()->to(base_url('/'));
        }
    }
    
public function logout()
{
    // Menghancurkan sesi
    $session = session();
    $session->destroy();
    session_write_close();

    // Menyimpan pesan sukses dalam flash data
    session()->setFlashdata('success', 'Berhasil Logout');

    // Mengalihkan pengguna ke halaman beranda (base url)
    return redirect()->to(base_url('/'));
}


public function register()
{
    $validationRules = [
        'username' => 'required|min_length[4]|max_length[20]|is_unique[akun.username]',
        'password' => 'required|min_length[6]',
        'email' => 'required|valid_email|is_unique[akun.email]',
        'name' => 'required|min_length[3]|max_length[50]|is_unique[akun.nama]',
    ];

    if ($this->validate($validationRules)) {
        // Mengambil nilai-nilai dari form
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $email = $this->request->getVar('email');
        $name = $this->request->getVar('name');
        $token = mt_rand(100000, 999999);

        // Menggunakan md5() untuk mengenkripsi kata sandi (TIDAK DISARANKAN)
        $hashedPassword = md5($password);

        // Menyiapkan data user dalam bentuk array
        $datauser = [
            'nama' => $name,
            'username' => $username,
            'password' => $hashedPassword,
            'email' => $email,
            'id_role' => 2,
            'token' => $token,
            'id_status_akun' => 1,
        ];

        $this->akunModel->insert($datauser);

        // Mengirim email verifikasi
        $to = $email;
        $subject = 'TOKEN PENDAFTARAN';
        $token_no = $token;
        $message = 'Halo ' . $name . '<br><br>'
            . 'Masukkan Token Dibawah ini untuk melakukan Pendaftaran Akun.'
            . '<br>' . 'Token Pendaftaran Akun Anda: <br> <h1>' . $token_no . ' </h1> <br>'
            . '<span style="color: red; font-weight: bold;">⚠️ PERHATIAN !!! JANGAN BERIKAN TOKEN KEPADA ORANG LAIN ⚠️</span>' . '<br>'
            . '<span style="color: red; font-weight: bold;">⚠️ ABAIKAN EMAIL INI JIKA ANDA TIDAK MELAKUKAN PENDAFTARAN AKUN INI ⚠️</span>' . '<br><br>'
            . 'Terima kasih,' . '<br><br>' . ' I-BINA KNOW';

        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('kms.binainsani@gmail.com', 'KMS-BINA INSANI');
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            $successMessage = 'Token Sukses Terkirim. Silakan Periksa Email yang Terdaftar';
            session()->setFlashdata('success', $successMessage);
            return redirect()->to(base_url('auth/activated'));
        } else {
            $errorData = $email->printDebugger(['headers']);
            session()->setFlashdata('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    } else {
        // Jika validasi gagal, kembali ke halaman registrasi dengan pesan error
        $errorMessages = implode('<br>', $this->validator->getErrors());
        session()->setFlashdata('error', $errorMessages);
        return redirect()->to(base_url('/'));
    }
}


public function activated()
{
    if ($this->request->getMethod() === 'post') {
        $validationRules = [
            'otp' => 'required',
            'email' => 'required|valid_email' // Tambahkan validasi email
        ];
    
        // Validasi input
        if ($this->validate($validationRules)) {
            $otp = $this->request->getPost('otp');
            $email = $this->request->getPost('email');
    
            $user = $this->akunModel->where('email', $email)->first();
    
            if ($user && $otp === $user['token']) {
                // Update 'id_status_akun' menjadi 2
                $this->akunModel->update($user, ['id_status_akun' => 2]); // Ubah cara pemanggilan kolom 'id'
                session()->setFlashdata('success', 'Akun Berhasil Diaktivasi.');
                return redirect()->to('/');
            } else {
                session()->setFlashdata('error', 'Kode Token Salah.');
                return redirect()->to('auth/activated');
            }
        } else {
            // Penanganan kesalahan validasi input
            session()->setFlashdata('error', 'Gagal validasi input.');
            return redirect()->to('/');
        }
    } else {
        return view('template/activated');
    }
}
}