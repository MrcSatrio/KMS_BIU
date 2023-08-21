<?php

namespace App\Controllers\Public;
use \App\Controllers\BaseController;
class index extends BaseController
{
    public function index(): string
    {
        return view('public/index');
    }

    public function knowledge(): string
    {
        return view('public/knowledge');
    }
}
