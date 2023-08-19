<?php

namespace App\Controllers;

class Home extends BaseController
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
