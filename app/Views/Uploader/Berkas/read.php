<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>

<div class="table-responsive">
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>kategori</th>
                <th>Penulis</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
            <?php foreach ($berkas as $bk): ?>
                <tr>
                <td><?= $i++ ?></td>
                    <td><?= $bk['judul'] ?></td>
                    <td><?= substr($bk['deskripsi'], 0, 30); ?>...</td>
                    <td><?= $bk['nama_kategori'] ?></td>
                    <td><?= $bk['nama'] ?></td>
                    <td><?= date('Y-m-d', strtotime($bk['created_at'])) ?></td>
                    <td>
                    <a href="<?= base_url('uploader/materi/update/'.$bk['id_dokumen']) ?>" class="btn btn-success btn-sm update-link">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('uploader/materi/delete/'.$bk['id_dokumen']) ?>" class="btn btn-danger btn-sm delete-link">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
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
