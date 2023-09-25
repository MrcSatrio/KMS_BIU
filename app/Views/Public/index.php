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
                            <img src="<?= base_url('uploads/' . $document['berkas']); ?>" alt="<?= $document['judul'] ?>" class="d-block w-100">

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
    <?php if (!empty($highlight)): ?> <!-- Check if $highlight is not empty -->
        <h2>Berita Terbaru</h2>
        <?php foreach ($highlight as $high): 
            $id_highlight = base64_encode($high['id_dokumen']);
            ?>
            <div class="card mb-3">
                <img src="<?= base_url('uploads/' . $high['berkas']); ?>" class="card-img-top" alt="<?= $high['judul'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $high['nama_sorot']; ?></h5>
                    <p class="card-text"><?= substr($high['deskripsi_sorotan'], 0, 50) ?></p>
                    <?php if (session('id_role') === '1'): ?>
                        <a href="<?= base_url('admin/knowledge/' . $id_highlight) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                    <?php elseif (session('id_role') === '2'): ?>
                        <a href="<?= base_url('uploader/knowledge/' . $id_highlight) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                    <?php else: ?>
                        <a href="<?= base_url('knowledge/' . $id_highlight) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?> <!-- End of check for $highlight -->
</div>


        <!-- Container untuk Daftar Pengetahuan -->
        <div class="col-md-12 mt-5">
            <h2>Daftar Pengetahuan</h2>
            <form action="<?= base_url('search') ?>" method="post" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari pengetahuan..." name="pencarian" id="pencarian">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <?php foreach ($berkas as $document): 
                $id_dokumen = base64_encode($document['id_dokumen']);
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm custom-card">
                            <img src="<?= base_url('uploads/' . $document['berkas']); ?>" class="card-img-top custom-img" alt="<?= $document['judul'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $document['judul'] ?></h5>
                                <p class="card-text"><?= $document['nama_kategori'] ?></p>
                                <p class="card-text"><strong>Created By <?= $document['nama'] ?></strong></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <?php if (session('id_role') === '1'): ?>
                                            <a href="<?= base_url('admin/knowledge/' . $id_dokumen) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                                        <?php elseif (session('id_role') === '2'): ?>
                                            <a href="<?= base_url('uploader/knowledge/' . $id_dokumen) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                                        <?php else: ?>
                                            <a href="<?= base_url('knowledge/' . $id_dokumen) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
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

<!-- JavaScript untuk menetapkan tinggi yang sama ke kolom-kolom dalam satu baris -->
<style>
    .custom-card {
    display: flex;
    flex-direction: column;
    height: 100%; /* Setel tinggi kartu menjadi 100% tinggi parentnya */
}

.custom-card .card-img-top {
    height: 200px; /* Sesuaikan tinggi gambar sesuai kebutuhan */
}

</style>

<?php $this->endSection(); ?>
