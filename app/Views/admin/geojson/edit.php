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
        .form-control, .form-select { border-radius: 10px; }
        .form-check-input { width: 1.3rem; height: 1.3rem; }
        .btn-save { background: #2563eb; border: none; }
    </style>
</head>
<body>
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
        <div class="col-md-3 col-lg-2 px-0">
            <div class="sidebar p-3">
                <h4 class="text-center mb-4"><i class="fas fa-school me-2"></i>EduMap</h4>
                <hr class="bg-light">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="<?= base_url('/admin/dashboard') ?>" class="nav-link"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                    <li class="nav-item"><a href="<?= base_url('/admin/sekolah') ?>" class="nav-link"><i class="fas fa-school me-2"></i>Data Sekolah</a></li>
                    <li class="nav-item"><a href="<?= base_url('/admin/geojson') ?>" class="nav-link active"><i class="fas fa-map me-2"></i>GeoJSON Overlay</a></li>
                    <li class="nav-item mt-4"><a href="<?= base_url('/auth/logout') ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9 col-lg-10 p-4">
            <div class="navbar-top d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-map me-2 text-primary"></i><?= $title ?></h4>
            </div>

            <?php if(session()->getFlashdata('success')): ?><div class="alert alert-success"><?= session()->getFlashdata('success') ?></div><?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div><?php endif; ?>
            <?php if(session()->getFlashdata('errors')): ?><div class="alert alert-danger"><ul><?php foreach(session()->getFlashdata('errors') as $err): ?><li><?= esc($err) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="<?= base_url('/admin/geojson/update/' . $geojson['id']) ?>" method="post">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Layer</label>
                                <input type="text" name="nama" class="form-control" value="<?= esc(old('nama', $geojson['nama'])) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Berkas GeoJSON</label>
                                <input type="text" class="form-control" value="<?= esc($geojson['file_path']) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Aktifkan</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?= $geojson['is_active'] ? 'checked' : '' ?> >
                                    <label class="form-check-label" for="is_active">Tampilkan di Beranda</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Warna Fill</label>
                                <input type="color" name="warna" class="form-control form-control-color" value="<?= esc(old('warna', $geojson['warna'])) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Warna Border</label>
                                <input type="color" name="stroke_color" class="form-control form-control-color" value="<?= esc(old('stroke_color', $geojson['stroke_color'])) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Opacity Fill</label>
                                <input type="number" step="0.05" min="0" max="1" name="fill_opacity" class="form-control" value="<?= esc(old('fill_opacity', $geojson['fill_opacity'])) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Lebar Border (px)</label>
                                <input type="number" min="1" name="stroke_width" class="form-control" value="<?= esc(old('stroke_width', $geojson['stroke_width'])) ?>" required>
                            </div>
                        </div>
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-save"><i class="fas fa-save me-2"></i>Simpan</button>
                            <a href="<?= base_url('/admin/geojson') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
