<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --bg-light: #f0f8ff;
            --shadow-sm: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: var(--bg-light); 
        }
        
        /* Sidebar */
        .sidebar { 
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); 
            min-height: 100vh; 
            color: white; 
            transition: transform 0.3s ease;
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
        
        .navbar-top { 
            background: white; 
            border-radius: 15px; 
            padding: 15px 20px; 
            margin-bottom: 25px; 
            box-shadow: var(--shadow-sm); 
        }
        
        .navbar { 
            background: white !important; 
            box-shadow: var(--shadow-sm); 
            padding: 10px 0; 
        }
        
        .navbar-brand { 
            font-size: 1.3rem; 
            font-weight: 800; 
            color: var(--primary-color) !important; 
        }
        

        .table { 
            background: white; 
            border-radius: 15px; 
            overflow: hidden; 
        }
    
        .badge-tk { 
            background: #10b981; 
            color: white;
            padding: 5px 12px;
        }
        .badge-sd { 
            background: #b91010;; 
            color: white;
            padding: 5px 12px;
        }
        .badge-smp { 
            background: #3b82f6; 
            color: white;
            padding: 5px 12px;
        }
       
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                padding: 1rem !important;
                position: fixed;
                z-index: 999;
                width: 280px;
                transform: translateX(-100%);
                height: 100vh;
                overflow-y: auto;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .sidebar-toggle {
                display: block !important;
            }
        }
        
        @media (min-width: 769px) {
            .sidebar-toggle {
                display: none !important;
            }
        }
        
        /* Toast Notifications */
        .toast-container {
            z-index: 1050;
        }
        

        .dataTables_processing {
            background: rgba(255,255,255,0.9) !important;
            border-radius: 10px !important;
            padding: 20px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <button class="btn btn-light me-2 sidebar-toggle" id="sidebarToggle" type="button">
            <i class="fas fa-bars"></i>
        </button>
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
                        <i class="fas fa-user-circle me-1"></i> 
                        <?= esc(session()->get('nama_lengkap')) ?> <!-- DIPERBAIKI: dengan esc() -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('/admin/dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('/admin/sekolah') ?>">
                                <i class="fas fa-school me-2"></i>Data Sekolah
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('/admin/geojson') ?>">
                                <i class="fas fa-map me-2"></i>GeoJSON Overlay
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= base_url('/auth/logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid" style="margin-top: 70px;">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0" id="sidebarWrapper">
            <div class="sidebar p-3">
                <h4 class="text-center mb-4"><i class="fas fa-school me-2"></i>EduMap</h4>
                <hr class="bg-light">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="<?= base_url('/admin/dashboard') ?>" class="nav-link">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/admin/sekolah') ?>" class="nav-link active">
                            <i class="fas fa-school me-2"></i>Data Sekolah
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('/admin/geojson') ?>" class="nav-link">
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
            <!-- Header -->
            <div class="navbar-top d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h4 class="mb-0">
                        <i class="fas fa-school me-2 text-primary"></i><?= esc($title) ?>
                    </h4>
                    <small class="text-muted">
                        Total: <?= count($sekolah) ?> sekolah terdaftar
                    </small>
                </div>
                <a href="<?= base_url('/admin/sekolah/tambah') ?>" class="btn btn-primary mt-2 mt-sm-0">
                    <i class="fas fa-plus me-2"></i>Tambah Sekolah
                </a>
            </div>
            
            <!-- Flash Messages dengan Toast -->
            <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <!-- Tabel Data Sekolah -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NPSN</th>
                                    <th>Nama Sekolah</th>
                                    <th>Jenjang</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($sekolah)): ?>
                                    <?php $no=1; foreach($sekolah as $s): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($s['npsn']) ?></td>
                                        <td><?= esc($s['nama_sekolah']) ?></td>
                                        <td>
                                            <!-- DIPERBAIKI: Logika badge yang benar -->
                                            <span class="badge <?= 
                                                $s['jenjang'] == 'TK' ? 'badge-tk' : 
                                                ($s['jenjang'] == 'SD' ? 'badge-sd' : 
                                                ($s['jenjang'] == 'SMP' ? 'badge-smp' : 'badge-sma')) 
                                            ?>">
                                                <?= esc($s['jenjang']) ?>
                                            </span>
                                        </td>
                                        <td><?= esc(substr($s['alamat'], 0, 50)) ?>...</td>
                                        <td>
                                            <a href="<?= base_url('/admin/sekolah/edit/'.$s['id']) ?>" 
                                               class="btn btn-sm btn-warning" 
                                               aria-label="Edit sekolah <?= esc($s['nama_sekolah']) ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirmDelete('<?= base_url('/admin/sekolah/hapus/'.$s['id']) ?>')"
                                               aria-label="Hapus sekolah <?= esc($s['nama_sekolah']) ?>">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Empty State -->
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fas fa-school fa-4x text-muted d-block mb-3"></i>
                                            <h5 class="text-muted">Belum ada data sekolah</h5>
                                            <p class="text-muted">Mulai tambahkan data sekolah pertama Anda</p>
                                            <a href="<?= base_url('/admin/sekolah/tambah') ?>" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Tambah Sekolah
                                            </a>
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

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data sekolah ini?</p>
                <p class="text-danger small">Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi DataTable dengan Loading State
    $('#dataTable').DataTable({
        processing: true,
        language: {
            processing: '<i class="fas fa-spinner fa-spin me-2"></i>Memuat data...',
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
        },
        pageLength: 10,
        order: [[0, 'asc']],
        responsive: true
    });
    
    // Toggle Sidebar untuk Mobile
    $('#sidebarToggle').on('click', function() {
        $('#sidebarWrapper .sidebar').toggleClass('show');
    });
    
    // Tutup sidebar saat klik di luar (mobile)
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('#sidebarWrapper').length && 
                !$(e.target).closest('#sidebarToggle').length) {
                $('#sidebarWrapper .sidebar').removeClass('show');
            }
        }
    });
});

// Fungsi Konfirmasi Hapus dengan Modal
function confirmDelete(url) {
    $('#confirmDeleteBtn').attr('href', url);
    $('#confirmModal').modal('show');
    return false;
}

// Auto dismiss alert setelah 5 detik
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>

</body>
</html>