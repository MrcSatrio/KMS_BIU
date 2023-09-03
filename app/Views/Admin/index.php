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
<?= $this->extend('Public/index'); ?>
    
<?php $this->endSection(); ?>
