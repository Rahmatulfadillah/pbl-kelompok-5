<?php

namespace App\Models;

use CodeIgniter\Model;

class SekolahModel extends Model
{
    protected $table = 'sekolah';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'npsn', 
        'nama_sekolah', 
        'jenjang', 
        'status', 
        'akreditasi', 
        'kelurahan', 
        'tahun_berdiri', 
        'alamat', 
        'latitude', 
        'longitude'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}