<?php

namespace App\Models;

use CodeIgniter\Model;

class SorotModel extends Model
{
    protected $table      = 'sorotan';
    protected $primaryKey = 'id_sorot';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['id_sorot','nama_sorot','deskripsi_sorotan', 'tgl_mulai', 'tgl_akhir', 'status_sorot'];
}
