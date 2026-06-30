<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Pemetaan Sekolah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f0f8ff; margin-top: 70px; }
        :root { --primary: #2563eb; --text-dark: #1e293b; --white: #ffffff; --shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .navbar { background: var(--white) !important; box-shadow: var(--shadow); padding: 12px 0; }
        .navbar-brand { font-size: 1.4rem; font-weight: 800; color: var(--primary) !important; }
        .nav-link { font-weight: 500; margin: 0 8px; color: var(--text-dark) !important; }
        .nav-link:hover, .nav-link.active { color: var(--primary) !important; }
        .dropdown-menu { border-radius: 12px; box-shadow: var(--shadow); border: none; margin-top: 10px; }
        .dropdown-item:hover { background: #eff6ff; color: var(--primary); }
        .page-header { background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); padding: 40px 0; }
        .page-header h1 { color: white; font-weight: 700; }
        .info-card { background: white; border-radius: 20px; padding: 30px; box-shadow: var(--shadow); margin-bottom: 30px; transition: all 0.3s; }
        .info-card:hover { transform: translateY(-5px); }
        .icon-circle { width: 70px; height: 70px; background: linear-gradient(135deg, var(--primary), #3b82f6); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .icon-circle i { font-size: 30px; color: white; }
        .value-card { background: #f8fafc; border-radius: 15px; padding: 25px; text-align: center; transition: all 0.3s; height: 100%; }
        .value-card:hover { background: linear-gradient(135deg, var(--primary), #3b82f6); color: white; }
        .value-card:hover i, .value-card:hover h4, .value-card:hover p { color: white; }
        .value-card i { font-size: 2rem; color: var(--primary); margin-bottom: 15px; }
        footer { background: #1e293b; padding: 50px 0 20px; color: white; margin-top: 50px; }
        @media (max-width: 768px) { body { margin-top: 60px; } }
    </style>
</head>
<body>

<!-- Navbar Dinamis -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <i class="fas fa-school me-2"></i><strong>EduMap Lintau Buo</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>"><i class="fas fa-home me-1"></i>Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/peta') ?>"><i class="fas fa-map-marked-alt me-1"></i>Peta Sekolah</a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('/about') ?>"><i class="fas fa-info-circle me-1"></i>Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/kontak') ?>"><i class="fas fa-envelope me-1"></i>Kontak</a></li>
                
                <?php if(session()->get('isLoggedIn')): ?>
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" style="gap: 5px;">
                            <i class="fas fa-user-circle me-1" style="font-size: 1.2rem;"></i>
                            <?= session()->get('nama_lengkap') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('/admin/dashboard') ?>"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('/admin/profil') ?>"><i class="fas fa-user-circle me-2"></i>Profil Saya</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('/admin/ganti_password') ?>"><i class="fas fa-key me-2"></i>Ganti Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('/auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-2">
                        <a class="nav-link btn btn-primary text-white px-3 py-1 rounded-pill" href="<?= base_url('/auth/login') ?>" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="page-header">
    <div class="container text-center">
        <h1><i class="fas fa-info-circle me-3"></i>Tentang EduMap Lintau Buo</h1>
        <p>Sistem Informasi Pemetaan Sekolah TK, SD dan SMP Se-Kabupaten Tanah Datar</p>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="info-card text-center">
                <div class="icon-circle"><i class="fas fa-map-marked-alt"></i></div>
                <h3>Apa Itu EduMap Lintau Buo?</h3>
                <p class="text-secondary">EduMap Lintau Buo adalah aplikasi pemetaan sekolah berbasis web yang bertujuan untuk memudahkan masyarakat, orang tua siswa, dan pemerintah dalam melihat distribusi fasilitas pendidikan di Kabupaten Tanah Datar, Sumatera Barat.</p>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12"><h3 class="text-center mb-4 fw-bold"><i class="fas fa-bullseye me-2 text-primary"></i>Tujuan Aplikasi</h3></div>
        <div class="col-md-4 mb-4"><div class="value-card"><i class="fas fa-search-location"></i><h4>Memudahkan Pencarian</h4><p>Memudahkan masyarakat mencari lokasi sekolah terdekat</p></div></div>
        <div class="col-md-4 mb-4"><div class="value-card"><i class="fas fa-chart-line"></i><h4>Visualisasi Data</h4><p>Menyajikan data distribusi sekolah dalam bentuk peta</p></div></div>
        <div class="col-md-4 mb-4"><div class="value-card"><i class="fas fa-building"></i><h4>Perencanaan Pembangunan</h4><p>Membantu pemerintah dalam perencanaan fasilitas pendidikan</p></div></div>
    </div>
</div>

<footer>
    <div class="container text-center small text-white-50">&copy; <?= date('Y') ?> EduMap Tanah Datar. Built with <i class="fas fa-heart text-danger"></i> for Education</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>