<?php

namespace App\Controllers;

use App\Models\SekolahModel;
use App\Models\GeojsonConfigModel;

class Home extends BaseController
{
    public function index()
    {
        $sekolahModel = new SekolahModel();
        $geojsonModel = new GeojsonConfigModel();
        
        $data = [
            'total_sekolah' => $sekolahModel->countAll(),
            'total_tk' => $sekolahModel->where('jenjang', 'TK')->countAllResults(),
            'total_sd' => $sekolahModel->where('jenjang', 'SD')->countAllResults(),
            'total_smp' => $sekolahModel->where('jenjang', 'SMP')->countAllResults(),
            'sekolah_terbaru' => $sekolahModel->orderBy('created_at', 'DESC')->findAll(5),
            'sekolah' => $sekolahModel->findAll(),
            'geojson_layers' => $geojsonModel->where('is_active', 1)->findAll(),
        ];
        
        return view('home', $data);
    }
}