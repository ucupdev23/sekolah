<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Website Resmi SMA Negeri Contoh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Website resmi SMA Negeri Contoh - Informasi sekolah, pengumuman, berita, dan kelulusan">
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom style -->
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-dark: #1e40af;
            --secondary-blue: #3b82f6;
            --accent-orange: #f59e0b;
            --light-bg: #f8fafc;
            --dark-bg: #0f172a;
            --text-dark: #1e293b;
            --text-gray: #64748b;
        }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Navbar */
        .navbar {
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-blue) !important;
        }
        
        .navbar-brand .school-icon {
            display: inline-block;
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            border-radius: 8px;
            margin-right: 10px;
            text-align: center;
            line-height: 32px;
            color: white;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            padding: 0.5rem 1rem !important;
            margin: 0 0.2rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue) !important;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #1e3a8a 0%, var(--primary-blue) 50%, #60a5fa 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: center;
        }
        
        .hero-title {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            max-width: 600px;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        /* Stats Cards in Hero */
        .stats-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: white;
        }
        
        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Section Titles */
        .section-title {
            position: relative;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-orange));
            border-radius: 2px;
        }
        
        .section-subtitle {
            color: var(--text-gray);
            font-size: 1.1rem;
            max-width: 600px;
        }
        
        /* Cards */
        .card-soft {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            background: white;
        }
        
        .card-soft:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
        }
        
        /* Feature Cards */
        .feature-card {
            text-align: center;
            padding: 2rem 1.5rem;
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 1.8rem;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: rotate(10deg) scale(1.1);
        }
        
        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-blue);
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-blue);
            transform: translateY(-3px);
        }
        
        /* Badges */
        .badge-blue {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
        }
        
        /* Footer */
        footer {
            background: var(--dark-bg);
            color: #94a3b8;
            padding: 4rem 0 2rem;
        }
        
        .footer-links h6 {
            color: white;
            margin-bottom: 1.5rem;
        }
        
        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            display: block;
            margin-bottom: 0.75rem;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-blue);
            transform: translateY(-3px);
        }
        
        /* Animations */
        [data-aos] {
            transition: all 0.8s ease;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero {
                padding: 80px 0 60px;
            }
            
            .hero-title {
                font-size: 2.2rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
        }
        
        /* Scroll to top button */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-blue);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }
        
        .scroll-top.active {
            opacity: 1;
            visibility: visible;
        }
        
        .scroll-top:hover {
            transform: translateY(-5px);
            background: var(--primary-dark);
        }
    </style>
    <style>
    /* Timeline Styles */
    .timeline {
        position: relative;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }
    
    .timeline-item {
        position: relative;
    }
    
    .timeline-marker {
        position: absolute;
        left: -29px;
        top: 5px;
        z-index: 1;
    }
    
    .timeline-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 3px solid white;
    }
    
    .timeline-content {
        padding-left: 20px;
    }
    
    /* Avatar Styles */
    .avatar-lg {
        width: 100px;
        height: 100px;
    }
    
    .avatar-md {
        width: 60px;
        height: 60px;
    }
    
    .avatar-xs {
        width: 24px;
        height: 24px;
    }
    
    /* Card Image Placeholder */
    .card-img-placeholder {
        height: 200px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }
    
    .placeholder-icon {
        font-size: 3rem;
        opacity: 0.3;
    }
    
    .card-img-overlay-top {
        position: absolute;
        top: 15px;
        right: 15px;
    }
    
    /* Stats Grid */
    .stats-grid .stat-item {
        padding: 1.5rem;
        text-align: center;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .stats-grid .stat-item:hover {
        transform: translateY(-5px);
        background: white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .timeline::before {
            left: 15px;
        }
        
        .timeline-marker {
            left: -14px;
        }
        
        .timeline-content {
            padding-left: 40px;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.8rem;
        }
    }
    
    /* Smooth transitions */
    .card-soft, .btn, .nav-link {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Gradient text for highlights */
    .gradient-text {
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-orange));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .footer-public {
    background-color: #0f172a; /* gelap elegan */
    color: #e5e7eb;
    padding: 60px 0 30px;
}

/* FIX text-muted biar kebaca */
.footer-public .text-muted {
    color: #9ca3af !important; /* muted tapi kontras */
}

/* Heading footer */
.footer-public h6 {
    color: #ffffff;
    font-weight: 600;
    margin-bottom: 1rem;
}

/* Link footer */
.footer-public .footer-links a {
    display: block;
    color: #cbd5f5;
    text-decoration: none;
    margin-bottom: 8px;
    font-size: 14px;
}

.footer-public .footer-links a:hover {
    color: #ffffff;
    transform: translateX(4px);
    transition: 0.3s;
}

/* Icon sosmed */
.footer-public .social-icons a {
    color: #cbd5f5;
    margin-right: 12px;
    font-size: 16px;
    transition: 0.3s;
}

.footer-public .social-icons a:hover {
    color: #ffffff;
    transform: translateY(-3px);
}

/* HR footer */
.footer-public hr {
    opacity: 0.2;
}

</style>
</head>
<body>
    <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('home'); ?>">
            <span class="school-icon">
                <i class="fas fa-graduation-cap"></i>
            </span>
            SMA Negeri Contoh
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#profil">
                        <i class="fas fa-school me-1"></i>Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#struktur">
                        <i class="fas fa-sitemap me-1"></i>Struktur
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#visi-misi">
                        <i class="fas fa-bullseye me-1"></i>Visi Misi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pengumuman">
                        <i class="fas fa-bullhorn me-1"></i>Pengumuman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#berita">
                        <i class="fas fa-newspaper me-1"></i>Berita
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('kelulusan'); ?>" target="_blank">
                        <i class="fas fa-user-graduate me-1"></i>Kelulusan
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-primary px-4" href="https://forms.gle/PPDB_GOOGLE_FORM" target="_blank">
                        <i class="fas fa-user-plus me-2"></i>PPDB Online
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="mb-4">
                    <span class="badge bg-light text-primary mb-3 border-0 px-4 py-2">
                        <i class="fas fa-star me-2"></i>Sekolah Unggulan Terakreditasi A
                    </span>
                    <h1 class="hero-title">
                        Membangun Generasi <span class="text-warning">Unggul</span> & Berkarakter
                    </h1>
                    <p class="hero-subtitle">
                        SMA Negeri Contoh merupakan institusi pendidikan berstandar nasional yang fokus 
                        pada pengembangan akademik, karakter, dan bakat siswa untuk menghadapi tantangan global.
                    </p>
                </div>
                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="<?= site_url('kelulusan'); ?>" target="_blank" class="btn btn-light text-primary fw-semibold px-4 py-3">
                        <i class="fas fa-search me-2"></i>Cek Kelulusan
                    </a>
                    <a href="https://forms.gle/PPDB_GOOGLE_FORM" target="_blank" 
                       class="btn btn-outline-light px-4 py-3">
                        <i class="fas fa-user-graduate me-2"></i>Daftar PPDB
                    </a>
                </div>
                
                <!-- Quick Stats -->
                <div class="row g-3">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="stats-card">
                            <div class="stats-number">500+</div>
                            <div class="stats-label">Siswa Aktif</div>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="stats-card">
                            <div class="stats-number">45</div>
                            <div class="stats-label">Guru Berpengalaman</div>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="stats-card">
                            <div class="stats-number">25+</div>
                            <div class="stats-label">Prestasi Nasional</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5" data-aos="fade-left">
                <div class="position-relative">
                    <div class="card card-soft bg-white">
                        <div class="card-body p-4">
                            <h5 class="fw-semibold mb-3">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Info Sekolah
                            </h5>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper me-3" style="background: rgba(37, 99, 235, 0.1); color: var(--primary-blue); width: 40px; height: 40px;">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Alamat</small>
                                        <p class="mb-0 fw-medium">Jl. Pendidikan No. 123, Kota Contoh</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper me-3" style="background: rgba(245, 158, 11, 0.1); color: var(--accent-orange); width: 40px; height: 40px;">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Telepon</small>
                                        <p class="mb-0 fw-medium">(021) 123-4567</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper me-3" style="background: rgba(34, 197, 94, 0.1); color: #22c55e; width: 40px; height: 40px;">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Email</small>
                                        <p class="mb-0 fw-medium">info@smacontoh.sch.id</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper me-3" style="background: rgba(168, 85, 247, 0.1); color: #a855f7; width: 40px; height: 40px;">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Jam Operasional</small>
                                        <p class="mb-0 fw-medium">Senin-Jumat, 07.00-15.00 WIB</p>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="https://maps.google.com" target="_blank" class="btn btn-outline-primary w-100">
                                <i class="fas fa-map-marked-alt me-2"></i>Lihat di Google Maps
                            </a>
                        </div>
                    </div>
                    
                    <!-- Floating elements -->
                    <div class="position-absolute top-0 end-0 mt-3 me-3">
                        <span class="badge bg-success py-2 px-3">
                            <i class="fas fa-check-circle me-1"></i>Akreditasi A
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KEUNGGULAN SEKOLAH -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Keunggulan Kami</h2>
            <p class="section-subtitle mx-auto">
                Mengapa memilih SMA Negeri Contoh sebagai tempat belajar terbaik?
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card card-soft">
                    <div class="feature-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Pengajar Berkualitas</h5>
                    <p class="text-muted">
                        Didukung oleh guru-guru bersertifikasi dengan pengalaman mengajar rata-rata 10+ tahun.
                    </p>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card card-soft">
                    <div class="feature-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Fasilitas Modern</h5>
                    <p class="text-muted">
                        Ruang kelas ber-AC, laboratorium lengkap, perpustakaan digital, dan WiFi seluruh area.
                    </p>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card card-soft">
                    <div class="feature-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Prestasi Membanggakan</h5>
                    <p class="text-muted">
                        Konsisten meraih prestasi di bidang akademik dan non-akademik tingkat nasional.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROFIL & SEJARAH SINGKAT -->
<section id="profil" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Profil & Sejarah Sekolah</h2>
            <p class="section-subtitle mx-auto">
                Mengenal lebih dekat identitas dan perjalanan panjang sekolah kami
            </p>
        </div>
        
        <div class="row g-5">
            <!-- Profil Sekolah -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card card-soft h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-wrapper me-3" style="background: rgba(37, 99, 235, 0.1); color: var(--primary-blue);">
                                <i class="fas fa-school"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Profil Sekolah</h4>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                    <i class="fas fa-check-circle text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Identitas Sekolah</h6>
                                    <p class="text-muted small mb-0">
                                        <strong>SMA Negeri Contoh</strong> - NPSN: 12345678
                                    </p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                    <i class="fas fa-award text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Akreditasi</h6>
                                    <p class="text-muted small mb-0">
                                        Terakreditasi <strong>A (Unggul)</strong> - Berlaku hingga 2027
                                    </p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-3">
                                    <i class="fas fa-calendar-alt text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Tahun Berdiri</h6>
                                    <p class="text-muted small mb-0">
                                        Didirikan sejak <strong>1990</strong> - 34 tahun melayani pendidikan
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-light rounded-3">
                            <h6 class="fw-semibold mb-2">Visi Pendidikan</h6>
                            <p class="text-muted mb-0">
                                SMA Negeri Contoh berkomitmen menjadi lembaga pendidikan unggulan 
                                yang mencetak generasi berkarakter, berprestasi akademik, 
                                dan siap menghadapi tantangan global dengan kompetensi abad 21.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sejarah Singkat -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card card-soft h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-wrapper me-3" style="background: rgba(245, 158, 11, 0.1); color: var(--accent-orange);">
                                <i class="fas fa-history"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Sejarah Singkat</h4>
                        </div>
                        
                        <!-- Timeline -->
                        <div class="timeline ps-3">
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker">
                                    <div class="timeline-dot bg-primary"></div>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold mb-1">1990 - Pendirian</h6>
                                    <p class="text-muted small mb-0">
                                        SMA Negeri Contoh didirikan sebagai sekolah negeri pertama di wilayah ini, 
                                        dengan 3 ruang kelas dan 5 guru pengajar.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker">
                                    <div class="timeline-dot bg-success"></div>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold mb-1">2005 - Akreditasi Pertama</h6>
                                    <p class="text-muted small mb-0">
                                        Meraih akreditasi B dari BAN-S/M, menandai peningkatan kualitas 
                                        pendidikan dan fasilitas sekolah.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker">
                                    <div class="timeline-dot bg-warning"></div>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold mb-1">2015 - Ekspansi Fasilitas</h6>
                                    <p class="text-muted small mb-0">
                                        Pembangunan gedung baru dua lantai, laboratorium komputer, 
                                        dan perpustakaan digital.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker">
                                    <div class="timeline-dot bg-danger"></div>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-semibold mb-1">2022 - Akreditasi Unggul</h6>
                                    <p class="text-muted small mb-0">
                                        Meraih predikat Akreditasi A (Unggul) dari BAN-S/M, 
                                        menjadi sekolah percontohan di tingkat kota.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top">
                            <div class="row g-3 text-center">
                                <div class="col-4">
                                    <div class="p-3 bg-primary bg-opacity-10 rounded-3">
                                        <h4 class="fw-bold text-primary mb-1">34+</h4>
                                        <small class="text-muted">Tahun</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 bg-success bg-opacity-10 rounded-3">
                                        <h4 class="fw-bold text-success mb-1">5000+</h4>
                                        <small class="text-muted">Alumni</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 bg-warning bg-opacity-10 rounded-3">
                                        <h4 class="fw-bold text-warning mb-1">100+</h4>
                                        <small class="text-muted">Prestasi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STRUKTUR ORGANISASI -->
<section id="struktur" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Struktur Organisasi</h2>
            <p class="section-subtitle mx-auto">
                Tim kepemimpinan yang berdedikasi untuk kemajuan pendidikan
            </p>
        </div>
        
        <!-- Kepala Sekolah -->
        <div class="row justify-content-center mb-5" data-aos="fade-up">
            <div class="col-lg-8">
                <div class="card card-soft">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <div class="avatar-wrapper mx-auto mb-3">
                                    <div class="avatar-lg bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user-tie fa-2x text-primary"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">Dr. Ahmad Sudrajat, M.Pd.</h5>
                                    <span class="badge bg-primary">Kepala Sekolah</span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="fw-semibold mb-3">Profil Kepala Sekolah</h6>
                                <p class="text-muted mb-3">
                                    Memimpin SMA Negeri Contoh sejak 2018 dengan visi transformatif. 
                                    Berpengalaman 25 tahun di dunia pendidikan dan aktif dalam 
                                    berbagai organisasi pendidikan nasional.
                                </p>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Masa Jabatan</small>
                                        <strong>2018 - Sekarang</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Latar Belakang</small>
                                        <strong>S3 Pendidikan</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Wakil Kepala Sekolah -->
        <div class="row g-4 mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="col-md-4">
                <div class="card card-soft h-100">
                    <div class="card-body p-4 text-center">
                        <div class="avatar-wrapper mx-auto mb-3">
                            <div class="avatar-md bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-book-open fa-lg text-info"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-1">Drs. Budi Santoso, M.Pd.</h6>
                        <small class="text-muted d-block mb-2">Wakil Kepala Bidang Kurikulum</small>
                        <p class="text-muted small">
                            Bertanggung jawab atas pengembangan kurikulum, 
                            pemantauan pembelajaran, dan evaluasi akademik.
                        </p>
                        <div class="mt-3">
                            <span class="badge bg-info bg-opacity-10 text-info">Pengalaman 20 Tahun</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card card-soft h-100">
                    <div class="card-body p-4 text-center">
                        <div class="avatar-wrapper mx-auto mb-3">
                            <div class="avatar-md bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-users fa-lg text-success"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-1">Dian Sari, M.Pd.</h6>
                        <small class="text-muted d-block mb-2">Wakil Kepala Bidang Kesiswaan</small>
                        <p class="text-muted small">
                            Mengelola kegiatan siswa, pembinaan karakter, 
                            dan pengembangan ekstrakurikuler sekolah.
                        </p>
                        <div class="mt-3">
                            <span class="badge bg-success bg-opacity-10 text-success">Pembina OSIS</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card card-soft h-100">
                    <div class="card-body p-4 text-center">
                        <div class="avatar-wrapper mx-auto mb-3">
                            <div class="avatar-md bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-building fa-lg text-warning"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-1">Ir. Hadi Prasetyo</h6>
                        <small class="text-muted d-block mb-2">Wakil Kepala Bidang Sarpras</small>
                        <p class="text-muted small">
                            Mengelola sarana dan prasarana sekolah, 
                            pemeliharaan fasilitas, dan pengembangan infrastruktur.
                        </p>
                        <div class="mt-3">
                            <span class="badge bg-warning bg-opacity-10 text-warning">Ahli Infrastruktur</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Divisi Lainnya -->
        <div class="text-center" data-aos="fade-up" data-aos-delay="200">
            <div class="card card-soft">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Struktur Lainnya</h6>
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="p-3 bg-light rounded-3">
                                <i class="fas fa-chalkboard-teacher text-primary mb-2"></i>
                                <h6 class="fw-semibold mb-1">45 Guru</h6>
                                <small class="text-muted">Pengajar</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 bg-light rounded-3">
                                <i class="fas fa-user-cog text-info mb-2"></i>
                                <h6 class="fw-semibold mb-1">15 Staff</h6>
                                <small class="text-muted">Tata Usaha</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 bg-light rounded-3">
                                <i class="fas fa-user-friends text-success mb-2"></i>
                                <h6 class="fw-semibold mb-1">8 Komite</h6>
                                <small class="text-muted">Sekolah</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 bg-light rounded-3">
                                <i class="fas fa-hands-helping text-warning mb-2"></i>
                                <h6 class="fw-semibold mb-1">12</h6>
                                <small class="text-muted">Pembina Eskul</small>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted small mt-4 mb-0">
                        *Struktur organisasi lengkap dapat dilihat pada papan informasi sekolah 
                        atau melalui administrasi tata usaha.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- VISI MISI -->
<section id="visi-misi" class="py-5 bg-white">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card card-soft h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-wrapper me-3" style="background: rgba(37, 99, 235, 0.1); color: var(--primary-blue);">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Visi Sekolah</h4>
                        </div>
                        <div class="p-4 bg-light rounded-3 mb-4">
                            <h5 class="text-center fst-italic fw-bold text-primary">
                                "Mewujudkan Generasi Emas Indonesia yang Berkarakter, Berprestasi, dan Berdaya Saing Global"
                            </h5>
                        </div>
                        <p class="text-muted">
                            Visi ini menjadi landasan utama dalam membentuk lulusan yang tidak hanya cerdas akademik,
                            tetapi juga memiliki karakter kuat dan siap bersaing di era globalisasi.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card card-soft h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-wrapper me-3" style="background: rgba(245, 158, 11, 0.1); color: var(--accent-orange);">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Misi Sekolah</h4>
                        </div>
                        <div class="ms-4">
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle p-2">1</span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold">Pembelajaran Berkualitas</h6>
                                    <p class="text-muted small mb-0">Menyelenggarakan pembelajaran aktif, inovatif, dan berorientasi pada pengembangan kompetensi abad 21.</p>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle p-2">2</span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold">Penguatan Karakter</h6>
                                    <p class="text-muted small mb-0">Menumbuhkan nilai-nilai kejujuran, disiplin, tanggung jawab, dan kepedulian sosial.</p>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle p-2">3</span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold">Pengembangan Bakat</h6>
                                    <p class="text-muted small mb-0">Mengembangkan potensi dan bakat siswa melalui kegiatan ekstrakurikuler dan pembinaan prestasi.</p>
                                </div>
                            </div>
                            
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle p-2">4</span>
                                </div>
                                <div>
                                    <h6 class="fw-semibold">Kemitraan Strategis</h6>
                                    <p class="text-muted small mb-0">Membangun kerjasama yang sinergis dengan orang tua, masyarakat, dan dunia industri.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PENGUMUMAN TERBARU -->
<section id="pengumuman" class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
            <div>
                <h2 class="section-title mb-0">Pengumuman Terbaru</h2>
                <p class="section-subtitle mb-0">Informasi penting terkini dari sekolah</p>
            </div>
            <a href="<?= site_url('pengumuman'); ?>" class="btn btn-outline-primary">
                <i class="fas fa-list me-2"></i>Lihat Semua
            </a>
        </div>

        <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
            <?php if (!empty($announcements)): ?>
                <?php foreach ($announcements as $index => $a): ?>
                    <div class="col-md-4">
                        <div class="card card-soft h-100">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge-blue">
                                        <i class="fas fa-bullhorn me-1"></i>Pengumuman
                                    </span>
                                    <small class="text-muted">
                                        <?= date('d M Y', strtotime($a->published_at)); ?>
                                    </small>
                                </div>
                                <h5 class="fw-bold mb-3">
                                    <?= htmlspecialchars($a->title); ?>
                                </h5>
                                <p class="text-muted flex-grow-1">
                                    <?= substr(strip_tags($a->body), 0, 120); ?>...
                                </p>
                                <div class="mt-3">
                                    <a href="<?= site_url('pengumuman/'.$a->id); ?>" class="text-primary fw-semibold text-decoration-none">
                                        Baca Selengkapnya
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-top-0 pt-0">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <small class="text-muted">Oleh: Admin Sekolah</small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-bullhorn fa-3x text-muted opacity-25"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada pengumuman</h5>
                        <p class="text-muted">Pengumuman akan segera tersedia</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- BERITA TERKINI -->
<section id="berita" class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
            <div>
                <h2 class="section-title mb-0">Berita Terkini</h2>
                <p class="section-subtitle mb-0">Informasi kegiatan dan prestasi terbaru sekolah</p>
            </div>
            <a href="<?= site_url('berita'); ?>" class="btn btn-outline-primary">
                <i class="fas fa-newspaper me-2"></i>Arsip Berita
            </a>
        </div>

        <div class="row g-4">
            <?php if (!empty($news)): ?>
                <?php foreach ($news as $index => $n): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="card card-soft h-100">
                            <?php if (!empty($n->thumbnail_path)): ?>
                                <div class="card-img-container">
                                    <img src="<?= base_url('uploads/news/' . $n->thumbnail_path); ?>" 
                                         class="card-img-top" 
                                         alt="<?= htmlspecialchars($n->title); ?>"
                                         style="height: 200px; object-fit: cover;">
                                    <div class="card-img-overlay-top">
                                        <span class="badge bg-primary">
                                            <i class="fas fa-newspaper me-1"></i>Berita
                                        </span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="card-img-placeholder">
                                    <div class="placeholder-icon">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?= date('d M Y', strtotime($n->published_at)); ?>
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-eye me-1"></i> 256
                                    </small>
                                </div>
                                
                                <h5 class="fw-bold mb-3">
                                    <?= htmlspecialchars($n->title); ?>
                                </h5>
                                
                                <p class="text-muted flex-grow-1">
                                    <?= substr(strip_tags($n->content), 0, 100); ?>...
                                </p>
                                
                                <div class="mt-3 pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="<?= site_url('berita/detail/'.$n->slug); ?>" 
                                           class="text-primary fw-semibold text-decoration-none">
                                            Baca Selengkapnya
                                            <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-primary small"></i>
                                            </div>
                                            <small class="text-muted">Admin</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!empty($n->category)): ?>
                                <div class="card-footer bg-transparent border-top-0 pt-0">
                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-tag me-1"></i>
                                            <?= htmlspecialchars($n->category); ?>
                                        </span>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            5 min read
                                        </small>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12" data-aos="fade-up">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <div class="icon-wrapper mx-auto" style="width: 80px; height: 80px; background: rgba(15, 23, 42, 0.05); color: #64748b;">
                                <i class="fas fa-newspaper fa-2x"></i>
                            </div>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada berita terbaru</h5>
                        <p class="text-muted mb-4">Berita kegiatan sekolah akan segera diupdate</p>
                        <a href="mailto:info@smacontoh.sch.id" class="btn btn-outline-primary">
                            <i class="fas fa-envelope me-2"></i>Kirim Informasi
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Highlight Berita (jika ada lebih dari 3) -->
        <?php if (count($news) > 3): ?>
            <div class="text-center mt-5" data-aos="fade-up">
                <div class="card card-soft bg-primary bg-opacity-5 border-primary">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="fw-bold mb-2">Masih banyak berita menarik lainnya!</h5>
                                <p class="text-muted mb-0">
                                    Jelajahi arsip berita lengkap untuk informasi kegiatan sekolah, 
                                    prestasi siswa, dan update terbaru dari SMA Negeri Contoh.
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <a href="<?= site_url('berita'); ?>" class="btn btn-primary px-4">
                                    <i class="fas fa-book-open me-2"></i>Lihat Semua Berita
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer-public">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="mb-4">
                    <a class="navbar-brand text-white mb-3" href="<?= site_url('home'); ?>">
                        <span class="school-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        SMA Negeri Contoh
                    </a>
                    <p class="text-muted">
                        Sekolah unggulan dengan komitmen membentuk generasi penerus bangsa yang berkarakter, 
                        berprestasi, dan berdaya saing global.
                    </p>
                </div>
                
                <div class="social-icons mb-4">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-phone text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Hotline</small>
                        <strong class="text-white">(021) 123-4567</strong>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4">
                <div class="footer-links">
                    <h6>Menu Utama</h6>
                    <a href="#home">Beranda</a>
                    <a href="#profil">Profil Sekolah</a>
                    <a href="#visi-misi">Visi & Misi</a>
                    <a href="#struktur">Struktur Organisasi</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4">
                <div class="footer-links">
                    <h6>Informasi</h6>
                    <a href="#pengumuman">Pengumuman</a>
                    <a href="#berita">Berita Sekolah</a>
                    <a href="#kelulusan">Info Kelulusan</a>
                    <a href="https://forms.gle/PPDB_GOOGLE_FORM" target="_blank">PPDB Online</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4">
                <div class="footer-links">
                    <h6>Kontak & Alamat</h6>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted">Alamat</small>
                            <p class="mb-0 text-white">Jl. Pendidikan No. 123<br>Kota Contoh, 12345</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <i class="fas fa-envelope text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted">Email</small>
                            <p class="mb-0 text-white">info@smacontoh.sch.id</p>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-clock text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted">Jam Operasional</small>
                            <p class="mb-0 text-white">Senin-Jumat<br>07.00-15.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="my-4 border-secondary">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-muted">
                    &copy; <?= date('Y'); ?> SMA Negeri Contoh. Semua hak dilindungi.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-muted">
                    Dikembangkan oleh <strong class="text-white">Tim IT Sekolah</strong>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS Animation -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Custom Script -->
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (window.scrollY > 100) {
            navbar.classList.add('shadow');
            navbar.style.padding = '0.5rem 0';
            navbar.style.background = 'rgba(255, 255, 255, 0.98)';
        } else {
            navbar.classList.remove('shadow');
            navbar.style.padding = '1rem 0';
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
        }
    });
    
    // Active nav link on scroll
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav-link');
    
    window.addEventListener('scroll', function() {
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (scrollY >= (sectionTop - 100)) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
    
    // Scroll to top button
    const scrollTopBtn = document.createElement('div');
    scrollTopBtn.className = 'scroll-top';
    scrollTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    document.body.appendChild(scrollTopBtn);
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.add('active');
        } else {
            scrollTopBtn.classList.remove('active');
        }
    });
    
    scrollTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Counter animation for stats
    const statsElements = document.querySelectorAll('.stats-number');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const finalValue = parseInt(target.textContent);
                const duration = 2000;
                const increment = finalValue / (duration / 16);
                let currentValue = 0;
                
                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        target.textContent = finalValue + '+';
                        clearInterval(timer);
                    } else {
                        target.textContent = Math.floor(currentValue) + '+';
                    }
                }, 16);
                
                observer.unobserve(target);
            }
        });
    }, { threshold: 0.5 });
    
    statsElements.forEach(stat => {
        observer.observe(stat);
    });
</script>
</body>
</html>





