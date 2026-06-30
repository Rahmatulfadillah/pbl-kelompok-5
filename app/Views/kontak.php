<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', 'Inter', sans-serif;
            background: #f0f8ff;
            color: #1e293b;
        }
        
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #60a5fa;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --white: #ffffff;
            --shadow: 0 10px 40px rgba(0,0,0,0.08);
            --shadow-hover: 0 20px 50px rgba(37,99,235,0.15);
        }
        
        /* Navbar */
        .navbar {
            background: var(--white) !important;
            box-shadow: var(--shadow);
            padding: 15px 0;
            transition: all 0.3s;
        }
        .navbar.scrolled {
            padding: 10px 0;
        }
        .navbar-brand {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary) !important;
            letter-spacing: -0.5px;
        }
        .navbar-brand i {
            color: var(--primary);
        }
        .nav-link {
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 8px;
            color: var(--text-dark) !important;
            transition: all 0.3s;
            position: relative;
        }
        .nav-link:hover,
        .nav-link.active {
            color: var(--primary) !important;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }
        
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            padding: 40px 0;
            margin-top: 70px;
            margin-bottom: 30px;
        }
        .page-header h1 {
            color: white;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .page-header p {
            color: rgba(255,255,255,0.9);
            margin-bottom: 0;
        }
        
        /* Contact Cards */
        .contact-card {
            background: var(--white);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s;
            box-shadow: var(--shadow);
            border: 1px solid rgba(37,99,235,0.1);
            height: 100%;
        }
        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary);
        }
        .contact-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .contact-icon i {
            font-size: 28px;
            color: white;
        }
        .contact-card h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .contact-card p {
            color: var(--text-light);
            margin-bottom: 5px;
        }
        .contact-card .detail {
            font-weight: 600;
            color: var(--text-dark);
            margin-top: 10px;
        }
        
        /* Map Container */
        .map-container {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-top: 30px;
        }
        .map-container iframe {
            width: 100%;
            height: 400px;
            border: none;
        }
        
        /* Form */
        .form-card {
            background: var(--white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
            height: 100%;
        }
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
            outline: none;
        }
        .btn-send {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37,99,235,0.3);
        }
        
        /* Social Links */
        .social-links {
            margin-top: 30px;
        }
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: #f0f2f5;
            border-radius: 50%;
            margin: 0 5px;
            color: var(--primary);
            transition: all 0.3s;
        }
        .social-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }
        
        /* Footer */
        footer {
            background: var(--text-dark);
            padding: 50px 0 20px;
            margin-top: 50px;
            color: white;
        }
        .footer-brand {
            font-size: 1.3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 15px;
            display: inline-block;
            text-decoration: none;
        }
        .footer-text {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            line-height: 1.6;
        }
        .social-icon {
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            margin-right: 8px;
            color: white;
            text-decoration: none;
        }
        .social-icon:hover {
            background: var(--primary);
            transform: translateY(-3px);
            color: white;
        }
        .footer-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: white;
        }
        .footer-links {
            list-style: none;
            padding: 0;
        }
        .footer-links li {
            margin-bottom: 10px;
        }
        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        .footer-links a:hover {
            color: var(--primary);
            padding-left: 5px;
        }
        
        @media (max-width: 768px) {
            .page-header {
                padding: 25px 0;
                margin-top: 60px;
            }
            .page-header h1 {
                font-size: 1.5rem;
            }
            .navbar-brand {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <i class="fas fa-school me-2"></i>
            <strong>EduMap Lintau Buo</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/') ?>">
                        <i class="fas fa-home me-1"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/peta') ?>">
                        <i class="fas fa-map-marked-alt me-1"></i> Peta Sekolah
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/about') ?>">
                        <i class="fas fa-info-circle me-1"></i> Tentang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('/kontak') ?>">
                        <i class="fas fa-envelope me-1"></i> Kontak
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/auth/login') ?>">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Header -->
<div class="page-header">
    <div class="container text-center">
        <h1><i class="fas fa-envelope me-3"></i>Hubungi Kami</h1>
        <p>Kami siap membantu Anda. Silahkan hubungi kami melalui kontak di bawah ini</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Contact Cards -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h4>Alamat Kantor</h4>
                <p>Kantor Dinas Pendidikan </p>
                <p>Kabupaten Tanah Datar</p>
                <p>Sumatera Barat, 27292</p>
             
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h4>Nomor Telepon</h4>
                <p><i class="fas fa-phone me-2"></i> 083161897613</p>
                <p><i class="fab fa-whatsapp me-2"></i> +62 83161897613</p>
           
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h4>Email</h4>
                <p><i class="fas fa-envelope me-2"></i> info@lintau-buo.go.id</p>
                <p><i class="fas fa-envelope me-2"></i> pendidikan@lintau-buo.go.id</p>
                <p><i class="fas fa-globe me-2"></i> www.lintau-buo.go.id</p>
            </div>
        </div>
    </div>
    
    <!-- Social Media & Map -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="form-card">
                <h4 class="mb-4 text-center" style="color: var(--text-dark); font-weight: 700;">
                    <i class="fas fa-paper-plane me-2" style="color: var(--primary);"></i>Kirim Pesan
                </h4>
                <form action="" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Alamat email" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Subjek">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" rows="4" placeholder="Pesan Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn-send">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Pesan
                    </button>
                </form>
                
                <div class="social-links text-center">
                    <h6 class="mb-3" style="color: var(--text-light);">Ikuti Kami</h6>
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255109.27392030363!2d100.6004749!3d-0.5732!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4c8e5b5e5b5e5%3A0x5e5e5e5e5e5e5e5e!2sLintau%20Buo%2C%20Tanah%20Datar%2C%20West%20Sumatra!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <a class="footer-brand" href="#">
                    <i class="fas fa-school me-2"></i>EduMap Lintau Buo
                </a>
                <p class="footer-text mt-3">Memudakan akses informasi lokasi pendidikan di Kabupaten Tanah Datar.</p>
                <div class="mt-3">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <h5 class="footer-title">Link Cepat</h5>
                <ul class="footer-links">
                    <li><a href="<?= base_url('/') ?>"><i class="fas fa-chevron-right me-2"></i>Beranda</a></li>
                    <li><a href="<?= base_url('/peta') ?>"><i class="fas fa-chevron-right me-2"></i>Peta Sekolah</a></li>
                    <li><a href="<?= base_url('/about') ?>"><i class="fas fa-chevron-right me-2"></i>Tentang</a></li>
                    <li><a href="<?= base_url('/kontak') ?>"><i class="fas fa-chevron-right me-2"></i>Kontak</a></li>
                </ul>
            </div>
            <div class="col-lg-4 mb-4">
                <h5 class="footer-title">Jam Pelayanan</h5>
                <ul class="footer-links">
                    <li><i class="fas fa-clock me-2"></i>Senin - Kamis: 08:00 - 16:00</li>
                    <li><i class="fas fa-clock me-2"></i>Jumat: 08:00 - 15:30</li>
                    <li><i class="fas fa-clock me-2"></i>Sabtu - Minggu: Tutup</li>
                </ul>
            </div>
        </div>
        <hr style="background: rgba(255,255,255,0.1); margin: 20px 0;">
        <div class="text-center">
            <p class="footer-text mb-0">&copy; <?= date('Y') ?> EduMap Tanah Datar. All rights reserved. | Built with <i class="fas fa-heart" style="color: #ef4444;"></i> for Education</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
</body>
</html>