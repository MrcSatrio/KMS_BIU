<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<div class="row">
    <div class="col-md-6">
        <h2>Edit Sub Kategori</h2>
        <form action="<?= base_url('admin/sub_kategori/update_action') ?>" method="post">
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
                <input type="text" class="form-control" id="nama_sub_kategori" name="nama_sub_kategori" value="<?php echo $subkategori['nama_sub_kategori']; ?>">
            </div>
            <input type="hidden" name="id_sub_kategori" value="<?php echo $subkategori['id_sub_kategori']; ?>">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>
