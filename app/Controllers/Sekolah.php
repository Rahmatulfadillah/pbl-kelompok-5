<?php

namespace App\Controllers;

use App\Models\SekolahModel;
use App\Models\GeojsonConfigModel;

class Sekolah extends BaseController
{
    public function index()
    {
        $sekolahModel = new SekolahModel();
        $geojsonModel = new GeojsonConfigModel();
        
        // PERBAIKAN: Mengambil data langsung tanpa JOIN karena kolom 'jenjang' sudah ada di tabel sekolah
        $data['sekolah'] = $sekolahModel->findAll();
        
        // Mengambil layer geojson yang aktif
        $data['geojson_layers'] = $geojsonModel->where('is_active', 1)->orderBy('nama')->findAll();
        
        return view('peta/index', $data);
    }

    public function fullMap()
    {
        $sekolahModel = new SekolahModel();
        $geojsonModel = new GeojsonConfigModel();
        
        // PERBAIKAN: Mengambil data langsung tanpa JOIN di halaman full map
        $data['sekolah'] = $sekolahModel->findAll();
        
        // Mengambil layer geojson yang aktif
        $data['geojson_layers'] = $geojsonModel->where('is_active', 1)->orderBy('nama')->findAll();
        
        return view('peta/full_map', $data);
    }
}