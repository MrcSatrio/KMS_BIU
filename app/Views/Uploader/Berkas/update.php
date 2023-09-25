<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<body>
<div class="container">
        <div class="upload-form">
            <form action="<?php echo base_url('uploader/materi/update_action'); ?>" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                    <label for="documentTitle" class="form-label">Link Video:</label>
                    <input type="text" class="form-control" id="documentTitle" aria-describedby="documentTitle" name="documentTitle" value="<?php echo $dokumen['judul']?>">
                </div>

                <label for="documentType">Kategori Materi:</label>
                <select id="documentType" name="documentType" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategori as $item): ?>
                    <option value="<?php echo $item['id_kategori']; ?>" data-subkategori="<?php echo $item['id_sub_kategori']; ?>"><?php echo $item['nama_sub_kategori']; ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="mb-3">
                    <label for="documentVideo" class="form-label">Link Video:</label>
                    <input type="link" class="form-control" id="documentVideo" aria-describedby="documentVideo" name="documentVideo" value="<?php echo $dokumen['video']?>">
                </div>

                <label for="documentContent">Materi:</label>
                <textarea id="mytextarea" name="documentContent"> <?php echo $dokumen['deskripsi']?></textarea>

                <input type="hidden" id="sub_kategori" name="sub_kategori" value="">
                <input type="hidden" id="id_dokumen" name="id_dokumen" value="<?php echo $dokumen['id_dokumen']?>">
                
                <input type="submit" value="Upload">
            </form>
        </div>
    </div>
    <script>
    document.getElementById('documentType').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var subKategoriValue = selectedOption.getAttribute('data-subkategori');
        document.getElementById('sub_kategori').value = subKategoriValue;
    });
</script>
<?php $this->endSection(); ?>
