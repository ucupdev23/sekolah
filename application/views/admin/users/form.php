<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header">
    <div>
        <h1>
            <i class="fas <?= isset($user) ? 'fa-edit' : 'fa-user-plus'; ?> me-2"></i>
            <?= isset($user) ? 'Edit Admin User' : 'Tambah Admin User'; ?>
        </h1>
        <p class="text-muted mb-0">
            <?= isset($user) ? 'Perbarui data admin user' : 'Tambahkan admin user baru untuk akses sistem'; ?>
        </p>
    </div>
    <a href="<?= site_url('admin/users'); ?>" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-cog me-2"></i>
                    Form Admin User
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
                
                <form method="post" id="userForm">
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-user me-2"></i>Nama Lengkap
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               class="form-control border-2" 
                               placeholder="Masukkan nama lengkap"
                               value="<?= set_value('name', isset($user) ? htmlspecialchars($user->name) : ''); ?>"
                               required>
                        <div class="form-text text-muted">
                            Nama lengkap admin yang akan ditampilkan di sistem
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-user me-2"></i>Nomor Whatsapp
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="no_wa" 
                               class="form-control border-2" 
                               placeholder="Masukkan nomor whatsapp"
                               value="<?= set_value('no_wa', isset($user) ? htmlspecialchars($user->no_wa) : ''); ?>"
                               required>
                        <div class="form-text text-danger">
                            Gunakan format 628****, jangan gunakan tanda + atau 0 di awal
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-user me-2"></i>Username
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="username" 
                               class="form-control border-2" 
                               placeholder="Masukkan username valid"
                               value="<?= set_value('username', isset($user) ? htmlspecialchars($user->username) : ''); ?>"
                               required>
                        <div class="form-text text-muted">
                            Username ini akan digunakan untuk login ke sistem
                        </div>
                    </div>
                    
                    <div class="mb-4">
    <label class="form-label fw-medium">
        <i class="fas fa-key me-2"></i>Password
        <?php if (isset($user)): ?>
            <small class="text-muted">(kosongkan jika tidak ingin mengubah)</small>
        <?php else: ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <div class="input-group">
        <input type="password" 
               name="password" 
               id="passwordField"
               class="form-control border-2" 
               placeholder="<?= isset($user) ? 'Masukkan password baru' : 'Masukkan password'; ?>"
               <?= !isset($user) ? 'required' : ''; ?>
               autocomplete="new-password">
        <button type="button" 
                class="btn btn-outline-secondary" 
                id="togglePassword"
                data-bs-toggle="tooltip" 
                title="Tampilkan/Sembunyikan password">
            <i class="fas fa-eye"></i>
        </button>
    </div>
    <div class="form-text text-muted">
        Minimal 6 karakter. <?= isset($user) ? 'Isi hanya jika ingin mengganti password' : ''; ?>
    </div>
    
    <!-- Password Strength Indicator -->
    <div class="mt-2" id="passwordStrength">
        <div class="progress" style="height: 5px;">
            <div class="progress-bar" id="passwordStrengthBar" role="progressbar" style="width: 0%"></div>
        </div>
        <small class="text-muted" id="passwordStrengthText">Kekuatan password: -</small>
    </div>
