<?php

namespace App\Controllers;

class Kontak extends BaseController
{
    public function index()
    {
        $data['title'] = 'Kontak Kami - Pemetaan Sekolah';
        return view('kontak', $data);
    }
}