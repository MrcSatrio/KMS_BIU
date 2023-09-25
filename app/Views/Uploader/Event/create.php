<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<body>
<div class="container">
        <div class="upload-form">
            <form action="<?php echo base_url('uploader/event/create'); ?>" method="post" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label for="eventTitle" class="form-label">Nama Event</label>
                    <input type="text" class="form-control" id="eventTitle" aria-describedby="eventTitle" name="eventTitle" value="<?php echo $dokumen['judul']?>">
                </div>

                <div class="mb-3">
                <label for="prodi" class="form-label">Program Studi</label>
                    <select class="form-select" aria-label="Default select example" name="prodi" id="prodi">
                    <?php foreach ($prodi as $item): ?>
                        <option value="<?php echo $item['id_prodi']; ?>"><?php echo $item['nama_prodi']; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="eventImage" class="form-label">Poster Event</label>
                    <input type="file" class="form-control" id="eventImage" aria-describedby="eventImage" name="eventImage" value="<?php echo $dokumen['banner_event']?>">
                </div>

                <div class="mb-3">
                    <label for="start_datetime" class="form-label">Waktu Mulai Event</label>
                    <input type="datetime-local" class="form-control" id="start_datetime" aria-describedby="start_datetime" name="start_datetime" value="<?php echo $dokumen['mulai_event']?>">
                </div>

                <div class="mb-3">
                    <label for="end_datetime" class="form-label">Waktu Selesai Event</label>
                    <input type="datetime-local" class="form-control" id="end_datetime" aria-describedby="end_datetime" name="end_datetime" value="<?php echo $dokumen['akhir_event']?>">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga Event</label>
                    <input type="number" class="form-control" id="price" aria-describedby="price" name="price" value="<?php echo $dokumen['harga']?>">
                </div>

                <div class="mb-3">
                    <label for="link_event" class="form-label">Link External</label>
                    <input type="link" class="form-control" id="link_event" aria-describedby="link_event" name="link_event" value="<?php echo $dokumen['link_event']?>">
                </div>

                <label for="eventContent">Deskripsi Event:</label>
                <textarea id="mytextarea" name="eventContent"> <?php echo $dokumen['deskripsi']?></textarea>
                <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?php echo $dokumen['id_dokumen']?>">


                <input type="submit" value="Upload">
            </form>
        </div>
    </div>
<?php $this->endSection(); ?>
