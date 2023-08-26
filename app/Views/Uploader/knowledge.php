<?= $this->extend('uploader/template/index'); ?>

<?php $this->section('container'); ?>
<div class="container mt-3">
    <div class="jumbotron text-center">
        <h5 class="display-4"><?= $document['judul'] ?></h5>
        <p class="lead"><?= $document['nama_kategori'] ?></p>
    </div>
    <?php if (!empty($document['video'])): ?>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="<?= $document['video'] ?>" allowfullscreen></iframe>
        </div>
    <?php endif; ?>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="media">
                <div class="media-body">
                    <h5 class="mt-0"><?= $document['nama'] ?></h5>
                    <p class="mb-1" id="video-stats">Diupload <?= date('d F Y', strtotime($document['created_at'])) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-right">
            <button class="btn btn-warning rounded-pill mt-2"><i class="fas fa-thumbs-up"></i> 0.0</button>
            <button class="btn btn-primary rounded-pill mt-2" id="share-button"><i class="fas fa-share"></i> Bagikan</button>
        </div>
    </div>
    <div class="mt-4">
        <p><?= $document['deskripsi'] ?></p>
    </div>
</div>

<script>
    const shareButton = document.getElementById('share-button');
    shareButton.addEventListener('click', function() {
        const documentId = <?= $document['id_dokumen'] ?>;
        const shareLink = window.location.origin + '/knowledge/' + documentId;
        alert('Bagikan link: ' + shareLink);
    });
</script>


<?php $this->endSection(); ?>
