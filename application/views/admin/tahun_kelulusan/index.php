<div class="page-header">
    <div>
        <h1><i class="fas fa-calendar-alt me-2"></i>Kelola Tahun Kelulusan</h1>
        <p class="text-muted mb-0">Kelola data tahun kelulusan untuk mengelompokkan data lulusan</p>
    </div>
    <a href="<?= site_url('admin/tahun-kelulusan/tambah'); ?>" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Tambah Tahun
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
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Tahun</h6>
                        <h3><?= $total_records; ?></h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-calendar"></i>
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
                        <h6>Tahun Aktif</h6>
                        <h3><?= !empty($years) ? $years[0]->year : '-' ; ?></h3>
                    </div>
                    <div class="stats-icon" style="background: #e0e7ff; color: #8b5cf6;">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="get" action="<?= site_url('admin/tahun-kelulusan'); ?>" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari tahun kelulusan..."
                           value="<?= $this->input->get('search'); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                    <?php if ($this->input->get('search')): ?>
                        <a href="<?= site_url('admin/tahun-kelulusan'); ?>" class="btn btn-outline-secondary">
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
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Tahun Kelulusan</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="yearsTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;" class="text-center">
                            <span class="d-flex align-items-center">
                                No
                            </span>
                        </th>
                        <th>Tahun</th>
                        <th style="width: 150px;" class="text-center">Jumlah Lulusan</th>
                        <th style="width: 150px;" class="text-center">Status</th>
                        <th style="width: 180px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($years)): ?>
                        <?php 
                        $start_number = (($current_page - 1) * 10) + 1;
                        $current_year = date('Y');
                        foreach ($years as $index => $y): 
                            $graduate_count = isset($year_counts[$y->id]) ? $year_counts[$y->id] : 0;
                            $is_current = ($y->year == $current_year);
                            $is_recent = ($current_year - $y->year <= 5);
                        ?>
                            <tr data-id="<?= $y->id; ?>" class="year-row">
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        <?= $start_number++; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-wrapper me-3" style="background: #fef3c7; color: #f59e0b;">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 fw-bold"><?= $y->year; ?></h4>
                                            <?php if ($is_current): ?>
                                                <small class="text-success">
                                                    <i class="fas fa-circle me-1"></i>Tahun berjalan
                                                </small>
                                            <?php elseif ($is_recent): ?>
                                                <small class="text-info">
                                                    <i class="fas fa-clock me-1"></i>Tahun terbaru
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php if ($graduate_count > 0): ?>
                                        <a href="<?= site_url('admin/kelulusan?year=' . $y->year); ?>" 
                                           class="badge bg-info bg-opacity-10 text-info d-inline-flex align-items-center px-3 py-2">
                                            <i class="fas fa-user-graduate me-2"></i>
                                            <div>
                                                <div class="fw-bold"><?= $graduate_count; ?></div>
                                                <small>lulusan</small>
                                            </div>
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                            <i class="fas fa-times-circle me-2"></i>
                                            <div>
                                                <div class="fw-bold">0</div>
                                                <small>lulusan</small>
                                            </div>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($is_current): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    <?php elseif ($is_recent): ?>
                                        <span class="badge bg-info">
                                            <i class="fas fa-clock me-1"></i>Terbaru
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-history me-1"></i>Lampau
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= site_url('admin/tahun-kelulusan/edit/'.$y->id); ?>" 
                                           class="btn btn-outline-primary px-3"
                                           data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('kelulusan?year=' . $y->year); ?>" 
                                           class="btn btn-outline-info px-3" target="_blank"
                                           data-bs-toggle="tooltip" title="Lihat Lulusan">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger px-3"
                                                onclick="confirmDelete(<?= $y->id; ?>, '<?= $y->year; ?>', <?= $graduate_count; ?>)"
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
                                        <i class="fas fa-calendar-alt fa-3x text-muted opacity-25"></i>
                                    </div>
                                    <?php if ($this->input->get('search')): ?>
                                        <h5 class="text-muted mb-2">Tahun tidak ditemukan</h5>
                                        <p class="text-muted mb-3">Coba dengan kata kunci lain</p>
                                        <a href="<?= site_url('admin/tahun-kelulusan'); ?>" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Hapus Pencarian
                                        </a>
                                    <?php else: ?>
                                        <h5 class="text-muted mb-2">Belum ada tahun kelulusan</h5>
                                        <p class="text-muted mb-3">Mulai dengan menambahkan tahun pertama</p>
                                        <a href="<?= site_url('admin/tahun-kelulusan/tambah'); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Tahun
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
    <?php if (!empty($years) && $total_pages > 1): ?>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan <strong><?= (($current_page - 1) * 10) + 1; ?></strong> - 
                <strong><?= min($current_page * 10, $total_records); ?></strong> dari 
                <strong><?= $total_records; ?></strong> tahun
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
                               echo site_url('admin/tahun-kelulusan?' . http_build_query($params));
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
                                echo site_url('admin/tahun-kelulusan?' . http_build_query($params));
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
                                   echo site_url('admin/tahun-kelulusan?' . http_build_query($params));
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
                                   echo site_url('admin/tahun-kelulusan?' . http_build_query($params));
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
                               echo site_url('admin/tahun-kelulusan?' . http_build_query($params));
                           ?>"
                           <?= $current_page == $total_pages ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php elseif (!empty($years)): ?>
        <div class="card-footer bg-white">
            <div class="text-muted small text-center">
                Menampilkan semua <strong><?= $total_records; ?></strong> tahun
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
                <p>Apakah Anda yakin ingin menghapus tahun kelulusan ini?</p>
                <div class="alert alert-warning mb-0">
                    <h4 id="yearValue" class="text-center mb-3"></h4>
                    <div id="yearInfo" class="mt-2"></div>
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
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .year-row:hover {
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
    
    .badge.bg-info, .badge.bg-secondary {
        padding: 0.75rem;
        border-radius: 8px;
    }
    
    h4.fw-bold {
        font-size: 1.5rem;
        color: #1e293b;
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
        // const rows = document.querySelectorAll('.year-row');
        // rows.forEach(row => {
        //     row.addEventListener('click', function(e) {
        //         // Don't trigger if clicking on buttons
        //         if (!e.target.closest('.btn-group')) {
        //             const id = this.getAttribute('data-id');
        //             window.location.href = '<?= site_url("admin/tahun-kelulusan/edit/"); ?>' + id;
        //         }
        //     });
        // });
    });
    
    // Delete confirmation
    function confirmDelete(id, year, graduateCount) {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('yearValue').textContent = 'Tahun ' + year;
        
        let infoHtml = '';
        if (graduateCount > 0) {
            infoHtml = `<div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                Tahun ini masih digunakan oleh <strong>${graduateCount}</strong> data lulusan.
                <br><small>Hapus atau pindahkan data lulusan terlebih dahulu sebelum menghapus tahun.</small>
            </div>`;
            // Disable delete button if year has graduates
            setTimeout(() => {
                document.getElementById('deleteButton').classList.add('disabled');
                document.getElementById('deleteButton').setAttribute('onclick', 'return false;');
            }, 100);
        } else {
            infoHtml = `<div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                Tahun ini tidak memiliki data lulusan dan dapat dihapus.
            </div>`;
            document.getElementById('deleteButton').href = '<?= site_url("admin/tahun-kelulusan/hapus/"); ?>' + id;
        }
        
        document.getElementById('yearInfo').innerHTML = infoHtml;
        modal.show();
    }
</script>