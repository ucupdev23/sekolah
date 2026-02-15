<div class="auth-wrapper">
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h1 class="auth-title">Reset Password</h1>
            <p class="auth-subtitle">Buat password baru untuk akun Anda</p>
        </div>
        
        <!-- Body -->
        <div class="auth-body">
            <!-- Info -->
            <div class="text-center mb-4">
                <div class="bg-light p-3 rounded-3">
                    <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                    <p class="text-muted small mb-0">
                        Masukkan <strong>Password Baru</strong> Anda dua kali untuk konfirmasi. 
                        Setelah disimpan, Anda dapat menggunakan password baru ini untuk login.
                    </p>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('warning')): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $this->session->flashdata('warning'); ?>
                </div>
            <?php endif; ?>

            <!-- Form New Password -->
            <form action="<?= base_url('admin/forgot_password/new_password_process'); ?>" method="post" id="newPasswordForm">
                <!-- Hidden token (if needed) -->
                <input type="hidden" name="reset_token" value="<?= isset($reset_token) ? $reset_token : ''; ?>">
                
                <!-- New Password -->
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <div class="input-group">
                        <input type="password" 
                               name="password_baru" 
                               id="newPassword"
                               class="form-control" 
                               placeholder="Minimal 6 karakter"
                               required>
                        <span class="input-group-text toggle-password" data-target="#newPassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <small class="text-muted">Gunakan kombinasi huruf dan angka untuk keamanan</small>
                </div>

                <!-- Password Strength -->
                <div class="mb-3">
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                    </div>
                    <small class="text-muted" id="strengthText">Kekuatan password: -</small>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" 
                               name="password_konfirmasi" 
                               id="confirmPassword"
                               class="form-control" 
                               placeholder="Ketik ulang password baru"
                               required>
                        <span class="input-group-text toggle-password" data-target="#confirmPassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div id="passwordMatchMessage" class="mt-1 small"></div>
                </div>
                
                <button type="submit" class="btn btn-primary-custom mb-3">
                    <i class="fas fa-save me-2"></i>Simpan Password Baru
                </button>
            </form>

            <!-- Footer Links -->
            <div class="auth-footer">
                <a href="<?= base_url('admin/login'); ?>" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Login
                </a>
                <span class="mx-2 text-muted">|</span>
                <a href="<?= base_url('admin/forgot_password'); ?>" class="back-link">
                    <i class="fas fa-question-circle"></i>
                    Lupa Password?
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password untuk semua field
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
    
    // Password strength checker
    const newPassword = document.getElementById('newPassword');
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');
    
    if (newPassword) {
        newPassword.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Kriteria penilaian
            if (password.length >= 6) strength++;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            const percentage = Math.min((strength / 6) * 100, 100);
            strengthBar.style.width = percentage + '%';
            
            // Warna dan teks berdasarkan kekuatan
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
        });
    }
    
    // Password match validation
    const confirmPassword = document.getElementById('confirmPassword');
    const matchMessage = document.getElementById('passwordMatchMessage');
    
    if (newPassword && confirmPassword) {
        confirmPassword.addEventListener('input', function() {
            if (this.value === '') {
                // Kosong
                this.classList.remove('is-valid', 'is-invalid');
                matchMessage.innerHTML = '';
            } else if (this.value !== newPassword.value) {
                // Tidak cocok
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
                matchMessage.innerHTML = '<i class="fas fa-times-circle text-danger me-1"></i>Password tidak cocok';
                matchMessage.className = 'text-danger';
            } else {
                // Cocok
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
                matchMessage.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i>Password cocok';
                matchMessage.className = 'text-success';
            }
        });
    }
    
    // Form submission loading state
    const form = document.getElementById('newPasswordForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        // Validasi password cocok
        if (newPassword.value !== confirmPassword.value) {
            e.preventDefault();
            alert('Password baru dan konfirmasi password tidak cocok!');
            confirmPassword.focus();
            return;
        }
        
        // Validasi minimal 6 karakter
        if (newPassword.value.length < 6) {
            e.preventDefault();
            alert('Password minimal 6 karakter!');
            newPassword.focus();
            return;
        }
        
        // Show loading
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
    });
});
</script>