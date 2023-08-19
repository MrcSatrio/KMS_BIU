<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>

<style>
        /* Custom styles */
        body {
            background-color: #f8f9fa;
        }

        .topbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-weight: bold;
            color: #343a40;
        }

        .logo svg {
            fill: #17a2b8;
            width: 40px;
            height: 32px;
            margin-right: 8px;
        }

        .nav-link {
            color: #343a40;
        }

        .nav-link:hover {
            color: #17a2b8;
        }

        .card {
            border: none;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    

    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php for ($i = 0; $i < 8; $i++) { ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <img src="https://via.placeholder.com/225" class="card-img-top" alt="Thumbnail">
                        <div class="card-body">
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat </button>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php $this->endSection(); ?>
