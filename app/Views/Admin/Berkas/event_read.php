<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Event</h1>
    <a href="<?= base_url('admin/event/create') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah Event</a>
</div>
<div class="table-responsive">
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Link Event</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($event as $bk): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $bk['judul_event'] ?></td>
                    <td><?= substr($bk['materi_event'], 0, 30); ?>...</td>
                    <td><?= $bk['nama'] ?></td>
                    <td>Rp <?= number_format($bk['harga'], 0, ',', '.') ?></td>
                    <td><?= $bk['link_event'] ?></td>
                    <td><?= date('Y-m-d H:i', strtotime($bk['mulai_event'])) ?></td>
                    <td><?= date('Y-m-d H:i', strtotime($bk['akhir_event'])) ?></td>
                    <td>
                        <a href="<?= base_url('admin/event/update/'.$bk['id_dokumen']) ?>" class="btn btn-success btn-sm update-link">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('admin/event/delete/'.$bk['id_dokumen']) ?>" class="btn btn-danger btn-sm delete-link">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                        <?php
                        if ($bk['id_status'] == '1' || $bk['id_status'] == '3') {
                            echo '<a href="' . base_url('admin/materi/status/' . $bk['id_dokumen']) . '" class="btn btn-success btn-sm delete-link">';
                            echo '<i class="fas fa-thumbs-up"></i> Setujui';
                            echo '</a>';
                        } else {
                        }
                        ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.delete-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const deleteUrl = this.getAttribute('href');

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke URL penghapusan jika pengguna mengonfirmasi
                    window.location.href = deleteUrl;
                }
            });
        });
    });
    document.querySelectorAll('.update-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const deleteUrl = this.getAttribute('href');

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin memperbarui data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke URL penghapusan jika pengguna mengonfirmasi
                    window.location.href = deleteUrl;
                }
            });
        });
    });
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: true
        });
    });
</script>

<?php $this->endSection(); ?>
