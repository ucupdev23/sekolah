<div class="page-header">
    <div>
        <h1>
            <i class="fas <?= isset($yearRow) ? 'fa-edit' : 'fa-plus-circle'; ?> me-2"></i>
            <?= isset($yearRow) ? 'Edit Tahun Kelulusan' : 'Tambah Tahun Kelulusan'; ?>
        </h1>
        <p class="text-muted mb-0">
            <?= isset($yearRow) ? 'Perbarui data tahun kelulusan' : 'Tambahkan tahun kelulusan baru untuk data lulusan'; ?>
        </p>
    </div>
    <a href="<?= site_url('admin/tahun-kelulusan'); ?>" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-calendar me-2"></i>
                    Form Tahun Kelulusan
                </h5>
            </div>
            <div class="card-body">
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= validation_errors(); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($custom_error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $custom_error; ?>
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
                
                <form method="post" id="yearForm">
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-calendar-alt me-2"></i>Tahun Kelulusan
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               name="year" 
                               class="form-control form-control-lg border-2" 
                               placeholder="Masukkan tahun (contoh: 2024)"
                               value="<?= set_value('year', isset($yearRow) ? $yearRow->year : date('Y')); ?>"
                               required
                               min="1900"
                               max="2100"
                               step="1">
                        <div class="form-text text-muted">
                            Masukkan tahun kelulusan (4 digit, contoh: 2024)
                        </div>
                    </div>
                    
                    <!-- Year Info -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="fas fa-info-circle fa-2x text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Info Tahun</h6>
                                                <p class="mb-0 small" id="yearInfoText">
                                                    <?php 
                                                    $input_year = isset($yearRow) ? $yearRow->year : date('Y');
                                                    $current_year = date('Y');
                                                    $difference = $input_year - $current_year;
                                                    
                                                    if ($difference > 0) {
                                                        echo "Tahun " . $input_year . " adalah tahun yang akan datang (" . $difference . " tahun lagi)";
                                                    } elseif ($difference == 0) {
                                                        echo "Tahun " . $input_year . " adalah tahun berjalan";
                                                    } else {
                                                        echo "Tahun " . $input_year . " adalah " . abs($difference) . " tahun yang lalu";
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="fas fa-user-graduate fa-2x text-success"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Data Lulusan</h6>
                                                <p class="mb-0 small">
                                                    <?php if (isset($graduate_count)): ?>
                                                        Tahun ini memiliki <strong><?= $graduate_count; ?> data lulusan</strong>
                                                    <?php else: ?>
                                                        Tahun baru, belum ada data lulusan
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (isset($yearRow)): ?>
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-info-circle me-2"></i>Informasi Data
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-calendar-plus"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           value="Dibuat: <?= isset($yearRow->created_at) ? date('d M Y H:i', strtotime($yearRow->created_at)) : 'Tidak diketahui'; ?>"
                                           readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-calendar-check"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           value="Terakhir diubah: <?= isset($yearRow->updated_at) ? date('d M Y H:i', strtotime($yearRow->updated_at)) : 'Belum pernah'; ?>"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="border-top pt-4 mt-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="<?= site_url('admin/tahun-kelulusan'); ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-primary px-4 me-2" onclick="previewYear()">
                                    <i class="fas fa-eye me-2"></i>Preview
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Tahun
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Year Tips -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>Panduan Tahun
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Gunakan format 4 digit (contoh: 2024)</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Tahun sebaiknya antara 1900-2100</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Hindari duplikasi tahun</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Tahun aktif untuk tahun berjalan</small>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Recent Years -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h6 class="mb-0">
            <i class="fas fa-history me-2"></i>Tahun Terbaru
        </h6>
    </div>
    <div class="card-body">
        <div class="d-flex flex-column gap-2">
            <?php 
            $recent_years = [
                date('Y') => 'Tahun Berjalan',
                date('Y')-1 => 'Tahun Lalu',
                date('Y')+1 => 'Tahun Depan'
            ];
            foreach ($recent_years as $ryear => $label): 
            ?>
                <div class="d-flex justify-content-between align-items-center p-2 border rounded">
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary me-2"><?= $ryear; ?></span>
                        <small class="text-muted"><?= $label; ?></small>
                    </div>
                    <?php if (!isset($yearRow) || $yearRow->year != $ryear): ?>
                        <button type="button" 
                                class="btn btn-sm btn-outline-secondary"
                                onclick="setYearValue(<?= $ryear; ?>, '<?= addslashes($label); ?>')">
                            <i class="fas fa-check"></i>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <small class="text-muted d-block mt-2">
            Klik tombol centang untuk menggunakan tahun tersebut
        </small>
    </div>
</div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Preview Tahun
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <div class="icon-wrapper mx-auto mb-3" style="width: 80px; height: 80px; background: #fef3c7; color: #f59e0b;">
                                <i class="fas fa-calendar-alt fa-2x"></i>
                            </div>
                            <h1 id="previewYear" class="display-4 fw-bold mb-3"></h1>
                            <div id="previewStatus" class="mb-3"></div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Tahun ini akan digunakan untuk:
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Mengelompokkan data lulusan</li>
                                <li>Filter data kelulusan</li>
                                <li>Statistik tahunan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('yearForm').submit()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Update year info on input
    document.querySelector('input[name="year"]').addEventListener('input', function() {
        const year = parseInt(this.value);
        const currentYear = new Date().getFullYear();
        const yearInfo = document.getElementById('yearInfoText');
        
        if (!isNaN(year) && year >= 1900 && year <= 2100) {
            const difference = year - currentYear;
            
            if (difference > 0) {
                yearInfo.textContent = "Tahun " + year + " adalah tahun yang akan datang (" + difference + " tahun lagi)";
            } else if (difference == 0) {
                yearInfo.textContent = "Tahun " + year + " adalah tahun berjalan";
            } else {
                yearInfo.textContent = "Tahun " + year + " adalah " + Math.abs(difference) + " tahun yang lalu";
            }
        } else if (this.value.trim() === '') {
            yearInfo.textContent = "Silakan masukkan tahun yang valid";
        }
    });

    // Function to set year value from recent years buttons
function setYearValue(year, label) {
    // Set the year input value
    const yearInput = document.querySelector('input[name="year"]');
    yearInput.value = year;
    
    // Trigger input event to update the info
    yearInput.dispatchEvent(new Event('input'));
    
    // Show feedback message
    showYearFeedback(year, label);
}

// Function to show feedback when year is selected
function showYearFeedback(year, label) {
    // Create feedback element
    const feedback = document.createElement('div');
    feedback.className = 'alert alert-success alert-dismissible fade show';
    feedback.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
    `;
    feedback.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            <div>
                <div class="fw-medium">Tahun <strong>${year}</strong> dipilih</div>
                <small class="text-muted">${label}</small>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Add to body
    document.body.appendChild(feedback);
    
    // Initialize Bootstrap alert
    const bsAlert = new bootstrap.Alert(feedback);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        bsAlert.close();
    }, 3000);
}
    
    // Preview function
    function previewYear() {
        const yearInput = document.querySelector('input[name="year"]');
        const year = parseInt(yearInput.value);
        const currentYear = new Date().getFullYear();
        
        if (!year || year < 1900 || year > 2100) {
            alert('Silakan masukkan tahun yang valid (1900-2100)');
            yearInput.focus();
            return;
        }
        
        document.getElementById('previewYear').textContent = year;
        
        const difference = year - currentYear;
        let statusHtml = '';
        
        if (difference > 0) {
            statusHtml = `<span class="badge bg-info">
                <i class="fas fa-clock me-1"></i>Tahun yang akan datang (${difference} tahun lagi)
            </span>`;
        } else if (difference == 0) {
            statusHtml = `<span class="badge bg-success">
                <i class="fas fa-check-circle me-1"></i>Tahun berjalan
            </span>`;
        } else {
            statusHtml = `<span class="badge bg-secondary">
                <i class="fas fa-history me-1"></i>Tahun lampau (${Math.abs(difference)} tahun yang lalu)
            </span>`;
        }
        
        document.getElementById('previewStatus').innerHTML = statusHtml;
        
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    }
    
    // Form validation
    document.getElementById('yearForm').addEventListener('submit', function(e) {
        const yearInput = document.querySelector('input[name="year"]');
        const year = parseInt(yearInput.value);
        
        if (!year || year < 1900 || year > 2100) {
            e.preventDefault();
            alert('Tahun harus antara 1900-2100!');
            yearInput.focus();
            return;
        }
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
    });
</script>

<style>
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    }
    
    .form-control-lg {
        font-size: 1.25rem;
        padding: 0.75rem 1rem;
        text-align: center;
        font-weight: bold;
    }
    
    .display-4 {
        font-size: 3.5rem;
        color: #1e293b;
    }
    
    .card.bg-light {
        background-color: #f8fafc !important;
    }
    
    .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>