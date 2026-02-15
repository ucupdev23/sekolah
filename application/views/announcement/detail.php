

<!-- HERO DETAIL PENGUMUMAN -->
<section class="py-5 bg-white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('pengumuman'); ?>" class="text-decoration-none">Pengumuman</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Pengumuman Content -->
                <article class="card-public">
                    <div class="card-body p-4">
                        <!-- Header -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge-public">
                                    <i class="fas fa-bullhorn me-2"></i>Pengumuman Resmi
                                </span>
                                <?php if ($announcement->is_important): ?>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Penting
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <h1 class="fw-bold mb-3"><?= htmlspecialchars($announcement->title); ?></h1>
                            
                            <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Diterbitkan</small>
                                        <strong><?= date('d F Y', strtotime($announcement->published_at)); ?></strong>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                                        <i class="fas fa-clock text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Waktu</small>
                                        <strong><?= date('H:i', strtotime($announcement->published_at)); ?> WIB</strong>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (isset($announcement->excerpt)): ?>
                                <div class="alert alert-info">
                                    <div class="d-flex">
                                        <i class="fas fa-info-circle mt-1 me-3"></i>
                                        <div>
                                            <p class="mb-0"><?= htmlspecialchars($announcement->excerpt); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Content -->
                        <div class="content-body mb-5">
                            <?= nl2br(htmlspecialchars($announcement->body)); ?>
                        </div>
                        
                        <!-- Metadata -->
                        <div class="border-top pt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-2">
                                        <i class="fas fa-user me-1"></i>Diterbitkan oleh
                                    </small>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-md rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3">
                                            <i class="fas fa-user-tie text-primary"></i>
                                        </div>
                                        <div>
                                            <strong>Admin Sekolah</strong>
                                            <small class="text-muted d-block">SMA Negeri Contoh</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <small class="text-muted d-block mb-2">
                                        <i class="fas fa-calendar me-1"></i>Informasi Tanggal
                                    </small>
                                    <div>
                                        <small class="d-block">
                                            <strong>Dibuat:</strong> 
                                            <?= date('d M Y H:i', strtotime($announcement->created_at)); ?>
                                        </small>
                                        <?php if ($announcement->updated_at && $announcement->updated_at != $announcement->created_at): ?>
                                            <small class="d-block mt-1">
                                                <strong>Diperbarui:</strong> 
                                                <?= date('d M Y H:i', strtotime($announcement->updated_at)); ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                
                <!-- Navigation -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="<?= site_url('pengumuman'); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                    <div>
                        <!-- <button onclick="window.print()" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-print me-2"></i>Cetak
                        </button> -->
                        <button onclick="sharePengumuman()" class="btn btn-outline-primary">
                            <i class="fas fa-share-alt me-2"></i>Bagikan
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4 mt-5 mt-lg-0">
                <!-- Info Box -->
                <div class="card-public mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informasi Pengumuman
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <small class="text-muted d-block">ID Pengumuman</small>
                                <strong>#<?= $announcement->id; ?></strong>
                            </li>
                            <li class="mb-2">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge <?= $announcement->is_important ? 'bg-warning' : 'bg-success'; ?>">
                                    <?= $announcement->is_important ? 'Penting' : 'Normal'; ?>
                                </span>
                            </li>
                            <li>
                                <small class="text-muted d-block">Tanggal Publikasi</small>
                                <strong><?= date('d M Y H:i', strtotime($announcement->published_at)); ?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Related Pengumuman -->
                <?php if (!empty($related_announcements)): ?>
                    <div class="card-public">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-newspaper text-primary me-2"></i>
                                Pengumuman Lainnya
                            </h6>
                            <div class="list-group list-group-flush">
                                <?php foreach ($related_announcements as $related): ?>
                                    <a href="<?= site_url('pengumuman/'.$related->id); ?>" 
                                       class="list-group-item list-group-item-action border-0 px-0 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-semibold mb-1"><?= htmlspecialchars($related->title); ?></h6>
                                                <small class="text-muted">
                                                    <?= date('d M Y', strtotime($related->published_at)); ?>
                                                </small>
                                            </div>
                                            <?php if ($related->is_important): ?>
                                                <span class="badge bg-warning rounded-pill">!</span>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- CTA Box -->
                <div class="card-public mt-4 bg-primary bg-opacity-5 border-primary">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">Butuh bantuan?</h6>
                        <p class="small text-muted mb-3">
                            Jika ada pertanyaan terkait pengumuman ini, 
                            jangan ragu untuk menghubungi kami.
                        </p>
                        <a href="mailto:info@smacontoh.sch.id" class="btn btn-primary w-100">
                            <i class="fas fa-envelope me-2"></i>Hubungi Sekolah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Print Styles (hidden) -->
<style media="print">
    @media print {
        nav, .breadcrumb, .sidebar, .btn, .alert {
            display: none !important;
        }
        
        .container {
            width: 100% !important;
            max-width: 100% !important;
        }
        
        .card-public {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        
        body {
            background: white !important;
            color: black !important;
        }
    }
</style>

<script>
    function sharePengumuman() {
        if (navigator.share) {
            navigator.share({
                title: '<?= htmlspecialchars($announcement->title); ?>',
                text: 'Pengumuman dari SMA Negeri Contoh',
                url: window.location.href
            })
            .then(() => console.log('Berhasil dibagikan'))
            .catch((error) => console.log('Error sharing:', error));
        } else {
            // Fallback untuk browser yang tidak support Web Share API
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link pengumuman telah disalin ke clipboard!');
            });
        }
    }
</script>