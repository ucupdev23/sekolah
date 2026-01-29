<div class="page-header">
    <div>
        <h1><i class="fas fa-newspaper me-2"></i>Kelola Berita</h1>
        <p class="text-muted mb-0">Kelola semua berita yang ditampilkan di website</p>
    </div>
    <a href="<?= site_url('admin/berita/tambah'); ?>" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Tambah Berita
    </a>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= validation_errors(); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Berita</h6>
                        <h3><?= $total_records; ?></h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Per Halaman</h6>
                        <h3>10</h3>
                    </div>
                    <div class="stats-icon" style="background: #d1fae5; color: #10b981;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Halaman</h6>
                        <h3><?= $current_page; ?>/<?= $total_pages; ?></h3>
                    </div>
                    <div class="stats-icon" style="background: #fef3c7; color: #f59e0b;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Ditampilkan</h6>
                        <h3><?= count($news_list); ?></h3>
                    </div>
                    <div class="stats-icon" style="background: #e0e7ff; color: #8b5cf6;">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="get" action="<?= site_url('admin/berita'); ?>" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari judul atau isi berita..."
                           value="<?= $this->input->get('search'); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat->id; ?>" 
                            <?= $this->input->get('category') == $cat->id ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($cat->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <?php if ($this->input->get('search') || $this->input->get('category')): ?>
                        <a href="<?= site_url('admin/berita'); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Berita</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="newsTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;" class="text-center">
                            <span class="d-flex align-items-center">
                                No
                            </span>
                        </th>
                        <th style="width: 100px;">Thumbnail</th>
                        <th>Judul & Konten</th>
                        <th style="width: 150px;">Kategori</th>
                        <th style="width: 150px;">Tanggal</th>
                        <th style="width: 180px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($news_list)): ?>
                        <?php 
                        $start_number = (($current_page - 1) * 10) + 1;
                        foreach ($news_list as $index => $n): 
                        ?>
                            <tr data-id="<?= $n->id; ?>" class="news-row">
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        <?= $start_number++; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($n->thumbnail_path)): ?>
                                        <img src="<?= base_url('uploads/news/' . $n->thumbnail_path); ?>" 
                                             class="news-thumbnail" 
                                             alt="<?= htmlspecialchars($n->title); ?>"
                                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNFM0U2RUEiLz48cGF0aCBkPSJNMzAgMzVMMzUgMjVIMjVMMzAgMzVaIiBmaWxsPSIjOTZBMUJDIi8+PHBhdGggZD0iTTQwIDQwSDEwQzggODk1IDggNDAgMTAgNDBINDBDNDIgNDAgNDIgNDAgNDAgNDBaIiBmaWxsPSIjOTZBMUJDIi8+PGNpcmNsZSBjeD0iMzAiIGN5PSIyMCIgcj0iNSIgZmlsbD0iIzk2QTFCQyIvPjwvc3ZnPg=='">
                                    <?php else: ?>
                                        <div class="no-thumbnail">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1"><?= htmlspecialchars($n->title); ?></h6>
                                        <small class="text-muted">
                                            <?= strlen(strip_tags($n->content)) > 100 ? substr(strip_tags($n->content), 0, 100).'...' : strip_tags($n->content); ?>
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        <?= $n->category_name ? htmlspecialchars($n->category_name) : '<span class="text-muted">Tanpa Kategori</span>'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium"><?= date('d M Y', strtotime($n->published_at)); ?></span>
                                        <small class="text-muted">
                                            <?= date('H:i', strtotime($n->published_at)); ?>
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= site_url('admin/berita/edit/'.$n->id); ?>" 
                                           class="btn btn-outline-primary px-3"
                                           data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('berita/detail/'.$n->slug); ?>" 
                                           class="btn btn-outline-info px-3" target="_blank"
                                           data-bs-toggle="tooltip" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger px-3"
                                                onclick="confirmDelete(<?= $n->id; ?>, '<?= htmlspecialchars(addslashes($n->title)); ?>')"
                                                data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-newspaper fa-3x text-muted opacity-25"></i>
                                    </div>
                                    <?php if ($this->input->get('search') || $this->input->get('category')): ?>
                                        <h5 class="text-muted mb-2">Hasil pencarian tidak ditemukan</h5>
                                        <p class="text-muted mb-3">Coba dengan kata kunci atau kategori lain</p>
                                        <a href="<?= site_url('admin/berita'); ?>" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Hapus Filter
                                        </a>
                                    <?php else: ?>
                                        <h5 class="text-muted mb-2">Belum ada berita</h5>
                                        <p class="text-muted mb-3">Mulai dengan membuat berita pertama Anda</p>
                                        <a href="<?= site_url('admin/berita/tambah'); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Berita
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (!empty($news_list) && $total_pages > 1): ?>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan <strong><?= (($current_page - 1) * 10) + 1; ?></strong> - 
                <strong><?= min($current_page * 10, $total_records); ?></strong> dari 
                <strong><?= $total_records; ?></strong> berita
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <!-- Previous Button -->
                    <li class="page-item <?= $current_page == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" 
                           href="<?php 
                               $params = [];
                               if ($this->input->get('search')) $params['search'] = $this->input->get('search');
                               if ($this->input->get('category')) $params['category'] = $this->input->get('category');
                               $params['page'] = $current_page - 1;
                               echo site_url('admin/berita?' . http_build_query($params));
                           ?>"
                           <?= $current_page == 1 ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    
                    <!-- Page Numbers -->
                    <?php 
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $current_page + 2);
                    
                    // First page
                    if ($start_page > 1): 
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php 
                                $params = [];
                                if ($this->input->get('search')) $params['search'] = $this->input->get('search');
                                if ($this->input->get('category')) $params['category'] = $this->input->get('category');
                                $params['page'] = 1;
                                echo site_url('admin/berita?' . http_build_query($params));
                            ?>">
                                1
                            </a>
                        </li>
                        <?php if ($start_page > 2): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <!-- Page numbers -->
                    <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <li class="page-item <?= $current_page == $i ? 'active' : ''; ?>">
                            <a class="page-link" 
                               href="<?php 
                                   $params = [];
                                   if ($this->input->get('search')) $params['search'] = $this->input->get('search');
                                   if ($this->input->get('category')) $params['category'] = $this->input->get('category');
                                   $params['page'] = $i;
                                   echo site_url('admin/berita?' . http_build_query($params));
                               ?>">
                                <?= $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    
                    <!-- Last page -->
                    <?php if ($end_page < $total_pages): ?>
                        <?php if ($end_page < $total_pages - 1): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" 
                               href="<?php 
                                   $params = [];
                                   if ($this->input->get('search')) $params['search'] = $this->input->get('search');
                                   if ($this->input->get('category')) $params['category'] = $this->input->get('category');
                                   $params['page'] = $total_pages;
                                   echo site_url('admin/berita?' . http_build_query($params));
                               ?>">
                                <?= $total_pages; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <!-- Next Button -->
                    <li class="page-item <?= $current_page == $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link" 
                           href="<?php 
                               $params = [];
                               if ($this->input->get('search')) $params['search'] = $this->input->get('search');
                               if ($this->input->get('category')) $params['category'] = $this->input->get('category');
                               $params['page'] = $current_page + 1;
                               echo site_url('admin/berita?' . http_build_query($params));
                           ?>"
                           <?= $current_page == $total_pages ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php elseif (!empty($news_list)): ?>
        <div class="card-footer bg-white">
            <div class="text-muted small text-center">
                Menampilkan semua <strong><?= $total_records; ?></strong> berita
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus berita ini?</p>
                <div class="alert alert-warning mb-0">
                    <h6 id="newsTitle"></h6>
                    <small class="mb-0">Semua data berita termasuk thumbnail akan dihapus permanen.</small>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="deleteButton" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .news-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--light-blue);
    }
    
    .no-thumbnail {
        width: 60px;
        height: 60px;
        background: var(--light-blue);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .news-row:hover {
        background-color: #f8fafc;
        cursor: pointer;
    }
    
    .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 2px;
    }
    
    .btn-group .btn:hover {
        transform: translateY(-2px);
        transition: transform 0.2s;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    
    // Delete confirmation
    function confirmDelete(id, title) {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('newsTitle').textContent = title;
        document.getElementById('deleteButton').href = '<?= site_url("admin/berita/hapus/"); ?>' + id;
        modal.show();
    }
</script>