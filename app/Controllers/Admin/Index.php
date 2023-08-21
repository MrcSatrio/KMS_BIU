<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AkunModel;

class Index extends BaseController
{
    public function index()
    {
        return view('admin/index');
    }
}