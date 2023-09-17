<?php

namespace App\Controllers\Uploader;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use App\Models\BerkasModel;
use App\Models\EventModel;
use App\Models\KategoriModel;
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

    public function __construct()
    {
        $this->akunModel = new AkunModel();
        $this->berkasModel = new BerkasModel();
        $this->kategoriModel = new KategoriModel();
        $this->subkategoriModel = new SubkategoriModel();
        $this->sorotModel = new SorotModel();
        $this->eventModel = new EventModel();
    }

    public function read($id_dokumen)
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
        
    
        return view('uploader/event/create', $data);
    }

    public function create()
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
            return view('uploader/event/create', $data);
        }
    
    }

}
