<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Helper function untuk generate pagination URL
function generate_graduation_pagination_url($base_url, $params, $page) {
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

// Helper function to get initials from name
function get_initials($name) {
    $words = explode(' ', $name);
    $initials = '';
    
    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
    }
    
    return substr($initials, 0, 2);
}

?>

<?php
// Helper function untuk mendapatkan inisial dari nama
function getAlumniInitials($name) {
    $words = explode(' ', $name);
    $initials = '';
    
    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
    }
    
    return substr($initials, 0, 2);
}
?>



<!-- HERO SECTION KELULUSAN -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>" class="text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelulusan</li>
                    </ol>
                </nav>
                <h1 class="section-title mb-3">Data Kelulusan Siswa</h1>
                <p class="lead text-muted">
                    Temukan informasi alumni SMA Negeri Contoh berdasarkan nama, NISN, atau tahun kelulusan.
                </p>
                
                <!-- Quick Stats -->
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                            <i class="fas fa-user-graduate text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Total Alumni</small>
                            <strong><?= $total_graduates; ?> Siswa</strong>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                            <i class="fas fa-calendar-alt text-success"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Tahun</small>
                            <strong><?= count($distinct_years); ?> Angkatan</strong>
                        </div>
                    </div>
                    
                    <?php if (!empty($graduates)): ?>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2">
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Terbaru</small>
                                <strong>
                                    <?php 
                                    $latest_year = max(array_column($graduates, 'graduation_year'));
                                    echo $latest_year; 
                                    ?>
                                </strong>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card-public p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informasi Pencarian
                    </h6>
                    <p class="small text-muted mb-3">
                        Gunakan fitur pencarian untuk menemukan data alumni. 
                        Anda dapat mengunduh CV alumni yang tersedia.
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
                <form method="get" action="<?= site_url('kelulusan'); ?>" class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">
                            <i class="fas fa-search me-2"></i>Cari Alumni
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-user-graduate text-muted"></i>
                            </span>
                            <input type="text" 
                                   name="q" 
                                   class="form-control" 
                                   placeholder="Masukkan nama siswa atau NISN..."
                                   value="<?= htmlspecialchars($keyword ?? ''); ?>">
                        </div>
                        <!-- <small class="text-muted">
                            Cari berdasarkan nama lengkap atau NISN
                        </small> -->
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-medium">
                            <i class="fas fa-calendar me-2"></i>Tahun Kelulusan
                        </label>
                        <select name="year" class="form-select">
                            <option value="">Semua Tahun</option>
                            <?php if (!empty($distinct_years)): ?>
                                <?php foreach ($distinct_years as $y): ?>
                                    <option value="<?= $y->year; ?>" <?= ($selected_year == $y->year) ? 'selected' : ''; ?>>
                                        Angkatan <?= $y->year; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                            <a href="<?= site_url('kelulusan'); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </form>
                
                <?php if ($keyword || $selected_year): ?>
                    <div class="mt-3">
                        <small class="text-muted">
                            Hasil pencarian: 
                            <?php if ($keyword): ?>
                                <span class="badge bg-info">"<?= htmlspecialchars($keyword); ?>"</span>
                            <?php endif; ?>
                            <?php if ($selected_year): ?>
                                <span class="badge bg-info ms-2">Tahun <?= $selected_year; ?></span>
                            <?php endif; ?>
                            <span class="ms-2">
                                <strong><?= $total_graduates; ?></strong> data ditemukan
                            </span>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ALUMNI CARDS SECTION -->
