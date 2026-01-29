<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header">
    <div>
        <h1><i class="fas fa-users me-2"></i>Kelola Admin User</h1>
        <p class="text-muted mb-0">Kelola akun admin dan super admin untuk sistem</p>
    </div>
    <a href="<?= site_url('admin/users/tambah'); ?>" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Tambah Admin
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
                        <h6>Total Admin</h6>
                        <h3><?= $total_records; ?></h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
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
                        <h6>Super Admin</h6>
                        <h3><?= $super_admin_count; ?></h3>
                    </div>
                    <div class="stats-icon" style="background: #fee2e2; color: #ef4444;">
                        <i class="fas fa-crown"></i>
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
                        <h6>Admin Biasa</h6>
                        <h3><?= $admin_count; ?></h3>
                    </div>
                    <div class="stats-icon" style="background: #dbeafe; color: #3b82f6;">
                        <i class="fas fa-user-shield"></i>
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
                    <div class="stats-icon" style="background: #f0fdf4; color: #22c55e;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="get" action="<?= site_url('admin/users'); ?>" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari nama, email, atau role..."
                           value="<?= htmlspecialchars($search_query ?? ''); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                    <?php if (!empty($search_query)): ?>
                        <a href="<?= site_url('admin/users'); ?>" class="btn btn-outline-secondary">
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
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Admin User</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="usersTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;" class="text-center">
                            <span class="d-flex align-items-center">
                                No
                            </span>
                        </th>
                        <th>Admin</th>
                        <th>Email</th>
                        <th style="width: 150px;" class="text-center">Role</th>
                        <th style="width: 180px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php 
                        $start_number = (($current_page - 1) * 10) + 1;
                        foreach ($users as $user): 
                            $is_current_user = ($user->id == $current_user_id);
                        ?>
                            <tr data-id="<?= $user->id; ?>" class="user-row <?= $is_current_user ? 'table-active' : ''; ?>">
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        <?= $start_number++; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-wrapper me-3" style="background: #f0f9ff; color: #0ea5e9;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 fw-bold"><?= htmlspecialchars($user->name); ?></h4>
                                            <small class="text-muted">
                                                ID: #<?= $user->id; ?>
                                                <?php if ($is_current_user): ?>
                                                    <span class="text-success ms-2">
                                                        <i class="fas fa-circle me-1"></i>Anda
                                                    </span>
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope me-2 text-muted"></i>
                                        <?= htmlspecialchars($user->email); ?>
                                    </div>
                                    <?php if (isset($user->created_at)): ?>
                                        <small class="text-muted">
                                            Bergabung: <?= date('d/m/Y', strtotime($user->created_at)); ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($user->role === 'super_admin'): ?>
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="fas fa-crown me-1"></i>Super Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-primary px-3 py-2">
                                            <i class="fas fa-user-shield me-1"></i>Admin
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= site_url('admin/users/edit/'.$user->id); ?>" 
                                           class="btn btn-outline-primary px-3"
                                           data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if (!$is_current_user): ?>
                                            <button type="button" 
                                                    class="btn btn-outline-danger px-3"
                                                    onclick="confirmDelete(<?= $user->id; ?>, '<?= addslashes(htmlspecialchars($user->name)); ?>', '<?= $user->role; ?>')"
                                                    data-bs-toggle="tooltip" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-outline-secondary px-3" disabled
                                                    data-bs-toggle="tooltip" title="Tidak dapat menghapus akun sendiri">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-users fa-3x text-muted opacity-25"></i>
                                    </div>
                                    <?php if (!empty($search_query)): ?>
                                        <h5 class="text-muted mb-2">Admin user tidak ditemukan</h5>
                                        <p class="text-muted mb-3">Coba dengan kata kunci lain</p>
                                        <a href="<?= site_url('admin/users'); ?>" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Hapus Pencarian
                                        </a>
                                    <?php else: ?>
                                        <h5 class="text-muted mb-2">Belum ada admin user</h5>
                                        <p class="text-muted mb-3">Mulai dengan menambahkan admin pertama</p>
                                        <a href="<?= site_url('admin/users/create'); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Admin
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
    <?php if (!empty($users) && $total_pages > 1): ?>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan <strong><?= (($current_page - 1) * 10) + 1; ?></strong> - 
                <strong><?= min($current_page * 10, $total_records); ?></strong> dari 
                <strong><?= $total_records; ?></strong> admin
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <!-- Previous Button -->
                    <li class="page-item <?= $current_page == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" 
                           href="<?php 
                               $params = [];
                               if (!empty($search_query)) $params['search'] = $search_query;
                               $params['page'] = $current_page - 1;
                               echo site_url('admin/users?' . http_build_query($params));
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
                                if (!empty($search_query)) $params['search'] = $search_query;
                                $params['page'] = 1;
                                echo site_url('admin/users?' . http_build_query($params));
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
                                   if (!empty($search_query)) $params['search'] = $search_query;
                                   $params['page'] = $i;
                                   echo site_url('admin/users?' . http_build_query($params));
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
                                   if (!empty($search_query)) $params['search'] = $search_query;
                                   $params['page'] = $total_pages;
                                   echo site_url('admin/users?' . http_build_query($params));
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
                               if (!empty($search_query)) $params['search'] = $search_query;
                               $params['page'] = $current_page + 1;
                               echo site_url('admin/users?' . http_build_query($params));
                           ?>"
                           <?= $current_page == $total_pages ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php elseif (!empty($users)): ?>
        <div class="card-footer bg-white">
            <div class="text-muted small text-center">
                Menampilkan semua <strong><?= $total_records; ?></strong> admin
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
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Admin
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus admin user ini?</p>
                <div class="alert alert-warning mb-0">
                    <h4 id="userName" class="text-center mb-3"></h4>
                    <div id="userInfo" class="mt-2"></div>
                    <small class="mb-0 d-block mt-2 text-danger">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        Tindakan ini akan menghapus akses admin tersebut secara permanen.
                    </small>
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
    
    .user-row:hover {
        background-color: #f8fafc;
    }
    
    .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 2px;
    }
    
    .btn-group .btn:hover {
        transform: translateY(-2px);
        transition: transform 0.2s;
    }
    
    h4.fw-bold {
        font-size: 1.3rem;
        color: #1e293b;
    }
    
    .badge.bg-danger, .badge.bg-primary {
        padding: 0.75rem;
        border-radius: 8px;
        font-weight: 500;
    }
    
    .table-active {
        background-color: rgba(59, 130, 246, 0.05) !important;
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
    function confirmDelete(id, name, role) {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('userName').textContent = name;
        
        const roleText = role === 'super_admin' ? 'Super Admin' : 'Admin';
        const roleColor = role === 'super_admin' ? 'danger' : 'primary';
        
        document.getElementById('userInfo').innerHTML = `
            <div class="text-center mb-3">
                <span class="badge bg-${roleColor} px-3 py-2 mb-2">
                    <i class="fas ${role === 'super_admin' ? 'fa-crown' : 'fa-user-shield'} me-1"></i>
                    ${roleText}
                </span>
            </div>
            <p class="text-center mb-0">
                Anda akan menghapus <strong>${roleText.toLowerCase()}</strong> dengan nama <strong>${name}</strong>.
            </p>
        `;
        
        document.getElementById('deleteButton').href = '<?= site_url("admin/users/hapus/"); ?>' + id;
        
        modal.show();
    }
</script>