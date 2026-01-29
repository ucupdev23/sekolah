<div class="page-header">
    <div>
        <h1><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
        <p class="text-muted mb-0">Selamat datang di panel admin sekolah</p>
    </div>
    <div class="text-end">
        <span class="badge bg-primary"><?= date('d F Y'); ?></span>
    </div>
</div>

<!-- Welcome Message -->
<div class="welcome-message">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Halo, <?= $this->session->userdata('user_name'); ?>! 👋</h3>
            <p>Semoga hari Anda menyenangkan. Berikut ringkasan data terbaru:</p>
        </div>
        <i class="fas fa-chart-pie fa-3x opacity-50"></i>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4">
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Total Pengumuman</h6>
                        <h3><?= $total_announcements; ?></h3>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>Terbaru hari ini
                        </small>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Total Berita</h6>
                        <h3><?= $total_news; ?></h3>
                        <small class="text-info">
                            <i class="fas fa-newspaper me-1"></i>Semua kategori
                        </small>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Data Kelulusan</h6>
                        <h3><?= $total_graduates; ?></h3>
                        <small class="text-warning">
                            <i class="fas fa-graduation-cap me-1"></i>Total siswa lulus
                        </small>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="<?= site_url('admin/pengumuman/tambah'); ?>" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i>
                            <span>Buat Pengumuman</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= site_url('admin/berita/tambah'); ?>" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i>
                            <span>Tambah Berita</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= site_url('admin/kelulusan/tambah'); ?>" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i>
                            <span>Tambah Kelulusan</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= site_url('admin/users'); ?>" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3">
                            <i class="fas fa-user-plus fa-2x mb-2"></i>
                            <span>Kelola Admin</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<footer class="mt-5 pt-4 border-top">
    <p class="text-center text-muted small">
        <i class="fas fa-info-circle me-1"></i>
        Gunakan menu di sebelah kiri untuk mengelola konten website secara lengkap.
    </p>
</footer>