<section class="py-5">
    <div class="container">
        <?php if (!empty($graduates)): ?>
            <!-- View Toggle -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-user-graduate me-2"></i>
                        Daftar Alumni
                    </h4>
                    <small class="text-muted"><?= $total_graduates; ?> data ditemukan</small>
                </div>
                <div class="d-flex align-items-center">
                    <small class="me-3 text-muted">Tampilan:</small>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary active" id="viewGrid">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="viewList">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Grid View (Default) -->
            <div class="row g-4" id="gridView">
                <?php foreach ($graduates as $alumni): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="alumni-card card-public h-100">
                            <!-- Card Header -->
                            <div class="card-header bg-transparent border-0 p-0">
                                <?php if (!empty($alumni->photo_path)): ?>
                                    <div class="alumni-avatar">
                                        <img src="<?= base_url('uploads/graduates/photos/' . $alumni->photo_path); ?>" 
                                             alt="<?= htmlspecialchars($alumni->student_name); ?>"
                                             class="alumni-photo">
                                        <div class="graduation-badge">
                                            <?= $alumni->graduation_year; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="alumni-avatar avatar-placeholder">
                                        <div class="avatar-initials">
                                            <?= getAlumniInitials($alumni->student_name); ?>
                                        </div>
                                        <div class="graduation-badge">
                                            <?= $alumni->graduation_year; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="fw-bold mb-2 text-center">
                                    <?= htmlspecialchars($alumni->student_name); ?>
                                </h5>
                                
                                <div class="text-center mb-3">
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-id-card me-1"></i>
                                        NISN: <?= htmlspecialchars($alumni->nisn); ?>
                                    </span>
                                </div>
                                
                                <div class="alumni-info mb-3">
                                    <div class="info-item mb-2">
                                        <i class="fas fa-graduation-cap text-primary me-2"></i>
                                        <small class="text-muted">Tahun Lulus:</small>
                                        <strong class="d-block"><?= $alumni->graduation_year; ?></strong>
                                    </div>
                                    
                                    <?php if (!empty($alumni->major)): ?>
                                        <div class="info-item mb-2">
                                            <i class="fas fa-book text-primary me-2"></i>
                                            <small class="text-muted">Jurusan:</small>
                                            <strong class="d-block"><?= htmlspecialchars($alumni->major); ?></strong>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="mt-auto pt-3 border-top">
                                    <div class="d-flex justify-content-center gap-2">
                                        <?php if (!empty($alumni->cv_link)): ?>
                                            <?php
                                                $cvUrl = (strpos($alumni->cv_link, 'http') === 0) 
                                                    ? $alumni->cv_link 
                                                    : base_url('uploads/graduates/cv/' . $alumni->cv_link);
                                            ?>
                                            <a href="<?= $cvUrl; ?>" 
                                               target="_blank" 
                                               class="btn btn-sm btn-primary"
                                               data-bs-toggle="tooltip" 
                                               title="Lihat CV">
                                                <i class="fas fa-file-pdf me-1"></i>CV
                                            </a>
                                        <?php endif; ?>
                                        
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary alumni-detail"
                                                data-name="<?= htmlspecialchars($alumni->student_name); ?>"
                                                data-nisn="<?= htmlspecialchars($alumni->nisn); ?>"
                                                data-year="<?= $alumni->graduation_year; ?>"
                                                data-major="<?= htmlspecialchars($alumni->major ?? '-'); ?>"
                                                data-cv="<?= !empty($alumni->cv_link) ? 'Ya' : 'Tidak'; ?>"
                                                data-photo="<?= !empty($alumni->photo_path) 
                                                ? base_url('uploads/graduates/photos/' . $alumni->photo_path) 
                                                : ''; ?>">
                                            <i class="fas fa-info-circle me-1"></i>Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- List View (Hidden by Default) -->
            <div class="d-none" id="listView">
                <div class="card-public">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 80px;">Tahun</th>
                                        <th>Nama Alumni</th>
                                        <th style="width: 140px;">NISN</th>
                                        <!-- <th style="width: 120px;">Jurusan</th> -->
                                        <th style="width: 100px;">Foto</th>
                                        <th style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($graduates as $alumni): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">
                                                    <?= $alumni->graduation_year; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($alumni->student_name); ?></strong>
                                            </td>
                                            <td><?= htmlspecialchars($alumni->nisn); ?></td>
                                            <!-- <td><?= htmlspecialchars($alumni->major ?? '-'); ?></td> -->
                                            <td>
                                                <?php if (!empty($alumni->photo_path)): ?>
                                                    <img src="<?= base_url('uploads/graduates/photos/' . $alumni->photo_path); ?>" 
                                                         alt="Foto" 
                                                         class="img-thumbnail"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <?php if (!empty($alumni->cv_link)): ?>
                                                        <?php
                                                            $cvUrl = (strpos($alumni->cv_link, 'http') === 0) 
                                                                ? $alumni->cv_link 
                                                                : base_url('uploads/graduates/cv/' . $alumni->cv_link);
                                                        ?>
                                                        <a href="<?= $cvUrl; ?>" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-outline-primary"
                                                           data-bs-toggle="tooltip" 
                                                           title="Download CV">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-secondary alumni-detail"
                                                            data-name="<?= htmlspecialchars($alumni->student_name); ?>"
                                                            data-nisn="<?= htmlspecialchars($alumni->nisn); ?>"
                                                            data-year="<?= $alumni->graduation_year; ?>"
                                                            data-major="<?= htmlspecialchars($alumni->major ?? '-'); ?>"
                                                            data-cv="<?= !empty($alumni->cv_link) ? 'Ya' : 'Tidak'; ?>"
                                                            data-photo="<?= !empty($alumni->photo_path) 
                                                            ? base_url('uploads/graduates/photos/' . $alumni->photo_path) 
                                                            : ''; ?>">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                                       href="<?= generate_graduation_pagination_url(site_url('kelulusan'), ['q' => $keyword, 'year' => $selected_year], $pagination['current_page'] - 1) ?>">
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
                                           href="<?= generate_graduation_pagination_url(site_url('kelulusan'), ['q' => $keyword, 'year' => $selected_year], $i) ?>">
                                            <?= $i; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endfor; ?>
                            
                            <!-- Next -->
                            <li class="page-item <?= ($pagination['current_page'] == $pagination['total_pages']) ? 'disabled' : ''; ?>">
                                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                    <a class="page-link" 
                                       href="<?= generate_graduation_pagination_url(site_url('kelulusan'), ['q' => $keyword, 'year' => $selected_year], $pagination['current_page'] + 1) ?>">
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
                        dari <?= $pagination['total']; ?> alumni
                    </p>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <div class="icon-wrapper mx-auto" style="width: 80px; height: 80px; background: rgba(15, 23, 42, 0.05); color: #64748b;">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-muted mb-3">Data tidak ditemukan</h4>
                <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
                    Tidak ada data alumni yang sesuai dengan kriteria pencarian Anda.
                    Coba gunakan kata kunci lain atau pilih tahun yang berbeda.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= site_url('kelulusan'); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-redo me-2"></i>Reset Pencarian
                    </a>
                    <a href="<?= site_url('home'); ?>" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- STATISTICS SECTION -->
