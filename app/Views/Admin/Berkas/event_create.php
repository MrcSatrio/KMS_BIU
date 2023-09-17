<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>

<div class="row">
    <div class="col-md-6">
        <h2>Tambah Event</h2>
        <form action="<?= base_url('admin/event/create') ?>" method="post">
            <div class="form-group">
                <label for="judul">Judul</label>
                <select id="judul" name="judul" required class="selectpicker" data-live-search="true">
                    <option value="">Pilih Judul</option>
                    <?php foreach ($berkas as $item): ?>
                        
                    <option value="<?php echo $item['id_dokumen']; ?>"><?php echo $item['judul']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="eventImage">Banner Event</label>
                <input type="file" id="eventImage" name="eventImage">
            </div>

            <div class="form-group">
                <label for="start_datetime">Waktu Mulai Event</label>
                <input type="datetime-local" id="start_datetime" name="start_datetime" placeholder="Waktu Mulai Event" required>
            </div>

            <div class="form-group">
                <label for="end_datetime">Waktu Selesai Event</label>
                <input type="datetime-local" id="end_datetime" name="end_datetime" placeholder="Waktu Selesai Event" required>
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" id="price" name="price" placeholder="Harga Event" required>
            </div>

            <div class="form-group">
                <label for="link_event">LINK</label>
                <input type="link" id="link_event" name="link_event" placeholder="Link External" required>
            </div>

            <div class="form-group">
                <label for="eventContent">Materi:</label>
                <textarea id="mytextarea" name="eventContent"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>


<?php $this->endSection(); ?>
