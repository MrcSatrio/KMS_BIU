<?= $this->extend('template/index'); ?>
<?php $this->section('container'); ?>

       <!-- Konten Utama -->
    <div class="container mt-5">
        <div class="row">
            <!-- Carousel (Slideshow Pengumuman) -->
            <div class="col-md-9">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php foreach ($event as $key => $document): ?>
                            <li data-bs-target="#myCarousel" data-bs-slide-to="<?= $key ?>" <?= $key === 0 ? 'class="active"' : '' ?>></li>
                        <?php endforeach; ?>
                    </ol>

                    <!-- Slides -->
                    <div class="carousel-inner">
                        <?php foreach ($event as $key => $document): ?>
                            <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                                <img src="<?= base_url('uploads/' . $document['berkas']); ?>" alt="<?= $document['judul'] ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Controls -->
                    <a class="carousel-control-prev" href="#myCarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>

            <!-- Kolom Berita Terbaru -->
            <div class="col-md-3">
                <h2>Berita Terbaru</h2>
                <div class="card mb-3">
                    <img src="berita1.jpg" class="card-img-top" alt="Berita 1">
                    <div class="card-body">
                        <h5 class="card-title">Pengumuman Penting</h5>
                        <p class="card-text">Pengumuman terbaru tentang perubahan dalam KMS. Baca selengkapnya...</p>
                        <a href="#" class="btn btn-primary">Baca Lebih Lanjut</a>
                    </div>
                </div>
                <div class="card mb-3">
                    <img src="berita2.jpg" class="card-img-top" alt="Berita 2">
                    <div class="card-body">
                        <h5 class="card-title">Perkembangan Terbaru</h5>
                        <p class="card-text">Pelajari perkembangan terbaru dalam manajemen pengetahuan. Baca selengkapnya...</p>
                        <a href="#" class="btn btn-primary">Baca Lebih Lanjut</a>
                    </div>
                </div>
            </div>

            <!-- Container untuk Daftar Pengetahuan -->
            <div class="col-md-12 mt-5">
                <h2>Daftar Pengetahuan</h2>
                <div class="row">
                    <?php foreach ($berkas as $document): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm">
                                <img src="<?= base_url('uploads/' . $document['berkas']); ?>" class="card-img-top" alt="<?= $document['judul'] ?>" height="200px">
                                <div class="card-body">
                                    <p class="card-text title"><?= $document['judul'] ?></p>
                                    <p class="card-text smaller-text"><?= $document['nama_kategori'] ?></p>
                                    <p class="card-text"><strong>Created By <?= $document['nama'] ?></strong></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <?php if (session('id_role') === '1'): ?>
                                                <a href="<?= base_url('admin/knowledge/' . $document['id_dokumen']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                                            <?php elseif (session('id_role') === '2'): ?>
                                                <a href="<?= base_url('uploader/knowledge/' . $document['id_dokumen']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                                            <?php else: ?>
                                                <a href="<?= base_url('knowledge/' . $document['id_dokumen']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted">9 mins</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


<?php $this->endSection(); ?>
