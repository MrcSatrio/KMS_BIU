<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<?php
$flashsuccess = session()->getFlashdata('success');
$flasherror = session()->getFlashdata('error');
?>

<?php if (!empty($flashsuccess) || !empty($flasherror)): ?>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        <?php if (!empty($flashsuccess)): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                html: '<?php echo addslashes($flashsuccess); ?>'
            });
        <?php endif; ?>
        
        <?php if (!empty($flasherror)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '<?php echo addslashes($flasherror); ?>'
            });
        <?php endif; ?>
    });
</script>
<?php endif; ?>



    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php foreach ($berkas as $document): ?>
                <div class="col">
                    <div class="card shadow-sm">
                    <img src="<?= base_url('uploads/' . $document['berkas']); ?>" class="card-img-top" alt="Thumbnail" height="300px">
                        <div class="card-body">
                            <p class="card-text title"><?php echo $document['judul']; ?></p>
                            <p class="card-text smaller-text"><?php echo $document['nama_kategori']; ?></p> <!-- Add class for smaller text -->
                            <p class="card-text"><?php echo substr($document['deskripsi'], 0, 30); ?>...</p>   
                            <p class="card-text"><strong> Created By <?php echo $document['nama']; ?></strong></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                <a href="<?= base_url('knowledge/' . $document['id_dokumen']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat </a>
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
