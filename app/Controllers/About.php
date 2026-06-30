<?php

namespace App\Controllers;

class About extends BaseController
{
    public function index()
    {
        $data['title'] = 'Tentang Kami - Pemetaan Sekolah';
        return view('about', $data);
    }
}