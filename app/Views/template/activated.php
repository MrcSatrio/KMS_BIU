<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                    <form action="<?= base_url('auth/activated') ?>" method="post">
                    <div class="form-group">
                                <label for="email">Email Terdaftar:</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Terdaftar" required>
                            </div>

                            <div class="form-group">
                                <label for="otp">Kode Token Pendaftaran:</label>
                                <input type="text" class="form-control" id="otp" name="otp" placeholder="Masukkan kode OTP" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endSection(); ?>