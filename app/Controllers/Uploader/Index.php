<?php

namespace App\Controllers\Uploader;
use \App\Controllers\BaseController;
class index extends BaseController
{
    public function index(): string
    {
        return view('uploader/index');
    }

}
