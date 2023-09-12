<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<body>
<div class="container">
        <div class="upload-form">
            <form action="<?php echo base_url('admin/upload'); ?>" method="post" enctype="multipart/form-data">
                <label for="documentTitle">Judul Materi</label>
                <input type="text" id="documentTitle" name="documentTitle" required>
                <label for="documentType">Kategori Materi:</label>
                <select id="documentType" name="documentType" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategori as $item): ?>
                    <option value="<?php echo $item['id_kategori']; ?>" data-subkategori="<?php echo $item['id_sub_kategori']; ?>"><?php echo $item['nama_sub_kategori']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="documentVideo">Link Video:</label>
                <input type="link" id="documentVideo" name="documentVideo">


                <label for="documentContent">Materi:</label>
                <textarea id="mytextarea" name="documentContent"></textarea>

                <label for="formFile" class="form-label">Thumbnail:</label>
                <input class="form-control" type="file" id="formFile" name="documentFile" accept=".jpg,.jpeg,.png,." required>

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
