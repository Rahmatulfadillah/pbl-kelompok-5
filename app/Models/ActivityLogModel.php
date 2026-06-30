<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'user_id',
        'admin_name',
        'action',
        'entity_type',
        'entity_id',
        'description',
        'ip_address',
        'user_agent',
        'created_at',
    ];
    protected $useTimestamps = false;

    public function delete($id = null, $purge = false)
    {
        return false;
    }
}
