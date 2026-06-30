<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $existing = $userModel->where('username', 'superadmin')->first();
        if ($existing) {
            return;
        }

        $userModel->insert([
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => 'superadmin123',
            'nama_lengkap' => 'Super Admin',
            'role' => 'admin_super',
            'school_id' => null,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
