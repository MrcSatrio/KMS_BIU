<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>

<!-- Konten Utama -->
<div class="container mt-5">
    <div class="row">
        <!-- Container untuk Daftar Pengetahuan -->
        <div class="col-md-12 mt-5">
            <h2>Daftar Pengetahuan</h2>
            <form action="<?= base_url('search') ?>" method="post" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari pengetahuan..." name="pencarian" id="pencarian">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    </div>
                </div>
            </form>
            <div class="row">
            <?php if (empty($berkas)): ?>
                <div class="col-md-12">
                    <p>"Maaf, pengetahuan tersebut tidak dapat saya temukan. Silakan gunakan kata kunci pencarian lainnya.".</p>
                </div>
            <?php else: ?>
                <?php foreach ($berkas as $document): 
                    $dokumen = base64_encode($document['id_dokumen']);?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <img src="<?= base_url('uploads/' . $document['berkas']); ?>" class="card-img-top custom-img" alt="<?= $document['judul'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $document['judul'] ?></h5>
                                <p class="card-text"><?= $document['nama_kategori'] ?></p>
                                <p class="card-text"><strong>Created By <?= $document['nama'] ?></strong></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <?php if (session('id_role') === '1'): ?>
                                            <a href="<?= base_url('admin/knowledge/' . $dokumen) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                                        <?php elseif (session('id_role') === '2'): ?>
                                            <a href="<?= base_url('uploader/knowledge/' . $dokumen) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                                        <?php else: ?>
                                            <a href="<?= base_url('knowledge/' . $dokumen) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat</a>
                                        <?php endif; ?>
                                    </div>
                                    <small class="text-muted">9 mins</small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk menetapkan tinggi yang sama ke kolom-kolom dalam satu baris -->
<script>
    const rows = document.querySelectorAll('.row'); // Pilih semua baris
    rows.forEach(row => {
        const columns = row.querySelectorAll('.col-md-4'); // Pilih semua kolom dalam satu baris
        let maxHeight = 0;
        columns.forEach(col => {
            const cardBody = col.querySelector('.card-body');
            if (cardBody.clientHeight > maxHeight) {
                maxHeight = cardBody.clientHeight;
            }
        });
        columns.forEach(col => {
            const cardBody = col.querySelector('.card-body');
            cardBody.style.height = `${maxHeight}px`; // Setel tinggi kolom-kolom dalam satu baris menjadi tinggi maksimum
        });
    });
</script>

<?php $this->endSection(); ?>
