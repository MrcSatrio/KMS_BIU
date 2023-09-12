<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<div class="row">
    <div class="col-md-6">
        <h2>Edit Foto Profil</h2>
        <form action="<?= base_url('uploader/photo_profile/update_action') ?>" enctype="multipart/form-data" method="post">
        <img src="<?= base_url('uploads/' . $akun['foto_profile']); ?>" alt="mdo" width="32" height="32" class="rounded-circle">
            <div class="form-group">
                <label for="foto_profile">Foto Profile</label>
                <input type="file" class="form-control" id="foto_profile" name="foto_profile" value="<?php echo $akun['foto_profile']; ?>" accept=".jpg, .jpeg, .png">
            </div>
            <input type="hidden" name="account_id" id="account_id" value="<?php echo $akun['account_id']; ?>">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>
