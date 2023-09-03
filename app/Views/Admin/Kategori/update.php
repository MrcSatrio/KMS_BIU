<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<div class="row">
    <div class="col-md-6">
        <h2>Edit Nama Kategori</h2>
        <form action="<?= base_url('admin/kategori/update_action') ?>" method="post">
        <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?php echo $kategori['nama_kategori']; ?>">
            </div>
            <input type="hidden" name="id_kategori" id="id_kategori" value="<?php echo $kategori['id_kategori']; ?>">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>
