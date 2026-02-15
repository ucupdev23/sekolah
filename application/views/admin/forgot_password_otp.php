<div class="auth-wrapper">
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1 class="auth-title">Verifikasi OTP</h1>
            <p class="auth-subtitle">Masukkan kode verifikasi yang dikirim ke WhatsApp</p>
        </div>
        
        <!-- Body -->
        <div class="auth-body">
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

            <!-- Info Akun -->
            <div class="bg-light p-3 rounded-3 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Username</small>
                        <strong><?= htmlspecialchars($username ?? ''); ?></strong>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                        <i class="fab fa-whatsapp text-success"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">No WhatsApp</small>
                        <strong><?= htmlspecialchars($no_wa ?? ''); ?></strong>
                    </div>
                </div>
            </div>

            <!-- Info Masa Berlaku OTP (5 menit) -->
            <div class="alert alert-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-hourglass-half me-3 fa-lg"></i>
                    <div>
                        <strong>Kode OTP berlaku 5 menit</strong>
                        <br>
                        <small class="text-muted">Batas waktu: <span id="otpExpiry"><?= date('H:i', strtotime($expired_at)); ?></span> WIB</small>
                    </div>
                </div>
            </div>

            <!-- Kode OTP -->
            <div class="mb-4">
                <label class="form-label">Kode OTP</label>
                <div class="d-flex gap-2 justify-content-center mb-3">
                    <?php for($i = 1; $i <= 6; $i++): ?>
                        <input type="text" 
                               class="form-control otp-input-field text-center" 
                               maxlength="1" 
                               style="width: 50px; height: 60px; font-size: 24px; font-weight: 600; border: 2px solid #4f46e5;"
                               data-index="<?= $i ?>">
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="kode_otp" id="kode_otp">
                <small class="text-muted d-block text-center">
                    <i class="fas fa-info-circle me-1"></i>
                    Masukkan 6 digit kode yang dikirim ke WhatsApp Anda
                </small>
            </div>

            <!-- Timer Kirim Ulang (60 detik) -->
            <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-clock text-primary me-2"></i>
                    <span class="text-muted">Kirim ulang dalam</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary p-2 me-2" style="font-size: 18px; min-width: 60px;" id="resendTimer">60</span>
                    <span class="text-muted"> detik</span>
                </div>
            </div>

            <!-- Tombol Verifikasi -->
            <form action="<?= base_url('admin/forgot_password/verify'); ?>" method="post" id="otpForm">
                <input type="hidden" name="kode_otp" id="hiddenOtp">
                <button type="submit" class="btn btn-primary-custom mb-3" id="verifyBtn">
                    <i class="fas fa-check-circle me-2"></i>Verifikasi OTP
                </button>
            </form>

            <!-- Tombol Kirim Ulang -->
            <form method="post" action="<?= base_url('admin/forgot_password/resend'); ?>" id="resendForm" class="text-center">
                <button type="submit" 
                        class="btn btn-outline-primary" 
                        id="btnResend" 
                        disabled>
                    <i class="fas fa-redo-alt me-1"></i>Kirim Ulang
                </button>
            </form>

            <!-- Footer Links -->
            <div class="auth-footer">
                <a href="<?= base_url('admin/forgot_password'); ?>" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Halaman Sebelumnya
                </a>
                <span class="mx-2 text-muted">|</span>
                <a href="<?= base_url('admin/login'); ?>" class="back-link">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </a>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    // ========== TIMER KIRIM ULANG (60 DETIK) ==========
    <?php 
    $resend_at = $this->session->userdata('fp_resend_at');
    if ($resend_at && is_numeric($resend_at)): 
    ?>
        const resendAt = <?= (int)$resend_at * 1000; ?>;
        console.log('Timer menggunakan session:', new Date(resendAt));
    <?php else: ?>
        // Fallback 60 detik dari sekarang
        const resendAt = Date.now() + 60000;
        console.log('Timer menggunakan fallback');
    <?php endif; ?>
    
    const resendTimerEl = document.getElementById('resendTimer');
    const btnResend = document.getElementById('btnResend');
    
    if (!resendTimerEl || !btnResend) {
        console.error('Element timer tidak ditemukan!');
        return;
    }
    
    function updateResendTimer() {
        const now = Date.now();
        let remainingSeconds = Math.ceil((resendAt - now) / 1000);
        
        if (remainingSeconds <= 0) {
            resendTimerEl.textContent = '0';
            resendTimerEl.className = 'badge bg-success p-2';
            btnResend.disabled = false;
            btnResend.classList.remove('btn-outline-primary');
            btnResend.classList.add('btn-primary');
            return;
        }
        
        resendTimerEl.textContent = remainingSeconds;
        resendTimerEl.className = 'badge bg-primary p-2';
        btnResend.disabled = true;
        btnResend.classList.add('btn-outline-primary');
        btnResend.classList.remove('btn-primary');
        
        setTimeout(updateResendTimer, 1000);
    }
    
    updateResendTimer();
    
    // ========== OTP INPUT HANDLING ==========
    const otpInputs = document.querySelectorAll('.otp-input-field');
    const hiddenOtp = document.getElementById('hiddenOtp');
    
    if (otpInputs.length > 0) {
        // Auto-focus ke input pertama
        otpInputs[0].focus();
        
        // Handle input
        otpInputs.forEach((input, index) => {
            input.addEventListener('keyup', function(e) {
                const value = this.value;
                
                // Hanya angka
                if (value && !/^\d+$/.test(value)) {
                    this.value = '';
                    return;
                }
                
                // Pindah ke input berikutnya jika sudah diisi
                if (value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
                
                // Gabungkan semua nilai OTP
                let otpValue = '';
                otpInputs.forEach(input => {
                    otpValue += input.value;
                });
                hiddenOtp.value = otpValue;
            });
            
            input.addEventListener('keydown', function(e) {
                // Backspace: pindah ke input sebelumnya
                if (e.key === 'Backspace' && index > 0 && !this.value) {
                    otpInputs[index - 1].focus();
                }
            });
            
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text');
                const numbers = pasteData.replace(/\D/g, '').split('');
                
                if (numbers.length > 0) {
                    otpInputs.forEach((input, idx) => {
                        if (idx < numbers.length) {
                            input.value = numbers[idx];
                        }
                    });
                    
                    // Focus ke input setelah paste
                    if (numbers.length < otpInputs.length) {
                        otpInputs[numbers.length].focus();
                    } else {
                        otpInputs[otpInputs.length - 1].focus();
                    }
                    
                    // Update hidden input
                    let otpValue = '';
                    otpInputs.forEach(input => {
                        otpValue += input.value;
                    });
                    hiddenOtp.value = otpValue;
                }
            });
        });
    }
    
    // ========== FORM SUBMIT ==========
    const otpForm = document.getElementById('otpForm');
    const verifyBtn = document.getElementById('verifyBtn');
    
    otpForm.addEventListener('submit', function(e) {
        let otpValue = '';
        otpInputs.forEach(input => {
            otpValue += input.value;
        });
        
        if (otpValue.length !== 6) {
            e.preventDefault();
            alert('Masukkan 6 digit kode OTP');
            return;
        }
        
        hiddenOtp.value = otpValue;
        
        // Loading state
        verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memverifikasi...';
        verifyBtn.disabled = true;
    });
    
    // ========== RESEND FORM ==========
    const resendForm = document.getElementById('resendForm');
    resendForm.addEventListener('submit', function() {
        const resendBtn = document.getElementById('btnResend');
        resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
        resendBtn.disabled = true;
    });
})();
</script>

<style>
.otp-input-field {
    transition: all 0.3s ease;
}

.otp-input-field:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    transform: scale(1.05);
}

.otp-input-field:not(:placeholder-shown) {
    background-color: #f0f9ff;
    border-color: #4f46e5;
}
</style>