<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - SMA Negeri Contoh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Cache Control -->
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 400px;
        }
        
        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .login-header {
            background: #4f46e5;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .login-icon {
            font-size: 40px;
            margin-bottom: 15px;
            opacity: 0.9;
        }
        
        .login-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .login-subtitle {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .input-group .form-control {
            border-right: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        
        .input-group-text {
            background: white;
            border: 1.5px solid #d1d5db;
            border-left: 0;
            border-radius: 0 8px 8px 0;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.3s;
            padding: 0 16px;
        }
        
        .input-group-text:hover {
            background: #f9fafb;
            color: #4f46e5;
        }
        
        .btn-login {
            background: #4f46e5;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            padding: 14px;
            width: 100%;
            font-size: 16px;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            background: #4338ca;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .login-footer {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }
        
        .forgot-link {
            color: #4f46e5;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: color 0.3s;
        }
        
        .forgot-link:hover {
            color: #3730a3;
            text-decoration: underline;
        }
        
        .back-link {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 15px;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: #4b5563;
        }
        
        .demo-info {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 12px;
            margin-top: 20px;
            font-size: 13px;
            color: #0369a1;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .login-body {
                padding: 25px 20px;
            }
            
            .login-header {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1 class="login-title">Panel Admin</h1>
            <p class="login-subtitle">SMA Negeri Contoh</p>
        </div>
        
        <!-- Body -->
        <div class="login-body">
            <!-- Error Messages -->
            <?php if (validation_errors()): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="post" action="<?= site_url('admin/login'); ?>" id="loginForm">
                <!-- Username Field -->
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" 
                           name="username" 
                           class="form-control" 
                           placeholder="Masukkan username"
                           value="<?= set_value('username'); ?>" 
                           required
                           autocomplete="username"
                           autofocus>
                </div>

                <!-- Password Field with Toggle -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" 
                               name="password" 
                               id="passwordField"
                               class="form-control" 
                               placeholder="Masukkan password"
                               required
                               autocomplete="current-password">
                        <span class="input-group-text" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-login" id="loginButton">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>

                <!-- Forgot Password -->
                <div class="login-footer">
                    <a href="<?= base_url('admin/forgot_password'); ?>" class="forgot-link">
                        <i class="fas fa-question-circle"></i>
                        Lupa password akun? Reset di sini
                    </a>
                    <br>
                    <a href="<?= site_url('home'); ?>" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Beranda Sekolah
                    </a>
                </div>

                <!-- Demo Info -->
                <div class="demo-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Akun Demo:</strong> admin@sekolah.test / admin123
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Simple Forgot Password Modal -->
<div class="modal fade" id="forgotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-key me-2"></i>Reset Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">
                    Untuk reset password admin, silakan hubungi <strong>Super Admin</strong> yang bertugas.
                </p>
                <div class="alert alert-info">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Hubungi: superadmin@sekolah.test atau kontak IT sekolah
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('passwordField');
        
        if (togglePassword && passwordField) {
            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                // Toggle icon
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
        
        // Form loading state
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        
        if (loginForm && loginButton) {
            loginForm.addEventListener('submit', function() {
                // Show loading state
                loginButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                loginButton.disabled = true;
                
                // Re-enable after 3 seconds in case submission fails
                setTimeout(() => {
                    loginButton.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login';
                    loginButton.disabled = false;
                }, 3000);
            });
        }
        
        // Prevent back/forward cache issues
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || performance.navigation.type === 2) {
                window.location.reload();
            }
        });
        
        // Enter key submits form
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.target.closest('.modal')) {
                const activeElement = document.activeElement;
                if (activeElement && (activeElement.type === 'email' || activeElement.type === 'password')) {
                    e.preventDefault();
                    loginForm.submit();
                }
            }
        });
        
        // Auto-focus password field after email is filled
        const emailField = document.querySelector('input[name="email"]');
        if (emailField) {
            emailField.addEventListener('blur', function() {
                if (this.value && !passwordField.value) {
                    passwordField.focus();
                }
            });
        }
    });
</script>

</body>
</html>