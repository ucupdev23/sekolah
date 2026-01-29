<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title . ' - SMA Negeri Contoh' : 'SMA Negeri Contoh'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= isset($meta_description) ? $meta_description : 'Website resmi SMA Negeri Contoh - Informasi sekolah, pengumuman, berita, dan kelulusan'; ?>">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS untuk halaman publik -->
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
            line-height: 1.6;
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        
        /* Navbar Public */
        .navbar-public {
            background: white;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-blue) !important;
        }
        
        .school-icon {
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
        
        .nav-link-public {
            font-weight: 500;
            color: var(--text-dark) !important;
            padding: 0.5rem 1rem !important;
            margin: 0 0.2rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .nav-link-public:hover {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue) !important;
            transform: translateY(-2px);
        }
        
        .nav-link-public.active {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue) !important;
        }
        
        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
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
        
        /* Cards */
        .card-public {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            transition: all 0.3s ease;
            background: white;
        }
        
        .card-public:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
        }
        
        /* Badges */
        .badge-public {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
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
        
        /* Pagination */
        .pagination-public .page-link {
            border: none;
            color: var(--text-dark);
            margin: 0 4px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .pagination-public .page-link:hover {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue);
        }
        
        .pagination-public .page-item.active .page-link {
            background: var(--primary-blue);
            color: white;
        }
        
        /* Footer Public */
        .footer-public {
            background: var(--dark-bg);
            color: #94a3b8;
            margin-top: auto;
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .school-icon {
                width: 28px;
                height: 28px;
                line-height: 28px;
            }
        }
        /* Tambahkan di public_header.php di bagian CSS */

/* Kelulusan specific styles */
.alumni-card {
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.alumni-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    border-color: var(--primary-blue);
}

.alumni-avatar {
    position: relative;
    height: 160px;
    overflow: hidden;
    border-radius: 16px 16px 0 0;
}

.alumni-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.alumni-card:hover .alumni-photo {
    transform: scale(1.05);
}

.avatar-placeholder {
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.avatar-initials {
    font-size: 3rem;
    font-weight: bold;
    color: white;
    text-transform: uppercase;
}

.graduation-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.9);
    color: var(--text-dark);
    padding: 5px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}
    </style>
</head>
<body>
    
<!-- NAVBAR PUBLIC -->
<nav class="navbar navbar-expand-lg navbar-public">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('home'); ?>">
            <span class="school-icon">
                <i class="fas fa-graduation-cap"></i>
            </span>
            SMA Negeri Contoh
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarPublic" aria-controls="navbarPublic"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarPublic">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link-public <?= (current_url() == site_url('home')) ? 'active' : ''; ?>" 
                       href="<?= site_url('home'); ?>">
                        <i class="fas fa-home me-1"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-public <?= (strpos(current_url(), 'pengumuman') !== false) ? 'active' : ''; ?>" 
                       href="<?= site_url('pengumuman'); ?>">
                        <i class="fas fa-bullhorn me-1"></i>Pengumuman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-public <?= (strpos(current_url(), 'berita') !== false) ? 'active' : ''; ?>" 
                       href="<?= site_url('berita'); ?>">
                        <i class="fas fa-newspaper me-1"></i>Berita
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-public <?= (strpos(current_url(), 'kelulusan') !== false) ? 'active' : ''; ?>" 
                       href="<?= site_url('kelulusan'); ?>">
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

<main>