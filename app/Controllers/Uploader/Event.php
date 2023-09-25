<?php

namespace App\Controllers\Uploader;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\BerkasModel;
use App\Models\EventModel;
use App\Models\KategoriModel;
use App\Models\ProdiModel;
use App\Models\SubkategoriModel;
use App\Models\SorotModel;

class Event extends BaseController
{
    protected $akunModel;
    protected $berkasModel;
    protected $kategoriModel;
    protected $subkategoriModel;
    protected $sorotModel;
    protected $eventModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
        $this->berkasModel = new BerkasModel();
        $this->kategoriModel = new KategoriModel();
        $this->subkategoriModel = new SubkategoriModel();
        $this->sorotModel = new SorotModel();
        $this->eventModel = new EventModel();
        $this->prodiModel = new ProdiModel();
    }

    public function read($id_dokumen)
    {
        $codedokumen = base64_decode($id_dokumen);
        $id_account = session()->get('account_id'); 
        $username = session()->get('username'); 
        $profile = $this->akunModel->find($username);
        $prodi = $this->prodiModel->where('id_prodi !=', 0)->findAll();
        
        $data = [
            'profile' => $profile,
            'user' => $this->akunModel
                ->where('account_id', $id_account)
                ->findAll(),
            'dokumen' => $this->berkasModel
                ->join('event', 'event.id_event = berkas.id_event')
                ->find($codedokumen),
            'prodi' => $prodi,
        ];
        
    
        return view('uploader/event/create', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            // Validasi aturan
            $validationRules = [
                'eventTitle' => 'required',
                'start_datetime' => 'required',
                'end_datetime' => 'required',
                'price' => 'required',
                'eventContent' => 'required',
                'link_event' => 'required',
                'id_dokumen' => 'required',
                'prodi' => 'required',
            ];
    
            if ($this->validate($validationRules)) {
                // Mendapatkan data dari formulir
                $eventTitle = $this->request->getPost('eventTitle');
                $eventImage = $this->request->getFile('eventImage');
                $start_datetime = $this->request->getPost('start_datetime');
                $end_datetime = $this->request->getPost('end_datetime');
                $eventContent = $this->request->getPost('eventContent');
                $link_event = $this->request->getPost('link_event');
                $price = $this->request->getPost('price');
                $prodi = $this->request->getPost('prodi');
                $id_dokumen = $this->request->getPost('id_dokumen');
                $id_event = mt_rand(1000000, 9999999);
    
                // Check if the uploaded image is valid and move it to the appropriate directory
                $eventImage = $this->request->getFile('eventImage');
    
                // Mengecek apakah berkas gambar diunggah dengan benar
                if ($eventImage->isValid() && !$eventImage->hasMoved()) {
                    // Menentukan lebar dan tinggi maksimum dalam piksel
                    $minWidth = 310;
                    $maxHeight = 170;
                    $minHeight = 166;
    
                    // Mendapatkan resolusi berkas gambar
                    list($width, $height) = getimagesize($eventImage->getTempName());
    
                    // Memeriksa apakah resolusi berkas gambar sesuai dengan batas yang diizinkan
                    if ($width >= $minWidth && $height <= $maxHeight && $height >= $minHeight) {
                        // Resolusi berkas gambar sesuai dengan batas maksimum dan minimum yang diizinkan,
                        // lanjutkan dengan pengolahan
                        $newFileName = $eventImage->getRandomName();
                        $eventImage->move(ROOTPATH . 'public/uploads', $newFileName);
                    } else {
                        // Resolusi berkas gambar di luar batas yang diizinkan, tampilkan pesan kesalahan
                        return redirect()->back()->withInput()->with('error', 'Resolusi berkas gambar tidak sesuai. Lebar minimal ' . $minWidth . ' piksel, tinggi minimum ' . $minHeight . ' piksel, dan tinggi maksimum ' . $maxHeight . ' piksel diizinkan.');
                    }
    
                    // Menyiapkan data event sebagai array
                    $event = [
                        'id_event' => $id_event,
                        'id_prodi' => $prodi,
                        'judul_event' => $eventTitle,
                        'banner_event' => $newFileName,
                        'mulai_event' => $start_datetime,
                        'akhir_event' => $end_datetime,
                        'harga' => $price,
                        'link_event' => $link_event,
                        'materi_event' => $eventContent,
                    ];
                    $berkas = [
                        'id_event' => $id_event,
                        'id_kategori' => 13,
                        'id_status' => 1,
                    ];
                    $this->eventModel->insert($event);
    
                    // Update data in berkasModel
                    $this->berkasModel->update($id_dokumen, $berkas);
    
                    // Set success flash message
                    session()->setFlashdata('success', 'Event berhasil ditambahkan.');
    
                    // Redirect the user to another page (e.g., admin/materi)
                    return redirect()->to(base_url('uploader/materi'));
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengunggah Banner.');
                }
            } else {
                // Jika validasi gagal, dapatkan pesan kesalahan validasi
                $validationErrors = \Config\Services::validation()->getErrors();
    
                // Set error flash message
                session()->setFlashdata('error', $validationErrors);
    
                // Redirect the user back to the form with input data
                return redirect()->back()->withInput();
            }
        } else {
            // Menghandle permintaan GET (menampilkan formulir)
            $username = session()->get('username');
            $profile = $this->akunModel->find($username);
            $prodi = $this->prodiModel->where('id_prodi !=', 0)->findAll();
            $data = [
                'profile' => $profile,
                'prodi' => $prodi,
                'berkas' => $this->berkasModel
                    ->join('kategori', 'kategori.id_kategori = berkas.id_kategori')
                    ->join('akun', 'akun.account_id = berkas.account_id')
                    ->join('sorotan', 'sorotan.id_sorot = berkas.id_sorot')
                    ->findAll(),
            ];
    
            // Load the view file (assuming 'Views' folder structure)
            return view('uploader/event/create', $data);
        }
    }
    

}
