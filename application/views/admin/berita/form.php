<div class="page-header">
    <div>
        <h1>
            <i class="fas <?= isset($news) ? 'fa-edit' : 'fa-plus-circle'; ?> me-2"></i>
            <?= isset($news) ? 'Edit Berita' : 'Tambah Berita'; ?>
        </h1>
        <p class="text-muted mb-0">
            <?= isset($news) ? 'Perbarui informasi berita' : 'Buat berita baru untuk ditampilkan di website'; ?>
        </p>
    </div>
    <a href="<?= site_url('admin/berita'); ?>" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>
                    Form Berita
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
                
                <form method="post" enctype="multipart/form-data" id="newsForm">
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-heading me-2"></i>Judul Berita
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               class="form-control form-control-lg border-2" 
                               placeholder="Masukkan judul berita"
                               value="<?= set_value('title', isset($news) ? $news->title : ''); ?>"
                               required>
                        <div class="form-text text-muted">
                            Judul yang menarik akan meningkatkan minat baca pengunjung
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-medium">
                                <i class="fas fa-tags me-2"></i>Kategori
                                <span class="text-danger">*</span>
                            </label>
                            <select name="category_id" class="form-select border-2" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($categories as $c): ?>
                                    <option value="<?= $c->id; ?>"
                                        <?= set_select('category_id', $c->id, 
                                            isset($news) && $news->category_id == $c->id
                                        ); ?>>
                                        <?= htmlspecialchars($c->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-image me-2"></i>Thumbnail
                            <span class="text-muted small">(Opsional)</span>
                        </label>
                        <input type="file" 
                               name="thumbnail" 
                               class="form-control border-2" 
                               accept="image/*"
                               id="thumbnailInput">
                        <div class="form-text text-muted">
                            Format: JPG, PNG, GIF, WebP. Maksimal 2MB.
                        </div>
                        
                        <!-- Thumbnail Preview -->
                        <div class="mt-3" id="thumbnailPreview" style="
                            <?= (isset($news) && !empty($news->thumbnail_path)) ? '' : 'display: none;' ?>">
                            <div class="d-flex align-items-center">
                                <img id="previewImage" 
                                     src="<?= isset($news) && !empty($news->thumbnail_path) ? base_url('uploads/news/' . $news->thumbnail_path) : ''; ?>" 
                                     class="img-thumbnail me-3" 
                                     style="max-width: 150px; max-height: 100px; object-fit: cover;"
                                     onerror="this.style.display='none'">
                                <div>
                                    <p class="small text-muted mb-1">Thumbnail saat ini:</p>
                                    <?php if (isset($news) && !empty($news->thumbnail_path)): ?>
                                        <a href="<?= base_url('uploads/news/' . $news->thumbnail_path); ?>" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>Lihat Full
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-align-left me-2"></i>Konten Berita
                            <span class="text-danger">*</span>
                        </label>
                        <textarea name="content" 
                                  id="content" 
                                  class="form-control" 
                                  rows="12" 
                                  placeholder="Tulis konten berita di sini..."
                                  ><?= set_value('content', isset($news) ? $news->content : ''); ?></textarea>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="form-text text-muted">
                                Gunakan editor untuk format yang lebih baik
                            </div>
                            <div class="form-text" id="charCount">
                                <span id="currentChars">0</span>/50000 karakter
                            </div>
                        </div>
                    </div>
                    
                    <?php if (isset($news)): ?>
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-info-circle me-2"></i>Informasi
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-link"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           value="<?= site_url('berita/' . $news->slug); ?>"
                                           readonly>
                                    <button type="button" 
                                        class="btn btn-outline-secondary" 
                                        onclick="copyToClipboard('<?= site_url('berita/detail/' . $news->slug); ?>')"
                                        data-bs-toggle="tooltip" title="Salin URL">
                                    <i class="fas fa-copy"></i>
                                </button>
                                </div>
                                <small class="form-text text-muted">URL berita</small>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-calendar-check"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           value="Terakhir diubah: <?= isset($news->updated_at) ? date('d M Y H:i', strtotime($news->updated_at)) : 'Belum pernah'; ?>"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="border-top pt-4 mt-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="<?= site_url('admin/berita'); ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-primary px-4 me-2" onclick="previewNews()">
                                    <i class="fas fa-eye me-2"></i>Preview
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Berita
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
                    <input type="datetime-local" 
                           name="published_at" 
                           class="form-control"
                           value="<?= isset($news) ? date('Y-m-d\TH:i', strtotime($news->published_at)) : date('Y-m-d\TH:i'); ?>" readonly>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>Berita akan langsung tampil di halaman depan sekolah.</small>
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
                        <small>Gunakan subjudul untuk memecah konten panjang</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Sertakan gambar untuk ilustrasi yang relevan</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Periksa ejaan dan tata bahasa sebelum publikasi</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Gunakan paragraf pendek untuk keterbacaan</small>
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
                    <i class="fas fa-eye me-2"></i>Preview Berita
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="card-body">
                        <h3 id="previewTitle" class="mb-3"></h3>
                        <div class="mb-3">
                            <span class="badge bg-info me-2" id="previewCategory"></span>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                <span id="previewDate"></span>
                            </small>
                        </div>
                        <div id="previewThumbnail" class="mb-4 text-center"></div>
                        <div id="previewContent" class="mb-3"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('newsForm').submit()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CKEditor 5 Classic -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
let editorInstance;

// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#content'), {
        toolbar: {
    items: [
        'heading', '|',
        'bold', 'italic', '|',
        'bulletedList', 'numberedList', '|',
        'blockQuote', 'insertTable', '|',
        'link', '|',
        'undo', 'redo'
    ]
},
        language: 'id',
        placeholder: 'Tulis konten berita di sini...'
    })
    .then(editor => {
        editorInstance = editor;
        
        // Update character count
        editor.model.document.on('change:data', () => {
            const content = editor.getData();
            document.getElementById('currentChars').textContent = content.length;
            
            if (content.length > 50000) {
                document.getElementById('charCount').classList.add('text-danger');
            } else if (content.length > 45000) {
                document.getElementById('charCount').classList.add('text-warning');
            } else {
                document.getElementById('charCount').classList.remove('text-danger', 'text-warning');
            }
        });
        
        // Initial count
        document.getElementById('currentChars').textContent = editor.getData().length;
        
        // Ensure data is sent on form submit
        document.getElementById('newsForm').addEventListener('submit', function() {
            document.querySelector('#content').value = editorInstance.getData();
        });
    })
    .catch(error => {
        console.error('CKEditor error:', error);
        // Fallback to textarea if CKEditor fails
        const textarea = document.querySelector('#content');
        textarea.style.display = 'block';
        
        // Character count for textarea fallback
        textarea.addEventListener('input', function() {
            document.getElementById('currentChars').textContent = this.value.length;
        });
        document.getElementById('currentChars').textContent = textarea.value.length;
    });

