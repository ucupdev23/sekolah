<!-- HERO -->
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3">Selamat Datang di <span class="text-accent">Nama Sekolah</span></h1>
                <p class="lead text-muted mb-4">
                    Sekolah yang berkomitmen membentuk generasi berkarakter, berprestasi,
                    dan berakhlak mulia.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#profil" class="btn btn-primary btn-lg">Lihat Profil</a>
                    <a href="https://forms.gle/..." target="_blank" class="btn btn-outline-light btn-lg">
                        PPDB Online
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-card shadow-lg">
                    <p class="small text-uppercase text-muted mb-2">Info terbaru</p>
                    <?php if (!empty($announcements)): ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($announcements as $a): ?>
                                <li class="mb-2">
                                    <span class="badge bg-warning-subtle text-warning me-2">
                                        <?= date('d/m', strtotime($a->published_at)); ?>
                                    </span>
                                    <a href="<?= site_url('pengumuman'); ?>" class="link-light text-decoration-none">
                                        <?= htmlspecialchars($a->title); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted mb-0">Belum ada pengumuman terbaru.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION PROFIL, PENGUMUMAN, BERITA, KELULUSAN -->
<section id="profil" class="py-5 section-soft-bg">
    <div class="container">
        <h2 class="section-title mb-3">Profil Sekolah</h2>
        <p class="text-muted mb-0">
            (isi profil, visi misi, dll. yang kemarin masih hardcode, tinggal pindahkan ke sini)
        </p>
    </div>
</section>

<section id="pengumuman" class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0">Pengumuman Terbaru</h2>
            <a href="<?= site_url('pengumuman'); ?>" class="link-primary">Lihat semua</a>
        </div>
        <div class="row g-3">
            <?php foreach ($announcements as $item): ?>
                <div class="col-md-4">
                    <div class="card card-soft h-100">
                        <div class="card-body">
                            <small class="text-muted d-block mb-1">
                                <?= date('d F Y', strtotime($item->published_at)); ?>
                            </small>
                            <h5 class="card-title mb-2">
                                <?= htmlspecialchars($item->title); ?>
                            </h5>
                            <a href="<?= site_url('pengumuman'); ?>" class="stretched-link small">
                                Selengkapnya →
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($announcements)): ?>
                <p class="text-muted">Belum ada pengumuman.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="berita" class="py-5 section-soft-bg">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0">Berita Sekolah</h2>
            <a href="<?= site_url('berita'); ?>" class="link-primary">Lihat semua</a>
        </div>
        <div class="row g-3">
            <?php foreach ($news as $n): ?>
                <div class="col-md-4">
                    <div class="card card-soft h-100">
                        <?php if (!empty($n->thumbnail_path)): ?>
                            <img src="<?= base_url($n->thumbnail_path); ?>" class="card-img-top" alt="">
                        <?php endif; ?>
                        <div class="card-body">
                            <small class="text-muted d-block mb-1">
                                <?= date('d F Y', strtotime($n->published_at)); ?>
                            </small>
                            <h5 class="card-title mb-2"><?= htmlspecialchars($n->title); ?></h5>
                            <a href="<?= site_url('berita/detail/'.$n->slug); ?>" class="stretched-link small">
                                Baca selengkapnya →
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($news)): ?>
                <p class="text-muted">Belum ada berita.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="kelulusan" class="py-5">
    <div class="container">
        <h2 class="section-title mb-3">Data Kelulusan</h2>
        <p class="text-muted mb-3">
            Lihat data kelulusan dan CV alumni pada halaman berikut:
        </p>
        <a href="<?= site_url('kelulusan'); ?>" class="btn btn-outline-primary">
            Lihat Data Kelulusan →
        </a>
    </div>
</section>
