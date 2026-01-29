<div class="page-header">
    <div>
        <h1>
            <i class="fas <?= isset($announcement) ? 'fa-edit' : 'fa-plus-circle'; ?> me-2"></i>
            <?= isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman'; ?>
        </h1>
        <p class="text-muted mb-0">
            <?= isset($announcement) ? 'Perbarui informasi pengumuman' : 'Buat pengumuman baru untuk ditampilkan di website'; ?>
        </p>
    </div>
    <a href="<?= site_url('admin/pengumuman'); ?>" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>
                    Form Pengumuman
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
                
                <form method="post" id="announcementForm">
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-heading me-2"></i>Judul Pengumuman
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               class="form-control form-control-lg border-2" 
                               placeholder="Masukkan judul pengumuman"
                               value="<?= set_value('title', isset($announcement) ? $announcement->title : ''); ?>"
                               required>
                        <div class="form-text text-muted">
                            Judul yang menarik akan lebih mudah dibaca oleh pengunjung
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-align-left me-2"></i>Isi Pengumuman
                            <span class="text-danger">*</span>
                        </label>
                        <textarea name="body" 
                                  class="form-control border-2" 
                                  rows="8" 
                                  placeholder="Tulis isi pengumuman di sini..."
                                  required><?= set_value('body', isset($announcement) ? $announcement->body : ''); ?></textarea>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="form-text text-muted">
                                Gunakan format yang jelas dan mudah dipahami
                            </div>
                            <div class="form-text" id="charCount">
                                <span id="currentChars">0</span>/2000 karakter
                            </div>
                        </div>
                    </div>
                    
                    <?php if (isset($announcement)): ?>
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-calendar-alt me-2"></i>Informasi Publikasi
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-calendar-plus"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           value="Dibuat: <?= date('d M Y H:i', strtotime($announcement->created_at)); ?>"
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
                                           value="Terakhir diubah: <?= date('d M Y H:i', strtotime($announcement->updated_at)); ?>"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="border-top pt-4 mt-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="<?= site_url('admin/pengumuman'); ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-primary px-4 me-2" onclick="previewAnnouncement()">
                                    <i class="fas fa-eye me-2"></i>Preview
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Pengumuman
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Publishing Options -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="fas fa-cog me-2"></i>Opsi Publikasi
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">
                        <i class="fas fa-calendar me-2"></i>Tanggal Publikasi
                    </label>
                    <input type="date" 
                           name="published_at" 
                           class="form-control"
                           value="<?= isset($announcement) ? date('Y-m-d', strtotime($announcement->published_at)) : date('Y-m-d'); ?>" readonly>
                </div>
                
                <!-- <div class="mb-3">
                    <label class="form-label fw-medium">
                        <i class="fas fa-eye me-2"></i>Status
                    </label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="is_published" 
                               id="isPublished"
                               <?= (isset($announcement) && $announcement->is_published) || !isset($announcement) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="isPublished">
                            Tampilkan di website
                        </label>
                    </div>
                </div> -->
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>Pengumuman akan langsung tampil di halaman depan sekolah</small>
                </div>
            </div>
        </div>
        
        <!-- Formatting Tips -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>Tips Penulisan
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Gunakan bahasa yang jelas dan mudah dipahami</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Sertakan informasi penting di awal</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Pisahkan poin-poin penting dengan paragraf</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Periksa kembali sebelum menyimpan</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Preview Pengumuman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="card-header bg-light">
                        <h4 id="previewTitle" class="mb-0"></h4>
                    </div>
                    <div class="card-body">
                        <div id="previewBody" class="mb-3"></div>
                        <hr>
                        <div class="text-muted small">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Dipublikasikan pada: 
                            <span id="previewDate"><?= date('d M Y'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('announcementForm').submit()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    }
    
    .form-control-lg {
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
    }
    
    .form-check-input:checked {
        background-color: var(--primary-blue);
        border-color: var(--primary-blue);
    }
    
    .form-switch .form-check-input {
        height: 1.5em;
        width: 3em;
    }
    
    textarea {
        resize: vertical;
        min-height: 200px;
        line-height: 1.6;
    }
    
    #charCount {
        font-weight: 500;
    }
</style>

<script>
    // Character count
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="body"]');
        const charCount = document.getElementById('charCount');
        const currentChars = document.getElementById('currentChars');
        
        // Initial count
        currentChars.textContent = textarea.value.length;
        
        // Update count on input
        textarea.addEventListener('input', function() {
            currentChars.textContent = this.value.length;
            
            if (this.value.length > 2000) {
                charCount.classList.add('text-danger');
            } else if (this.value.length > 1800) {
                charCount.classList.add('text-warning');
            } else {
                charCount.classList.remove('text-danger', 'text-warning');
            }
        });
        
        // Auto-resize textarea
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Trigger initial resize
        textarea.dispatchEvent(new Event('input'));
    });
    
    // Preview function
    function previewAnnouncement() {
        const title = document.querySelector('input[name="title"]').value;
        const body = document.querySelector('textarea[name="body"]').value;
        const date = document.querySelector('input[name="published_at"]')?.value || '<?= date('d M Y'); ?>';
        
        document.getElementById('previewTitle').textContent = title || '[Judul Pengumuman]';
        document.getElementById('previewBody').innerHTML = body 
            ? body.replace(/\n/g, '<br>')
            : '[Isi pengumuman akan ditampilkan di sini]';
        
        if (date) {
            const dateObj = new Date(date);
            document.getElementById('previewDate').textContent = dateObj.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }
        
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    }
    
    // Form submission confirmation
    document.getElementById('announcementForm').addEventListener('submit', function(e) {
        const title = document.querySelector('input[name="title"]').value.trim();
        const body = document.querySelector('textarea[name="body"]').value.trim();
        
        if (!title || !body) {
            e.preventDefault();
            alert('Judul dan isi pengumuman harus diisi!');
            return;
        }
        
        if (body.length > 2000) {
            e.preventDefault();
            if (!confirm('Isi pengumuman melebihi 2000 karakter. Lanjutkan?')) {
                return;
            }
        }
        
        // Optional: Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
    });
</script>