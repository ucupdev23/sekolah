<div class="page-header">
    <div>
        <h1 class="h3 fw-bold mb-1">
            <i class="fas fa-key me-2 text-primary"></i>Ubah Password
        </h1>
        <p class="text-muted mb-0">
            Perbarui password akun Anda secara berkala untuk keamanan
        </p>
    </div>
    <a href="<?= base_url('admin'); ?>" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <!-- Info Keamanan Card -->
        <div class="alert alert-info d-flex align-items-start mb-4">
            <i class="fas fa-shield-alt fa-lg me-3 mt-1"></i>
            <div>
                <strong>Tips Keamanan:</strong>
                <ul class="mb-0 small">
                    <li>Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol</li>
                    <li>Minimal 8 karakter untuk password yang kuat</li>
                    <li>Jangan gunakan password yang sama dengan akun lain</li>
                </ul>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-lock me-2 text-primary"></i>
                    Form Ubah Password
                </h5>
            </div>
            <div class="card-body p-4">
                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= $this->session->flashdata('success'); ?>
                        </div>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="<?= base_url('profil/password/update'); ?>" method="post" id="passwordForm">
                    <!-- Password Lama -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-key me-2 text-primary"></i>Password Lama
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   name="password_lama" 
                                   id="pwd_lama" 
                                   class="form-control" 
                                   placeholder="Masukkan password lama Anda"
                                   required>
                            <button type="button" 
                                    class="btn btn-outline-secondary toggle-password" 
                                    data-target="#pwd_lama">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-lock me-2 text-primary"></i>Password Baru
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   name="password_baru" 
                                   id="pwd_baru" 
                                   class="form-control" 
                                   placeholder="Minimal 6 karakter"
                                   required>
                            <button type="button" 
                                    class="btn btn-outline-secondary toggle-password" 
                                    data-target="#pwd_baru">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <!-- Password Strength Indicator -->
                        <div class="mt-2">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted" id="strengthText">Kekuatan password: -</small>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-check-circle me-2 text-primary"></i>Konfirmasi Password Baru
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   name="password_konfirmasi" 
                                   id="pwd_konf" 
                                   class="form-control" 
                                   placeholder="Ketik ulang password baru"
                                   required>
                            <button type="button" 
                                    class="btn btn-outline-secondary toggle-password" 
                                    data-target="#pwd_konf">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatchMessage" class="mt-1 small"></div>
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <h6 class="fw-semibold mb-2">
                            <i class="fas fa-clipboard-check me-2 text-primary"></i>
                            Persyaratan Password:
                        </h6>
                        <div class="row g-2 small">
                            <div class="col-6">
                                <div id="reqLength" class="text-muted">
                                    <i class="fas fa-times-circle me-1 text-danger"></i>
                                    Minimal 6 karakter
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="reqUppercase" class="text-muted">
                                    <i class="fas fa-times-circle me-1 text-danger"></i>
                                    Huruf besar (A-Z)
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="reqLowercase" class="text-muted">
                                    <i class="fas fa-times-circle me-1 text-danger"></i>
                                    Huruf kecil (a-z)
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="reqNumber" class="text-muted">
                                    <i class="fas fa-times-circle me-1 text-danger"></i>
                                    Angka (0-9)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between border-top pt-4">
                        <a href="<?= base_url('admin'); ?>" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                            <i class="fas fa-save me-2"></i>Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="fas fa-clock me-1"></i>
                Terakhir diubah: <?= isset($last_password_change) ? date('d M Y H:i', strtotime($last_password_change)) : 'Belum pernah'; ?>
            </small>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Password Visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('data-target'));
            const type = target.getAttribute('type') === 'password' ? 'text' : 'password';
            target.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    });

    // Password Strength Checker
    const pwdBaru = document.getElementById('pwd_baru');
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');
    
    // Requirement elements
    const reqLength = document.getElementById('reqLength');
    const reqUppercase = document.getElementById('reqUppercase');
    const reqLowercase = document.getElementById('reqLowercase');
    const reqNumber = document.getElementById('reqNumber');
    
    function checkPasswordStrength(password) {
        // Requirements check
        const hasLength = password.length >= 6;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        
        // Update requirement icons
        reqLength.innerHTML = hasLength 
            ? '<i class="fas fa-check-circle me-1 text-success"></i>Minimal 6 karakter ✓'
            : '<i class="fas fa-times-circle me-1 text-danger"></i>Minimal 6 karakter';
        
        reqUppercase.innerHTML = hasUppercase
            ? '<i class="fas fa-check-circle me-1 text-success"></i>Huruf besar (A-Z) ✓'
            : '<i class="fas fa-times-circle me-1 text-danger"></i>Huruf besar (A-Z)';
        
        reqLowercase.innerHTML = hasLowercase
            ? '<i class="fas fa-check-circle me-1 text-success"></i>Huruf kecil (a-z) ✓'
            : '<i class="fas fa-times-circle me-1 text-danger"></i>Huruf kecil (a-z)';
        
        reqNumber.innerHTML = hasNumber
            ? '<i class="fas fa-check-circle me-1 text-success"></i>Angka (0-9) ✓'
            : '<i class="fas fa-times-circle me-1 text-danger"></i>Angka (0-9)';
        
        // Calculate strength
        let strength = 0;
        if (hasLength) strength++;
        if (hasUppercase) strength++;
        if (hasLowercase) strength++;
        if (hasNumber) strength++;
        if (password.length >= 8) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        const percentage = Math.min((strength / 6) * 100, 100);
        strengthBar.style.width = percentage + '%';
        
        if (strength <= 2) {
            strengthBar.className = 'progress-bar bg-danger';
            strengthText.textContent = 'Kekuatan password: Lemah';
            strengthText.className = 'text-danger';
        } else if (strength <= 4) {
            strengthBar.className = 'progress-bar bg-warning';
            strengthText.textContent = 'Kekuatan password: Sedang';
            strengthText.className = 'text-warning';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            strengthText.textContent = 'Kekuatan password: Kuat';
            strengthText.className = 'text-success';
        }
    }
    
    pwdBaru.addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });
    
    // Password match validation
    const pwdKonf = document.getElementById('pwd_konf');
    const matchMessage = document.getElementById('passwordMatchMessage');
    
    function checkPasswordMatch() {
        if (pwdKonf.value === '') {
            pwdKonf.classList.remove('is-valid', 'is-invalid');
            matchMessage.innerHTML = '';
        } else if (pwdKonf.value !== pwdBaru.value) {
            pwdKonf.classList.add('is-invalid');
            pwdKonf.classList.remove('is-valid');
            matchMessage.innerHTML = '<i class="fas fa-times-circle text-danger me-1"></i>Password tidak cocok';
            matchMessage.className = 'text-danger';
        } else {
            pwdKonf.classList.add('is-valid');
            pwdKonf.classList.remove('is-invalid');
            matchMessage.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i>Password cocok';
            matchMessage.className = 'text-success';
        }
    }
    
    pwdBaru.addEventListener('input', checkPasswordMatch);
    pwdKonf.addEventListener('input', checkPasswordMatch);
    
    // Form validation before submit
    const form = document.getElementById('passwordForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        const pwdLama = document.getElementById('pwd_lama').value;
        const pwdBaruValue = pwdBaru.value;
        const pwdKonfValue = pwdKonf.value;
        
        if (!pwdLama || !pwdBaruValue || !pwdKonfValue) {
            e.preventDefault();
            alert('Semua field harus diisi!');
            return;
        }
        
        if (pwdBaruValue.length < 6) {
            e.preventDefault();
            alert('Password baru minimal 6 karakter!');
            return;
        }
        
        if (pwdBaruValue !== pwdKonfValue) {
            e.preventDefault();
            alert('Konfirmasi password tidak cocok!');
            return;
        }
        
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
    });
});
</script>

<style>
    /* Additional custom styles */
    .input-group .btn-outline-secondary {
        border-color: #dee2e6;
        background: white;
    }
    
    .input-group .btn-outline-secondary:hover {
        background: #f8f9fa;
        color: var(--primary-blue);
    }
    
    .form-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    }
    
    .bg-light {
        background-color: #f8fafc !important;
    }
    
    .alert-info {
        background: rgba(13, 202, 240, 0.1);
        border: 1px solid rgba(13, 202, 240, 0.2);
    }
</style>