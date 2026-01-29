<div class="page-header">
    <div>
        <h1><i class="fas fa-graduation-cap me-2"></i>Kelola Data Kelulusan</h1>
        <p class="text-muted mb-0">Kelola data siswa lulusan sekolah</p>
    </div>
    <a href="<?= site_url('admin/kelulusan/tambah'); ?>" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Tambah Data Lulusan
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
                        <h6>Total Lulusan</h6>
                        <h3><?= $total_records; ?></h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-user-graduate"></i>
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
                        <h3><?= count($graduates); ?></h3>
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
        <form method="get" action="<?= site_url('admin/kelulusan'); ?>" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari nama siswa atau NISN..."
                           value="<?= $this->input->get('search'); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select name="year" class="form-select">
                    <option value="">Semua Tahun</option>
                    <?php foreach ($years as $year_item): ?>
                        <option value="<?= $year_item->year; ?>" 
                            <?= $this->input->get('year') == $year_item->year ? 'selected' : ''; ?>>
                            Tahun <?= $year_item->year; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <?php if ($this->input->get('search') || $this->input->get('year')): ?>
                        <a href="<?= site_url('admin/kelulusan'); ?>" class="btn btn-outline-secondary">
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
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Data Lulusan</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="graduatesTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;" class="text-center">
                            <span class="d-flex align-items-center">
                                No
                            </span>
                        </th>
                        <th style="width: 100px;">Foto</th>
                        <th>Data Siswa</th>
                        <th style="width: 150px;">Tahun Lulus</th>
                        <th style="width: 150px;">CV</th>
                        <th style="width: 180px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($graduates)): ?>
                        <?php 
                        $start_number = (($current_page - 1) * 10) + 1;
                        foreach ($graduates as $index => $g): 
                        ?>
                            <tr data-id="<?= $g->id; ?>" class="graduate-row">
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        <?= $start_number++; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($g->photo_path)): ?>
                                        <img src="<?= base_url('uploads/graduates/photos/' . $g->photo_path); ?>" 
                                             class="graduate-photo" 
                                             alt="<?= htmlspecialchars($g->student_name); ?>"
                                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHJ4PSI4IiBmaWxsPSIjRTRFQUYxIi8+PHBhdGggZD0iTTMwIDM4QzM3LjczMTkgMzggNDQgMzEuNzMxOSA0NCAyNEM0NCAxNi4yNjgxIDM3LjczMTkgMTAgMzAgMTBDMjIuMjY4MSAxMCAxNiAxNi4yNjgxIDE2IDI0QzE2IDMxLjczMTkgMjIuMjY4MSAzOCAzMCAzOFoiIGZpbGw9IiM5NkExQkMiLz48cGF0aCBkPSJNMzAgMzBDMzIuMjA5MSAzMCAzNCAyOC4yMDkxIDM0IDI2QzM0IDIzLjc5MDkgMzIuMjA5MSAyMiAzMCAyMkMyNy43OTA5IDIyIDI2IDIzLjc5MDkgMjYgMjZDMjYgMjguMjA5MSAyNy43OTA5IDMwIDMwIDMwWiIgZmlsbD0id2hpdGUiLz48cGF0aCBkPSJNMTkgNDJMNCA0MkM0IDQyIDQgNDAgNCA0MEwxOSA0MEMxOSA0MCAxOSA0MiAxOSA0MloiIGZpbGw9IiM5NkExQkMiLz48L3N2Zz4='">
                                    <?php else: ?>
                                        <div class="no-photo">
                                            <i class="fas fa-user-graduate text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1"><?= htmlspecialchars($g->student_name); ?></h6>
                                        <small class="text-muted">
                                            <i class="fas fa-id-card me-1"></i>
                                            NISN: <?= htmlspecialchars($g->nisn); ?>
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?= $g->graduation_year; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($g->cv_link)): ?>
                                        <?php
                                        $extension = pathinfo($g->cv_link, PATHINFO_EXTENSION);
                                        $icon = '';
                                        $color = '';
                                        
                                        switch(strtolower($extension)) {
                                            case 'pdf':
                                                $icon = 'fa-file-pdf';
                                                $color = 'danger';
                                                break;
                                            case 'doc':
                                            case 'docx':
                                                $icon = 'fa-file-word';
                                                $color = 'primary';
                                                break;
                                            default:
                                                $icon = 'fa-file';
                                                $color = 'secondary';
                                        }
                                        ?>
                                        <a href="<?= base_url('uploads/graduates/cv/' . $g->cv_link); ?>" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-<?= $color; ?> d-flex align-items-center"
                                           data-bs-toggle="tooltip" title="Download CV">
                                            <i class="fas <?= $icon; ?> me-2"></i>
                                            <span>Download CV</span>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">
                                            <i class="fas fa-times-circle me-1"></i>
                                            Tidak ada
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= site_url('admin/kelulusan/edit/'.$g->id); ?>" 
                                           class="btn btn-outline-primary px-3"
                                           data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('kelulusan?q='.htmlspecialchars($g->nisn)); ?>" 
                                           class="btn btn-outline-info px-3" target="_blank"
                                           data-bs-toggle="tooltip" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger px-3"
                                                onclick="confirmDelete(<?= $g->id; ?>, '<?= htmlspecialchars(addslashes($g->student_name)); ?>')"
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
                                        <i class="fas fa-graduation-cap fa-3x text-muted opacity-25"></i>
                                    </div>
                                    <?php if ($this->input->get('search') || $this->input->get('year')): ?>
                                        <h5 class="text-muted mb-2">Hasil pencarian tidak ditemukan</h5>
                                        <p class="text-muted mb-3">Coba dengan kata kunci atau tahun lain</p>
                                        <a href="<?= site_url('admin/kelulusan'); ?>" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Hapus Filter
                                        </a>
                                    <?php else: ?>
                                        <h5 class="text-muted mb-2">Belum ada data kelulusan</h5>
                                        <p class="text-muted mb-3">Mulai dengan menambahkan data lulusan pertama</p>
                                        <a href="<?= site_url('admin/kelulusan/tambah'); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Data Lulusan
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
    <?php if (!empty($graduates) && $total_pages > 1): ?>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan <strong><?= (($current_page - 1) * 10) + 1; ?></strong> - 
                <strong><?= min($current_page * 10, $total_records); ?></strong> dari 
                <strong><?= $total_records; ?></strong> data lulusan
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <!-- Previous Button -->
                    <li class="page-item <?= $current_page == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" 
                           href="<?php 
                               $params = [];
                               if ($this->input->get('search')) $params['search'] = $this->input->get('search');
                               if ($this->input->get('year')) $params['year'] = $this->input->get('year');
                               $params['page'] = $current_page - 1;
                               echo site_url('admin/kelulusan?' . http_build_query($params));
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
                                if ($this->input->get('year')) $params['year'] = $this->input->get('year');
                                $params['page'] = 1;
                                echo site_url('admin/kelulusan?' . http_build_query($params));
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
                                   if ($this->input->get('year')) $params['year'] = $this->input->get('year');
                                   $params['page'] = $i;
                                   echo site_url('admin/kelulusan?' . http_build_query($params));
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
                                   if ($this->input->get('year')) $params['year'] = $this->input->get('year');
                                   $params['page'] = $total_pages;
                                   echo site_url('admin/kelulusan?' . http_build_query($params));
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
                               if ($this->input->get('year')) $params['year'] = $this->input->get('year');
                               $params['page'] = $current_page + 1;
                               echo site_url('admin/kelulusan?' . http_build_query($params));
                           ?>"
                           <?= $current_page == $total_pages ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php elseif (!empty($graduates)): ?>
        <div class="card-footer bg-white">
            <div class="text-muted small text-center">
                Menampilkan semua <strong><?= $total_records; ?></strong> data lulusan
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
                <p>Apakah Anda yakin ingin menghapus data kelulusan ini?</p>
                <div class="alert alert-warning mb-0">
                    <h6 id="graduateName"></h6>
                    <small class="mb-0">Semua data termasuk foto dan CV akan dihapus permanen.</small>
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
    .graduate-photo {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--light-blue);
    }
    
    .no-photo {
        width: 60px;
        height: 60px;
        background: var(--light-blue);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .graduate-row:hover {
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
    
    .badge.bg-success {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Click row to view detail (optional)
        // const rows = document.querySelectorAll('.graduate-row');
        // rows.forEach(row => {
        //     row.addEventListener('click', function(e) {
        //         // Don't trigger if clicking on buttons
        //         if (!e.target.closest('.btn-group')) {
        //             const id = this.getAttribute('data-id');
        //             window.open('<?= site_url("kelulusan/detail/"); ?>' + id, '_blank');
        //         }
        //     });
        // });
    });
    
    // Delete confirmation
    function confirmDelete(id, name) {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('graduateName').textContent = name;
        document.getElementById('deleteButton').href = '<?= site_url("admin/kelulusan/hapus/"); ?>' + id;
        modal.show();
    }
</script>