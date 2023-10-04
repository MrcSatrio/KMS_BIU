<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>

<!-- Konten Utama -->
<div class="container mt-5">
    <div class="row">
        <!-- Container untuk Daftar Pengetahuan -->
        <div class="word-break hidden-print">
            <!-- Isi Sidebar (Masih perlu diisi) -->
        </div>

        <?php 
        // Buat array untuk melacak author yang sudah ditampilkan
        $displayedAuthors = [];

        if (!empty($berkas)): ?>
        <div class="container-fluid">
            <div class="row">
                <!-- Content -->
                <div class="col-xs-6 col-sm-9">
                    <!-- Isi konten Anda di sini -->
                </div>

                <!-- Sidebar -->
                <div class="col-xs-6 col-sm-3 sidebar-offcanvas">
                    <ul class="list-group">
                        <li class="list-group-item active">Author</li>
                        <?php foreach ($berkas as $document):
                            if ($document['scholar'] != 0):

                                // Ambil nama author dari data
                                $author = $document['nama'];
                                $scholar = $document['scholar'];

                                // Cek apakah author sudah ditampilkan sebelumnya
                                if (!in_array($author, $displayedAuthors)):
                                    // Tampilkan author hanya jika belum ditampilkan sebelumnya
                        ?>
                        <li class="list-group-item ds-option">
                            <a href="https://scholar.google.co.id/citations?user=<?= $scholar ?>&hl=id&oi=sra"><?= $author ?></a>
                        </li>
                        <?php 
                                    // Tandai author sebagai sudah ditampilkan
                                    $displayedAuthors[] = $author;
                                endif;
                            endif;
                        endforeach; 
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->endSection(); ?>
