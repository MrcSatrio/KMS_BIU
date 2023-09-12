<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<div class="row">
    <div class="col-md-6">
        <h2>Edit Highlight</h2>
        <form action="<?= base_url('admin/highlight/update_action') ?>" method="post">
        <div class="form-group">
                <label for="nama_sorot">Judul Sorotan</label>
                <input type="text" class="form-control" id="nama_sorot" name="nama_sorot" value="<?php echo $sorotan['nama_sorot']; ?>">
            </div>
            <div class="form-group">
            <label for="deskripsi_sorotan">Deskripsi sorotan</label>
            <textarea id="mytextarea" name="deskripsi_sorotan"><?php echo $sorotan['deskripsi_sorotan']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="tgl_awal">Tanggal Awal</label>
                <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="<?php echo $sorotan['tgl_mulai']; ?>">
            </div>
            <div class="form-group">
                <label for="tgl_akhir">Tanggal Akhir</label>
                <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" value="<?php echo $sorotan['tgl_akhir']; ?>">
            </div>
            <input type="hidden" value="<?php echo $sorotan['id_sorot']; ?>" name="id_sorot" id="id_sorot">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>
