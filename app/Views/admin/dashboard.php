<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f8ff; }
        .sidebar { background: linear-gradient(135deg, #2563eb, #1d4ed8); min-height: 100vh; color: white; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 10px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.2); color: white; }
        .navbar-top { background: white; border-radius: 15px; padding: 15px 20px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .stat-card { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon { width: 50px; height: 50px; background: rgba(37,99,235,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .stat-icon i { font-size: 24px; color: #2563eb; }
        .navbar { background: white !important; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 10px 0; }
        .navbar-brand { font-size: 1.3rem; font-weight: 800; color: #2563eb !important; }
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
                <!-- Dropdown Admin -->
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> <?= session()->get('nama_lengkap') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= base_url('/admin/dashboard') ?>"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/admin/sekolah') ?>"><i class="fas fa-school me-2"></i>Data Sekolah</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/admin/geojson') ?>"><i class="fas fa-map me-2"></i>GeoJSON Overlay</a></li>
                        <?php if (session()->get('role') === 'admin_super') : ?>
                        <li><a class="dropdown-item" href="<?= base_url('/admin/users') ?>"><i class="fas fa-users-cog me-2"></i>Manajemen Admin</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/admin/activity-logs') ?>"><i class="fas fa-history me-2"></i>Log Aktivitas</a></li>
                        <?php endif; ?>
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
        <div class="col-md-3 col-lg-2 px-0">
            <div class="sidebar p-3">
                <h4 class="text-center mb-4"><i class="fas fa-school me-2"></i>EduMap</h4>
                <hr class="bg-light">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="<?= base_url('/admin/dashboard') ?>" class="nav-link active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                    <li class="nav-item"><a href="<?= base_url('/admin/sekolah') ?>" class="nav-link"><i class="fas fa-school me-2"></i>Data Sekolah</a></li>
                    <li class="nav-item"><a href="<?= base_url('/admin/geojson') ?>" class="nav-link"><i class="fas fa-map me-2"></i>GeoJSON Overlay</a></li>
                    <?php if (session()->get('role') === 'admin_super') : ?>
                    <li class="nav-item"><a href="<?= base_url('/admin/users') ?>" class="nav-link"><i class="fas fa-users-cog me-2"></i>Manajemen Admin</a></li>
                    <li class="nav-item"><a href="<?= base_url('/admin/activity-logs') ?>" class="nav-link"><i class="fas fa-history me-2"></i>Log Aktivitas</a></li>
                    <?php endif; ?>
                    <li class="nav-item mt-4"><a href="<?= base_url('/auth/logout') ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <?php $currentRole = session()->get('role'); $roleLabel = $currentRole === 'admin_super' ? 'Super Admin' : 'Admin Sekolah'; $roleBadge = $currentRole === 'admin_super' ? 'danger' : 'primary'; ?>
            <div class="navbar-top d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard Admin</h4>
                <div><a href="<?= base_url('/admin/sekolah/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-2"></i>Tambah Sekolah</a></div>
            </div>
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h5 class="mb-1">Halo, <?= esc(session()->get('nama_lengkap')) ?></h5>
                        <p class="text-muted mb-0">Anda masuk sebagai <span class="badge bg-<?= $roleBadge ?>"><?= esc($roleLabel) ?></span></p>
                    </div>
                    <div class="text-end">
                        <div class="small text-muted">Username</div>
                        <div class="fw-semibold"><?= esc(session()->get('username')) ?></div>
                    </div>
                </div>
            </div>
            <?php if(session()->getFlashdata('success')): ?><div class="alert alert-success"><?= session()->getFlashdata('success') ?></div><?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div><?php endif; ?>
            <div class="row">
                <div class="col-md-4 mb-4"><div class="stat-card"><div class="d-flex justify-content-between"><div><h6 class="text-muted mb-2">Total Sekolah</h6><h3 class="mb-0"><?= $total_sekolah ?? 0 ?></h3></div><div class="stat-icon"><i class="fas fa-school"></i></div></div></div></div>
                 <div class="col-md-4 mb-4"><div class="stat-card"><div class="d-flex justify-content-between"><div><h6 class="text-muted mb-2">TK</h6><h3 class="mb-0"><?= $total_tk?? 0 ?></h3></div><div class="stat-icon"><i class="fas fa-building text-success"></i></div></div></div></div>
 
                <div class="col-md-4 mb-4"><div class="stat-card"><div class="d-flex justify-content-between"><div><h6 class="text-muted mb-2">SD</h6><h3 class="mb-0"><?= $total_sd ?? 0 ?></h3></div><div class="stat-icon"><i class="fas fa-building text-danger"></i></div></div></div></div>
                <div class="col-md-4 mb-4"><div class="stat-card"><div class="d-flex justify-content-between"><div><h6 class="text-muted mb-2">SMP</h6><h3 class="mb-0"><?= $total_smp ?? 0 ?></h3></div><div class="stat-icon"><i class="fas fa-building text-primary"></i></div></div></div></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>