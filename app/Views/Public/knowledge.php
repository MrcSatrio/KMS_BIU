<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<link href="//vjs.zencdn.net/8.3.0/video-js.min.css" rel="stylesheet">
<script src="//vjs.zencdn.net/8.3.0/video.min.js"></script>
<script src="<?= base_url("videojs-youtube\dist\Youtube.min.js") ?>"></script>

<body>
  <div class="container mt-3">
    <div class="jumbotron text-center">
      <h5 class="display-4"><?= $document['judul'] ?></h5>
      <p class="lead"><?= $document['nama_kategori'] ?></p>
    </div>
    <style>
        .video-container {
  position: relative;
  padding-bottom: 56.25%; /* Untuk video 16:9, gunakan 75% untuk 4:3 */
  height: 0;
  overflow: hidden;
}

.video-js {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

        </style>
    <?php if (!empty($document['video'])): ?>
        <div class="video-container">
  <video
    id="my-video"
    class="video-js vjs-default-skin"
    controls
    autoplay
    width="100%"
    height="auto"
    data-setup='{
      "techOrder": ["youtube"],
      "sources": [
        { "type": "video/youtube", "src": "<?= $document['video'] ?>" }
      ]
    }'>
  </video>
</div>


    <?php endif; ?>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="media">
                <div class="media-body">
                    <h5 class="mt-0"><?= $document['nama'] ?></h5>
                    <p class="mb-1" id="video-stats">Diupload <?= date('d F Y', strtotime($bk['created_at'])) ?></p>
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
