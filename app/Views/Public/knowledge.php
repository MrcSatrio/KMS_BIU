<?= $this->extend('template/index'); ?>

<?php $this->section('container'); ?>

<div class="container mt-3">
        <div class="jumbotron text-center">
            <h5 class="display-4">MARI MENARI BERSAMA</h5>
            <p class="lead">KULIAH KERJA NGANGGUR</p>
        </div>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/IxxstCcJlsc" allowfullscreen></iframe>
        </div>
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="media">
                    <div class="media-body">
                        <h5 class="mt-0">Asep Kudis</h5>
                        <p class="mb-1" id="video-stats">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-right">
                <button class="btn btn-warning rounded-pill mt-2"><i class="fas fa-star"></i> 0.0</button>
                <button class="btn btn-primary rounded-pill mt-2"><i class="fas fa-share"></i> Bagikan</button>
            </div>
        </div>
        <div class="mt-4">
            <p>Ini adalah isi dari pengetahuan Anda. Tulis di sini informasi dan penjelasan yang ingin Anda bagikan kepada pengunjung.</p>
            <p>Tambahkan teks, gambar, atau format lain sesuai kebutuhan.</p>
        </div>
    </div>
    <script>
        // Retrieve video statistics using YouTube API or scraping methods
        // Here's an example of how you can update the stats dynamically
        const videoStatsElement = document.getElementById('video-stats');
        
        // Replace this with your logic to retrieve video statistics
        const videoStats = "0 x ditonton - dibuat 10 Agustus 2023";
        
        videoStatsElement.innerText = videoStats;
    </script>

<?php $this->endSection(); ?>