<section class="py-5 bg-light">
    <div class="container">
        <h4 class="fw-bold text-center mb-4">
            <i class="fas fa-chart-bar me-2"></i>Statistik Kelulusan
        </h4>
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="text-center p-3 bg-white rounded-3 shadow-sm">
                    <div class="stats-icon mb-2" style="background: rgba(37, 99, 235, 0.1); color: var(--primary-blue);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= $total_graduates; ?></h3>
                    <small class="text-muted">Total Alumni</small>
                </div>
            </div>
            
            <div class="col-md-3 col-6">
                <div class="text-center p-3 bg-white rounded-3 shadow-sm">
                    <div class="stats-icon mb-2" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= count($distinct_years); ?></h3>
                    <small class="text-muted">Tahun Kelulusan</small>
                </div>
            </div>
            
            <div class="col-md-3 col-6">
                <div class="text-center p-3 bg-white rounded-3 shadow-sm">
                    <div class="stats-icon mb-2" style="background: rgba(245, 158, 11, 0.1); color: var(--accent-orange);">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <h3 class="fw-bold mb-1">
                        <?php
                        $cv_count = 0;
                        if (!empty($graduates)) {
                            foreach ($graduates as $g) {
                                if (!empty($g->cv_link)) $cv_count++;
                            }
                        }
                        echo $cv_count;
                        ?>
                    </h3>
                    <small class="text-muted">CV Tersedia</small>
                </div>
            </div>
            
            <div class="col-md-3 col-6">
                <div class="text-center p-3 bg-white rounded-3 shadow-sm">
                    <div class="stats-icon mb-2" style="background: rgba(168, 85, 247, 0.1); color: #a855f7;">
                        <i class="fas fa-images"></i>
                    </div>
                    <h3 class="fw-bold mb-1">
                        <?php
                        $photo_count = 0;
                        if (!empty($graduates)) {
                            foreach ($graduates as $g) {
                                if (!empty($g->photo_path)) $photo_count++;
                            }
                        }
                        echo $photo_count;
                        ?>
                    </h3>
                    <small class="text-muted">Foto Tersedia</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DETAIL MODAL -->
