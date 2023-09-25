<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Akun</h1>
    <a href="<?= base_url('admin/account/create') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah Akun</a>
</div>
<div class="table-responsive">
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Foto</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['account_id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['nama'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['role_name'] ?></td>
                    <td><img src="<?= base_url('uploads/' . $user['foto_profile']); ?>" alt="mdo" width="32" height="32" class="rounded-circle"></td>
                    <td>
                    <a href="<?= base_url('admin/account/update/'.$user['account_id']) ?>" class="btn btn-success btn-sm update-link">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('admin/account/delete/'.$user['account_id']) ?>" class="btn btn-danger btn-sm delete-link">
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
