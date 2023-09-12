<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunModel extends Model
{
    protected $table      = 'akun';
    protected $primaryKey = 'account_id';

    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = ['account_id','nama', 'username', 'password','email','foto_profile','id_role', 'created_at', 'updated_at'];
}
