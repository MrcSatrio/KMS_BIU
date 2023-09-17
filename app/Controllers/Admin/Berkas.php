<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\BerkasModel;
use App\Models\EventModel;
use App\Models\KategoriModel;
use App\Models\SubkategoriModel;
use App\Models\SorotModel;
use App\Models\StatusModel;

class Berkas extends BaseController
{
    protected $akunModel;
    protected $berkasModel;
    protected $kategoriModel;
    protected $subkategoriModel;
    protected $sorotModel;
    protected $statusModel;
    protected $eventModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
        $this->berkasModel = new BerkasModel();
        $this->kategoriModel = new KategoriModel();
        $this->subkategoriModel = new SubkategoriModel();
        $this->sorotModel = new SorotModel();
        $this->statusModel = new StatusModel();
        $this->eventModel = new EventModel();

    }

    public function read()
    {
        $username = session()->get('username'); // Mengambil username dari session
        $profie = $this->akunModel->find($username);
        $data = [
            'profile' => $profie,
            'user' => $this->akunModel
                ->join('role', 'role.id_role = akun.id_role')
                ->where('username', $username)
                ->first(),
            'berkas' => $this->berkasModel
                ->join('kategori', 'kategori.id_kategori = berkas.id_kategori')
                ->join('akun', 'akun.account_id = berkas.account_id')
                ->findAll(), // Use findAll() to get all results
        ];

        return view('admin/berkas/read', $data);
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
        $documentVideo = $this->request->getPost('documentVideo');
        $documentType = $this->request->getPost('documentType');
        $documentContent = $this->request->getPost('documentContent');
        $sub_kategori = $this->request->getPost('sub_kategori');
        $documentFile = $this->request->getFile('documentFile');

        // Validasi input data
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            session()->setFlashdata('error', $errors);
            return redirect()->to('admin/upload'); // Redirect kembali ke halaman upload dengan pesan kesalahan dan data input sebelumnya.
        }
        
        

        // Handle the uploaded document file
        if ($documentFile->isValid() && !$documentFile->hasMoved()) {
            $newFileName = $documentFile->getRandomName();
            $documentFile->move(ROOTPATH . 'public/uploads', $newFileName);
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah berkas.'); // Jika gagal mengunggah berkas, kembali ke halaman upload dengan pesan kesalahan.
        }

        $id_sorot = mt_rand(1000000, 9999999); // Menghasilkan nilai integer acak dalam rentang tertentu
        $account_id = $_SESSION['account_id'];
        $databerkas = [
            'judul' => $documentTitle,
            'account_id' => $account_id,
            'deskripsi' => $documentContent,
            'video' => $documentVideo,
            'id_kategori' => $documentType,
            'id_sorot' => $id_sorot,
            'id_sub_kategori' => $sub_kategori,
            'berkas' => $newFileName, // Simpan nama berkas dalam database
        ];
        $datasorotan = [
            'id_sorot' => $id_sorot,
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
        $profie = $this->akunModel->find($username);
        $data = [
            'profile' => $profie,
            'kategori' => $this->kategoriModel
            ->join('sub_kategori', 'sub_kategori.id_kategori = kategori.id_kategori')
            ->findAll(),
        ];
        
        return view('admin/berkas/upload', $data);
    }
}
public function status($id_dokumen)
{
    $berkas = [
        'id_status' => 2
    ];

    // Update the document's status
    $this->berkasModel->update($id_dokumen, $berkas);

    // Set a success flash message
    session()->setFlashdata('success', 'Materi berhasil DiSetujui.');

    // Redirect the user to another page (e.g., the category list page)
    return redirect()->to('admin/materi');
}


public function delete($id_dokumen)
{
    $dokumen = $this->berkasModel->find($id_dokumen);

    if ($dokumen) {
        $this->berkasModel->delete($id_dokumen);

        // Tampilkan pesan sukses dengan SweetAlert
        session()->setFlashdata('success', 'Materi berhasil diHapus.');

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/materi');
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error

        // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
        return redirect()->to('admin/materi');
    }

}
public function update($id_dokumen)
{
    $id_account = session()->get('account_id'); 
    $dokumen = $this->berkasModel->find($id_dokumen);
    $username = session()->get('username'); 
    $profile = $this->akunModel->find($username);
    // Ambil data kategori (mungkin perlu menyesuaikan nama model dan metode)

    $data = [
        'profile' => $profile,
        'user' => $this->akunModel
        ->where('account_id', $id_account)
        ->findAll(),
        'dokumen' => $dokumen,
        'kategori' => $this->kategoriModel
        ->join('sub_kategori', 'sub_kategori.id_kategori = kategori.id_kategori')
        ->findAll(),
    ];

    return view('admin/berkas/update', $data);
}
public function update_action()
{
    if ($this->request->getMethod() === 'post') {
        // Validasi input
        $validationRules = [
            'documentTitle' => 'required',
            'documentType' => 'required',
            'documentVideo' => 'required',
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
            ];

            // Update data subkategori berdasarkan $id_sub_kategori
            $this->berkasModel->update($id_dokumen, $berkas);

            session()->setFlashdata('success', 'Kategori berhasil diperbarui.');

            // Mengalihkan pengguna ke halaman lain (misalnya halaman daftar kategori)
            return redirect()->to('admin/materi');
        } else {
            // Jika validasi gagal, tampilkan pesan kesalahan
            $validationErrors = $this->validator->getErrors();
            session()->setFlashdata('error', $validationErrors);

            // Mengembalikan pengguna ke halaman formulir dengan data input sebelumnya
            return redirect()->back()->withInput();
        }
    }
}
public function event_read()
{
    $username = session()->get('username'); 
    $profile = $this->akunModel->find($username);
    $data = [
        'profile' => $profile,
        'event' => $this->berkasModel
            ->join('event', 'event.id_event = berkas.id_event')
            ->join('akun', 'akun.account_id = berkas.account_id')
            ->where('berkas.id_event !=', 0)
            ->findAll()
    ];
    return view('admin/berkas/event_read', $data);
}

