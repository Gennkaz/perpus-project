<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ketentuan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <link href="css/bootstrap.min.css?version=1.2" rel="stylesheet">

    <link href="css/style.css?version=1.1" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Kazz...</span>
            </div>
        </div>

        <?php
        require "sidebar.php";
        ?>

        <div class="content">
            <?php
            require "navbar.php";
            ?>

            <div class="container-fluid pt-4 px-4">
                <h3 style="color: #005b8f;">Syarat dan Ketentuan Penggunaan Perpustakaan Digital Fakultas Teknik Universitas Majalengka</h3>
                
                <p>Selamat datang di <strong>Perpustakaan Digital Fakultas Teknik Universitas Majalengka</strong>. Dengan mengakses dan menggunakan layanan perpustakaan digital ini, Anda setuju untuk mematuhi syarat dan ketentuan berikut.</p>

                <h5>1. Penggunaan Layanan</h5>
                <p>- Layanan Perpustakaan Digital ini hanya diperuntukkan bagi mahasiswa, dosen, dan staf Fakultas Teknik Universitas Majalengka.</p>
                <p>- Pengguna diwajibkan untuk memiliki akun yang valid untuk mengakses layanan ini. Akun hanya boleh digunakan oleh pemilik yang terdaftar dan tidak dapat dipindahtangankan.</p>
                <p>- Pengguna bertanggung jawab untuk menjaga kerahasiaan informasi akun mereka, termasuk nama pengguna dan kata sandi.</p>

                <h5>2. Akses dan Konten</h5>
                <p>- Perpustakaan Digital menyediakan akses ke berbagai koleksi digital, termasuk buku teks, jurnal, skripsi, dan materi pembelajaran lainnya yang dimiliki oleh Fakultas Teknik Universitas Majalengka.</p>
                <p>- Semua konten yang tersedia di Perpustakaan Digital hanya dapat digunakan untuk tujuan akademis dan penelitian.</p>

                <h5>3. Hak Cipta</h5>
                <p>- Semua materi yang tersedia di Perpustakaan Digital Fakultas Teknik Universitas Majalengka dilindungi oleh hak cipta dan kekayaan intelektual.</p>
                <p>- Pengguna wajib menghormati hak cipta dan tidak diperbolehkan untuk memodifikasi, mendistribusikan, atau menjual materi yang ada di dalamnya tanpa izin tertulis dari pemegang hak cipta.</p>

                <h5>4. Kewajiban Pengguna</h5>
                <p>- Pengguna wajib menggunakan layanan Perpustakaan Digital dengan cara yang sah dan sesuai.</p>
                <p>- Dilarang untuk:</p>
                <ul>
                    <li>Menjaga akun orang lain tanpa izin.</li>
                    <li>Mengakses atau mencoba mengakses data atau sistem secara tidak sah.</li>
                    <li>Menggunakan layanan untuk tujuan komersial atau memperoleh keuntungan pribadi tanpa izin.</li>
                </ul>

                <h5>5. Keamanan dan Kerahasiaan</h5>
                <p>- Perpustakaan Digital Fakultas Teknik Universitas Majalengka berkomitmen untuk menjaga keamanan data pribadi pengguna. Kami akan menggunakan data pengguna sesuai dengan kebijakan privasi yang berlaku.</p>

                <h3 style="color: #005b8f;">Kontak dan Dukungan</h3>
                <p>- Jika Anda memiliki pertanyaan atau membutuhkan bantuan terkait penggunaan layanan Perpustakaan Digital, silakan hubungi kami melalui:</p>
                <ul>
                    <li>Email: <a href="#">akas@gmail.com</a></li>
                    <li>Telepon: +62 xxx xxxx xxxx</li>
                </ul>

                <p>Terima kasih telah menggunakan layanan <strong>Perpustakaan Digital Fakultas Teknik Universitas Majalengka</strong>. Kami berharap layanan ini dapat mendukung kebutuhan akademik Anda.</p>
            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="js/main.js"></script>
</body>

</html>
