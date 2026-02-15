<div class="auth-wrapper">
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-key"></i>
            </div>
            <h1 class="auth-title">Lupa Password</h1>
            <p class="auth-subtitle">Reset password akun admin Anda</p>
        </div>
        
        <!-- Body -->
        <div class="auth-body">
            <!-- Info -->
            <div class="text-center mb-4">
                <p class="text-muted small mb-0">
                    Masukkan <strong>Username</strong> atau <strong>nomor WhatsApp</strong> yang terdaftar. 
                    Kami akan mengirimkan kode OTP ke WhatsApp Anda.
                </p>
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

            <!-- Form -->
            <form action="<?= base_url('admin/forgot_password/process'); ?>" method="post">
                <div class="mb-4">
                    <label class="form-label">Username / No WhatsApp</label>
                    <input type="text" 
                           name="identifier" 
                           class="form-control" 
                           placeholder="Masukkan username atau nomor WhatsApp"
                           value="<?= set_value('identifier'); ?>"
                           required
                           autofocus>
                </div>
                
                <button type="submit" class="btn btn-primary-custom mb-3">
                    <i class="fab fa-whatsapp me-2"></i>Kirim OTP ke WhatsApp
                </button>
            </form>

            <!-- Footer Links -->
            <div class="auth-footer">
                <a href="<?= base_url('admin/login'); ?>" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Login
                </a>
            </div>

            <!-- Info -->
            <div class="text-center mt-3">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Pastikan nomor WhatsApp sudah terdaftar di data user.
                </small>
            </div>
        </div>
    </div>
</div>