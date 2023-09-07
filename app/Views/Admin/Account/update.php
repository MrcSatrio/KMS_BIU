<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<div class="row">
    <div class="col-md-6">
        <h2>Edit Pengguna</h2>
        <form action="<?= base_url('admin/account/update_action') ?>" method="post">
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
            <div class="form-group">
            <label for="id_role">Role</label>
                <select id="id_role" name="id_role" required>
                    <option value="">Pilih Role</option>
                    <?php foreach ($role as $item): ?>
                        <option value="<?php echo $item['id_role']; ?>"><?php echo $item['role_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="account_id" id="account_id" value="<?php echo $akun['account_id']; ?>">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>