</div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-user-tag me-2"></i>Role
                            <span class="text-danger">*</span>
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="role" 
                                           id="roleAdmin" 
                                           value="admin"
                                           <?= set_radio('role', 'admin', (isset($user) && $user->role == 'admin') || (!isset($user) && set_value('role') == 'admin')); ?>
                                           required>
                                    <label class="form-check-label w-100" for="roleAdmin">
                                        <div class="card border-2 h-100 <?= (isset($user) && $user->role == 'admin') ? 'border-primary' : ''; ?>">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <div class="icon-wrapper mx-auto" style="background: #dbeafe; color: #3b82f6; width: 60px; height: 60px;">
                                                        <i class="fas fa-user-shield fa-2x"></i>
                                                    </div>
                                                </div>
                                                <h6 class="fw-bold mb-2">Admin</h6>
                                                <small class="text-muted d-block">
                                                    Akses terbatas, dapat mengelola data utama
                                                </small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="role" 
                                           id="roleSuperAdmin" 
                                           value="super_admin"
                                           <?= set_radio('role', 'super_admin', (isset($user) && $user->role == 'super_admin') || (!isset($user) && set_value('role') == 'super_admin')); ?>
                                           required>
                                    <label class="form-check-label w-100" for="roleSuperAdmin">
                                        <div class="card border-2 h-100 <?= (isset($user) && $user->role == 'super_admin') ? 'border-danger' : ''; ?>">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <div class="icon-wrapper mx-auto" style="background: #fee2e2; color: #ef4444; width: 60px; height: 60px;">
                                                        <i class="fas fa-crown fa-2x"></i>
                                                    </div>
                                                </div>
                                                <h6 class="fw-bold mb-2">Super Admin</h6>
                                                <small class="text-muted d-block">
                                                    Akses penuh, termasuk kelola admin lain
                                                </small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (isset($user)): ?>
                    <div class="mb-4">
                        <label class="form-label fw-medium">
                            <i class="fas fa-info-circle me-2"></i>Informasi Akun
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-calendar-plus"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           value="Dibuat: <?= isset($user->created_at) ? date('d M Y H:i', strtotime($user->created_at)) : 'Tidak diketahui'; ?>"
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
                                           value="Terakhir diubah: <?= isset($user->updated_at) ? date('d M Y H:i', strtotime($user->updated_at)) : 'Belum pernah'; ?>"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="border-top pt-4 mt-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="<?= site_url('admin/users'); ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-primary px-4 me-2" onclick="previewUser()">
                                    <i class="fas fa-eye me-2"></i>Preview
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Admin
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- User Tips -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>Panduan Admin
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Super Admin memiliki akses penuh</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Admin biasa tidak bisa mengelola admin lain</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Gunakan username valid untuk login</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Password minimal 6 karakter</small>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Quick Roles Info -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="fas fa-shield-alt me-2"></i>Perbandingan Role
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Fitur</th>
                                <th class="text-center">Admin</th>
                                <th class="text-center">Super Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><small>Pengumuman</small></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td><small>Berita</small></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td><small>Kelulusan</small></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td><small>Kategori Berita</small></td>
                                <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td><small>Tahun Kelulusan</small></td>
                                <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td><small>Kelola Admin</small></td>
                                <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                    <i class="fas fa-eye me-2"></i>Preview Admin User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="icon-wrapper mx-auto mb-3" style="width: 80px; height: 80px; background: #f0f9ff; color: #0ea5e9;">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                            <h3 id="previewName" class="fw-bold mb-2"></h3>
                            <div id="previewUsername" class="text-muted mb-3"></div>
                            <div id="previewRole" class="mb-4"></div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Admin ini akan memiliki akses untuk:
                            <ul class="mb-0 mt-2 ps-3">
                                <li id="access1">Mengelola <strong>pengumuman</strong></li>
                                <li id="access2">Mengelola <strong>berita</strong></li>
                                <li id="access3">Mengelola <strong>kelulusan</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('userForm').submit()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('passwordField');
    
    if (togglePassword && passwordField) {
        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle icon
            const icon = this.querySelector('i');
            if (type === 'text') {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                this.setAttribute('title', 'Sembunyikan password');
            } else {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                this.setAttribute('title', 'Tampilkan password');
            }
            
            // Update tooltip
            const tooltip = bootstrap.Tooltip.getInstance(this);
            if (tooltip) {
                tooltip.update();
            }
        });
    }
    
    // Password Strength Checker
    if (passwordField) {
        passwordField.addEventListener('input', function() {
            checkPasswordStrength(this.value);
        });
        
        function checkPasswordStrength(password) {
            let strength = 0;
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');
            
            if (!password) {
                strengthBar.style.width = '0%';
                strengthText.textContent = 'Kekuatan password: -';
                strengthBar.className = 'progress-bar';
                strengthText.className = 'text-muted';
                return;
            }
            
            // Length check
            if (password.length >= 6) strength++;
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            
            // Complexity checks
            if (/[A-Z]/.test(password)) strength++; // Uppercase letters
            if (/[a-z]/.test(password)) strength++; // Lowercase letters
            if (/[0-9]/.test(password)) strength++; // Numbers
            if (/[^A-Za-z0-9]/.test(password)) strength++; // Special characters
            
            // Calculate percentage
            const maxStrength = 7; // Maximum points
            const percentage = Math.min((strength / maxStrength) * 100, 100);
            
            // Update progress bar
            strengthBar.style.width = percentage + '%';
            
            // Set color and text based on strength
            if (strength <= 2) {
                // Weak
                strengthBar.className = 'progress-bar password-weak';
                strengthText.textContent = 'Kekuatan password: Lemah';
                strengthText.className = 'password-strength-text-weak';
            } else if (strength <= 4) {
                // Fair
                strengthBar.className = 'progress-bar password-fair';
                strengthText.textContent = 'Kekuatan password: Cukup';
                strengthText.className = 'password-strength-text-fair';
            } else if (strength <= 5) {
                // Good
                strengthBar.className = 'progress-bar password-good';
                strengthText.textContent = 'Kekuatan password: Baik';
                strengthText.className = 'password-strength-text-good';
            } else {
                // Strong
                strengthBar.className = 'progress-bar password-strong';
                strengthText.textContent = 'Kekuatan password: Kuat';
                strengthText.className = 'password-strength-text-strong';
            }
        }
        
        // Initialize on page load if there's a value
        if (passwordField.value) {
            checkPasswordStrength(passwordField.value);
        }
    }
    
    // Generate Random Password Button
    document.addEventListener('DOMContentLoaded', function() {
        // Add generate password button
        const passwordGroup = document.querySelector('#passwordField').closest('.input-group');
        if (passwordGroup) {
            // Create generate button
            const generateBtn = document.createElement('button');
            generateBtn.type = 'button';
            generateBtn.className = 'btn btn-outline-secondary';
            generateBtn.id = 'generatePassword';
            generateBtn.innerHTML = '<i class="fas fa-dice"></i>';
            generateBtn.setAttribute('data-bs-toggle', 'tooltip');
            generateBtn.setAttribute('title', 'Generate password acak');
            
            // Insert before toggle button
            passwordGroup.appendChild(generateBtn);
            
            // Initialize tooltip
            new bootstrap.Tooltip(generateBtn);
            
            // Generate password function
            generateBtn.addEventListener('click', async function() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
    let password = '';
    
    for (let i = 0; i < 12; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    
    // Set password ke field
    passwordField.value = password;
    passwordField.dispatchEvent(new Event('input'));

    // Copy ke clipboard
    try {
        await navigator.clipboard.writeText(password);
        showPasswordFeedback(password, true);
    } catch (err) {
        console.error('Gagal copy:', err);
        showPasswordFeedback(password, false);
    }
});

        }
    });
    
    function showPasswordFeedback(password, copied = false) {
    const feedback = document.createElement('div');
    feedback.className = 'alert alert-success alert-dismissible fade show mt-2';
    feedback.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            <div>
                <div class="fw-medium">
                    Password acak berhasil dibuat ${copied ? 'dan disalin!' : '!'}
                </div>
                <small class="text-muted">
                    ${copied ? 'Password sudah tersalin ke clipboard.' : ''}
                    <br>
                    <code class="bg-light px-2 py-1 rounded">${password}</code>
                </small>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    `;

    const passwordContainer = document.querySelector('#passwordField').closest('.mb-4');
    passwordContainer.appendChild(feedback);

    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(feedback);
        bsAlert.close();
    }, 5000);
}

    
    // Card radio selection (existing code)
    document.querySelectorAll('.card-radio .form-check-input').forEach(input => {
        input.addEventListener('change', function() {
            document.querySelectorAll('.card-radio .card').forEach(card => {
                card.classList.remove('border-primary', 'border-danger');
            });
            
            const label = this.closest('.form-check').querySelector('.card');
            if (this.value === 'super_admin') {
                label.classList.add('border-danger');
            } else {
                label.classList.add('border-primary');
            }
        });
    });
    
    // Preview function (existing code)
    function previewUser() {
        const name = document.querySelector('input[name="name"]').value;
        const username = document.querySelector('input[name="username"]').value;
        const roleInput = document.querySelector('input[name="role"]:checked');
        const password = document.querySelector('#passwordField').value;
        
        if (!name || !username || !roleInput) {
            alert('Harap isi semua field yang diperlukan!');
            return;
        }
        
        <?php if (!isset($user)): ?>
        if (!password || password.length < 6) {
            alert('Password harus minimal 6 karakter!');
            return;
        }
        <?php endif; ?>
        
        const role = roleInput.value;
        const roleText = role === 'super_admin' ? 'Super Admin' : 'Admin';
        const roleColor = role === 'super_admin' ? 'danger' : 'primary';
        const roleIcon = role === 'super_admin' ? 'fa-crown' : 'fa-user-shield';
        
        document.getElementById('previewName').textContent = name;
        document.getElementById('previewUsername').textContent = username;
        document.getElementById('previewRole').innerHTML = `
            <span class="badge bg-${roleColor} px-3 py-2">
                <i class="fas ${roleIcon} me-1"></i>${roleText}
            </span>
        `;
        
        // Update access list
        if (role === 'super_admin') {
            document.getElementById('access1').innerHTML = 'Mengelola <strong>semua data</strong>';
            document.getElementById('access2').innerHTML = 'Mengakses <strong>semua fitur</strong>';
            document.getElementById('access3').innerHTML = 'Mengelola <strong>admin lain</strong>';
        } else {
            document.getElementById('access1').innerHTML = 'Mengelola <strong>pengumuman</strong>';
            document.getElementById('access2').innerHTML = 'Mengelola <strong>berita</strong>';
            document.getElementById('access3').innerHTML = 'Mengelola <strong>kelulusan</strong>';
        }
        
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    }
    
    // Form validation (existing code)
    document.getElementById('userForm').addEventListener('submit', function(e) {
        const name = document.querySelector('input[name="name"]').value;
        const username = document.querySelector('input[name="username"]').value;
        const role = document.querySelector('input[name="role"]:checked');
        const password = document.querySelector('#passwordField').value;
        
        if (!name || !username || !role) {
            e.preventDefault();
            alert('Harap isi semua field yang diperlukan!');
            return;
        }
        
        <?php if (!isset($user)): ?>
        if (!password || password.length < 6) {
            e.preventDefault();
            alert('Password harus minimal 6 karakter!');
            return;
        }
        <?php endif; ?>
        
        // Username validation
        const usernameRegex = /^[a-zA-Z0-9_]+$/;
        if (!usernameRegex.test(username)) {
            e.preventDefault();
            alert('Format username tidak valid!');
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
    
    .card-radio .card {
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .card-radio .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .card-radio .form-check-input {
        display: none;
    }
    
    .card.border-primary {
        border-color: #4361ee !important;
        background-color: rgba(67, 97, 238, 0.05);
    }
    
    .card.border-danger {
        border-color: #ef4444 !important;
        background-color: rgba(239, 68, 68, 0.05);
    }
    
    .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .table-sm th, .table-sm td {
        padding: 0.5rem;
    }
</style>
<style>
    /* Password Strength Colors */
    .password-weak { background-color: #ef4444 !important; }
    .password-fair { background-color: #f59e0b !important; }
    .password-good { background-color: #3b82f6 !important; }
    .password-strong { background-color: #10b981 !important; }
    
    .password-strength-text-weak { color: #ef4444 !important; }
    .password-strength-text-fair { color: #f59e0b !important; }
    .password-strength-text-good { color: #3b82f6 !important; }
    .password-strength-text-strong { color: #10b981 !important; }
</style>