<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Helper function untuk generate pagination URL
function generate_news_pagination_url($base_url, $params, $page) {
    if ($page < 1) return '#';
    
    $query_params = array_merge($params, ['halaman' => $page]);
    $query_params = array_filter($query_params, function($value) {
        return $value !== '' && $value !== null;
    });
    
    if (empty($query_params)) {
        return $base_url;
    }
    
    return $base_url . '?' . http_build_query($query_params);
}

?>


<!-- HERO SECTION BERITA -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>" class="text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Berita</li>
                    </ol>
                </nav>
                <h1 class="section-title mb-3">Berita Sekolah</h1>
                <p class="lead text-muted">
                    Informasi kegiatan, prestasi siswa, dan berita terbaru dari SMA Negeri Contoh.
                </p>
                
                <!-- Quick Stats -->
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                            <i class="fas fa-newspaper text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Total</small>
                            <strong><?= $total_news; ?> Berita</strong>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                            <i class="fas fa-tags text-success"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Kategori</small>
                            <strong><?= count($categories); ?></strong>
                        </div>
                    </div>
                    
                    <?php if (!empty($news_list)): ?>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2">
                                <i class="fas fa-calendar-alt text-warning"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Terbaru</small>
                                <strong><?= date('d M Y', strtotime($news_list[0]->published_at)); ?></strong>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card-public p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informasi Berita
                    </h6>
                    <p class="small text-muted mb-3">
                        Temukan berita terbaru tentang kegiatan sekolah, prestasi siswa, 
                        dan informasi penting lainnya.
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
                <form method="get" action="<?= site_url('berita'); ?>" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-medium">
                            <i class="fas fa-search me-2"></i>Cari Berita
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Kata kunci judul atau isi berita..."
                                   value="<?= htmlspecialchars($search_query ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat->slug; ?>" <?= ($selected_category == $cat->slug) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($cat->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Tahun</label>
                        <select name="tahun" class="form-select">
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
                
                <?php if ($search_query || $selected_category || $year_filter): ?>
                    <div class="mt-3">
                        <small class="text-muted">
                            Hasil filter: 
                            <?php if ($search_query): ?>
                                <span class="badge bg-info">"<?= htmlspecialchars($search_query); ?>"</span>
                            <?php endif; ?>
                            <?php if ($selected_category): ?>
                                <span class="badge bg-info ms-2">
                                    <?= htmlspecialchars(array_column($categories, 'name', 'slug')[$selected_category] ?? $selected_category); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($year_filter): ?>
                                <span class="badge bg-info ms-2">Tahun <?= $year_filter; ?></span>
                            <?php endif; ?>
                            <a href="<?= site_url('berita'); ?>" class="text-danger ms-3">
                                <i class="fas fa-times me-1"></i>Hapus Filter
                            </a>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- DAFTAR BERITA -->
<section class="py-5">
    <div class="container">
        <?php if (!empty($news_list)): ?>
            <!-- Grid View -->
            <div class="row g-4">
                <?php foreach ($news_list as $news): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-public h-100">
                            <?php if (!empty($news->thumbnail_path)): ?>
                                <div class="card-img-container">
                                    <img src="<?= base_url('uploads/news/' . $news->thumbnail_path); ?>" 
                                         class="card-img-top" 
                                         alt="<?= htmlspecialchars($news->title); ?>"
                                         style="height: 200px; object-fit: cover;">
                                    <div class="card-img-overlay-top">
                                        <span class="badge bg-primary">
                                            <?= htmlspecialchars($news->category_name); ?>
                                        </span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="card-img-placeholder">
                                    <div class="placeholder-icon">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <div class="card-img-overlay-top">
                                        <span class="badge bg-primary">
                                            <?= htmlspecialchars($news->category_name); ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?= date('d M Y', strtotime($news->published_at)); ?>
                                    </small>
                                    <!-- <small class="text-muted">
                                        <i class="fas fa-eye me-1"></i> 0
                                    </small> -->
                                </div>
                                
                                <h5 class="fw-bold mb-3">
                                    <a href="<?= site_url('berita/detail/'.$news->slug); ?>" class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($news->title); ?>
                                    </a>
                                </h5>
                                
                                <p class="text-muted flex-grow-1">
                                    <?= isset($news->excerpt) ? $news->excerpt : substr(strip_tags($news->content), 0, 120) . '...'; ?>
                                </p>
                                
                                <div class="mt-3 pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="<?= site_url('berita/detail/'.$news->slug); ?>" 
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
                                       href="<?= generate_news_pagination_url(site_url('berita'), ['search' => $search_query, 'kategori' => $selected_category, 'tahun' => $year_filter], $pagination['current_page'] - 1) ?>">
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
                                           href="<?= generate_news_pagination_url(site_url('berita'), ['search' => $search_query, 'kategori' => $selected_category, 'tahun' => $year_filter], $i) ?>">
                                            <?= $i; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endfor; ?>
                            
                            <!-- Next -->
                            <li class="page-item <?= ($pagination['current_page'] == $pagination['total_pages']) ? 'disabled' : ''; ?>">
                                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                    <a class="page-link" 
                                       href="<?= generate_news_pagination_url(site_url('berita'), ['search' => $search_query, 'kategori' => $selected_category, 'tahun' => $year_filter], $pagination['current_page'] + 1) ?>">
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
                        dari <?= $pagination['total']; ?> berita
                    </p>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <div class="icon-wrapper mx-auto" style="width: 80px; height: 80px; background: rgba(15, 23, 42, 0.05); color: #64748b;">
                        <i class="fas fa-newspaper fa-2x"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-muted mb-3">Belum ada berita</h4>
                <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
                    Saat ini belum ada berita yang tersedia. 
                    Berita terbaru tentang kegiatan sekolah akan ditampilkan di halaman ini.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= site_url('home'); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                    <a href="<?= site_url('pengumuman'); ?>" class="btn btn-primary">
                        <i class="fas fa-bullhorn me-2"></i>Lihat Pengumuman
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA SECTION -->
<section class="py-5 bg-primary bg-opacity-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-2">Ingin berbagi informasi kegiatan?</h4>
                <p class="text-muted mb-0">
                    Jika Anda memiliki informasi kegiatan sekolah yang ingin dibagikan, 
                    hubungi tim humas sekolah untuk publikasi berita.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="mailto:humas@smacontoh.sch.id" class="btn btn-primary px-4">
                    <i class="fas fa-envelope me-2"></i>Hubungi Humas
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    .card-img-placeholder {
        height: 200px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        position: relative;
    }
    
    .placeholder-icon {
        font-size: 3rem;
        opacity: 0.3;
    }
    
    .card-img-overlay-top {
        position: absolute;
        top: 15px;
        left: 15px;
    }
</style>
<style>
    .card-img-container {
        position: relative;
        overflow: hidden;
    }
    
    .card-img-container img {
        width: 100%;
        transition: transform 0.3s ease;
    }
    
    .card-public:hover .card-img-container img {
        transform: scale(1.05);
    }
    
    .card-img-placeholder {
        height: 200px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        position: relative;
    }
    
    .placeholder-icon {
        font-size: 3rem;
        opacity: 0.3;
    }
    
    .card-img-overlay-top {
        position: absolute;
        top: 15px;
        left: 15px;
    }
    
    /* Untuk thumbnail di sidebar */
    .list-group-item img {
        transition: transform 0.3s ease;
    }
    
    .list-group-item:hover img {
        transform: scale(1.1);
    }
</style>