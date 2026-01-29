<div class="page-header">
    <div>
        <h1><i class="fas fa-bullhorn me-2"></i>Kelola Pengumuman</h1>
        <p class="text-muted mb-0">Kelola semua pengumuman yang ditampilkan di website</p>
    </div>
    <a href="<?= site_url('admin/pengumuman/tambah'); ?>" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Tambah Pengumuman
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
                        <h6>Total Data</h6>
                        <h3><?= $total_records; ?></h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-database"></i>
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
                        <h3><?= count($announcements); ?></h3>
                    </div>
                    <div class="stats-icon" style="background: #e0e7ff; color: #8b5cf6;">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Pengumuman</h5>
    <form method="get" action="<?= site_url('admin/pengumuman'); ?>" class="d-flex">
        <div class="input-group input-group-sm me-2" style="width: 250px;">
            <input type="text" 
                   name="search" 
                   class="form-control" 
                   placeholder="Cari pengumuman..."
                   value="<?= $this->input->get('search'); ?>">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <?php if ($this->input->get('search')): ?>
            <a href="<?= site_url('admin/pengumuman'); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-times"></i>
            </a>
        <?php endif; ?>
    </form>
</div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="announcementsTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;" class="text-center">
                            <span class="d-flex align-items-center">
                                No <i class="fas fa-sort ms-1 text-muted"></i>
                            </span>
                        </th>
                        <th>Judul</th>
                        <th style="width: 150px;">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-calendar me-1"></i> Tanggal
                            </span>
                        </th>
                        <th style="width: 180px;" class="text-center">
                            <span class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-cog me-1"></i> Aksi
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($announcements)): ?>
                        <?php 
                        // Hitung nomor urut berdasarkan halaman
                        $start_number = (($current_page - 1) * 10) + 1;
                        foreach ($announcements as $index => $a): 
                        ?>
                            <tr data-id="<?= $a->id; ?>" class="announcement-row">
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        <?= $start_number++; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-wrapper me-3">
                                            <i class="fas fa-bullhorn text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1"><?= htmlspecialchars($a->title); ?></h6>
                                            <small class="text-muted">
                                                <?= strlen($a->body) > 100 ? substr(strip_tags($a->body), 0, 100).'...' : strip_tags($a->body); ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium"><?= date('d M Y', strtotime($a->published_at)); ?></span>
                                        <small class="text-muted">
                                            <?= date('H:i', strtotime($a->published_at)); ?>
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= site_url('admin/pengumuman/edit/'.$a->id); ?>" 
                                           class="btn btn-outline-primary px-3"
                                           data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('pengumuman/'.$a->id); ?>" 
                                           class="btn btn-outline-info px-3" target="_blank"
                                           data-bs-toggle="tooltip" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger px-3"
                                                onclick="confirmDelete(<?= $a->id; ?>, '<?= htmlspecialchars(addslashes($a->title)); ?>')"
                                                data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-bullhorn fa-3x text-muted opacity-25"></i>
                                    </div>
                                    <?php if ($this->input->get('search')): ?>
                                        <h5 class="text-muted mb-2">Hasil pencarian tidak ditemukan</h5>
                                        <p class="text-muted mb-3">Coba dengan kata kunci lain</p>
                                        <a href="<?= site_url('admin/pengumuman'); ?>" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Hapus Pencarian
                                        </a>
                                    <?php else: ?>
                                        <h5 class="text-muted mb-2">Belum ada pengumuman</h5>
                                        <p class="text-muted mb-3">Mulai dengan membuat pengumuman pertama Anda</p>
                                        <a href="<?= site_url('admin/pengumuman/tambah'); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Pengumuman
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
    <?php if (!empty($announcements) && $total_pages > 1): ?>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan <strong><?= (($current_page - 1) * 10) + 1; ?></strong> - 
                <strong><?= min($current_page * 10, $total_records); ?></strong> dari 
                <strong><?= $total_records; ?></strong> pengumuman
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
           echo site_url('admin/pengumuman?' . http_build_query($params));
       ?>"
       <?= $current_page == 1 ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
        <i class="fas fa-chevron-left"></i>
    </a>
</li>

<!-- Page Numbers -->
<?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
    <li class="page-item <?= $current_page == $i ? 'active' : ''; ?>">
        <a class="page-link" 
           href="<?php 
               $params = [];
               if ($this->input->get('search')) $params['search'] = $this->input->get('search');
               $params['page'] = $i;
               echo site_url('admin/pengumuman?' . http_build_query($params));
           ?>">
            <?= $i; ?>
        </a>
    </li>
<?php endfor; ?>

<!-- Next Button -->
<li class="page-item <?= $current_page == $total_pages ? 'disabled' : ''; ?>">
    <a class="page-link" 
       href="<?php 
           $params = [];
           if ($this->input->get('search')) $params['search'] = $this->input->get('search');
           $params['page'] = $current_page + 1;
           echo site_url('admin/pengumuman?' . http_build_query($params));
       ?>"
       <?= $current_page == $total_pages ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
        <i class="fas fa-chevron-right"></i>
    </a>
</li>
                </ul>
            </nav>
        </div>
    <?php elseif (!empty($announcements)): ?>
        <div class="card-footer bg-white">
            <div class="text-muted small text-center">
                Menampilkan semua <strong><?= $total_records; ?></strong> pengumuman
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
                <p>Apakah Anda yakin ingin menghapus pengumuman ini?</p>
                <div class="alert alert-warning mb-0">
                    <h6 id="announcementTitle"></h6>
                    <small class="mb-0">Tindakan ini tidak dapat dibatalkan.</small>
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
        background: var(--light-blue);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .announcement-row:hover {
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
    
    .table th {
        border-top: none;
        border-bottom: 2px solid #f1f5f9;
        font-weight: 600;
        color: #64748b;
        padding: 1rem;
    }
    
    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .page-link {
        border: none;
        border-radius: 6px;
        margin: 0 2px;
        min-width: 35px;
        text-align: center;
    }
    
    .page-item.active .page-link {
        background-color: var(--primary-blue);
        border-color: var(--primary-blue);
    }
    
    .page-item.disabled .page-link {
        color: #94a3b8;
    }
    
    .page-link:hover {
        background-color: #f1f5f9;
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
        document.getElementById('announcementTitle').textContent = title;
        document.getElementById('deleteButton').href = '<?= site_url("admin/pengumuman/hapus/"); ?>' + id;
        modal.show();
    }
    
    // Auto submit search form on enter
    document.querySelector('input[name="search"]')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.form.submit();
        }
    });
</script>