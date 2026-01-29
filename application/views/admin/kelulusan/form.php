<div class="page-header">
    <div>
        <h1>
            <i class="fas <?= isset($graduate) ? 'fa-edit' : 'fa-plus-circle'; ?> me-2"></i>
            <?= isset($graduate) ? 'Edit Data Kelulusan' : 'Tambah Data Kelulusan'; ?>
        </h1>
        <p class="text-muted mb-0">
            <?= isset($graduate) ? 'Perbarui data siswa lulusan' : 'Tambah data siswa lulusan baru'; ?>
        </p>
    </div>
    <a href="<?= site_url('admin/kelulusan'); ?>" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-graduate me-2"></i>
                    Form Data Lulusan
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
                
                <?php if (!empty($upload_error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $upload_error; ?>
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
                
                <form method="post" enctype="multipart/form-data" id="graduateForm">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                <i class="fas fa-user me-2"></i>Nama Siswa
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="student_name" 
                                   class="form-control border-2" 
                                   placeholder="Masukkan nama lengkap siswa"
                                   value="<?= set_value('student_name', isset($graduate) ? $graduate->student_name : ''); ?>"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                <i class="fas fa-id-card me-2"></i>NISN
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="nisn" 
                                   class="form-control border-2" 
                                   placeholder="Masukkan NISN siswa"
                                   value="<?= set_value('nisn', isset($graduate) ? $graduate->nisn : ''); ?>"
                                   required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-calendar-alt me-2"></i>Tahun Kelulusan
                            <span class="text-danger">*</span>
                        </label>
                        <select name="graduation_year" class="form-select border-2" required>
                            <option value="">-- Pilih Tahun Kelulusan --</option>
                            <?php foreach ($years as $y): ?>
                                <option value="<?= $y->year; ?>"
                                    <?= set_select('graduation_year', $y->year, 
                                        isset($graduate) && $graduate->graduation_year == $y->year
                                    ); ?>>
                                    Tahun <?= $y->year; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text text-muted">
                            Pilih tahun kelulusan siswa
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                <i class="fas fa-image me-2"></i>Foto Siswa
                                <span class="text-muted small">(Opsional)</span>
                            </label>
                            <input type="file" 
                                   name="photo" 
                                   class="form-control border-2" 
                                   accept="image/*"
                                   id="photoInput">
                            <div class="form-text text-muted">
                                Format: JPG, PNG, WebP. Maksimal 2MB. Rekomendasi: 400x400px
                            </div>
                            
                            <!-- Photo Preview -->
                            <div class="mt-3" id="photoPreview" style="
                                <?= (isset($graduate) && !empty($graduate->photo_path)) ? '' : 'display: none;' ?>">
                                <div class="d-flex flex-column align-items-start">
                                    <p class="small text-muted mb-2">Preview Foto:</p>
                                    <img id="previewPhoto" 
                                         src="<?= isset($graduate) && !empty($graduate->photo_path) ? base_url('uploads/graduates/photos/' . $graduate->photo_path) : ''; ?>" 
                                         class="img-thumbnail rounded-circle" 
                                         style="width: 120px; height: 120px; object-fit: cover;"
                                         onerror="this.style.display='none'">
                                    <?php if (isset($graduate) && !empty($graduate->photo_path)): ?>
                                        <small class="text-muted mt-2">
                                            <a href="<?= base_url('uploads/graduates/photos/' . $graduate->photo_path); ?>" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-external-link-alt me-1"></i>Lihat Full
                                            </a>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                <i class="fas fa-file me-2"></i>File CV/Portfolio
                                <span class="text-muted small">(Opsional)</span>
                            </label>
                            <input type="file" 
                                   name="cv_file" 
                                   class="form-control border-2" 
                                   accept=".pdf,.doc,.docx"
                                   id="cvInput">
                            <div class="form-text text-muted">
                                Format: PDF, DOC, DOCX. Maksimal 4MB
                            </div>
                            
                            <!-- CV Preview -->
                            <div class="mt-3" id="cvPreview" style="
                                <?= (isset($graduate) && !empty($graduate->cv_link)) ? '' : 'display: none;' ?>">
                                <div class="d-flex flex-column align-items-start">
                                    <p class="small text-muted mb-2">File CV saat ini:</p>
                                    <?php if (isset($graduate) && !empty($graduate->cv_link)): ?>
                                        <?php
                                        $extension = pathinfo($graduate->cv_link, PATHINFO_EXTENSION);
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
                                        <div class="d-flex align-items-center">
                                            <i class="fas <?= $icon; ?> fa-2x text-<?= $color; ?> me-3"></i>
                                            <div>
                                                <div class="fw-medium">CV Siswa</div>
                                                <small class="text-muted"><?= strtoupper($extension); ?> • 
                                                    <?php 
                                                    if (file_exists(FCPATH . $graduate->cv_link)) {
                                                        $size = filesize(FCPATH . $graduate->cv_link);
                                                        echo round($size / 1024, 2) . ' KB';
                                                    }
                                                    ?>
                                                </small>
                                            </div>
                                        </div>
                                        <a href="<?= base_url('uploads/graduates/cv/' . $graduate->cv_link); ?>" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-<?= $color; ?> mt-2">
                                            <i class="fas fa-download me-1"></i>Download CV
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (isset($graduate)): ?>
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-info-circle me-2"></i>Informasi Data
                        </label>
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <small>
                                        <i class="fas fa-calendar-plus me-2"></i>
                                        Ditambahkan: <?= isset($graduate->created_at) ? date('d M Y H:i', strtotime($graduate->created_at)) : 'Tidak diketahui'; ?>
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small>
                                        <i class="fas fa-calendar-check me-2"></i>
                                        Terakhir diubah: <?= isset($graduate->updated_at) ? date('d M Y H:i', strtotime($graduate->updated_at)) : 'Belum pernah'; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="border-top pt-4 mt-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="<?= site_url('admin/kelulusan'); ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Data
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Upload Tips -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>Tips Upload
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Gunakan foto dengan latar belakang netral</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Pastikan foto jelas dan terang</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>CV sebaiknya dalam format PDF</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Periksa data NISN sebelum menyimpan</small>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Data Status -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Statistik Data
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">Total Data:</small>
                    <span class="badge bg-primary"><?= isset($graduate) ? 'Edit Mode' : 'Tambah Baru'; ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">Status Foto:</small>
                    <span class="badge bg-<?= (isset($graduate) && !empty($graduate->photo_path)) ? 'success' : 'warning'; ?>">
                        <?= (isset($graduate) && !empty($graduate->photo_path)) ? '✓ Ada' : 'Belum ada'; ?>
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Status CV:</small>
                    <span class="badge bg-<?= (isset($graduate) && !empty($graduate->cv_link)) ? 'success' : 'warning'; ?>">
                        <?= (isset($graduate) && !empty($graduate->cv_link)) ? '✓ Ada' : 'Belum ada'; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Photo preview
    document.getElementById('photoInput').addEventListener('change', function(e) {
        const preview = document.getElementById('photoPreview');
        const previewImage = document.getElementById('previewPhoto');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // CV file name display
    document.getElementById('cvInput').addEventListener('change', function(e) {
        const preview = document.getElementById('cvPreview');
        
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const fileName = file.name;
            const fileSize = (file.size / 1024).toFixed(2);
            const fileType = fileName.split('.').pop().toLowerCase();
            
            let icon = 'fa-file';
            let color = 'secondary';
            
            if (fileType === 'pdf') {
                icon = 'fa-file-pdf';
                color = 'danger';
            } else if (fileType === 'doc' || fileType === 'docx') {
                icon = 'fa-file-word';
                color = 'primary';
            }
            
            preview.innerHTML = `
                <div class="d-flex flex-column align-items-start">
                    <p class="small text-muted mb-2">File baru akan diupload:</p>
                    <div class="d-flex align-items-center">
                        <i class="fas ${icon} fa-2x text-${color} me-3"></i>
                        <div>
                            <div class="fw-medium">${fileName}</div>
                            <small class="text-muted">${fileType.toUpperCase()} • ${fileSize} KB</small>
                        </div>
                    </div>
                </div>
            `;
            preview.style.display = 'block';
        }
    });
    
    // Form validation
    document.getElementById('graduateForm').addEventListener('submit', function(e) {
        const studentName = document.querySelector('input[name="student_name"]').value.trim();
        const nisn = document.querySelector('input[name="nisn"]').value.trim();
        const graduationYear = document.querySelector('select[name="graduation_year"]').value;
        
        if (!studentName) {
            e.preventDefault();
            alert('Nama siswa harus diisi!');
            return;
        }
        
        if (!nisn) {
            e.preventDefault();
            alert('NISN harus diisi!');
            return;
        }
        
        if (!graduationYear) {
            e.preventDefault();
            alert('Tahun kelulusan harus dipilih!');
            return;
        }
        
        // File size validation for photo
        const photoInput = document.getElementById('photoInput');
        if (photoInput.files.length > 0) {
            const photoSize = photoInput.files[0].size / 1024 / 1024; // MB
            if (photoSize > 2) {
                e.preventDefault();
                alert('Ukuran foto maksimal 2MB!');
                return;
            }
        }
        
        // File size validation for CV
        const cvInput = document.getElementById('cvInput');
        if (cvInput.files.length > 0) {
            const cvSize = cvInput.files[0].size / 1024 / 1024; // MB
            if (cvSize > 4) {
                e.preventDefault();
                alert('Ukuran CV maksimal 4MB!');
                return;
            }
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
    
    .img-thumbnail {
        border-width: 2px;
    }
    
    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
    }
</style>