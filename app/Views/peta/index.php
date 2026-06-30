<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Sekolah - Kecamatan Lintau Buo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Poppins', sans-serif; 
            background: #f0f8ff; 
            margin-top: 70px;
            overflow-x: hidden;
        }
        
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #60a5fa;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --white: #ffffff;
            --shadow: 0 10px 40px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 60px rgba(0,0,0,0.12);
            --gradient-primary: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        }
        
        .navbar {
            background: var(--white) !important;
            box-shadow: var(--shadow);
            padding: 12px 0;
            transition: all 0.3s;
        }
        .navbar-brand {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary) !important;
        }
        .nav-link {
            font-weight: 500;
            margin: 0 8px;
            color: var(--text-dark) !important;
            transition: all 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
        }
        .dropdown-menu {
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            border: none;
            margin-top: 10px;
        }
        .dropdown-item:hover {
            background: #eff6ff;
            color: var(--primary);
        }
        
        .page-header {
            background: var(--gradient-primary);
            padding: 50px 0 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transform: rotate(15deg);
        }
        .page-header::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -20%;
            width: 60%;
            height: 150%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            transform: rotate(-10deg);
        }
        .page-header h1 {
            color: white;
            font-weight: 800;
            font-size: 2.5rem;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        .page-header p {
            color: rgba(255,255,255,0.9);
            position: relative;
            z-index: 1;
            font-size: 1.1rem;
        }
        .page-header .stats-badge {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 30px;
            padding: 8px 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            color: white;
            position: relative;
            z-index: 1;
        }
        .page-header .stats-badge i {
            color: rgba(255,255,255,0.9);
        }
        
        .map-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(37,99,235,0.08);
            transition: transform 0.3s;
        }
        .map-card:hover {
            transform: translateY(-5px);
        }
        .map-card .card-header {
            background: white;
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .map-card .card-header h5 {
            font-weight: 700;
            color: var(--text-dark);
        }
        
        #map {
            height: 580px;
            width: 100%;
            background: #f8fafc;
        }
        
        .sekolah-list-card {
            background: white;
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            max-height: 630px;
            overflow-y: auto;
            border: 1px solid rgba(37,99,235,0.08);
            transition: transform 0.3s;
        }
        .sekolah-list-card:hover {
            transform: translateY(-5px);
        }
        .sekolah-list-card .card-header {
            background: white;
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
            position: sticky;
            top: 0;
            z-index: 10;
            background: white;
        }
        .sekolah-list-card .card-header h5 {
            font-weight: 700;
            color: var(--text-dark);
        }
        
        .sekolah-list-card::-webkit-scrollbar {
            width: 6px;
        }
        .sekolah-list-card::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .sekolah-list-card::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }
        
        .school-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .school-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform 0.3s;
        }
        .school-item:hover::before {
            transform: scaleY(1);
        }
        .school-item:hover {
            background: #f8faff;
            transform: translateX(6px);
        }
        .school-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
            font-size: 0.95rem;
        }
        .school-address {
            font-size: 0.75rem;
            color: var(--text-light);
        }
        .badge-sd {
            background: linear-gradient(135deg, #10b981, #34d399);
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
        }
        .badge-smp {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
        }
        
        footer {
            background: #0f172a;
            padding: 40px 0 25px;
            color: white;
            margin-top: 50px;
        }
        
        .stats-badge {
            background: #eff6ff;
            border-radius: 30px;
            padding: 6px 18px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            color: var(--text-dark);
            border: 1px solid rgba(37,99,235,0.1);
            transition: all 0.3s;
        }
        .stats-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(37,99,235,0.15);
        }
        
        .filter-group {
            margin-bottom: 20px;
        }
        .btn-filter {
            border-radius: 30px;
            padding: 8px 24px;
            margin: 0 4px;
            font-weight: 500;
            transition: all 0.3s;
            border: 2px solid #e2e8f0;
            background: transparent;
        }
        .btn-filter:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        .btn-filter.active {
            background: var(--gradient-primary) !important;
            color: white !important;
            border-color: var(--primary) !important;
            box-shadow: 0 4px 15px rgba(37,99,235,0.3);
        }
        
        .info-panel {
            background: white;
            border-radius: 20px;
            padding: 20px 24px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            border: 1px solid rgba(37,99,235,0.08);
            transition: transform 0.3s;
        }
        .info-panel:hover {
            transform: translateY(-3px);
        }
        .info-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
            display: inline-block;
        }
        
        .btn-fullscreen {
            background: var(--gradient-primary);
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
            font-size: 0.85rem;
        }
        .btn-fullscreen:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(37,99,235,0.4);
            color: white;
        }
        
        /* Leaflet Custom Popup */
        .leaflet-popup-content-wrapper {
            border-radius: 18px !important;
            box-shadow: 0 14px 40px rgba(0,0,0,0.16) !important;
            border: 1px solid rgba(37,99,235,0.10) !important;
            overflow: hidden !important;
        }
        .leaflet-popup-content {
            font-family: 'Poppins', sans-serif !important;
            font-size: 13px !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .school-popup { min-width: 260px; max-width: 300px; }
        .school-popup__header { padding: 14px 16px; color: white; background: linear-gradient(135deg, #2563eb, #3b82f6); }
        .school-popup__title { font-size: 1rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px; }
        .school-popup__badge { display: inline-block; margin-top: 8px; padding: 5px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 700; background: rgba(255,255,255,0.22); }
        .school-popup__body { padding: 14px 16px 16px; background: #fff; }
        .school-popup__row { display: flex; gap: 8px; align-items: flex-start; font-size: 0.85rem; color: #334155; margin-bottom: 8px; }
        .school-popup__row i { color: #2563eb; margin-top: 3px; }
        .school-popup__row strong { color: #0f172a; }
        
        .leaflet-control-zoom {
            border: none !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
            border-radius: 12px !important;
        }
        .leaflet-control-zoom a {
            border-radius: 0 !important;
            background: white !important;
            color: #1e293b !important;
            width: 38px !important;
            height: 38px !important;
            line-height: 38px !important;
            transition: all 0.3s;
        }
        .leaflet-control-zoom a:hover {
            background: var(--primary) !important;
            color: white !important;
        }
        .leaflet-control-zoom a:first-child {
            border-radius: 12px 12px 0 0 !important;
        }
        .leaflet-control-zoom a:last-child {
            border-radius: 0 0 12px 12px !important;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        @media (max-width: 768px) {
            body { margin-top: 60px; }
            #map { height: 400px; }
            .page-header h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

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
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('/peta') ?>"><i class="fas fa-map-marked-alt me-1"></i>Peta Sekolah</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/about') ?>"><i class="fas fa-info-circle me-1"></i>Tentang</a></li>
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
        <h1><i class="fas fa-map-marked-alt me-3"></i>Peta Lokasi Sekolah</h1>
        <p class="mb-3">SD dan SMP di Kecamatan Lintau Buo, Kabupaten Tanah Datar</p>
        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <span class="stats-badge"><i class="fas fa-school text-white"></i> Total: <span id="totalCount" class="fw-bold">0</span></span>
            <span class="stats-badge"><i class="fas fa-seedling text-success"></i> TK: <span id="tkCount" class="fw-bold">0</span></span>
            <span class="stats-badge"><i class="fas fa-building text-danger"></i> SD: <span id="sdCount" class="fw-bold">0</span></span>
            <span class="stats-badge"><i class="fas fa-building text-primary"></i> SMP: <span id="smpCount" class="fw-bold">0</span></span>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="map-card animate-in">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-map me-2 text-primary"></i>Peta Interaktif</h5>
                    <a href="<?= base_url('/peta/fullmap') ?>" class="btn-fullscreen">
                        <i class="fas fa-expand me-1"></i> Full Screen
                    </a>
                </div>
                <div id="map"></div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="info-panel animate-in" style="animation-delay: 0.1s;">
                <h5 class="info-title"><i class="fas fa-info-circle me-2 text-primary"></i>Informasi</h5>
                <p class="small text-muted mb-0">
                    <i class="fas fa-mouse-pointer me-1"></i> Klik marker untuk detail sekolah.<br>
                    <i class="fas fa-list me-1"></i> Klik daftar sekolah untuk zoom.
                </p>
                <hr class="my-3">
                <div class="d-flex justify-content-between">
                     <div><i class="fas fa-circle text-success me-1"></i> TK <span class="badge bg-success ms-1">Hijau</span></div>
                    <div><i class="fas fa-circle text-danger me-1"></i> SD <span class="badge bg-danger ms-1">merah</span></div>
                    <div><i class="fas fa-circle text-primary me-1"></i> SMP <span class="badge bg-primary ms-1">Biru</span></div>
                    <div><i class="fas fa-map text-muted me-1"></i> Overlay GeoJSON</div>
                </div>
            </div>
            
            <div class="info-panel animate-in" style="animation-delay: 0.2s;">
                <h5 class="info-title"><i class="fas fa-filter me-2 text-primary"></i>Filter Sekolah</h5>
                <div class="filter-group">
                  <div class="filter-group">
    <div class="mb-2">
        <button class="btn btn-filter active w-100" data-filter="all">
            <i class="fas fa-globe me-1"></i> Semua
        </button>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-filter flex-fill" data-filter="TK">
            <i class="fas fa-school me-1"></i> TK
        </button>

        <button class="btn btn-filter flex-fill" data-filter="SD">
            <i class="fas fa-school me-1"></i> SD
        </button>

        <button class="btn btn-filter flex-fill" data-filter="SMP">
            <i class="fas fa-school me-1"></i> SMP
        </button>
    </div>

</div>
                </div>
            </div>
            
            <div class="sekolah-list-card animate-in" style="animation-delay: 0.3s;">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Daftar Sekolah</h5>
                </div>
                <div class="card-body p-0">
                    <div id="sekolahList" class="sekolah-list">
                        <div class="text-center p-4 text-muted">
                            <i class="fas fa-spinner fa-spin me-2"></i>Memuat data...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container text-center">
        <p class="mb-1 small">&copy; <?= date('Y') ?> EduMap Tanah Datar</p>
        <p class="small text-white-50">Dinas Pendidikan Tanah Datar</p>
        <p class="small text-white-50 mt-2">
            <i class="fas fa-code me-1"></i> Dibangun dengan <i class="fas fa-heart text-danger"></i> untuk Pendidikan
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
AOS.init({ duration: 1000, once: true });

var sekolahData = <?= json_encode($sekolah ?? []) ?>;
var geojsonLayers = <?= json_encode($geojson_layers ?? []) ?>;
var map;
var markers = [];
var currentFilter = 'all';

function initMap() {
    map = L.map('map', {
        center: [-0.5732, 100.8123],
        zoom: 13,
        zoomControl: false
    });
    
    L.control.zoom({
        position: 'topright'
    }).addTo(map);
    
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap & CARTO',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);
    
    L.control.scale({ metric: true, imperial: false, position: 'bottomleft' }).addTo(map);
}

function updateGlobalStats(data) {
    const total = data.length;
    const totalTK = data.filter(s => getJenjangLabel(s) === 'TK').length;
    const totalSD = data.filter(s => getJenjangLabel(s) === 'SD').length;
    const totalSMP = data.filter(s => getJenjangLabel(s) === 'SMP').length;
    document.getElementById('totalCount').textContent = total;
    document.getElementById('tkCount').textContent = totalTK;
    document.getElementById('sdCount').textContent = totalSD;
    document.getElementById('smpCount').textContent = totalSMP;
}

function escapeHtml(text) {
    if (!text) return '';
    return text.toString().replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function getJenjangLabel(sekolah) {
    return sekolah.jenjang || sekolah.tingkat || '-';
}

function getMarkerColor(jenjang) {
    if (jenjang === 'TK') return '#10b981';
    if (jenjang === 'SD') return '#dc2626';
    if (jenjang === 'SMP') return '#2563eb';
    return '#f59e0b';
}

function getBadgeClass(jenjang) {
    if (jenjang === 'TK') return 'bg-success';
    if (jenjang === 'SD') return 'bg-danger';
    if (jenjang === 'SMP') return 'bg-primary';
    return 'bg-warning';
}

function buildPopupContent(sekolah) {
    const jenjang = getJenjangLabel(sekolah);
    const alamat = sekolah.alamat || '-';
    const status = sekolah.status || '';
    const lat = sekolah.latitude || '-';
    const lng = sekolah.longitude || '-';
    const color = getMarkerColor(jenjang);
    const statusHtml = status ? `<div class="school-popup__row"><i class="fas fa-info-circle"></i><span><strong>Status:</strong> ${escapeHtml(status)}</span></div>` : '';

    return `
        <div class="school-popup">
            <div class="school-popup__header" style="background: linear-gradient(135deg, ${color}, #2563eb);">
                <h6 class="school-popup__title"><i class="fas fa-school"></i>${escapeHtml(sekolah.nama_sekolah || '-')}</h6>
                <span class="school-popup__badge">${escapeHtml(jenjang)}</span>
            </div>
            <div class="school-popup__body">
                <div class="school-popup__row"><i class="fas fa-map-marker-alt"></i><span><strong>Alamat:</strong> ${escapeHtml(alamat)}</span></div>
                ${statusHtml}
                <div class="school-popup__row"><i class="fas fa-location-arrow"></i><span><strong>Koordinat:</strong> ${escapeHtml(lat)}, ${escapeHtml(lng)}</span></div>
            </div>
        </div>
    `;
}

function displaySekolahList(data) {
    const container = document.getElementById('sekolahList');
    if (data.length === 0) {
        container.innerHTML = '<div class="text-center p-4 text-muted"><i class="fas fa-school me-1"></i>Belum ada data sekolah</div>';
        return;
    }
    let html = '';
    data.forEach((sekolah) => {
        const jenjang = getJenjangLabel(sekolah);
        const badgeClass = getBadgeClass(jenjang);
        const lat = sekolah.latitude ? parseFloat(sekolah.latitude) : 0;
        const lng = sekolah.longitude ? parseFloat(sekolah.longitude) : 0;
        html += `
            <div class="school-item" onclick="focusMarkerDirect(${lat}, ${lng})">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="school-name">${escapeHtml(sekolah.nama_sekolah)}</div>
                        <div class="school-address"><i class="fas fa-map-marker-alt me-1"></i>${escapeHtml(sekolah.alamat || '-')}</div>
                    </div>
                    <span class="badge ${badgeClass} ms-2">${escapeHtml(jenjang)}</span>
                </div>
            </div>
        `;
    });
    container.innerHTML = html;
}

function createMarkers(data) {
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];
    
    let filteredData = data;
    if (currentFilter !== 'all') {
        filteredData = data.filter(s => getJenjangLabel(s) === currentFilter);
    }
    
    filteredData.forEach((sekolah) => {
        if (!sekolah.latitude || !sekolah.longitude) return;
        const lat = parseFloat(sekolah.latitude);
        const lng = parseFloat(sekolah.longitude);
        if (isNaN(lat) || isNaN(lng)) return;
        
        const jenjang = getJenjangLabel(sekolah);
        const color = getMarkerColor(jenjang);
        const customIcon = L.divIcon({
            html: `<div style="background-color: ${color}; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid white; box-shadow: 0 4px 14px rgba(0,0,0,0.25);">
                        <i class="fas fa-school" style="color: white; font-size: 18px;"></i>
                   </div>`,
            iconSize: [40, 40],
            popupAnchor: [0, -20],
            className: 'custom-marker'
        });
        
        const marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);
        marker.latData = lat;
        marker.lngData = lng;
        marker.bindPopup(buildPopupContent(sekolah), { maxWidth: 320 });
        markers.push(marker);
    });
    
    if (markers.length > 0) {
        const group = L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
}

function filterSekolah(filter) {
    currentFilter = filter;
    document.querySelectorAll('.btn-filter').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.filter === filter) btn.classList.add('active');
    });
    let filteredData = sekolahData;
    if (filter !== 'all') {
        filteredData = sekolahData.filter(s => getJenjangLabel(s) === filter);
    }
    displaySekolahList(filteredData);
    createMarkers(sekolahData);
}

function focusMarkerDirect(lat, lng) {
    if (!lat || !lng || lat === 0 || lng === 0) {
        alert('Koordinat lokasi sekolah ini belum valid.');
        return;
    }
    map.setView([lat, lng], 17);
    markers.forEach(marker => {
        if (marker.latData.toFixed(6) === lat.toFixed(6) && marker.lngData.toFixed(6) === lng.toFixed(6)) {
            marker.openPopup();
        }
    });
}

function loadGeojsonOverlay() {
    if (!geojsonLayers || geojsonLayers.length === 0) return;
    var baseUrl = '<?= rtrim(base_url(), '/') ?>';
    geojsonLayers.forEach(function(layerConfig) {
        fetch(baseUrl + '/' + layerConfig.file_path)
            .then(function(res) { return res.json(); })
            .then(function(data) {
                L.geoJSON(data, {
                    style: {
                        color: layerConfig.stroke_color || '#1e293b',
                        weight: Number(layerConfig.stroke_width) || 2,
                        fillColor: layerConfig.warna || '#2563eb',
                        fillOpacity: Number(layerConfig.fill_opacity) || 0.4,
                    }
                }).addTo(map);
            })
            .catch(function() { console.warn('Gagal memuat GeoJSON:', layerConfig.file_path); });
    });
}

document.querySelectorAll('.btn-filter').forEach(btn => {
    btn.addEventListener('click', function() {
        filterSekolah(this.dataset.filter);
    });
});

initMap();
setTimeout(() => {
    updateGlobalStats(sekolahData);
    displaySekolahList(sekolahData);
    createMarkers(sekolahData);
    setTimeout(() => { loadGeojsonOverlay(); }, 600);
}, 500);
</script>

</body>
</html>