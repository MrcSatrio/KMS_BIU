<?php

namespace App\Controllers\Public;
use \App\Controllers\BaseController;
class index extends BaseController
{
    public function index()
    {
        $data =
        [
            'title' => 'Parking Management System'
        ]; 
        return view('public/index', $data);
    }

    public function knowledge()
    {
        return view('public/knowledge');
    }
}
