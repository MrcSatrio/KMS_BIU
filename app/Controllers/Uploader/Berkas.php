<?php

namespace App\Controllers\Uploader;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\BerkasModel;
use App\Models\KategoriModel;
use App\Models\SubkategoriModel;
use App\Models\SorotModel;

class Berkas extends BaseController
{
    protected $akunModel;
    protected $berkasModel;
    protected $kategoriModel;
    protected $subkategoriModel;
    protected $sorotModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
        $this->berkasModel = new BerkasModel();
        $this->kategoriModel = new KategoriModel();
        $this->subkategoriModel = new SubkategoriModel();
        $this->sorotModel = new SorotModel();
    }

    public function read()
    {
        $username = session()->get('username'); // Mengambil username dari session
        $profile = $this->akunModel->find($username);
        $id_account = session()->get('account_id'); 
        $data = [
            'profile' => $profile,
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

        return view('uploader/berkas/read', $data);
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
        $documentType = $this->request->getPost('documentType');
        $documentContent = $this->request->getPost('documentContent');
        $sub_kategori = $this->request->getPost('sub_kategori');
        $documentFile = $this->request->getFile('documentFile');
        $documentPDF = $this->request->getFile('documentPDF');
        $documentVideo = $this->request->getPost('documentVideo');

        // Validasi input data
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            session()->setFlashdata('error', $errors);
            return redirect()->to('uploader/upload'); // Redirect kembali ke halaman upload dengan pesan kesalahan dan data input sebelumnya.
        }

        // Handle the uploaded document (PDF)
        if ($documentPDF->isValid() && !$documentPDF->hasMoved()) {
            $newPDF = $documentPDF->getRandomName();
            $documentPDF->move(ROOTPATH . 'public/uploads', $newPDF);
        } else {
            $newPDF = ''; // Tetapkan nilai kosong jika tidak ada PDF diunggah
        }

        // Handle the uploaded video link
        if (!empty($documentVideo)) {
            $newVideo = $documentVideo;
        } else {
            $newVideo = ''; // Tetapkan nilai kosong jika tidak ada link video diisi
        }

        // Memeriksa apakah keduanya kosong
        if (empty($newPDF) && empty($newVideo)) {
            // Tampilkan pesan kesalahan jika tidak ada file PDF atau video yang diunggah atau diisi
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah berkas PDF atau mengisi link video.');
        }

        // Memeriksa berkas gambar yang diunggah
        if ($documentFile->isValid() && !$documentFile->hasMoved()) {
            $maxWidth = 1080;
            $maxHeight = 1080;
            $minHeight = 166;
            
            list($width, $height) = getimagesize($documentFile->getTempName());
            
            if ($width <= $maxWidth && $height <= $maxHeight && $height >= $minHeight) {
                $newFileName = $documentFile->getRandomName();
                $documentFile->move(ROOTPATH . 'public/uploads', $newFileName);
            } else {
                return redirect()->back()->withInput()->with('error', 'Resolusi berkas gambar tidak sesuai. Maksimum ' . $maxWidth . 'x' . $maxHeight . ' piksel diizinkan, dan tinggi minimum ' . $minHeight . ' piksel diizinkan.');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah berkas gambar.');
        }

        // Siapkan data untuk dimasukkan ke dalam database
        $databerkas = [
            'judul' => $documentTitle,
            'account_id' => session()->get('account_id'),
            'id_status' => 1,
            'id_event' => 0,
            'deskripsi' => $documentContent,
            'video' => $newVideo,
            'id_kategori' => $documentType,
            'id_sorot' => mt_rand(1000000, 9999999),
            'id_sub_kategori' => $sub_kategori,
            'berkas' => $newFileName,
            'pdf' => $newPDF,
        ];

        $datasorotan = [
            'id_sorot' => $databerkas['id_sorot'],
            'nama_sorot' => $documentTitle,
            'deskripsi_sorotan' => $documentContent,
            'status_sorot' => 0
        ];

        $this->sorotModel->insert($datasorotan);
        $this->berkasModel->insert($databerkas);

        session()->setFlashdata('success', 'Berkas berhasil diunggah.');
        return redirect()->to('uploader/materi');
    } else {
        $username = session()->get('username');
        $profile = $this->akunModel->find($username);
        $data = [
            'profile' => $profile,
            'kategori' => $this->kategoriModel
                ->join('sub_kategori', 'sub_kategori.id_kategori = kategori.id_kategori')
                ->where('kategori.nama_kategori !=', 'EVENT')
                ->findAll(),
        ];

        return view('uploader/upload', $data);
    }
}


    

public function delete($id_dokumen)
{
    $codedokumen = base64_decode($id_dokumen);
    $dokumen = $this->berkasModel->find($codedokumen);

    if ($dokumen) {
        $this->berkasModel->delete($id_dokumen);

        // Tampilkan pesan sukses dengan SweetAlert
        session()->setFlashdata('success', 'Materi berhasil diHapus.');

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('uploader/materi');
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('uploader/materi');
    }

}
public function update($id_dokumen)
{
    $codedokumen = base64_decode($id_dokumen);

    $dokumen = $this->berkasModel->find($codedokumen);

    // Ambil data kategori (mungkin perlu menyesuaikan nama model dan metode)
    $username = session()->get('username'); 
    $profile = $this->akunModel->find($username);
    $data = [
        'profile' => $profile,
        'dokumen' => $dokumen,
        'kategori' => $this->kategoriModel
            ->join('sub_kategori', 'sub_kategori.id_kategori = kategori.id_kategori')
            ->where('kategori.nama_kategori !=', 'EVENT')
            ->findAll(),
    ];

    return view('uploader/berkas/update', $data);
}
public function update_action()
{
    if ($this->request->getMethod() === 'post') {
        // Validasi input
        $validationRules = [
            'documentTitle' => 'required',
            'documentType' => 'required',
            'documentContent'=> 'required',
            'sub_kategori'=> 'required',
            

        ];

        if ($this->validate($validationRules)) {
            // Jika validasi berhasil, ambil nilai dari form
            $documentTitle = $this->request->getPost('documentTitle');
            $documentVideo = $this->request->getPost('documentVideo');
            $documentType = $this->request->getPost('documentType');
            $documentContent = $this->request->getPost('documentContent');
            $sub_kategori = $this->request->getPost('sub_kategori');
            $id_dokumen = $this->request->getPost('id_dokumen');
            $account_id = $_SESSION['account_id'];

            // Persiapan data subkategori dalam bentuk array
            $berkas = [
                'judul' => $documentTitle,
                'account_id' => $account_id,
                'deskripsi' => $documentContent,
                'video' => $documentVideo,
                'id_kategori' => $documentType,
                'id_sub_kategori' => $sub_kategori,
                'id_event' => 0,
                
            ];

            // Update data subkategori berdasarkan $id_sub_kategori
            $this->berkasModel->update($id_dokumen, $berkas);

            session()->setFlashdata('success', 'Berkas berhasil diperbarui.');

            // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
            return redirect()->to('uploader/materi');
        } else {
            // Jika validasi gagal, tampilkan pesan kesalahan
            $validationErrors = $this->validator->getErrors();
            session()->setFlashdata('error', $validationErrors);

            // Mengembalikan pengguna ke halaman formulir dengan data input sebelumnya
            return redirect()->back()->withInput();
        }
    }
}

}
