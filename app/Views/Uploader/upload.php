<?= $this->extend('Uploader/template/index'); ?>

<?php $this->section('container'); ?>

<body>
<div class="container">
        <div class="upload-form">
            <form action="<?php echo base_url('uploader/action_upload'); ?>" method="post" enctype="multipart/form-data">
                <label for="documentTitle">Judul Materi</label>
                <input type="text" id="documentTitle" name="documentTitle" required>

                <label for="documentType">Kategori Materi:</label>
                <select id="documentType" name="documentType" required>
                    <option value="">Pilih Jenis</option>
                    <option value="1">KKN</option>
                    <option value="2">Magang</option>
                </select>

                <label for="documentVideo">Link Video:</label>
                <input type="link" id="documentVideo" name="documentVideo">


                <label for="documentContent">Materi:</label>
                <textarea id="documentContent" name="documentContent"></textarea>

                <label for="documentFile">Thumbnail:</label>
                <input type="file" id="documentFile" name="documentFile" accept=".jpg,.jpeg,." required>
                
                <input type="submit" value="Upload">
            </form>
        </div>
    </div>
<?php $this->endSection(); ?>
