<?php
    $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="dashboard/img/ft.png" />
    <title>KazPus | Tentang Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?version=1.4">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner2 d-flex align-items-center bg-dark text-white py-5">
        <div class="container text-center">
            <h1 class="text-center">Informasi</h1>
        </div>
    </div>

    <div class="container my-5">
        <div class="mb-4">
            <h2 class="fw-bold border-bottom pb-2">Perpustakaan Informasi</h2>
        </div>

        <div class="mb-5 px-5">
            <h4 class="fw-bold mb-3">Kontak Informasi</h4>
            <p>
                <strong>Alamat :</strong><br>
                Jl. KH. Abdul Halim No. 103
            </p>
            <p>
                <strong>Nomor Telephone :</strong><br>
                <a href="tel:(0233)281496" class="text-decoration-none text-primary">(0233) 281 496</a>
            </p>
        </div>

        <div class="mb-5 px-5">
            <h4 class="fw-bold mb-3">Jam Buka</h4>
            <p>
                <strong>Senin - Kamis :</strong><br>
                Buka: 08.00 AM<br>
                Istirahat: 12.00 - 13.00 PM<br>
                Tutup: 16.00 PM
            </p>
            <p>
                <strong>Jum'at :</strong><br>
                Buka: 08.00 AM<br>
                Istirahat: 11.30 - 13.00 PM<br>
                Tutup: 16.00 PM
            </p>
            <p>
                <strong>Sabtu :</strong><br>
                Buka: 08.00 AM<br>
                Istirahat: 12.00 - 13.00 PM<br>
                Tutup: 14.00 PM
            </p>
        </div>

        <div class="mb-5 px-5">
            <h4 class="fw-bold mb-3">Koleksi</h4>
            <p>
            Kami memiliki berbagai jenis koleksi di perpustakaan kami, mulai dari Fiksi hingga Materi Ilmiah, dari materi cetak hingga koleksi digital seperti CD-ROM, CD, VCD, dan DVD. Kami juga mengumpulkan publikasi serial harian seperti surat kabar dan publikasi serial bulanan seperti majalah.
            </p>
        </div>

        <div class="px-5">
            <h4 class="fw-bold mb-3">Langganan Perpustakaan</h4>
            <p>
            Untuk dapat meminjam koleksi perpustakaan kami, Anda harus terlebih dahulu menjadi anggota perpustakaan. Terdapat syarat dan ketentuan yang harus Anda patuhi.
            </p>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
</body>

</html>