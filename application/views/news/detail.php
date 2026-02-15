

<!-- HERO DETAIL BERITA -->
<section class="py-5 bg-white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('berita'); ?>" class="text-decoration-none">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Berita Content -->
                <article class="card-public">
                    <?php if (!empty($news->thumbnail_path)): ?>
                        <div class="card-img-container">
                            <img src="<?= base_url('uploads/news/' . $news->thumbnail_path); ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($news->title); ?>"
                                 style="max-height: 400px; object-fit: cover;">
                            <div class="card-img-overlay-top">
                                <span class="badge bg-primary">
                                    <?= htmlspecialchars($news->category_name); ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body p-4">
                        <!-- Header -->
                        <div class="mb-4">
                            <h1 class="fw-bold mb-3"><?= htmlspecialchars($news->title); ?></h1>
                            
                            <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Diterbitkan</small>
                                        <strong><?= date('d F Y', strtotime($news->published_at)); ?></strong>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                                        <i class="fas fa-tag text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Kategori</small>
                                        <strong><?= htmlspecialchars($news->category_name); ?></strong>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2">
                                        <i class="fas fa-user text-warning"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Penulis</small>
                                        <strong>Admin Sekolah</strong>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (isset($news->excerpt)): ?>
                                <div class="alert alert-info">
                                    <div class="d-flex">
                                        <i class="fas fa-quote-left mt-1 me-3"></i>
                                        <div>
                                            <p class="mb-0"><?= htmlspecialchars($news->excerpt); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Content -->
                        <div class="content-body mb-5">
                            <?= $news->content; ?>
                        </div>
                        
                        <!-- Metadata -->
                        <div class="border-top pt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-2">
                                        <i class="fas fa-info-circle me-1"></i>Informasi Berita
                                    </small>
                                    <div>
                                        <small class="d-block">
                                            <strong>Kategori:</strong> 
                                            <?= htmlspecialchars($news->category_name); ?>
                                        </small>
                                        <small class="d-block mt-1">
                                            <strong>Dibuat:</strong> 
                                            <?= date('d M Y H:i', strtotime($news->created_at)); ?>
                                        </small>
                                        <?php if ($news->updated_at && $news->updated_at != $news->created_at): ?>
                                            <small class="d-block mt-1">
                                                <strong>Diperbarui:</strong> 
                                                <?= date('d M Y H:i', strtotime($news->updated_at)); ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <small class="text-muted d-block mb-2">
                                        <i class="fas fa-share-alt me-1"></i>Bagikan Berita
                                    </small>
                                    <div class="d-flex gap-2">
                                        <button onclick="shareNews('facebook')" class="btn btn-sm btn-outline-primary">
                                            <i class="fab fa-facebook-f me-1"></i>Facebook
                                        </button>
                                        <button onclick="shareNews('twitter')" class="btn btn-sm btn-outline-info">
                                            <i class="fab fa-twitter me-1"></i>Twitter
                                        </button>
                                        <button onclick="shareNews('whatsapp')" class="btn btn-sm btn-outline-success">
                                            <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                
                <!-- Related Berita -->
                <?php if (!empty($related_news)): ?>
                    <div class="mt-5">
                        <h4 class="fw-bold mb-4">
                            <i class="fas fa-newspaper me-2"></i>Berita Terkait
                        </h4>
                        <div class="row g-3">
                            <?php foreach ($related_news as $related): ?>
                                <div class="col-md-4">
                                    <div class="card-public">
                                        <?php if (!empty($related->thumbnail_path)): ?>
                                            <img src="<?= base_url('uploads/news/' . $related->thumbnail_path); ?>" 
                                                 class="card-img-top" 
                                                 alt="<?= htmlspecialchars($related->title); ?>"
                                                 style="height: 150px; object-fit: cover;">
                                        <?php endif; ?>
                                        <div class="card-body p-3">
                                            <small class="badge bg-primary mb-2">
                                                <?= htmlspecialchars($related->category_name); ?>
                                            </small>
                                            <h6 class="fw-semibold mb-2">
                                                <a href="<?= site_url('berita/detail/'.$related->slug); ?>" class="text-decoration-none text-dark">
                                                    <?= htmlspecialchars($related->title); ?>
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <?= date('d M Y', strtotime($related->published_at)); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Navigation -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="<?= site_url('berita'); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                    <div>
                        <!-- <button onclick="window.print()" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-print me-2"></i>Cetak
                        </button> -->
                        <button onclick="shareNews('all')" class="btn btn-outline-primary">
                            <i class="fas fa-share-alt me-2"></i>Bagikan
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4 mt-5 mt-lg-0">
                <!-- Categories -->
                <div class="card-public mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-tags text-primary me-2"></i>
                            Kategori Berita
                        </h6>
                        <div class="list-group list-group-flush">
                            <a href="<?= site_url('berita'); ?>" 
                               class="list-group-item list-group-item-action border-0 px-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Semua Berita</span>
                                    <span class="badge bg-primary rounded-pill"><?= $total_news ?? 0; ?></span>
                                </div>
                            </a>
                            <?php foreach ($categories as $cat): ?>
                                <a href="<?= site_url('berita?kategori=' . $cat->slug); ?>" 
                                   class="list-group-item list-group-item-action border-0 px-0 py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><?= htmlspecialchars($cat->name); ?></span>
                                        <span class="badge bg-light text-dark rounded-pill"><?= $cat->count ?? 0; ?></span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Berita -->
                <?php if (!empty($recent_news)): ?>
                    <div class="card-public">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-clock text-primary me-2"></i>
                                Berita Terbaru
                            </h6>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recent_news as $recent): ?>
                                    <a href="<?= site_url('berita/detail/'.$recent->slug); ?>" 
                                       class="list-group-item list-group-item-action border-0 px-0 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-semibold mb-1"><?= htmlspecialchars($recent->title); ?></h6>
                                                <small class="text-muted">
                                                    <?= date('d M Y', strtotime($recent->published_at)); ?>
                                                </small>
                                            </div>
                                            <?php if (!empty($recent->thumbnail_path)): ?>
                                                <img src="<?= base_url('uploads/news/' . $recent->thumbnail_path); ?>" 
                                                     alt="Thumbnail" 
                                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
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
                        <h6 class="fw-bold mb-3">Ada informasi kegiatan?</h6>
                        <p class="small text-muted mb-3">
                            Jika ada kegiatan sekolah yang ingin dipublikasikan, 
                            kirimkan informasi ke tim humas.
                        </p>
                        <a href="mailto:humas@smacontoh.sch.id" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Berita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Print Styles -->
<style media="print">
    @media print {
        nav, .breadcrumb, .sidebar, .btn, .alert, .related-news {
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
        
        img {
            max-height: 300px !important;
        }
    }
</style>

<script>
    function shareNews(platform) {
        const title = '<?= htmlspecialchars(addslashes($news->title)); ?>';
        const url = window.location.href;
        const text = '<?= htmlspecialchars(addslashes($news->excerpt ?? "Berita dari SMA Negeri Contoh")); ?>';
        
        let shareUrl = '';
        
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`;
                break;
            case 'whatsapp':
                shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(title + ' ' + url)}`;
                break;
            default:
                // Web Share API
                if (navigator.share) {
                    navigator.share({
                        title: title,
                        text: text,
                        url: url
                    });
                    return;
                } else {
                    // Fallback: copy to clipboard
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Link berita telah disalin ke clipboard!');
                    });
                    return;
                }
        }
        
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
</script>