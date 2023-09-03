<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Sub kategori</h1>
    <a href="<?= base_url('admin/sub_kategori/create') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah Sub kategori</a>
</div>
<div class="table-responsive">
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kategori as $kg): ?>
                <tr>
                    <td><?= $kg['id_kategori'] ?></td>
                    <td><?= $kg['nama_kategori'] ?></td>
                    <td><?= $kg['nama_sub_kategori'] ?></td>
                    <td>
                    <a href="<?= base_url('admin/sub_kategori/update/'.$kg['id_sub_kategori']) ?>" class="btn btn-success btn-sm update-link">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('admin/sub_kategori/delete/'.$kg['id_sub_kategori']) ?>" class="btn btn-danger btn-sm delete-link">
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
                text: 'Apakah Anda yakin ingin menghapus akun ini?',
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