public function event($id_dokumen)
{
    $id_account = session()->get('account_id'); 
    $username = session()->get('username'); 
    $profile = $this->akunModel->find($username);
    
    $data = [
        'profile' => $profile,
        'user' => $this->akunModel
            ->where('account_id', $id_account)
            ->findAll(),
        'dokumen' => $this->berkasModel
            ->join('event', 'event.id_event = berkas.id_event')
            ->find($id_dokumen),
    ];
    

    return view('admin/berkas/event', $data);
}

    public function event_create()
    {
        if ($this->request->getMethod() === 'post') {
            // Validation rules
            $validationRules = [
                'eventTitle' => 'required',
                'eventImage' => 'uploaded[eventImage]|max_size[eventImage,1024]|is_image[eventImage]',
                'start_datetime' => 'required',
                'end_datetime' => 'required',
                'price' => 'required',
                'eventContent' => 'required',
                'link_event' => 'required',
                'id_dokumen' => 'required',
            ];

            if ($this->validate($validationRules)) {
                // Retrieve form input
                $eventTitle = $this->request->getPost('eventTitle');
                $eventImage = $this->request->getFile('eventImage');
                $start_datetime = $this->request->getPost('start_datetime');
                $end_datetime = $this->request->getPost('end_datetime');
                $eventContent = $this->request->getPost('eventContent');
                $link_event = $this->request->getPost('link_event');
                $price = $this->request->getPost('price');
                $id_dokumen = $this->request->getPost('id_dokumen');
                $id_event = mt_rand(1000000, 9999999);

                // Check if the uploaded image is valid and move it to the appropriate directory
                if ($eventImage->isValid() && !$eventImage->hasMoved()) {
                    $newFileName = $eventImage->getRandomName();
                    $eventImage->move(ROOTPATH . 'public/uploads', $newFileName);

                    // Prepare event data as an array
                    $event = [
                        'id_event' => $id_event,
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
                        'id_kategori' => 13
                    ];
                    $this->eventModel->insert($event);

                    // Update data in berkasModel
                    $this->berkasModel->update($id_dokumen, $berkas);

                    // Set success flash message
                    session()->setFlashdata('success', 'Event berhasil ditambahkan.');

                    // Redirect the user to another page (e.g., admin/materi)
                    return redirect()->to(base_url('admin/event'));
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengunggah Banner.');
                }
            } else {
                // If validation fails, get validation errors
                $validationErrors = \Config\Services::validation()->getErrors();

                // Set error flash message
                session()->setFlashdata('error', $validationErrors);

                // Redirect the user back to the form with input data
                return redirect()->back()->withInput();
            }
        } else {
            // Handle GET requests (render the form)
            $username = session()->get('username');
            $profile = $this->akunModel->find($username);
            $data = [
                'profile' => $profile,
                'berkas' => $this->berkasModel
                    ->join('kategori', 'kategori.id_kategori = berkas.id_kategori')
                    ->join('akun', 'akun.account_id = berkas.account_id')
                    ->join('sorotan', 'sorotan.id_sorot = berkas.id_sorot')
                    ->findAll(),
            ];

            // Load the view file (assuming 'Views' folder structure)
            return view('admin/berkas/event_create', $data);
        }
    }


public function event_delete($id_dokumen)
{
    $dokumen = $this->berkasModel->find($id_dokumen);
    // Mengubah nilai 'id_event' dalam dokumen menjadi 0
    $this->berkasModel->update($id_dokumen, ['id_event' => 0]);
    if (is_array($dokumen) && isset($dokumen['id_event'])) {
        $id_event = $dokumen['id_event'];
        $event = $this->eventModel->find($id_event);

        if ($event) {
            $this->eventModel->delete($id_event);
        }

        

        // Tampilkan pesan sukses dengan SweetAlert
        session()->setFlashdata('success', 'Event berhasil dihapus.');
    }

    // Redirect ke halaman lain setelah operasi selesai
    return redirect()->to('admin/event');
}






}
