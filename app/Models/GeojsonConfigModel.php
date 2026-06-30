<?php

namespace App\Models;

use CodeIgniter\Model;

class GeojsonConfigModel extends Model
{
    protected $table = 'geojson_config';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'file_path',
        'is_active',
        'warna',
        'fill_opacity',
        'stroke_color',
        'stroke_width'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
