<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
</main>

<style>
    .footer-public {
    background-color: #0f172a; /* gelap elegan */
    color: #e5e7eb;
}

.footer-public .text-muted {
    color: #9ca3af !important; /* muted tapi tetap kebaca */
}

.footer-public a {
    color: #cbd5f5;
    text-decoration: none;
}

.footer-public a:hover {
    color: #ffffff;
}

/* Scroll to top button */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-blue);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }
        
        .scroll-top.active {
            opacity: 1;
            visibility: visible;
        }
        
        .scroll-top:hover {
            transform: translateY(-5px);
            background: var(--primary-dark);
        }

</style>

<!-- FOOTER PUBLIC -->
<footer class="footer-public py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="mb-4">
                    <a class="navbar-brand text-white mb-3" href="<?= site_url('home'); ?>">
                        <span class="school-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        SMA Negeri Contoh
                    </a>
                    <p class="text-muted">
                        Sekolah unggulan dengan komitmen membentuk generasi penerus bangsa yang berkarakter, 
                        berprestasi, dan berdaya saing global.
                    </p>
                </div>
                
                <div class="social-icons mb-4">
                    <a href="#" title="Facebook" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" title="Instagram" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" title="YouTube" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" title="Twitter" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-phone text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Hotline</small>
                        <strong class="text-white">(021) 123-4567</strong>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4">
                <div class="footer-links">
                    <h6>Menu Utama</h6>
                    <a href="<?= site_url('home'); ?>">Beranda</a>
                    <a href="<?= site_url('home') . '#profil'; ?>">Profil Sekolah</a>
                    <a href="<?= site_url('home') . '#visi-misi'; ?>">Visi & Misi</a>
                    <a href="<?= site_url('home') . '#struktur'; ?>">Struktur Organisasi</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4">
                <div class="footer-links">
                    <h6>Informasi</h6>
                    <a href="<?= site_url('pengumuman'); ?>">Pengumuman</a>
                    <a href="<?= site_url('berita'); ?>">Berita Sekolah</a>
                    <a href="<?= site_url('kelulusan'); ?>">Info Kelulusan</a>
                    <a href="https://forms.gle/PPDB_GOOGLE_FORM" target="_blank">PPDB Online</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4">
                <div class="footer-links">
                    <h6>Kontak & Alamat</h6>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted">Alamat</small>
                            <p class="mb-0 text-white">Jl. Pendidikan No. 123<br>Kota Contoh, 12345</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <i class="fas fa-envelope text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted">Email</small>
                            <p class="mb-0 text-white">info@smacontoh.sch.id</p>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-clock text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted">Jam Operasional</small>
                            <p class="mb-0 text-white">Senin-Jumat<br>07.00-15.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="my-4 border-secondary">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-muted">
                    &copy; <?= date('Y'); ?> SMA Negeri Contoh. Semua hak dilindungi.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-muted">
                    Dikembangkan oleh <strong class="text-white">Tim IT Sekolah</strong>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Script -->
<script>
    // Navbar active state
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Tooltip initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Scroll to top button
    const scrollTopBtn = document.createElement('div');
    scrollTopBtn.className = 'scroll-top';
    scrollTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    document.body.appendChild(scrollTopBtn);
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.add('active');
        } else {
            scrollTopBtn.classList.remove('active');
        }
    });
    
    scrollTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    });
</script>
</body>
</html>