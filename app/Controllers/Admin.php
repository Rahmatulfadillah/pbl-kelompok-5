<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;
use App\Models\SekolahModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    private function logActivity($action, $entityType = null, $entityId = null, $description = null)
    {
        $logModel = new ActivityLogModel();

        $data = [
            'user_id' => session()->get('user_id'),
            'admin_name' => session()->get('nama_lengkap'),
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'description' => $description,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $logModel->insert($data);
    }

    private function checkAdmin()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu!');
        }
        
        $role = session()->get('role');
        if ($role !== 'admin_super' && $role !== 'admin_sekolah') {
            return redirect()->to('/auth/login')->with('error', 'Akses ditolak!');
        }
        return null;
    }
    
    private function checkSuperAdmin()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        if (session()->get('role') !== 'admin_super') {
            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak! Hanya Super Admin yang bisa mengakses halaman ini.');
        }
        return null;
    }
    
    public function dashboard()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $sekolahModel = new SekolahModel();
        $userModel = new UserModel();
        
        // Jika admin sekolah, hanya lihat data sekolahnya
        $userId = session()->get('user_id');
        $role = session()->get('role');
        
        if ($role === 'admin_sekolah') {
            $schoolId = $userModel->getSekolahByAdmin($userId);
            $data['total_sekolah'] = $schoolId ? 1 : 0;
            $data['total_sd'] = $sekolahModel->where('id', $schoolId)->where('jenjang', 'SD')->countAllResults();
            $data['total_smp'] = $sekolahModel->where('id', $schoolId)->where('jenjang', 'SMP')->countAllResults();
            $data['is_super_admin'] = false;
        } else {
            $data['total_sekolah'] = $sekolahModel->countAll();
            $data['total_sd'] = $sekolahModel->where('jenjang', 'SD')->countAllResults();
            $data['total_smp'] = $sekolahModel->where('jenjang', 'SMP')->countAllResults();
            $data['is_super_admin'] = true;
        }
        
        $data['nama'] = session()->get('nama_lengkap');
        $data['username'] = session()->get('username');
        $data['role'] = session()->get('role');
        
        return view('admin/dashboard', $data);
    }
    
    // ========== CRUD SEKOLAH ==========
    
    public function sekolah()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $model = new SekolahModel();
        $userModel = new UserModel();
        
        // Jika admin sekolah, hanya lihat sekolahnya sendiri
        if (session()->get('role') === 'admin_sekolah') {
            $schoolId = $userModel->getSekolahByAdmin(session()->get('user_id'));
            $data['sekolah'] = $model->where('id', $schoolId)->findAll();
        } else {
            $data['sekolah'] = $model->orderBy('id', 'DESC')->findAll();
        }
        
        $data['title'] = 'Data Sekolah';
        $data['is_super_admin'] = session()->get('role') === 'admin_super';
        
        return view('admin/sekolah/index', $data);
    }
    
    public function tambah()
    {
        // Hanya super admin yang bisa tambah sekolah
        $redirect = $this->checkSuperAdmin();
        if ($redirect) return $redirect;
        
        $data['title'] = 'Tambah Sekolah';
        return view('admin/sekolah/tambah', $data);
    }
    
    public function simpan()
    {
        // Hanya super admin yang bisa simpan sekolah
        $redirect = $this->checkSuperAdmin();
        if ($redirect) return $redirect;
        
        // Validasi input
        $rules = [
            'npsn'         => 'required|max_length[8]|is_unique[sekolah.npsn]',
            'nama_sekolah' => 'required|max_length[200]',
            'jenjang'      => 'required|in_list[SD,SMP,TK]',
            'status'       => 'required|in_list[Negeri,Swasta]',
            'kelurahan'    => 'required|max_length[100]',
            'alamat'       => 'required',
            'latitude'     => 'required',
            'longitude'    => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Semua kolom wajib bertanda bintang/krusial harus diisi!');
        }

        $sekolahModel = new SekolahModel();
        $userModel = new UserModel();
        
        // Data sekolah
        $dataSekolah = [
            'npsn'           => $this->request->getPost('npsn'),
            'nama_sekolah'   => $this->request->getPost('nama_sekolah'),
            'jenjang'        => $this->request->getPost('jenjang'),
            'status'         => $this->request->getPost('status'),
            'akreditasi'     => $this->request->getPost('akreditasi') ?: null,
            'kelurahan'      => $this->request->getPost('kelurahan'),
            'tahun_berdiri'  => $this->request->getPost('tahun_berdiri'),
            'alamat'         => $this->request->getPost('alamat'),
            'latitude'       => $this->request->getPost('latitude'),
            'longitude'      => $this->request->getPost('longitude'),
        ];
        
        // Simpan sekolah
        if ($sekolahModel->save($dataSekolah)) {
            $schoolId = $sekolahModel->insertID();
            
            $this->logActivity(
                'create',
                'sekolah',
                $schoolId,
                'Menambahkan data sekolah ' . $this->request->getPost('nama_sekolah')
            );
            
            // ========== BUAT AKUN ADMIN SEKOLAH ==========
            $username = 'admin_' . strtolower(str_replace(' ', '_', $this->request->getPost('nama_sekolah')));
            $email = $this->request->getPost('email') ?: $this->request->getPost('npsn') . '@sekolah.go.id';
            $password = 'password123'; // Password default, bisa diubah nanti
            
            $dataUser = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'nama_lengkap' => 'Admin ' . $this->request->getPost('nama_sekolah'),
                'role' => 'admin_sekolah',
                'school_id' => $schoolId,
                'is_active' => 1
            ];
            
            $userModel->save($dataUser);
            $this->logActivity(
                'create',
                'user',
                $userModel->insertID(),
                'Membuat akun admin sekolah untuk ' . $this->request->getPost('nama_sekolah')
            );
            
            return redirect()->to('/admin/sekolah')->with('success', 'Data sekolah berhasil ditambahkan! Akun admin sekolah juga telah dibuat.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan data!')->withInput();
        }
    }
    
    public function edit($id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $model = new SekolahModel();
        $userModel = new UserModel();
        $data['sekolah'] = $model->find($id);
        
        if (!$data['sekolah']) {
            return redirect()->to('/admin/sekolah')->with('error', 'Data tidak ditemukan!');
        }
        
        // Jika admin sekolah, cek apakah ini sekolahnya
        if (session()->get('role') === 'admin_sekolah') {
            $schoolId = $userModel->getSekolahByAdmin(session()->get('user_id'));
            if ($data['sekolah']['id'] != $schoolId) {
                return redirect()->to('/admin/sekolah')->with('error', 'Anda tidak memiliki akses ke data ini!');
            }
        }
        
        // Ambil data user admin sekolah
        $data['admin_user'] = $userModel->where('school_id', $id)->where('role', 'admin_sekolah')->first();
        $data['title'] = 'Edit Sekolah';
        $data['is_super_admin'] = session()->get('role') === 'admin_super';
        
        return view('admin/sekolah/edit', $data);
    }
    
    public function update($id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $sekolahModel = new SekolahModel();
        $userModel = new UserModel();
        
        // Jika admin sekolah, cek apakah ini sekolahnya
        if (session()->get('role') === 'admin_sekolah') {
            $schoolId = $userModel->getSekolahByAdmin(session()->get('user_id'));
            if ($id != $schoolId) {
                return redirect()->to('/admin/sekolah')->with('error', 'Anda tidak memiliki akses ke data ini!');
            }
        }
        
        $rules = [
            'npsn'         => 'required|max_length[8]',
            'nama_sekolah' => 'required|max_length[200]',
            'jenjang'      => 'required|in_list[SD,SMP,TK]',
            'status'       => 'required|in_list[Negeri,Swasta]',
            'kelurahan'    => 'required|max_length[100]',
            'alamat'       => 'required',
            'latitude'     => 'required',
            'longitude'    => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Semua kolom wajib bertanda bintang/krusial harus diisi!');
        }
        
        $data = [
            'npsn'           => $this->request->getPost('npsn'),
            'nama_sekolah'   => $this->request->getPost('nama_sekolah'),
            'jenjang'        => $this->request->getPost('jenjang'),
            'status'         => $this->request->getPost('status'),
            'akreditasi'     => $this->request->getPost('akreditasi') ?: null,
            'kelurahan'      => $this->request->getPost('kelurahan'),
            'tahun_berdiri'  => $this->request->getPost('tahun_berdiri'),
            'alamat'         => $this->request->getPost('alamat'),
            'latitude'       => $this->request->getPost('latitude'),
            'longitude'      => $this->request->getPost('longitude'),
        ];
        
        if ($sekolahModel->update($id, $data)) {
            $this->logActivity(
                'update',
                'sekolah',
                $id,
                'Mengubah data sekolah ' . $this->request->getPost('nama_sekolah')
            );
            // Update juga data admin sekolah jika ada
            $adminUser = $userModel->where('school_id', $id)->where('role', 'admin_sekolah')->first();
            if ($adminUser) {
                $userData = [
                    'email' => $this->request->getPost('email') ?: $adminUser['email'],
                ];
                // Update password jika diisi
                $newPassword = $this->request->getPost('password_admin');
                if (!empty($newPassword) && strlen($newPassword) >= 6) {
                    $userData['password'] = $newPassword;
                }
                $userModel->update($adminUser['id'], $userData);
            }
            
            return redirect()->to('/admin/sekolah')->with('success', 'Data sekolah berhasil diupdate!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate data!');
        }
    }
    
    public function hapus($id)
    {
        // Hanya super admin yang bisa hapus
        $redirect = $this->checkSuperAdmin();
        if ($redirect) return $redirect;
        
        $model = new SekolahModel();
        $userModel = new UserModel();
        
        // Hapus juga user admin sekolah terkait
        $userModel->where('school_id', $id)->delete();
        
        if ($model->delete($id)) {
            $this->logActivity(
                'delete',
                'sekolah',
                $id,
                'Menghapus data sekolah dan akun admin terkait'
            );
            return redirect()->to('/admin/sekolah')->with('success', 'Data sekolah dan akun admin terkait berhasil dihapus!');
        } else {
            return redirect()->to('/admin/sekolah')->with('error', 'Gagal menghapus data!');
        }
    }
    
    // ========== MANAJEMEN USER (Khusus Super Admin) ==========
    
    public function users()
    {
        $redirect = $this->checkSuperAdmin();
        if ($redirect) return $redirect;
        
        $model = new UserModel();
        $data['users'] = $model->orderBy('id', 'DESC')->findAll();
        $data['title'] = 'Manajemen User';
        
        return view('admin/users/index', $data);
    }

    public function tambahAdmin()
    {
        $redirect = $this->checkSuperAdmin();
        if ($redirect) return $redirect;

        $sekolahModel = new SekolahModel();
        $data['title'] = 'Tambah Admin';
        $data['sekolah'] = $sekolahModel->orderBy('nama_sekolah', 'ASC')->findAll();

        return view('admin/users/tambah', $data);
    }

    public function simpanAdmin()
    {
        $redirect = $this->checkSuperAdmin();
        if ($redirect) return $redirect;

        $userModel = new UserModel();

        $rules = [
            'username' => 'required|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'nama_lengkap' => 'required',
            'role' => 'required|in_list[admin_super,admin_sekolah]',
        ];

        if ($this->request->getPost('role') === 'admin_sekolah') {
            $rules['school_id'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data admin belum lengkap atau ada duplikasi username/email.');
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'role' => $this->request->getPost('role'),
            'school_id' => $this->request->getPost('role') === 'admin_sekolah' ? $this->request->getPost('school_id') : null,
            'is_active' => 1,
        ];

        if ($userModel->save($data)) {
            $this->logActivity(
                'create',
                'user',
                $userModel->insertID(),
                'Menambahkan akun admin ' . $this->request->getPost('nama_lengkap')
            );

            return redirect()->to('/admin/users')->with('success', 'Akun admin berhasil ditambahkan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan akun admin.');
    }

    public function activityLogs()
    {
        $redirect = $this->checkSuperAdmin();
        if ($redirect) return $redirect;

        $logModel = new ActivityLogModel();
        $data['logs'] = $logModel->orderBy('created_at', 'DESC')->findAll();
        $data['title'] = 'Log Aktivitas';

        return view('admin/activity_logs', $data);
    }
    
    public function resetPassword($id)
    {
        $redirect = $this->checkSuperAdmin();
        if ($redirect) return $redirect;
        
        $model = new UserModel();
        $user = $model->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan!');
        }
        
        if ($user['role'] === 'admin_super') {
            return redirect()->to('/admin/users')->with('error', 'Tidak dapat mereset password super admin!');
        }
        
        $model->update($id, ['password' => 'password123']);
        $this->logActivity(
            'reset_password',
            'user',
            $id,
            'Mereset password user ' . ($user['username'] ?? 'unknown')
        );
        
        return redirect()->to('/admin/users')->with('success', 'Password user berhasil direset menjadi "password123"');
    }

    public function hapusAdmin($id)
    {
        $redirect = $this->checkSuperAdmin();
        if ($redirect) return $redirect;

        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan!');
        }

        if ($user['role'] === 'admin_super') {
            return redirect()->to('/admin/users')->with('error', 'Tidak dapat menghapus akun super admin!');
        }

        if ($model->delete($id)) {
            $this->logActivity(
                'delete',
                'user',
                $id,
                'Menghapus akun admin ' . ($user['username'] ?? 'unknown')
            );
            return redirect()->to('/admin/users')->with('success', 'Akun admin berhasil dihapus.');
        }

        return redirect()->to('/admin/users')->with('error', 'Gagal menghapus akun admin.');
    }
}