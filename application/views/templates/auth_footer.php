<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Password Visibility (if exists)
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
        const authForm = document.querySelector('form');
        const submitBtn = authForm?.querySelector('button[type="submit"]');
        
        if (authForm && submitBtn) {
            authForm.addEventListener('submit', function() {
                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;
            });
        }
        
        // Timer for OTP (if exists)
        const timerElement = document.getElementById('timer');
        if (timerElement) {
            let timeLeft = parseInt(timerElement.getAttribute('data-time')) || 300; // 5 minutes default
            
            const timer = setInterval(function() {
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    timerElement.innerHTML = 'Kode OTP kadaluarsa';
                    timerElement.classList.add('text-danger');
                    
                    // Show resend button
                    const resendBtn = document.getElementById('resendBtn');
                    if (resendBtn) {
                        resendBtn.classList.remove('d-none');
                    }
                } else {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timerElement.innerHTML = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                    timeLeft--;
                }
            }, 1000);
        }
        
        // Auto-focus OTP inputs
        const otpInputs = document.querySelectorAll('.otp-input-field');
        if (otpInputs.length > 0) {
            otpInputs.forEach((input, index) => {
                input.addEventListener('keyup', function(e) {
                    if (e.key >= '0' && e.key <= '9' && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });
                
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && index > 0 && !this.value) {
                        otpInputs[index - 1].focus();
                    }
                });
            });
            
            otpInputs[0].focus();
        }
    });
</script>
</body>
</html>