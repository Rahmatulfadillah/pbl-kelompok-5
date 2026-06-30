<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }
        return view('auth/login');
    }
    
    public function doLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan password harus diisi!');
        }
        
        $model = new UserModel();
        $user = $model->login($username, $password);
        
        if ($user) {
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'],
                'email' => $user['email'],
                'role' => $user['role'],
                'school_id' => $user['school_id'],
                'isLoggedIn' => true
            ]);
            
            // Update last login
            $model->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

            $logModel = new ActivityLogModel();
            $logModel->insert([
                'user_id' => $user['id'],
                'admin_name' => $user['nama_lengkap'],
                'action' => 'login',
                'entity_type' => 'user',
                'entity_id' => $user['id'],
                'description' => 'Login ke sistem admin',
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . $user['nama_lengkap'] . '!');
        } else {
            return redirect()->back()->with('error', 'Username atau password salah!');
        }
    }
    
    public function logout()
    {
        $userId = session()->get('user_id');
        $adminName = session()->get('nama_lengkap');

        if ($userId) {
            $logModel = new ActivityLogModel();
            $logModel->insert([
                'user_id' => $userId,
                'admin_name' => $adminName,
                'action' => 'logout',
                'entity_type' => 'user',
                'entity_id' => $userId,
                'description' => 'Logout dari sistem admin',
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Anda telah logout.');
    }
}