

<!-- HERO SECTION PENGUMUMAN -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>" class="text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengumuman</li>
                    </ol>
                </nav>
                <h1 class="section-title mb-3">Pengumuman Sekolah</h1>
                <p class="lead text-muted">
                    Informasi resmi dan penting dari pihak sekolah untuk siswa, orang tua, dan masyarakat.
                </p>
                
                <!-- Quick Stats -->
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                            <i class="fas fa-bullhorn text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Total</small>
                            <strong><?= $total_announcements; ?> Pengumuman</strong>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                            <i class="fas fa-calendar-alt text-success"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Terbaru</small>
                            <strong>
                                <?php if (!empty($announcements)): ?>
                                    <?= date('d M Y', strtotime($announcements[0]->published_at)); ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card-public p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informasi
                    </h6>
                    <p class="small text-muted mb-3">
                        Pengumuman diurutkan berdasarkan tanggal terbaru. 
                        Pastikan selalu memeriksa pengumuman penting dari sekolah.
                    </p>
                    <a href="<?= site_url('home'); ?>" class="btn btn-outline-primary w-100">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FILTER & SEARCH -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="card-public">
            <div class="card-body p-4">
                <form method="get" action="<?= site_url('pengumuman'); ?>" class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label fw-medium">
                            <i class="fas fa-search me-2"></i>Cari Pengumuman
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Kata kunci judul atau isi pengumuman..."
                                   value="<?= htmlspecialchars($search_query ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Tahun</label>
                        <select name="year" class="form-select">
                            <option value="">Semua Tahun</option>
                            <?php if (!empty($available_years)): ?>
                                <?php foreach ($available_years as $year_item): ?>
                                    <option value="<?= $year_item; ?>" <?= ($year_filter == $year_item) ? 'selected' : ''; ?>>
                                        <?= $year_item; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="<?= date('Y'); ?>"><?= date('Y'); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </form>
                
                <?php if ($search_query || $year_filter): ?>
                    <div class="mt-3">
                        <small class="text-muted">
                            Hasil filter: 
                            <?php if ($search_query): ?>
                                <span class="badge bg-info">"<?= htmlspecialchars($search_query); ?>"</span>
                            <?php endif; ?>
                            <?php if ($year_filter): ?>
                                <span class="badge bg-info ms-2">Tahun <?= $year_filter; ?></span>
                            <?php endif; ?>
                            <a href="<?= site_url('pengumuman'); ?>" class="text-danger ms-3">
                                <i class="fas fa-times me-1"></i>Hapus Filter
                            </a>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- DAFTAR PENGUMUMAN -->
<section class="py-5">
    <div class="container">
        <?php if (!empty($announcements)): ?>
            <!-- Grid View -->
            <div class="row g-4">
                <?php foreach ($announcements as $index => $a): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-public h-100">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge-public">
                                        <i class="fas fa-bullhorn me-1"></i>Pengumuman
                                    </span>
                                    <small class="text-muted">
                                        <?= date('d M Y', strtotime($a->published_at)); ?>
                                    </small>
                                </div>
                                
                                <h5 class="fw-bold mb-3">
                                    <a href="<?= site_url('pengumuman/'.$a->id); ?>" class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($a->title); ?>
                                        <?php if ($a->is_important): ?>
                                            <span class="badge bg-warning ms-2">Penting!</span>
                                        <?php endif; ?>
                                    </a>
                                </h5>
                                
                                <p class="text-muted flex-grow-1">
                                    <?= isset($a->excerpt) ? $a->excerpt : substr(strip_tags($a->body), 0, 120) . '...'; ?>
                                </p>
                                
                                <div class="mt-3 pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="<?= site_url('pengumuman/'.$a->id); ?>" 
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
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
<?php if ($pagination['total_pages'] > 1): ?>
    <div class="mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-public justify-content-center">
                <!-- Previous -->
                <li class="page-item <?= ($pagination['current_page'] == 1) ? 'disabled' : ''; ?>">
                    <?php if ($pagination['current_page'] > 1): ?>
                        <a class="page-link" 
                           href="<?= site_url('pengumuman') ?>?<?= http_build_query(array_merge(['search' => $search_query, 'year' => $year_filter, 'page' => $pagination['current_page'] - 1])) ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php else: ?>
                        <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                    <?php endif; ?>
                </li>
                
                <!-- Page Numbers -->
                <?php for($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <?php if ($i == $pagination['current_page']): ?>
                        <li class="page-item active">
                            <span class="page-link"><?= $i; ?></span>
                        </li>
                    <?php elseif ($i >= $pagination['current_page'] - 2 && $i <= $pagination['current_page'] + 2): ?>
                        <li class="page-item">
                            <a class="page-link" 
                               href="<?= site_url('pengumuman') ?>?<?= http_build_query(array_merge(['search' => $search_query, 'year' => $year_filter, 'page' => $i])) ?>">
                                <?= $i; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <!-- Next -->
                <li class="page-item <?= ($pagination['current_page'] == $pagination['total_pages']) ? 'disabled' : ''; ?>">
                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                        <a class="page-link" 
                           href="<?= site_url('pengumuman') ?>?<?= http_build_query(array_merge(['search' => $search_query, 'year' => $year_filter, 'page' => $pagination['current_page'] + 1])) ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
        
        <p class="text-center text-muted small mt-3">
            Menampilkan <?= $pagination['start']; ?>-<?= $pagination['end']; ?> 
            dari <?= $pagination['total']; ?> pengumuman
        </p>
    </div>
<?php endif; ?>
            
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <div class="icon-wrapper mx-auto" style="width: 80px; height: 80px; background: rgba(15, 23, 42, 0.05); color: #64748b;">
                        <i class="fas fa-bullhorn fa-2x"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-muted mb-3">Belum ada pengumuman</h4>
                <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
                    Saat ini belum ada pengumuman yang tersedia. 
                    Pengumuman penting dari sekolah akan ditampilkan di halaman ini.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= site_url('home'); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                    <a href="mailto:info@smacontoh.sch.id" class="btn btn-primary">
                        <i class="fas fa-envelope me-2"></i>Hubungi Sekolah
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>