<div class="modal fade" id="alumniDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-user-graduate me-2 text-primary"></i>
                    Detail Alumni
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="modal-avatar-wrapper mx-auto mb-3">
                        <div class="modal-avatar" id="modalAvatarContent">
                            <i class="fas fa-user-graduate fa-3x"></i>
                        </div>
                    </div>
                    <h4 id="modalAlumniName" class="fw-bold mb-2"></h4>
                    <p class="text-muted mb-0" id="modalAlumniYear"></p>
                </div>
                
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center py-3">
                                <small class="text-muted d-block">NISN</small>
                                <strong id="modalAlumniNisn"></strong>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-6">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center py-3">
                                <small class="text-muted d-block">Jurusan</small>
                                <strong id="modalAlumniMajor"></strong>
                            </div>
                        </div>
                    </div> -->
                </div>
                
                <div class="mt-4">
                    <div class="alert alert-info">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-pdf me-3"></i>
                            <div>
                                <strong>CV Tersedia:</strong>
                                <span id="modalAlumniCv" class="ms-2"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="modalDownloadCv" style="display: none;">
                    <i class="fas fa-download me-2"></i>Download CV
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Kelulusan Page -->
<style>
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
    
    .alumni-info {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 10px;
    }
    
    .info-item {
        display: flex;
        align-items: center;
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 1.5rem;
    }
    
    .alumni-avatar-modal {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .avatar-placeholder-modal {
        color: white;
    }

    .modal-avatar-wrapper {
    width: 130px;
    height: 130px;
    margin: 0 auto;
    border-radius: 50%;
    padding: 6px;
    background: linear-gradient(135deg, #2563eb, #1e40af);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.modal-avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: #ffffff;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.modal-avatar i {
    color: #2563eb;
}

    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .alumni-card {
            margin-bottom: 1.5rem;
        }
        
        .alumni-avatar {
            height: 140px;
        }
        
        .stats-icon {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
    }
</style>

<script>
    // View Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const viewGridBtn = document.getElementById('viewGrid');
        const viewListBtn = document.getElementById('viewList');
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        
        viewGridBtn.addEventListener('click', function() {
            viewGridBtn.classList.add('active');
            viewListBtn.classList.remove('active');
            gridView.classList.remove('d-none');
            listView.classList.add('d-none');
        });
        
        viewListBtn.addEventListener('click', function() {
            viewListBtn.classList.add('active');
            viewGridBtn.classList.remove('active');
            listView.classList.remove('d-none');
            gridView.classList.add('d-none');
        });
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Alumni detail modal
        const detailButtons = document.querySelectorAll('.alumni-detail');
        const detailModal = new bootstrap.Modal(document.getElementById('alumniDetailModal'));
        
        detailButtons.forEach(button => {
            button.addEventListener('click', function() {
                const name = this.getAttribute('data-name');
                const nisn = this.getAttribute('data-nisn');
                const year = this.getAttribute('data-year');
                const major = this.getAttribute('data-major');
                const hasCv = this.getAttribute('data-cv');
                const photo = this.getAttribute('data-photo');
                
                document.getElementById('modalAlumniName').textContent = name;
                document.getElementById('modalAlumniNisn').textContent = nisn;
                document.getElementById('modalAlumniYear').textContent = 'Angkatan ' + year;
                // document.getElementById('modalAlumniMajor').textContent = major;
                document.getElementById('modalAlumniCv').textContent = hasCv;

                const avatarContent = document.getElementById('modalAvatarContent');

                if (photo && photo !== '') {
                    avatarContent.innerHTML = `<img src="${photo}" alt="${name}">`;
                } else {
                    avatarContent.innerHTML = `<i class="fas fa-user-graduate fa-3x"></i>`;
                }

                
                // Get CV URL from the card
                const card = this.closest('.alumni-card') || this.closest('tr');
                const cvLink = card.querySelector('a[href*=".pdf"], a[href*=".doc"], a[href*="cv"]');
                
                if (cvLink && hasCv === 'Ya') {
                    document.getElementById('modalDownloadCv').style.display = 'block';
                    document.getElementById('modalDownloadCv').onclick = function() {
                        window.open(cvLink.href, '_blank');
                    };
                } else {
                    document.getElementById('modalDownloadCv').style.display = 'none';
                }
                
                detailModal.show();
            });
        });
    });
</script>
