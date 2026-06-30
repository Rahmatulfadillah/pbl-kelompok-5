<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;
use App\Models\GeojsonConfigModel;

class Geojson extends BaseController
{
    private function checkAccess()
    {
        $role = session()->get('role');
        if (!session()->get('isLoggedIn') || !in_array($role, ['admin_super', 'admin_sekolah', 'admin'], true)) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login sebagai admin!');
        }

        return null;
    }

    public function index()
    {
        $redirect = $this->checkAccess();
        if ($redirect) {
            return $redirect;
        }
        
        $model = new GeojsonConfigModel();
        $data['geojson'] = $model->orderBy('id', 'DESC')->findAll();
        $data['title'] = 'GeoJSON Overlay';
        
        return view('admin/geojson/index', $data);
    }
    
    public function tambah()
    {
        $redirect = $this->checkAccess();
        if ($redirect) {
            return $redirect;
        }
        
        $data['title'] = 'Tambah GeoJSON';
        return view('admin/geojson/tambah', $data);
    }
    
    public function simpan()
    {
        $redirect = $this->checkAccess();
        if ($redirect) {
            return $redirect;
        }
        
        $model = new GeojsonConfigModel();
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'file_path' => $this->request->getPost('file_path'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'warna' => $this->request->getPost('warna'),
            'fill_opacity' => $this->request->getPost('fill_opacity'),
            'stroke_color' => $this->request->getPost('stroke_color'),
            'stroke_width' => $this->request->getPost('stroke_width'),
        ];
        
        if ($model->save($data)) {
            $logModel = new ActivityLogModel();
            $logModel->insert([
                'user_id' => session()->get('user_id'),
                'admin_name' => session()->get('nama_lengkap'),
                'action' => 'create',
                'entity_type' => 'geojson',
                'entity_id' => $model->insertID(),
                'description' => 'Menambahkan konfigurasi GeoJSON ' . ($this->request->getPost('nama') ?? ''),
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/admin/geojson')->with('success', 'GeoJSON berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan GeoJSON!')->withInput();
        }
    }
    
    public function edit($id)
    {
        $redirect = $this->checkAccess();
        if ($redirect) {
            return $redirect;
        }
        
        $model = new GeojsonConfigModel();
        $data['geojson'] = $model->find($id);
        
        if (!$data['geojson']) {
            return redirect()->to('/admin/geojson')->with('error', 'Data tidak ditemukan!');
        }
        
        $data['title'] = 'Edit GeoJSON';
        return view('admin/geojson/edit', $data);
    }
    
    public function update($id)
    {
        $redirect = $this->checkAccess();
        if ($redirect) {
            return $redirect;
        }
        
        $model = new GeojsonConfigModel();
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'file_path' => $this->request->getPost('file_path'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'warna' => $this->request->getPost('warna'),
            'fill_opacity' => $this->request->getPost('fill_opacity'),
            'stroke_color' => $this->request->getPost('stroke_color'),
            'stroke_width' => $this->request->getPost('stroke_width'),
        ];
        
        if ($model->update($id, $data)) {
            $logModel = new ActivityLogModel();
            $logModel->insert([
                'user_id' => session()->get('user_id'),
                'admin_name' => session()->get('nama_lengkap'),
                'action' => 'update',
                'entity_type' => 'geojson',
                'entity_id' => $id,
                'description' => 'Mengubah konfigurasi GeoJSON ' . ($this->request->getPost('nama') ?? ''),
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/admin/geojson')->with('success', 'GeoJSON berhasil diupdate!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate GeoJSON!');
        }
    }
    
    public function hapus($id)
    {
        $redirect = $this->checkAccess();
        if ($redirect) {
            return $redirect;
        }
        
        $model = new GeojsonConfigModel();
        
        if ($model->delete($id)) {
            $logModel = new ActivityLogModel();
            $logModel->insert([
                'user_id' => session()->get('user_id'),
                'admin_name' => session()->get('nama_lengkap'),
                'action' => 'delete',
                'entity_type' => 'geojson',
                'entity_id' => $id,
                'description' => 'Menghapus konfigurasi GeoJSON',
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/admin/geojson')->with('success', 'GeoJSON berhasil dihapus!');
        } else {
            return redirect()->to('/admin/geojson')->with('error', 'Gagal menghapus GeoJSON!');
        }
    }
}