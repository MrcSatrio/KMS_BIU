<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap">
            <img src="https://1.bp.blogspot.com/-Btegxn7O3hk/X5GWBUPfHQI/AAAAAAAAJ1U/x2Tdgy-iNqIYwsZNHnALJIPRMAwOZvrLACLcBGAsYHQ/s0/UBI.png" alt="Logo" width="50" height="50">
            </svg>
          
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Pelatihan</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Pusat Pengetahuan</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Pusat Bantuan</a></li>
            </ul>
            <button type="button" class="btn btn-primary" id="loginButton">Login</button>
        </div>
    </div>
</nav>

<script>
        document.getElementById('loginButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Login',
                html:
                    '<input type="text" id="username" class="swal2-input" placeholder="Username">' +
                    '<div class="password-container">' +
                    '<input type="password" id="password" class="swal2-input password-input" placeholder="Password">' +
                    '<br>' +
                    '<input type="checkbox" id="showPassword" class="show-password"> <label for="showPassword">Lihat Password</label>' +
                    '</div>',
                focusConfirm: false,
                didOpen: () => {
                    const passwordInput = Swal.getPopup().querySelector('.password-input');
                    const showPasswordCheckbox = Swal.getPopup().querySelector('.show-password');

                    showPasswordCheckbox.addEventListener('change', () => {
                        passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';
                    });
                },
                preConfirm: () => {
                    const username = Swal.getPopup().querySelector('#username').value;
                    const passwordInput = Swal.getPopup().querySelector('#password');
                    const password = passwordInput.value;

                    // Di sini Anda dapat menambahkan logika untuk memeriksa kredensial
                    // Contoh: if (username === 'admin' && password === 'password') { ... }
                    // Jika berhasil, tampilkan pesan sukses, jika gagal, tampilkan pesan error
                    Swal.fire('Logged In', 'Anda telah login', 'success');
                }
            });
        });
    </script>



