<?= $this->extend('Admin/template/index'); ?>

<?php $this->section('container'); ?>

<div class="table-responsive">
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
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
                    <td>
                        <a href="<?= site_url('admin/update/'.$user['account_id']) ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= site_url('admin/delete/'.$user['account_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        responsive: true
    });
});
</script>

<?php $this->endSection(); ?>
