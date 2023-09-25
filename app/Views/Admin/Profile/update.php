<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
<div class="container-xl px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" src="<?= base_url('uploads/' . $akun['foto_profile']); ?>" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#updatePhotoModal">Upload new image</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                <form action="<?= base_url('admin/profile/update_action') ?>" enctype="multipart/form-data" method="post">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Username</label>
                            <input class="form-control" id="username" name="username" type="text" placeholder="Enter your username" value="<?php echo $akun['username']; ?>">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">Nama Lengkap</label>
                                <input class="form-control" id="nama" name="nama" type="text" placeholder="Enter your first name" value="<?php echo $akun['nama']; ?>">
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName">Email</label>
                                <input class="form-control" id="email" name="email" type="text" placeholder="Enter your last name" value="<?php echo $akun['email']; ?>">
                            </div>
                        </div>
                        <input type="hidden" name="account_id" id="account_id" value="<?php echo $akun['account_id']; ?>">
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updatePhotoModal" tabindex="-1" aria-labelledby="updatePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePhotoModalLabel">Ubah Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk mengunggah foto baru -->
                <form  action="<?= base_url('admin/photo_profile/update_action') ?>" id="uploadForm" enctype="multipart/form-data"  method="post">
                    <div class="form-group">
                    <label for="foto_profile">Foto Profile</label>
                    <input type="file" class="form-control" id="foto_profile" name="foto_profile" value="<?php echo $akun['foto_profile']; ?>" accept=".jpg, .jpeg, .png">
                    </div>
                    <input type="hidden" name="account_id" id="account_id" value="<?php echo $akun['account_id']; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="uploadForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<style>
    body{margin-top:20px;
background-color:#f2f6fc;
color:#69707a;
}
.img-account-profile {
    height: 10rem;
}
.rounded-circle {
    border-radius: 50% !important;
}
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
}
.card .card-header {
    font-weight: 500;
}
.card-header:first-child {
    border-radius: 0.35rem 0.35rem 0 0;
}
.card-header {
    padding: 1rem 1.35rem;
    margin-bottom: 0;
    background-color: rgba(33, 40, 50, 0.03);
    border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}
.form-control, .dataTable-input {
    display: block;
    width: 100%;
    padding: 0.875rem 1.125rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1;
    color: #69707a;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c5ccd6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.nav-borders .nav-link.active {
    color: #0061f2;
    border-bottom-color: #0061f2;
}
.nav-borders .nav-link {
    color: #69707a;
    border-bottom-width: 0.125rem;
    border-bottom-style: solid;
    border-bottom-color: transparent;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0;
    padding-right: 0;
    margin-left: 1rem;
    margin-right: 1rem;
}
    </style>
<?php $this->endSection(); ?>
