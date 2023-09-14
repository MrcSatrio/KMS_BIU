<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<body>
<div class="container">
        <div class="upload-form">
            <form action="<?php echo base_url('admin/event/create'); ?>" method="post" enctype="multipart/form-data">
                <label for="eventTittle">Judul Event</label>
                <input type="text" id="eventTittle" name="eventTittle" value="<?php echo $dokumen['judul']?>" placeholder="Judul Event" required>

                <label for="eventImage">Banner Event</label>
                <input type="file" id="eventImage" name="eventImage" value="<?php echo $dokumen['banner_event']?>">

                <label for="start_datetime">Waktu Mulai Event</label>
                <input type="datetime-local" id="start_datetime" name="start_datetime" placeholder="Waktu Mulai Event" value="<?php echo $dokumen['mulai_event']?>" required>

                <label for="end_datetime">Waktu Selesai Event</label>
                <input type="datetime-local" id="end_datetime" name="end_datetime" placeholder="Waktu Selesai Event" value="<?php echo $dokumen['akhir_event']?>" required>

                <label for="price">Harga</label>
                <input type="number" id="price" name="price" placeholder="Harga Event" value="<?php echo $dokumen['harga']?>" required>

                <label for="link_event">LINK</label>
                <input type="link" id="link_event" name="link_event" placeholder="Link External" value="<?php echo $dokumen['link_event']?>" required>

                <label for="eventContent">Materi:</label>
                <textarea id="mytextarea" name="eventContent"> <?php echo $dokumen['deskripsi']?></textarea>
                <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?php echo $dokumen['id_dokumen']?>">


                <input type="submit" value="Upload">
            </form>
        </div>
    </div>
<?php $this->endSection(); ?>