// Thumbnail preview
document.getElementById('thumbnailInput').addEventListener('change', function(e) {
    const preview = document.getElementById('thumbnailPreview');
    const previewImage = document.getElementById('previewImage');
    
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

// Copy to clipboard dengan fallback
function copyToClipboard(text) {
    // Method 1: Modern clipboard API (HTTPS required)
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
            showToast('URL berhasil disalin ke clipboard!', 'success');
        }).catch(function(err) {
            // Fallback jika clipboard API gagal
            fallbackCopyToClipboard(text);
        });
    } else {
        // Fallback untuk browser lama atau HTTP
        fallbackCopyToClipboard(text);
    }
}

// Fallback method menggunakan textarea
function fallbackCopyToClipboard(text) {
    // Buat textarea sementara
    const textArea = document.createElement('textarea');
    textArea.value = text;
    
    // Hilangkan dari viewport
    textArea.style.position = 'fixed';
    textArea.style.top = '0';
    textArea.style.left = '0';
    textArea.style.width = '2em';
    textArea.style.height = '2em';
    textArea.style.padding = '0';
    textArea.style.border = 'none';
    textArea.style.outline = 'none';
    textArea.style.boxShadow = 'none';
    textArea.style.background = 'transparent';
    
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        // Coba copy menggunakan document.execCommand
        const successful = document.execCommand('copy');
        if (successful) {
            showToast('URL berhasil disalin ke clipboard!', 'success');
        } else {
            showToast('Gagal menyalin URL. Silakan salin manual.', 'warning');
        }
    } catch (err) {
        console.error('Fallback copy error: ', err);
        showToast('Gagal menyalin URL. Silakan salin manual.', 'error');
        
        // Tampilkan text untuk disalin manual
        prompt('Salin URL berikut secara manual:', text);
    }
    
    // Hapus textarea
    document.body.removeChild(textArea);
}

