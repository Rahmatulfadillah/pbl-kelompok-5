<?php

use App\Models\UserModel;

if (!function_exists('get_navbar')) {
    function get_navbar()
    {
        $isLoggedIn = session()->get('isLoggedIn');
        $namaLengkap = session()->get('nama_lengkap');
        $userId = session()->get('user_id');
        $foto = '';
        
        if ($isLoggedIn && $userId) {
            $model = new UserModel();
            $user = $model->find($userId);
            $foto = $user['foto'] ?? '';
        }
        
        $currentUrl = current_url();
        $baseUrl = base_url();
        
        $navbar = '
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="' . base_url('/') . '">
                    <i class="fas fa-school me-2"></i><strong>EduMap Lintau Buo</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link ' . ($currentUrl == base_url('/') ? 'active' : '') . '" href="' . base_url('/') . '"><i class="fas fa-home me-1"></i>Beranda</a></li>
                        <li class="nav-item"><a class="nav-link ' . (strpos($currentUrl, '/peta') !== false ? 'active' : '') . '" href="' . base_url('/peta') . '"><i class="fas fa-map-marked-alt me-1"></i>Peta Sekolah</a></li>
                        <li class="nav-item"><a class="nav-link ' . (strpos($currentUrl, '/about') !== false ? 'active' : '') . '" href="' . base_url('/about') . '"><i class="fas fa-info-circle me-1"></i>Tentang</a></li>
                        <li class="nav-item"><a class="nav-link ' . (strpos($currentUrl, '/kontak') !== false ? 'active' : '') . '" href="' . base_url('/kontak') . '"><i class="fas fa-envelope me-1"></i>Kontak</a></li>';
        
        if ($isLoggedIn) {
            // Jika sudah login, tampilkan nama admin + foto
            $fotoHtml = '';
            if ($foto && file_exists('uploads/foto_profil/' . $foto)) {
                $fotoHtml = '<img src="' . base_url('uploads/foto_profil/' . $foto) . '" alt="Profile" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; margin-right: 8px;">';
            } else {
                $fotoHtml = '<i class="fas fa-user-circle me-1" style="font-size: 1.2rem;"></i>';
            }
            
            $navbar .= '
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" style="gap: 5px;">
                                ' . $fotoHtml . ' ' . htmlspecialchars($namaLengkap) . '
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="' . base_url('/admin/dashboard') . '"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="' . base_url('/admin/profil') . '"><i class="fas fa-user-circle me-2"></i>Profil Saya</a></li>
                                <li><a class="dropdown-item" href="' . base_url('/admin/ganti_password') . '"><i class="fas fa-key me-2"></i>Ganti Password</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="' . base_url('/auth/logout') . '"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>';
        } else {
            // Jika belum login, tampilkan tombol login
            $navbar .= '
                        <li class="nav-item ms-2">
                            <a class="nav-link btn btn-primary text-white px-3 py-1 rounded-pill" href="' . base_url('/auth/login') . '" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>';
        }
        
        $navbar .= '
                    </ul>
                </div>
            </div>
        </nav>';
        
        return $navbar;
    }
}