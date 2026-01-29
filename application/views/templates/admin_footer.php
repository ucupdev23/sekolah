<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS for animations -->
<script>
    // Add active class animation
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.admin-nav .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Add hover effect to cards
        const cards = document.querySelectorAll('.dashboard-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
<script>
    // Simple and reliable sidebar toggle
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (toggleBtn && sidebar) {
        // Show/hide toggle button based on screen size
        function checkScreenSize() {
            if (window.innerWidth < 992) {
                toggleBtn.style.display = 'flex';
            } else {
                toggleBtn.style.display = 'none';
                sidebar.classList.remove('show');
                if (overlay) overlay.classList.remove('show');
            }
        }
        
        // Toggle sidebar function
        function toggleSidebar() {
            const isOpening = !sidebar.classList.contains('show');
            sidebar.classList.toggle('show');
            if (overlay) overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            
            // Toggle hamburger button visibility
            if (isOpening) {
                toggleBtn.style.opacity = '0';
                toggleBtn.style.visibility = 'hidden';
                toggleBtn.style.pointerEvents = 'none';
            } else {
                setTimeout(() => {
                    toggleBtn.style.opacity = '1';
                    toggleBtn.style.visibility = 'visible';
                    toggleBtn.style.pointerEvents = 'auto';
                }, 300); // Match with CSS transition
            }
        }
        
        // Event listeners
        toggleBtn.addEventListener('click', toggleSidebar);
        
        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }
        
        // Close button in sidebar
        const closeBtn = document.getElementById('closeSidebar');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                toggleSidebar();
                // Reset hamburger button
                setTimeout(() => {
                    toggleBtn.style.opacity = '1';
                    toggleBtn.style.visibility = 'visible';
                    toggleBtn.style.pointerEvents = 'auto';
                }, 300);
            });
        }
        
        // Close sidebar when clicking nav links on mobile
        const navLinks = document.querySelectorAll('.admin-nav .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    toggleSidebar();
                    // Reset hamburger button
                    setTimeout(() => {
                        toggleBtn.style.opacity = '1';
                        toggleBtn.style.visibility = 'visible';
                        toggleBtn.style.pointerEvents = 'auto';
                    }, 300);
                }
            });
        });
        
        // Initial check
        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);
        
        // Ensure hamburger button is visible when sidebar is closed
        if (!sidebar.classList.contains('show')) {
            toggleBtn.style.opacity = '1';
            toggleBtn.style.visibility = 'visible';
            toggleBtn.style.pointerEvents = 'auto';
        }
    }
</script>
<!-- Toast Container -->
<div id="toastContainer" style="
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
"></div>

<style>
    .toast {
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .toast-body {
        padding: 12px 16px;
    }
</style>
</body>
</html>