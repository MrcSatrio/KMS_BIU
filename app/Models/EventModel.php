<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table      = 'event';
    protected $primaryKey = 'id_event';

    protected $useAutoIncrement = false;

    protected $allowedFields = ['id_event','judul_event','banner_event','mulai_event','akhir_event','link_event', 'harga', 'materi_event'];
}
