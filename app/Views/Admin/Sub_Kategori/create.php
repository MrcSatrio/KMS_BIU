<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>

<div class="row">
    <div class="col-md-6">
        <h2>Tambah Sub Kategori</h2>
        <form action="<?= base_url('admin/sub_kategori/create') ?>" method="post">
    <div class="form-group">
        <label for="id_kategori">Nama Kategori</label>
        <select id="id_kategori" name="id_kategori" required>
            <option value="">Pilih Kategori</option>
            <?php foreach ($kategori as $item): ?>
                <option value="<?php echo $item['id_kategori']; ?>"><?php echo $item['nama_kategori']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="nama_sub_kategori">Nama Sub Kategori</label>
        <input type="text" class="form-control" id="nama_sub_kategori" name="nama_sub_kategori" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

    </div>
</div>

<?php $this->endSection(); ?>
