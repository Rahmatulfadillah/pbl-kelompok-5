<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Perbaikan header navbar agar tidak transparan */
        .navbar.fixed-top {
            background-color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: #f0f8ff; 
        }
        
        /* Sidebar */
        .sidebar { 
            background: linear-gradient(135deg, #2563eb, #1d4ed8); 
            min-height: 100vh; 
            color: white; 
            position: sticky; 
            top: 0; 
        }
        
        .sidebar .nav-link { 
            color: rgba(255,255,255,0.8); 
            padding: 12px 20px; 
            border-radius: 10px; 
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active { 
            background: rgba(255,255,255,0.2); 
            color: white; 
        }
        
        .sidebar .nav-link i {
            width: 25px;
        }
        
        /* Navbar Top */
        .navbar-top { 
            background: white; 
            border-radius: 15px; 
            padding: 15px 20px; 
            margin-bottom: 25px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-top h4 {
            margin: 0;
            color: #1e293b;
            font-weight: 600;
        }
        
        /* Table */
        .table { 
            background: white; 
            border-radius: 15px; 
            overflow: hidden; 
        }
        
        .table th {
            background: #f8fafc;
            font-weight: 600;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .form-select, .form-control { 
            border-radius: 10px; 
        }
        
        .form-check-input { 
            width: 1.3rem; 
            height: 1.3rem; 
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 500;
            color: white;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37,99,235,0.3);
            color: white;
        }
        
        .btn-back-custom {
            background: #64748b;
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 500;
            color: white;
            transition: all 0.3s;
        }
        
        .btn-back-custom:hover {
            background: #475569;
            color: white;
        }
        
        .btn-sm {
            border-radius: 8px;
            padding: 5px 15px;
        }
        
        /* Badge */
        .badge-color-preview {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-right: 5px;
            vertical-align: middle;
            border: 1px solid #e2e8f0;
        }
        
        /* Card */
        .card-shadow {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .card-shadow .card-body {
            padding: 20px;
        }
        
        /* Dropdown */
        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: none;
            margin-top: 10px;
        }
        
        .dropdown-item:hover {
            background: #eff6ff;
            color: #2563eb;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                min-height: auto;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
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
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/') ?>">
                        <i class="fas fa-home me-1"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/peta') ?>">
                        <i class="fas fa-map-marked-alt me-1"></i>Peta Sekolah
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/about') ?>">
                        <i class="fas fa-info-circle me-1"></i>Tentang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/kontak') ?>">
                        <i class="fas fa-envelope me-1"></i>Kontak
                    </a>
                </li>
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> <?= session()->get('nama_lengkap') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= base_url('/admin/dashboard') ?>"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/admin/sekolah') ?>"><i class="fas fa-school me-2"></i>Data Sekolah</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/admin/geojson') ?>"><i class="fas fa-map me-2"></i>GeoJSON Overlay</a></li>
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
                <h4 class="text-center mb-4">
                    <i class="fas fa-school me-2"></i>EduMap
                </h4>
                <hr class="bg-light">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="<?= base_url('/admin/dashboard') ?>" class="nav-link">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/admin/sekolah') ?>" class="nav-link">
                            <i class="fas fa-school me-2"></i>Data Sekolah
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/admin/geojson') ?>" class="nav-link active">
                            <i class="fas fa-map me-2"></i>GeoJSON Overlay
                        </a>
                    </li>
                   
                    <li class="nav-item mt-4">
                        <a href="<?= base_url('/auth/logout') ?>" class="nav-link text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <!-- Page Header -->
            <div class="navbar-top">
                <h4>
                    <i class="fas fa-map me-2 text-primary"></i><?= $title ?>
                </h4>
                <div>
                    <a href="<?= base_url('/admin/dashboard') ?>" class="btn btn-back-custom me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="<?= base_url('/admin/geojson/tambah') ?>" class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>Tambah GeoJSON
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
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

            <!-- Table -->
            <div class="card card-shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Nama Berkas</th>
                                    <th width="15%">Aktif</th>
                                    <th width="15%">Warna</th>
                                    <th width="10%">Opacity</th>
                                    <th width="15%">Stroke</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($geojson)): ?>
                                    <?php $no = 1; foreach ($geojson as $item): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <i class="fas fa-file-code me-2 text-primary"></i>
                                                <?= esc($item['nama']) ?>
                                            </td>
                                            <td>
                                                <?php if($item['is_active']): ?>
                                                    <span class="badge bg-success px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary px-3 py-2">
                                                        <i class="fas fa-ban me-1"></i> Nonaktif
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge-color-preview" style="background: <?= esc($item['warna']) ?>;"></span>
                                                    <?= esc($item['warna']) ?>
                                                </div>
                                            </td>
                                            <td><?= esc($item['fill_opacity']) ?></td>
                                            <td>
                                                <span class="badge" style="background: <?= esc($item['stroke_color']) ?>; color: white; padding: 4px 8px;">
                                                    <?= esc($item['stroke_color']) ?>
                                                </span>
                                                / <?= esc($item['stroke_width']) ?>px
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 flex-wrap">
                                                    <a href="<?= base_url('/admin/geojson/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit me-1"></i> Ubah
                                                    </a>
                                                    <a href="<?= base_url('/admin/geojson/hapus/' . $item['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data GeoJSON ini?')">
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-map-marked-alt fa-2x mb-2 d-block"></i>
                                            Belum ada data GeoJSON. Silakan tambah data.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>