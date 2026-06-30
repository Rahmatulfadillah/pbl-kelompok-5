<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemetaan Sekolah - Dinas Pendidikan Kabupaten Tanah Datar</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f0f8ff; color: #1e293b; margin-top: 70px; }
        
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #60a5fa;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --white: #ffffff;
            --shadow: 0 10px 40px rgba(0,0,0,0.08);
        }
        
        .navbar {
            background: var(--white) !important;
            box-shadow: var(--shadow);
            padding: 12px 0;
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
            box-shadow: var(--shadow);
            border: none;
            margin-top: 10px;
        }
        .dropdown-item:hover {
            background: #eff6ff;
            color: var(--primary);
        }
        
        .hero {
            background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
            min-height: 100vh;
            padding: 120px 0 80px;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
        }
        .hero-title span { color: var(--primary); }
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37,99,235,0.3);
            color: white;
        }
        .btn-outline-custom {
            background: transparent;
            border: 2px solid var(--primary);
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            color: var(--primary);
            transition: all 0.3s;
        }
        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation { animation: float 4s ease-in-out infinite; }
        
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 35px 20px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: all 0.3s;
        }
        .stat-card:hover { transform: translateY(-10px); }
        .stat-number { font-size: 2.5rem; font-weight: 800; color: var(--primary); }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 25px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: all 0.3s;
        }
        .feature-card:hover { transform: translateY(-10px); }
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            font-size: 2rem;
        }
        
        .map-card-custom {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .map-card-custom .card-body {
            padding: 30px;
        }
        #homeGeojsonMap {
            width: 100%;
            min-height: 420px;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
        }
        
        /* Leaflet Popup */
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
        .school-popup { min-width: 240px; max-width: 280px; }
        .school-popup__header { padding: 14px 16px; color: white; background: linear-gradient(135deg, #2563eb, #3b82f6); }
        .school-popup__title { font-size: 1rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px; }
        .school-popup__badge { display: inline-block; margin-top: 8px; padding: 5px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 700; background: rgba(255,255,255,0.22); }
        .school-popup__body { padding: 14px 16px 16px; background: #fff; }
        .school-popup__row { display: flex; gap: 8px; align-items: flex-start; font-size: 0.85rem; color: #334155; margin-bottom: 8px; }
        .school-popup__row i { color: #2563eb; margin-top: 3px; }
        .school-popup__row strong { color: #0f172a; }
        
        footer {
            background: var(--text-dark);
            padding: 50px 0 20px;
            color: white;
        }
        
        @media (max-width: 768px) {
            .hero-title { font-size: 2rem; }
            body { margin-top: 60px; }
            #homeGeojsonMap { min-height: 300px; }
        }
    </style>
</head>
<body>

<!-- Navbar Dinamis -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <i class="fas fa-school me-2"></i><strong> Dinas Pendidikan Kabupaten Tanah Datar</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('/') ?>"><i class="fas fa-home me-1"></i>Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/peta') ?>"><i class="fas fa-map-marked-alt me-1"></i>Peta Sekolah</a></li>
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

<!-- Hero Section -->
<section class="hero d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge bg-primary mb-4 px-3 py-2">Kabupaten Tanah Datar</span>
                <h1 class="hero-title mb-4">Pemetaan Sekolah <br><span>TK, SD & SMP</span></h1>
                <p class="mb-4 text-secondary">Temukan lokasi sekolah terdekat, lihat distribusi pendidikan, dan dapatkan informasi lengkap tentang fasilitas pendidikan di Kabupaten Tanah Datar.</p>
                <div class="d-flex gap-3">
                    <a href="<?= base_url('/peta') ?>" class="btn btn-primary-custom"><i class="fas fa-map me-2"></i>Lihat Peta</a>
                    <a href="<?= base_url('/about') ?>" class="btn btn-outline-custom"><i class="fas fa-info-circle me-2"></i>Pelajari</a>
                </div>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <div class="float-animation">
                    <img src="https://cdn-icons-png.flaticon.com/512/3062/3062631.png" alt="Education" style="width: 80%; max-width: 350px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Statistik Sekolah</h2>
        <p class="text-muted">Data terkini SD dan SMP di Kabupaten Tanah Datar</p>
        <div class="mx-auto" style="width: 60px; height: 3px; background: var(--primary);"></div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="stat-card"><i class="fas fa-school fa-3x text-primary mb-3"></i><div class="stat-number"><?= $total_sekolah ?? 0 ?></div><h5>Total Sekolah</h5><p class="text-muted small">TK, SD & SMP</p></div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card"><i class="fas fa-seedling fa-3x text-success mb-3"></i><div class="stat-number"><?= $total_tk ?? 0 ?></div><h5>Taman Kanak-Kanak (TK)</h5><p class="text-muted small">Jumlah TK terdata</p></div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card"><i class="fas fa-building fa-3x text-danger mb-3"></i><div class="stat-number"><?= $total_sd ?? 0 ?></div><h5>Sekolah Dasar (SD)</h5><p class="text-muted small">Jumlah SD terdata</p></div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card"><i class="fas fa-school fa-3x text-primary mb-3"></i><div class="stat-number"><?= $total_smp ?? 0 ?></div><h5>SMP</h5><p class="text-muted small">Jumlah SMP terdata</p></div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Fitur Unggulan</h2>
            <p class="text-muted">Kemudahan akses informasi pendidikan</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4"><div class="feature-card"><div class="feature-icon"><i class="fas fa-map-marked-alt"></i></div><h5>Peta Interaktif</h5><p class="text-muted">Lihat lokasi sekolah secara realtime</p></div></div>
            <div class="col-md-4 mb-4"><div class="feature-card"><div class="feature-icon"><i class="fas fa-filter"></i></div><h5>Filter Sekolah</h5><p class="text-muted">Filter berdasarkan tingkat pendidikan</p></div></div>
            <div class="col-md-4 mb-4"><div class="feature-card"><div class="feature-icon"><i class="fas fa-info-circle"></i></div><h5>Informasi Lengkap</h5><p class="text-muted">Detail alamat dan informasi penting</p></div></div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">🗺️ Peta Sebaran Sekolah</h2>
        <p class="text-muted">Lokasi sekolah TK, SD dan SMP di Kabupaten Tanah Datar</p>
    </div>
    <div class="map-card-custom">
        <div class="card-body">
            <div id="homeGeojsonMap"></div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4"><a class="text-white text-decoration-none fw-bold fs-5" href="#"><i class="fas fa-school me-2"></i>EduMap Kabupaten Tanah Datar</a><p class="text-white-50 mt-3 small">Memudakan akses informasi lokasi pendidikan di Kabupaten Tanah Datar.</p></div>
            <div class="col-lg-4 mb-4"><h5 class="text-white">Link Cepat</h5><ul class="list-unstyled"><li><a href="<?= base_url('/') ?>" class="text-white-50 text-decoration-none small">Beranda</a></li><li><a href="<?= base_url('/peta') ?>" class="text-white-50 text-decoration-none small">Peta Sekolah</a></li><li><a href="<?= base_url('/about') ?>" class="text-white-50 text-decoration-none small">Tentang</a></li><li><a href="<?= base_url('/kontak') ?>" class="text-white-50 text-decoration-none small">Kontak</a></li></ul></div>
            <div class="col-lg-4 mb-4"><h5 class="text-white">Jam Pelayanan</h5><ul class="list-unstyled text-white-50 small"><li>Senin - Kamis: 08:00 - 16:00</li><li>Jumat: 08:00 - 15:30</li><li>Sabtu - Minggu: Tutup</li></ul></div>
        </div>
        <hr class="bg-secondary">
        <div class="text-center small text-white-50">&copy; <?= date('Y') ?> Dinas Pendidikan Kabupaten Tanah Datar. Built with <i class="fas fa-heart text-danger"></i> for Education</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({ duration: 1000, once: true });

    // ============================================
    // DATA DARI CONTROLLER
    // ============================================
    var sekolahData = <?= json_encode($sekolah ?? []) ?>;
    var geojsonLayers = <?= json_encode($geojson_layers ?? []) ?>;
    
    // ============================================
    // INISIALISASI PETA
    // ============================================
    var homeMap = L.map('homeGeojsonMap').setView([-0.5732, 100.8123], 11);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(homeMap);

    // ============================================
    // BUAT MARKER SEKOLAH
    // ============================================
    function getJenjangLabel(sekolah) {
        return sekolah.jenjang || sekolah.tingkat || '-';
    }

    function getMarkerColor(jenjang) {
        if (jenjang === 'TK') return '#10b981';
        if (jenjang === 'SD') return '#dc2626';
        if (jenjang === 'SMP') return '#2563eb';
        return '#f59e0b';
    }

    function buildPopupContent(sekolah) {
        var jenjang = getJenjangLabel(sekolah);
        var alamat = sekolah.alamat || '-';
        var status = sekolah.status || '';
        var color = getMarkerColor(jenjang);
        var statusHtml = status ? '<div class="school-popup__row"><i class="fas fa-info-circle"></i><span><strong>Status:</strong> ' + status + '</span></div>' : '';

        return '<div class="school-popup">' +
            '<div class="school-popup__header" style="background: linear-gradient(135deg, ' + color + ', #2563eb);">' +
                '<h6 class="school-popup__title"><i class="fas fa-school"></i>' + (sekolah.nama_sekolah || '-') + '</h6>' +
                '<span class="school-popup__badge">' + jenjang + '</span>' +
            '</div>' +
            '<div class="school-popup__body">' +
                '<div class="school-popup__row"><i class="fas fa-map-marker-alt"></i><span><strong>Alamat:</strong> ' + alamat + '</span></div>' +
                statusHtml +
                '<div class="school-popup__row"><i class="fas fa-location-arrow"></i><span><strong>Koordinat:</strong> ' + (sekolah.latitude || '-') + ', ' + (sekolah.longitude || '-') + '</span></div>' +
            '</div>' +
        '</div>';
    }

    function createSchoolMarkers(data) {
        if (!data || data.length === 0) {
            console.log('Tidak ada data sekolah');
            return;
        }

        data.forEach(function(sekolah) {
            if (!sekolah.latitude || !sekolah.longitude) return;
            
            var lat = parseFloat(sekolah.latitude);
            var lng = parseFloat(sekolah.longitude);
            
            if (isNaN(lat) || isNaN(lng)) return;
            
            var jenjang = getJenjangLabel(sekolah);
            var color = getMarkerColor(jenjang);
            
            var icon = L.divIcon({
                html: '<div style="background:' + color + ';width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.2)"><i class="fas fa-school" style="color:white;font-size:14px"></i></div>',
                iconSize: [32, 32],
                className: 'home-marker'
            });
            
            var marker = L.marker([lat, lng], { icon: icon }).addTo(homeMap);
            marker.bindPopup(buildPopupContent(sekolah), { maxWidth: 320 });
        });
    }

    // ============================================
    // LOAD GEOJSON LAYERS
    // ============================================
    if (geojsonLayers.length === 0) {
        var info = L.control({ position: 'topright' });
        info.onAdd = function () {
            var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            div.style.background = 'white';
            div.style.padding = '10px';
            div.style.borderRadius = '10px';
            div.style.boxShadow = '0 2px 12px rgba(0,0,0,0.08)';
            div.innerHTML = '<strong>Tidak ada overlay GeoJSON aktif.</strong><br>Aktifkan melalui admin.';
            return div;
        };
        info.addTo(homeMap);
    } else {
        var boundsList = [];
        var baseUrl = '<?= rtrim(base_url(), '/') ?>';

        geojsonLayers.forEach(function (layerConfig) {
            fetch(baseUrl + '/' + layerConfig.file_path)
                .then(function (response) { return response.json(); })
                .then(function (geojsonData) {
                    var geojsonLayer = L.geoJSON(geojsonData, {
                        style: {
                            color: layerConfig.stroke_color,
                            weight: Number(layerConfig.stroke_width) || 2,
                            fillColor: layerConfig.warna,
                            fillOpacity: Number(layerConfig.fill_opacity) || 0.4,
                        }
                    }).addTo(homeMap);

                    if (geojsonLayer.getBounds && geojsonLayer.getBounds().isValid()) {
                        boundsList.push(geojsonLayer.getBounds());
                        var merged = boundsList[0];
                        for (var i = 1; i < boundsList.length; i++) {
                            merged = merged.extend(boundsList[i]);
                        }
                        homeMap.fitBounds(merged.pad(0.1));
                    }
                })
                .catch(function () {
                    console.warn('Gagal memuat layer GeoJSON:', layerConfig.file_path);
                });
        });
    }

    // ============================================
    // TAMPILKAN MARKER SETELAH DATA DIMUAT
    // ============================================
    setTimeout(function() {
        createSchoolMarkers(sekolahData);
    }, 500);
</script>

</body>
</html>