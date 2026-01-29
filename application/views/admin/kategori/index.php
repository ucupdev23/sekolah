<div class="page-header">
    <div>
        <h1><i class="fas fa-tags me-2"></i>Kelola Kategori Berita</h1>
        <p class="text-muted mb-0">Kelola kategori untuk mengelompokkan berita</p>
    </div>
    <a href="<?= site_url('admin/kategori/tambah'); ?>" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Tambah Kategori
    </a>
</div>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $this->session->flashdata('error'); ?>
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
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Kategori</h6>
                        <h3><?= $total_records; ?></h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
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
    <div class="col-md-4">
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
</div>

<!-- Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="get" action="<?= site_url('admin/kategori'); ?>" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari kategori..."
                           value="<?= $this->input->get('search'); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                    <?php if ($this->input->get('search')): ?>
                        <a href="<?= site_url('admin/kategori'); ?>" class="btn btn-outline-secondary">
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
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Kategori</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="categoriesTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;" class="text-center">
                            <span class="d-flex align-items-center">
                                No
                            </span>
                        </th>
                        <th>Kategori</th>
                        <th style="width: 150px;" class="text-center">Jumlah Berita</th>
                        <th style="width: 180px;" class="text-center">Slug/URL</th>
                        <th style="width: 180px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php 
                        $start_number = (($current_page - 1) * 10) + 1;
                        foreach ($categories as $index => $c): 
                            $news_count = isset($category_counts[$c->id]) ? $category_counts[$c->id] : 0;
                        ?>
                            <tr data-id="<?= $c->id; ?>" class="category-row">
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        <?= $start_number++; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-wrapper me-3" style="background: #e0e7ff; color: #4f46e5;">
                                            <i class="fas fa-tag"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1"><?= htmlspecialchars($c->name); ?></h6>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                Diperbarui: <?= $c->updated_at ? date('d M Y H:i', strtotime($c->updated_at)) : 'Belum pernah'; ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php if ($news_count > 0): ?>
                                        <a href="<?= site_url('admin/berita?category=' . $c->id); ?>" 
                                           class="badge bg-info bg-opacity-10 text-info d-inline-flex align-items-center">
                                            <i class="fas fa-newspaper me-1"></i>
                                            <?= $news_count; ?> berita
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            <i class="fas fa-times-circle me-1"></i>
                                            Kosong
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="input-group input-group-sm">
                                        <input type="text" 
                                               class="form-control form-control-sm bg-light" 
                                               value="<?= $c->slug; ?>" 
                                               readonly>
                                        <button type="button" 
                                                class="btn btn-outline-secondary btn-sm"
                                                onclick="copyToClipboard('<?= $c->slug; ?>')"
                                                data-bs-toggle="tooltip" title="Salin slug">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= site_url('admin/kategori/edit/'.$c->id); ?>" 
                                           class="btn btn-outline-primary px-3"
                                           data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('berita?kategori=' . $c->slug); ?>" 
                                           class="btn btn-outline-info px-3" target="_blank"
                                           data-bs-toggle="tooltip" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger px-3"
                                                onclick="confirmDelete(<?= $c->id; ?>, '<?= htmlspecialchars(addslashes($c->name)); ?>', <?= $news_count; ?>)"
                                                data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-tags fa-3x text-muted opacity-25"></i>
                                    </div>
                                    <?php if ($this->input->get('search')): ?>
                                        <h5 class="text-muted mb-2">Kategori tidak ditemukan</h5>
                                        <p class="text-muted mb-3">Coba dengan kata kunci lain</p>
                                        <a href="<?= site_url('admin/kategori'); ?>" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Hapus Pencarian
                                        </a>
                                    <?php else: ?>
                                        <h5 class="text-muted mb-2">Belum ada kategori</h5>
                                        <p class="text-muted mb-3">Mulai dengan menambahkan kategori pertama</p>
                                        <a href="<?= site_url('admin/kategori/tambah'); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Kategori
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
    <?php if (!empty($categories) && $total_pages > 1): ?>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan <strong><?= (($current_page - 1) * 10) + 1; ?></strong> - 
                <strong><?= min($current_page * 10, $total_records); ?></strong> dari 
                <strong><?= $total_records; ?></strong> kategori
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <!-- Previous Button -->
                    <li class="page-item <?= $current_page == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" 
                           href="<?php 
                               $params = [];
                               if ($this->input->get('search')) $params['search'] = $this->input->get('search');
                               $params['page'] = $current_page - 1;
                               echo site_url('admin/kategori?' . http_build_query($params));
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
                                $params['page'] = 1;
                                echo site_url('admin/kategori?' . http_build_query($params));
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
                                   $params['page'] = $i;
                                   echo site_url('admin/kategori?' . http_build_query($params));
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
                                   $params['page'] = $total_pages;
                                   echo site_url('admin/kategori?' . http_build_query($params));
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
                               $params['page'] = $current_page + 1;
                               echo site_url('admin/kategori?' . http_build_query($params));
                           ?>"
                           <?= $current_page == $total_pages ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php elseif (!empty($categories)): ?>
        <div class="card-footer bg-white">
            <div class="text-muted small text-center">
                Menampilkan semua <strong><?= $total_records; ?></strong> kategori
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
                <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
                <div class="alert alert-warning mb-0">
                    <h6 id="categoryName"></h6>
                    <div id="categoryInfo" class="mt-2"></div>
                    <small class="mb-0 d-block mt-2">Tindakan ini tidak dapat dibatalkan.</small>
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
    .icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .category-row:hover {
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
    
    .input-group .form-control {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }
    
    .input-group .btn {
        padding: 0.25rem 0.5rem;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Click row to edit
        const rows = document.querySelectorAll('.category-row');
        rows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking on buttons or input
                if (!e.target.closest('.btn-group') && !e.target.closest('.input-group')) {
                    const id = this.getAttribute('data-id');
                    window.location.href = '<?= site_url("admin/kategori/edit/"); ?>' + id;
                }
            });
        });
    });
    
    // Delete confirmation
    function confirmDelete(id, name, newsCount) {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('categoryName').textContent = name;
        
        let infoHtml = '';
        if (newsCount > 0) {
            infoHtml = `<div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                Kategori ini masih digunakan oleh <strong>${newsCount}</strong> berita.
                <br><small>Hapus atau pindahkan berita terlebih dahulu sebelum menghapus kategori.</small>
            </div>`;
            // Disable delete button if category has news
            setTimeout(() => {
                document.getElementById('deleteButton').classList.add('disabled');
                document.getElementById('deleteButton').setAttribute('onclick', 'return false;');
            }, 100);
        } else {
            infoHtml = `<small class="text-muted">Kategori ini tidak memiliki berita dan dapat dihapus.</small>`;
            document.getElementById('deleteButton').href = '<?= site_url("admin/kategori/hapus/"); ?>' + id;
        }
        
        document.getElementById('categoryInfo').innerHTML = infoHtml;
        modal.show();
    }
    
    // Copy to clipboard function
    function copyToClipboard(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        
        // Show toast
        showToast('Slug berhasil disalin: ' + text, 'success');
    }
    
    // Simple toast function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'info'} border-0`;
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        `;
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', function() {
            toast.remove();
        });
    }
</script>