// Fungsi untuk menampilkan toast/pesan
function showToast(message, type = 'info') {
    // Cek jika sudah ada toast
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        `;
        document.body.appendChild(toastContainer);
    }
    
    // Buat toast
    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Inisialisasi Bootstrap toast
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 3000
    });
    bsToast.show();
    
    // Hapus toast setelah ditutup
    toast.addEventListener('hidden.bs.toast', function() {
        toast.remove();
    });
}

// Preview function
function previewNews() {
    const title = document.querySelector('input[name="title"]').value;
    const content = editorInstance ? editorInstance.getData() : document.querySelector('#content').value;
    const categorySelect = document.querySelector('select[name="category_id"]');
    const category = categorySelect.options[categorySelect.selectedIndex].text;
    const date = document.querySelector('input[name="published_at"]')?.value || '<?= date('d M Y H:i'); ?>';
    const thumbnail = document.getElementById('thumbnailInput').files[0];
    
    document.getElementById('previewTitle').textContent = title || '[Judul Berita]';
    document.getElementById('previewCategory').textContent = category || 'Belum dipilih';
    document.getElementById('previewContent').innerHTML = content || '[Konten berita akan ditampilkan di sini]';
    
    if (date) {
        const dateObj = new Date(date);
        document.getElementById('previewDate').textContent = dateObj.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    // Handle thumbnail preview
    const previewThumbnail = document.getElementById('previewThumbnail');
    if (thumbnail) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewThumbnail.innerHTML = `
                <img src="${e.target.result}" 
                     class="img-fluid rounded" 
                     style="max-height: 300px; object-fit: cover;">
            `;
        };
        reader.readAsDataURL(thumbnail);
    } else if (document.getElementById('previewImage').src) {
        previewThumbnail.innerHTML = `
            <img src="${document.getElementById('previewImage').src}" 
                 class="img-fluid rounded" 
                 style="max-height: 300px; object-fit: cover;">
        `;
    } else {
        previewThumbnail.innerHTML = '<p class="text-muted"><i>Belum ada thumbnail</i></p>';
    }
    
    const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    previewModal.show();
}

// Form validation
document.getElementById('newsForm').addEventListener('submit', function(e) {
    const title = document.querySelector('input[name="title"]').value.trim();
    const category = document.querySelector('select[name="category_id"]').value;
    const content = editorInstance ? editorInstance.getData() : document.querySelector('#content').value.trim();
    
    if (!title) {
        e.preventDefault();
        alert('Judul berita harus diisi!');
        return;
    }
    
    if (!category) {
        e.preventDefault();
        alert('Kategori harus dipilih!');
        return;
    }
    
    if (!content) {
        e.preventDefault();
        alert('Konten berita harus diisi!');
        return;
    }
    
    if (content.length > 50000) {
        e.preventDefault();
        if (!confirm('Konten berita melebihi 50.000 karakter. Lanjutkan?')) {
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
    
    .form-control-lg {
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
    }
    
    .form-check-input:checked {
        background-color: var(--primary-blue);
        border-color: var(--primary-blue);
    }
    
    .ck-editor__editable {
        min-height: 300px;
        max-height: 500px;
        overflow-y: auto;
    }
    
    #charCount {
        font-weight: 500;
    }
</style>