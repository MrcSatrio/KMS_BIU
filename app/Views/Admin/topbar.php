<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap">
            <img src="https://1.bp.blogspot.com/-Btegxn7O3hk/X5GWBUPfHQI/AAAAAAAAJ1U/x2Tdgy-iNqIYwsZNHnALJIPRMAwOZvrLACLcBGAsYHQ/s0/UBI.png" alt="Logo" width="50" height="50">
            </svg>
          
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/dashboard'); ?>">Beranda</a></li>
        <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pengaturan" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pengaturan
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pengaturan">
                        <a class="dropdown-item" href="<?php echo base_url('admin/kategori'); ?>">Kategori</a>
                        <a class="dropdown-item" href="<?php echo base_url('admin/sub_kategori'); ?>">Sub kategori</a>
                        <a class="dropdown-item" href="<?php echo base_url('admin/account'); ?>">Akun</a>
                    </div>
                </li>
        <li class="nav-item"><a class="nav-link" href="#">Profil</a></li>
    </ul>
            <button type="button" class="btn btn-danger" id="logoutButton">Logout</button>
        </div>
    </div>
</nav>
<script>
    // Event listener untuk tombol logout
    document.getElementById('logoutButton').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah aksi default link
        
        // Tampilkan SweetAlert konfirmasi
        Swal.fire({
            title: 'Logout',
            text: 'Anda yakin ingin logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika konfirmasi di SweetAlert diterima, arahkan ke URL logout
                window.location.href = "<?= base_url('logout'); ?>";
            }
        });
    });
</script>
