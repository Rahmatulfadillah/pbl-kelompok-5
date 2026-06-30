<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Full Map - Kecamatan Lintau Buo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f0f8ff; margin: 0; }
        html, body { height: 100%; }
        :root { --primary: #2563eb; --text-dark: #1e293b; --white: #ffffff; --shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .navbar { background: var(--white) !important; box-shadow: var(--shadow); padding: 12px 0; }
        .navbar-brand { font-size: 1.4rem; font-weight: 800; color: var(--primary) !important; }
        .nav-link { font-weight: 500; margin: 0 8px; color: var(--text-dark) !important; }
        .nav-link:hover, .nav-link.active { color: var(--primary) !important; }
        .dropdown-menu { border-radius: 12px; box-shadow: var(--shadow); border: none; margin-top: 10px; }
        .dropdown-item:hover { background: #eff6ff; color: var(--primary); }
        #map { width: 100%; height: calc(100vh - 72px); }
        .mode-panel { position: absolute; top: 90px; right: 20px; z-index: 999; background: white; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.12); padding: 12px; width: 190px; }
        .mode-panel button { width: 100%; text-align: left; margin-bottom: 8px; border: none; border-radius: 12px; padding: 12px 14px; font-weight: 600; cursor: pointer; transition: all 0.25s ease; }
        .mode-panel button:last-child { margin-bottom: 0; }
        .mode-panel button.active { background: #2563eb; color: white; }
        .mode-panel button:not(.active) { background: #f8fafc; color: #1e293b; }
        .back-btn { position: absolute; top: 90px; left: 20px; z-index: 999; background: white; border: none; border-radius: 14px; padding: 12px 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.12); color: #2563eb; font-weight: 700; }
        .back-btn:hover { background: #eff6ff; }
        .leaflet-popup-content-wrapper { border-radius: 18px !important; box-shadow: 0 14px 40px rgba(0,0,0,0.16) !important; border: 1px solid rgba(37,99,235,0.10) !important; overflow: hidden !important; }
        .leaflet-popup-content { margin: 0 !important; padding: 0 !important; font-family: 'Poppins', sans-serif !important; }
        .school-popup { min-width: 260px; max-width: 300px; }
        .school-popup__header { padding: 14px 16px; color: #fff; background: linear-gradient(135deg, #2563eb, #3b82f6); }
        .school-popup__title { font-size: 1rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px; }
        .school-popup__badge { display: inline-block; margin-top: 8px; padding: 5px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 700; background: rgba(255,255,255,0.22); }
        .school-popup__body { padding: 14px 16px 16px; background: #fff; }
        .school-popup__row { display: flex; gap: 8px; align-items: flex-start; font-size: 0.85rem; color: #334155; margin-bottom: 8px; }
        .school-popup__row i { color: #2563eb; margin-top: 3px; }
        .school-popup__row strong { color: #0f172a; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>"><i class="fas fa-school me-2"></i><strong>EduMap Lintau Buo</strong></a>
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

<button class="back-btn" onclick="window.location.href='<?= base_url('/peta') ?>'"><i class="fas fa-arrow-left me-2"></i>Kembali</button>

<div class="mode-panel">
    <button id="btnStandard" class="active" onclick="switchMode('standard', this)"><i class="fas fa-map me-2"></i>Mode Standar</button>
    <button id="btnSatellite" onclick="switchMode('satellite', this)"><i class="fas fa-satellite-dish me-2"></i>Mode Satelit</button>
</div>

<div id="map"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var sekolahData = <?= json_encode($sekolah ?? []) ?>;
    var geojsonLayers = <?= json_encode($geojson_layers ?? []) ?>;
    var map, standardLayer, satelliteLayer;

    function initMap() {
        map = L.map('map').setView([-0.5732, 100.8123], 13);

        standardLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap & CARTO',
            subdomains: 'abcd',
            maxZoom: 19
        });

        satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri',
            maxZoom: 19
        });

        standardLayer.addTo(map);
        createMarkers(sekolahData);
        loadGeojsonOverlay();
    }

    function getPopupHtml(item) {
        var jenjang = item.jenjang || item.tingkat || '-';
        var alamat = item.alamat || item.alamat_sekolah || '-';
        var status = item.status || item.status_sekolah || '';
        var color = jenjang === 'TK' ? '#10b981' : (jenjang === 'SD' ? '#dc2626' : (jenjang === 'SMP' ? '#2563eb' : '#f59e0b'));
        var statusHtml = status ? '<div class="school-popup__row"><i class="fas fa-info-circle"></i><span><strong>Status:</strong> ' + status + '</span></div>' : '';

        return '<div class="school-popup">' +
            '<div class="school-popup__header" style="background: linear-gradient(135deg, ' + color + ', #2563eb);">' +
                '<h6 class="school-popup__title"><i class="fas fa-school"></i>' + (item.nama_sekolah || '-') + '</h6>' +
                '<span class="school-popup__badge">' + jenjang + '</span>' +
            '</div>' +
            '<div class="school-popup__body">' +
                '<div class="school-popup__row"><i class="fas fa-map-marker-alt"></i><span><strong>Alamat:</strong> ' + alamat + '</span></div>' +
                statusHtml +
                '<div class="school-popup__row"><i class="fas fa-location-arrow"></i><span><strong>Koordinat:</strong> ' + (item.latitude || '-') + ', ' + (item.longitude || '-') + '</span></div>' +
            '</div>' +
        '</div>';
    }

    function createMarkers(data) {
        data.forEach(function(item) {
            if (!item.latitude || !item.longitude) return;
            var jenjang = item.jenjang || item.tingkat || '-';
            var color = jenjang === 'TK' ? '#10b981' : (jenjang === 'SD' ? '#dc2626' : (jenjang === 'SMP' ? '#2563eb' : '#f59e0b'));
            var icon = L.divIcon({
                html: '<div style="background:' + color + ';width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.2)"><i class="fas fa-school" style="color:white;font-size:16px"></i></div>',
                iconSize: [40, 40],
                className: ''
            });

            var marker = L.marker([item.latitude, item.longitude], { icon: icon }).addTo(map);
            marker.bindPopup(getPopupHtml(item), { maxWidth: 320 });
        });
    }

    function loadGeojsonOverlay() {
        if (geojsonLayers.length === 0) return;
        
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
                    }).addTo(map);
                })
                .catch(function () {
                    console.warn('Gagal memuat layer GeoJSON:', layerConfig.file_path);
                });
        });
    }

    function switchMode(mode, button) {
        document.querySelectorAll('.mode-panel button').forEach(function(btn) {
            btn.classList.remove('active');
        });
        button.classList.add('active');

        if (mode === 'standard') {
            if (map.hasLayer(satelliteLayer)) map.removeLayer(satelliteLayer);
            standardLayer.addTo(map);
        } else {
            if (map.hasLayer(standardLayer)) map.removeLayer(standardLayer);
            satelliteLayer.addTo(map);
        }
    }

    window.onload = initMap;
</script>
</body>
</html>