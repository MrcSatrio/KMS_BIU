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
            <?php for ($i = 0; $i < 8; $i++) { ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <img src="https://via.placeholder.com/225" class="card-img-top" alt="Thumbnail">
                        <div class="card-body">
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                <a href="<?= base_url('knowledge') ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat </a>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    
<?php $this->endSection(); ?>
