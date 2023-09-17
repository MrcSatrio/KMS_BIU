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
                <th>Tanggal</th>
                <th>Status</th>
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
                    <td><?= date('Y-m-d', strtotime($bk['created_at'])) ?></td>
                    <td>
                        <?php
                        if ($bk['id_status'] == 1) {
                            echo '<span class="badge badge-warning">VALIDASI</span>';
                        } elseif ($bk['id_status'] == 2) {
                            echo '<span class="badge badge-success">DISETUJUI</span>';
                        } elseif ($bk['id_status'] == 3) {
                            echo '<span class="badge badge-danger">DITOLAK</span>';
                        }
                        ?>
                    </td>
                    <td>
                    <a href="<?= base_url('uploader/materi/update/'.$bk['id_dokumen']) ?>" class="btn btn-success btn-sm update-link">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('uploader/materi/delete/'.$bk['id_dokumen']) ?>" class="btn btn-danger btn-sm delete-link">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                        <?php if ($bk['id_event'] == '0') { ?>
                            <a href="<?= base_url('uploader/event/update/' . $bk['id_dokumen']) ?>" class="btn btn-primary btn-sm update-link">
                                <i class="fas fa-calendar"></i> Event
                            </a>
                        <?php } ?>
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
