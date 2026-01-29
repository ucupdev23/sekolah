<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title.' - ' : ''; ?>Admin Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    
    <style>
        /* Additional inline styles for better appearance */
        .admin-nav .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        /* Mobile Toggle Button */
        .mobile-toggle-btn {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1050;
            width: 40px;
            height: 40px;
            background: var(--primary-blue);
            border: none;
            border-radius: 8px;
            color: white;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                position: fixed;
                left: -260px;
                top: 0;
                bottom: 0;
                z-index: 1050;
                transition: left 0.3s ease;
            }
            
            .admin-sidebar.show {
                left: 0;
            }
            
            .admin-main {
                margin-left: 0 !important;
                padding: 1rem;
            }
            
            .mobile-toggle-btn {
                display: flex;
            }
            
            .page-header {
                margin-top: 60px;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .page-header > div:first-child {
                width: 100%;
            }
            
            .page-header > a {
                width: 100%;
                text-align: center;
            }
        }
        
        @media (max-width: 767.98px) {
            .dashboard-card .card-body {
                padding: 1rem;
            }
            
            .table-responsive {
                font-size: 0.9rem;
            }
            
            .btn-group .btn {
                padding: 0.25rem 0.5rem;
            }
        }
    </style>
</head>
<body class="admin-body">

<!-- Mobile Toggle Button -->
<!-- Mobile Toggle Button -->
<button class="mobile-toggle-btn" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- SIDEBAR -->
        <aside class="col-md-3 col-lg-2 admin-sidebar" id="adminSidebar">
            <div class="logo-area">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1"><i class="fas fa-school me-2"></i>Admin Sekolah</h5>
                        <small class="text-light d-block mb-2">
                            <i class="fas fa-user me-1"></i><?= $this->session->userdata('user_name'); ?>
                        </small>
                        <span class="badge bg-light text-primary">
                            <i class="fas fa-shield-alt me-1"></i>
                            <?= $this->session->userdata('user_role') === 'super_admin' ? 'Super Admin' : 'Admin'; ?>
                        </span>
                    </div>
                    <button class="btn btn-sm btn-outline-light d-lg-none" id="closeSidebar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <nav class="nav flex-column admin-nav">
                <a href="<?= site_url('admin'); ?>" class="nav-link <?= ($active_menu ?? '') === 'dashboard' ? 'active' : ''; ?>">
                    <i class="fas fa-chart-line"></i>Dashboard
                </a>
                <a href="<?= site_url('admin/pengumuman'); ?>" class="nav-link <?= ($active_menu ?? '') === 'pengumuman' ? 'active' : ''; ?>">
                    <i class="fas fa-bullhorn"></i>Pengumuman
                </a>
                <a href="<?= site_url('admin/berita'); ?>" class="nav-link <?= ($active_menu ?? '') === 'berita' ? 'active' : ''; ?>">
                    <i class="fas fa-newspaper"></i>Berita
                </a>
                <a href="<?= site_url('admin/kelulusan'); ?>" class="nav-link <?= ($active_menu ?? '') === 'kelulusan' ? 'active' : ''; ?>">
                    <i class="fas fa-graduation-cap"></i>Kelulusan
                </a>

                <?php if ($this->session->userdata('user_role') === 'super_admin'): ?>
                    <hr class="border-light opacity-25 my-2">
                    <a href="<?= site_url('admin/kategori'); ?>" class="nav-link <?= ($active_menu ?? '') === 'kategori' ? 'active' : ''; ?>">
                        <i class="fas fa-tags"></i>Kategori Berita
                    </a>
                    <a href="<?= site_url('admin/tahun-kelulusan'); ?>" class="nav-link <?= ($active_menu ?? '') === 'tahun' ? 'active' : ''; ?>">
                        <i class="fas fa-calendar-alt"></i>Tahun Kelulusan
                    </a>
                    <a href="<?= site_url('admin/users'); ?>" class="nav-link <?= ($active_menu ?? '') === 'users' ? 'active' : ''; ?>">
                        <i class="fas fa-users-cog"></i>Admin User
                    </a>
                <?php endif; ?>

                <hr class="border-light opacity-25 my-2">
                <a href="<?= site_url('admin/logout'); ?>" class="nav-link text-danger">
                    <i class="fas fa-sign-out-alt"></i>Logout
                </a>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="col-md-9 col-lg-10 admin-main" id="adminMain">