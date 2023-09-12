<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>

<div class="row">
    <div class="col-md-6">
        <h2>Tambah Highlight</h2>
        <form action="<?= base_url('admin/highlight/create') ?>" method="post">
        <div class="form-group">
  <label for="judul">Judul</label>
  <select id="judul" name="judul" required class="selectpicker" data-live-search="true">
    <option value="">Pilih Judul</option>
    <?php foreach ($berkas as $item): ?>
      <option value="<?php echo $item['id_sorot']; ?>"><?php echo $item['judul']; ?></option>
    <?php endforeach; ?>
  </select>
</div>
<?php
// Mendapatkan tanggal dan jam saat ini pada server
$sekarang = date("Y-m-d H:i:s");

// Menampilkan tanggal dan jam
echo "Tanggal dan Jam saat ini pada server adalah: " . $sekarang;
?>

            <div class="form-group">
                <label for="tgl_awal">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" required>
            </div>
            <div class="form-group">
                <label for="tgl_akhir">Tanggal Akhir</label>
                <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<?php $this->endSection(); ?>
