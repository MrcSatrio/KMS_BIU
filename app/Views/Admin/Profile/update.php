<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<div class="row">
    <img src="<?= base_url('uploads/' . $akun['foto_profile']); ?>" alt="mdo" width="32" height="32" class="rounded-circle">
    <div class="col-md-6">
        <h2>Edit Profile</h2>
        <form action="<?= base_url('admin/profile/update_action') ?>" enctype="multipart/form-data" method="post">
        <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $akun['nama']; ?>">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $akun['username']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $akun['email']; ?>">
            </div>
            <input type="hidden" name="account_id" id="account_id" value="<?php echo $akun['account_id']; ?>">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>
