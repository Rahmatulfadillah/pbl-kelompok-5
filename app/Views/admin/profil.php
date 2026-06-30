<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f8ff; }
        .sidebar { background: linear-gradient(135deg, #2563eb, #1d4ed8); min-height: 100vh; color: white; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 10px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.2); color: white; }
        .navbar-top { background: white; border-radius: 15px; padding: 15px 20px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .navbar { background: white !important; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 10px 0; }
        .navbar-brand { font-size: 1.3rem; font-weight: 800; color: #2563eb !important; }
        .profile-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .profile-img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 5px solid #2563eb; }
        .info-label { font-weight: 600; color: #1e293b; width: 150px; }
        .info-value { color: #64748b; }
        .btn-action { padding: 8px 20px; border-radius: 10px; margin-right: 10px; }
    </style>
</head>
<body>
<!-- Navbar untuk Admin (tanpa tombol login, tapi dengan dropdown user) -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>"><i class="fas fa-school me-2"></i><strong>EduMap Lintau Buo</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>"><i class="fas fa-home me-1"></i>Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/peta') ?>"><i class="fas fa-map-marked-alt me-1"></i>Peta Sekolah</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/about') ?>"><i class="fas fa-info-circle me-1"></i>Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/kontak') ?>"><i class="fas fa-envelope me-1"></i>Kontak</a></li>
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> <?= session()->get('nama_lengkap') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= base_url('/admin/dashboard') ?>"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/admin/sekolah') ?>"><i class="fas fa-school me-2"></i>Data Sekolah</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/admin/profil') ?>"><i class="fas fa-user-circle me-2"></i>Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('/auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container-fluid" style="margin-top: 70px;">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3">
                    <h4 class="text-center mb-4"><i class="fas fa-school me-2"></i>EduMap</h4>
                    <hr class="bg-light">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="<?= base_url('/admin/dashboard') ?>" class="nav-link"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                        <li class="nav-item"><a href="<?= base_url('/admin/sekolah') ?>" class="nav-link"><i class="fas fa-school me-2"></i>Data Sekolah</a></li>
                                            <li class="nav-item"><a href="<?= base_url('/admin/geojson') ?>" class="nav-link"><i class="fas fa-map me-2"></i>GeoJSON Overlay</a></li>

                        <li class="nav-item mt-4"><a href="<?= base_url('/auth/logout') ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="navbar-top d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user-circle me-2 text-primary"></i><?= $title ?></h4>
                    <div>
                        <a href="<?= base_url('/admin/edit_profil') ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit me-2"></i>Edit Profil</a>
                        <a href="<?= base_url('/admin/ganti_password') ?>" class="btn btn-warning btn-sm"><i class="fas fa-key me-2"></i>Ganti Password</a>
                    </div>
                </div>
                
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="profile-card">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <?php if($user['foto'] && file_exists('uploads/foto_profil/' . $user['foto'])): ?>
                                <img src="<?= base_url('uploads/foto_profil/' . $user['foto']) ?>" class="profile-img mb-3" alt="Profile">
                            <?php else: ?>
                                <div class="profile-img bg-primary d-flex align-items-center justify-content-center mx-auto mb-3" style="background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;">
                                    <i class="fas fa-user fa-4x text-white"></i>
                                </div>
                            <?php endif; ?>
                            
                            <form action="<?= base_url('/admin/uploadFoto') ?>" method="post" enctype="multipart/form-data" class="mt-3">
                                <?= csrf_field() ?>
                                <div class="mb-2">
                                    <input type="file" name="foto" class="form-control form-control-sm" accept="image/*" required>
                                </div>
                                <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fas fa-upload me-1"></i>Upload Foto</button>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <h4 class="mb-4">Informasi Profil</h4>
                            <div class="row mb-3">
                                <div class="col-4 fw-bold">Username</div>
                                <div class="col-8">: <?= $user['username'] ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 fw-bold">Nama Lengkap</div>
                                <div class="col-8">: <?= $user['nama_lengkap'] ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 fw-bold">Email</div>
                                <div class="col-8">: <?= $user['email'] ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 fw-bold">Role</div>
                                <div class="col-8">: <span class="badge bg-primary"><?= $user['role'] ?></span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 fw-bold">Status</div>
                                <div class="col-8">: <?= $user['is_active'] ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>' ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 fw-bold">Terdaftar Sejak</div>
                                <div class="col-8">: <?= date('d-m-Y H:i', strtotime($user['created_at'])) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>