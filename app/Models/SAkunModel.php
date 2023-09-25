<?php

namespace App\Models;

use CodeIgniter\Model;

class SAkunModel extends Model
{
    protected $table      = 'status_akun';
    protected $primaryKey = 'id_status_akun';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['id_status_akun','nama_status_akun'];
}
