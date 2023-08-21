<?php

namespace App\Controllers\Public;
use \App\Controllers\BaseController;
class index extends BaseController
{
    public function index()
    {
        return view('public/index');
    }

    public function knowledge()
    {
        return view('public/knowledge');
    }
}
