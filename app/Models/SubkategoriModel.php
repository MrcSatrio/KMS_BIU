<?php

namespace App\Models;

use CodeIgniter\Model;

class SubkategoriModel extends Model
{
    protected $table      = 'sub_kategori';
    protected $primaryKey = 'id_sub_kategori';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['id_sub_kategori','nama_sub_kategori','id_kategori'];
    
}
