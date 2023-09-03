<?= $this->extend('template/index'); ?>
<?php $this->section('container'); ?>

<div class="container">

<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($berkas as $key => $document): ?>
            <li data-bs-target="#myCarousel" data-bs-slide-to="<?= $key ?>" <?= $key === 0 ? 'class="active"' : '' ?>></li>
        <?php endforeach; ?>
    </ol>

    <!-- Slides -->
    <div class="carousel-inner">
        <?php foreach ($berkas as $key => $document): ?>
            <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                <img src="<?= base_url('uploads/' . $document['berkas']); ?>" alt="<?= $document['judul'] ?>">
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Tombol Next/Prev -->
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </a>
</div>
<br>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php foreach ($berkas as $document): ?>
            <div class="col">
                <div class="card shadow-sm">
                    <img src="<?= base_url('uploads/' . $document['berkas']); ?>" class="card-img-top" alt="<?= $document['judul'] ?>" height="300px">
                    <div class="card-body">
                        <p class="card-text title"><?= $document['judul'] ?></p>
                        <p class="card-text smaller-text"><?= $document['nama_kategori'] ?></p>
                        <p class="card-text"><strong> Created By <?= $document['nama'] ?></strong></p>
                        <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
    <?php if (session('id_role') === '1'): ?>
        <a href="<?= base_url('admin/knowledge/' . $document['id_dokumen']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat </a>
    <?php elseif (session('id_role') === '2'): ?>
        <a href="<?= base_url('uploader/knowledge/' . $document['id_dokumen']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat </a>
    <?php else: ?>
        <a href="<?= base_url('knowledge/' . $document['id_dokumen']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat </a>
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

<?php $this->endSection(); ?>
