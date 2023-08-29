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
