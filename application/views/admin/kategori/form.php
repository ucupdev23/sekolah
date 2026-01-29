<div class="page-header">
    <div>
        <h1>
            <i class="fas <?= isset($category) ? 'fa-edit' : 'fa-plus-circle'; ?> me-2"></i>
            <?= isset($category) ? 'Edit Kategori' : 'Tambah Kategori'; ?>
        </h1>
        <p class="text-muted mb-0">
            <?= isset($category) ? 'Perbarui informasi kategori' : 'Buat kategori baru untuk berita'; ?>
        </p>
    </div>
    <a href="<?= site_url('admin/kategori'); ?>" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-tag me-2"></i>
                    Form Kategori
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
                
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form method="post" id="categoryForm">
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-heading me-2"></i>Nama Kategori
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               class="form-control form-control-lg border-2" 
                               placeholder="Masukkan nama kategori"
                               value="<?= set_value('name', isset($category) ? $category->name : ''); ?>"
                               required
                               minlength="3"
                               maxlength="100">
                        <div class="form-text text-muted">
                            Nama kategori akan digunakan untuk mengelompokkan berita (3-100 karakter)
                        </div>
                    </div>
                    
                    <!-- Slug Preview -->
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-link me-2"></i>Slug (URL)
                        </label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control border-2" 
                                   id="slugPreview"
                                   value="<?= isset($category) ? $category->slug : 'slug-otomatis'; ?>"
                                   readonly>
                            <button type="button" 
                                    class="btn btn-outline-secondary"
                                    onclick="copyToClipboard(document.getElementById('slugPreview').value)"
                                    data-bs-toggle="tooltip" title="Salin slug">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <div class="form-text text-muted">
                            Slug akan dibuat otomatis dari nama kategori. Digunakan untuk URL.
                        </div>
                    </div>
                    
                    <?php if (isset($category)): ?>
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-info-circle me-2"></i>Informasi Kategori
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-calendar-plus"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           value="Dibuat: <?= isset($category->created_at) ? date('d M Y H:i', strtotime($category->created_at)) : 'Tidak diketahui'; ?>"
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
                                           value="Terakhir diubah: <?= isset($category->updated_at) ? date('d M Y H:i', strtotime($category->updated_at)) : 'Belum pernah'; ?>"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="mb-4">
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-newspaper fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Statistik Kategori</h6>
                                    <p class="mb-0">
                                        Kategori ini digunakan oleh <strong><?= $news_count; ?> berita</strong>.
                                        <?php if ($news_count > 0): ?>
                                            <br><small><a href="<?= site_url('admin/berita?category=' . $category->id); ?>" class="text-decoration-none">Lihat semua berita dalam kategori ini</a></small>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="border-top pt-4 mt-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="<?= site_url('admin/kategori'); ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-primary px-4 me-2" onclick="previewCategory()">
                                    <i class="fas fa-eye me-2"></i>Preview
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Kategori
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Tips -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>Tips Penamaan Kategori
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Gunakan nama yang singkat dan jelas</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Hindari nama yang terlalu spesifik</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Gunakan huruf kapital hanya di awal kata</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Hindari karakter khusus dan spasi</small>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Example Categories -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="fas fa-list-alt me-2"></i>Contoh Kategori
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary">Berita Sekolah</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary">Pengumuman</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary">Ekstrakurikuler</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary">Prestasi</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary">Kegiatan</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary">Informasi</span>
                </div>
                <small class="text-muted d-block mt-2">
                    Contoh kategori yang umum digunakan di website sekolah
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
                    <i class="fas fa-eye me-2"></i>Preview Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper me-3" style="background: #e0e7ff; color: #4f46e5;">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <h4 id="previewName" class="mb-0"></h4>
                                <small class="text-muted" id="previewSlug"></small>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Kategori ini akan muncul di:
                            <ul class="mb-0 mt-2">
                                <li>Filter berita di halaman depan</li>
                                <li>Menu kategori berita</li>
                                <li>URL: <code id="previewUrl"></code></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('categoryForm').submit()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Update slug preview on name input
    document.querySelector('input[name="name"]').addEventListener('input', function() {
        const name = this.value.trim();
        if (name) {
            // Simple slug generation
            let slug = name.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-')     // Replace spaces with hyphens
                .replace(/-+/g, '-');     // Replace multiple hyphens with single hyphen
            
            document.getElementById('slugPreview').value = slug;
        } else {
            document.getElementById('slugPreview').value = 'slug-otomatis';
        }
    });
    
    // Copy to clipboard
    function copyToClipboard(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        
        showToast('Slug berhasil disalin!', 'success');
    }
    
    // Show toast
    function showToast(message, type = 'info') {
        // Remove existing toast
        const existingToast = document.querySelector('.toast-message');
        if (existingToast) existingToast.remove();
        
        const toast = document.createElement('div');
        toast.className = `toast-message alert alert-${type} alert-dismissible fade show`;
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        `;
        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                <span>${message}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 3000);
    }
    
    // Preview function
    function previewCategory() {
        const name = document.querySelector('input[name="name"]').value.trim();
        const slug = document.getElementById('slugPreview').value;
        
        if (!name) {
            alert('Silakan isi nama kategori terlebih dahulu');
            return;
        }
        
        document.getElementById('previewName').textContent = name || '[Nama Kategori]';
        document.getElementById('previewSlug').textContent = 'Slug: ' + (slug || 'slug-otomatis');
        document.getElementById('previewUrl').textContent = '<?= site_url("berita?kategori="); ?>' + (slug || 'nama-kategori');
        
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    }
    
    // Form validation
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        const name = document.querySelector('input[name="name"]').value.trim();
        
        if (!name) {
            e.preventDefault();
            alert('Nama kategori harus diisi!');
            return;
        }
        
        if (name.length < 3) {
            e.preventDefault();
            alert('Nama kategori minimal 3 karakter!');
            return;
        }
        
        if (name.length > 100) {
            e.preventDefault();
            alert('Nama kategori maksimal 100 karakter!');
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
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
    }
    
    .icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    code {
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.9em;
    }
</style>