<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<body>
<div class="container">
        <div class="upload-form">
            <form action="<?php echo base_url('uploader/upload'); ?>" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="documentTitle" class="form-label">Judul Materi:</label>
                    <input type="text" class="form-control" id="documentTitle" aria-describedby="documentTitle" name="documentTitle">
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
                    <input type="link" class="form-control" id="documentVideo" aria-describedby="documentVideo" name="documentVideo">
                </div>

                <div class="mb-3">
                    <label for="documentPDF" class="form-label">Upload PDF</label>
                    <input type="file" class="form-control" id="documentPDF" aria-describedby="documentPDF" name="documentPDF" accept=".pdf">
                </div>

                <div class="mb-3">
                    <label for="documentFile" class="form-label">Thumbnail:</label>
                    <input type="file" class="form-control" id="documentFile" aria-describedby="documentFile" name="documentFile" accept=".jpg,.png,.jpeg">
                </div>

                <label for="documentContent">Materi:</label>
                <textarea id="mytextarea" name="documentContent"><html></html></textarea>




                <input type="hidden" id="sub_kategori" name="sub_kategori" value="">
                
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
