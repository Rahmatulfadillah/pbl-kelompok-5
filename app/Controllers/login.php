<?php
namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        // Jika sudah login
        if (session()->get('login')) {
            return redirect()->to('/dashboard');
        }
        return view('login_view');
    }

    public function proses()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Data login hardcode (tanpa database)
        $valid_username = 'admin';
        $valid_password = 'admin123';
        
        if ($username == $valid_username && $password == $valid_password) {
            session()->set([
                'login' => true,
                'username' => $username,
                'nama' => 'Administrator'
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->to('/login')->with('error', 'Username atau password salah!');
        }
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    
    public function dashboard()
    {
        if (!session()->get('login')) {
            return redirect()->to('/login');
        }
        return view('dashboard_view');
    }
}