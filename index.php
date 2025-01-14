<?php
include "koneksi.php";

$is_logged_in = isset($_SESSION['login']) && $_SESSION['login'] === true;

$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="dashboard/img/ft.png" />
    <title>KazPus | Beranda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css?version=1.4">
</head>

<body>
    <?php
    require "navbar.php";
    ?>

    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Selamat Datang Di Perpustakaan Fakultas Teknik</h1>
            <h1>Universitas Majalengka</h1>
            <div class="col-md-8 offset-md-2">
                <form method="get" action="buku_list.php">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Cari Judul, Penulis, atau Penerbit" aria-label="Kata Kunci" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" autocomplete="off">
                        <button type="submit" class="btn warna1 text-white">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4 bg-light">
        <div class="container text-center">
            <h3>Buku Populer</h3>

            <div class="row mt-5 d-flex justify-content-center">
                <?php
                $sql = mysqli_query($conn, "SELECT buku.*, COUNT(peminjaman.BukuID) AS JumlahPeminjaman
                                            FROM buku
                                            LEFT JOIN peminjaman 
                                            ON buku.BukuID = peminjaman.BukuID AND peminjaman.StatusPeminjaman = 'pinjam'
                                            GROUP BY buku.BukuID
                                            ORDER BY JumlahPeminjaman DESC
                                            LIMIT 3;");

                while ($data = mysqli_fetch_array($sql)) { ?>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="dashboard/imgbuku/<?php echo htmlspecialchars($data['Gambar']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($data['Judul']); ?>">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($data['Judul']); ?></h5>
                                <p class="card-text text-truncate">Penulis: <?php echo htmlspecialchars($data['Penulis']); ?></p>
                                <p class="card-text text-truncate">Penerbit: <?php echo htmlspecialchars($data['Penerbit']); ?></p>
                                <p class="card-text text-truncate">Tahun Terbit: <?php echo htmlspecialchars($data['TahunTerbit']); ?></p>
                                <p class="card-text text-truncate">Jumlah Peminjaman: <?php echo $data['JumlahPeminjaman']; ?></p>
                                <?php if ($is_logged_in) { ?>
                                    <a href="peminjaman.php?BukuID=<?php echo urlencode($data['BukuID']); ?>&Judul=<?php echo urlencode($data['Judul']); ?>" class="btn btn-primary">Pinjam</a>
                                <?php } else { ?>
                                    <a href="login.php" class="btn btn-primary">Login untuk Pinjam</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>



    <div class="container-fluid py-4">
        <div class="container">
            <h3 class="text-center">Buku</h3>

            <div class="row mt-5">
                <?php
                $sql = mysqli_query($conn, "SELECT * FROM buku
            LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
            LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
            LIMIT 6");

                while ($data = mysqli_fetch_array($sql)) { ?>
                    <div class="col-md-2 mb-3">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="dashboard/imgbuku/<?php echo htmlspecialchars($data['Gambar']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($data['Judul']); ?>">
                            </div>
                            <div class="card-body">
                                <p class="card-title"><?php echo htmlspecialchars($data['Judul']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="text-center">
                <a class="btn btn-outline-primary mt-3" href="buku_list.php">See more</a>
            </div>
        </div>
    </div>


    <div class="container-fluid py-4 bg-light">
        <div class="container">
            <h3 class="text-center">Pengguna Terbaik Tahun ini</h3>
            <p class="text-center mt-2">Pengunjung terbaik kami, ada di sini. Nama dan foto Anda juga bisa muncul di sini. Rajin-rajinlah berkunjung dan membaca!</p>

            <div class="row mt-5">
                <?php
                $sql = mysqli_query($conn, "SELECT user.UserID, user.NamaLengkap, user.Gambar, COUNT(peminjaman.BukuID) AS JumlahPeminjaman
                                            FROM peminjaman
                                            LEFT JOIN user ON user.UserID = peminjaman.UserID
                                            WHERE peminjaman.StatusPeminjaman = 'pinjam'
                                            GROUP BY user.UserID
                                            ORDER BY JumlahPeminjaman DESC
                                            LIMIT 3");

                while ($data = mysqli_fetch_array($sql)) {
                    $status = ($data['JumlahPeminjaman'] > 4) ? "Master🏆" : "Standard🎖️";
                ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 text-center">
                            <div class="image-box">
                                <img src="dashboard/img/<?php echo htmlspecialchars($data['Gambar']); ?>" class="card-img-top">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($data['NamaLengkap']); ?></h5>
                                <p class="card-text"><?php echo $status; ?></p>
                                <p class="card-text"><?php echo $data['JumlahPeminjaman']; ?> Peminjaman Buku</p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>


    <div class="container-fluid py-4">
        <div class="container d-flex flex-wrap align-items-center">
            <div class="col-md-6 mb-3">
                <iframe
                    src="https://maps.google.com/maps?q=Fakultas%20Teknik%20Universitas%20Majalengka&t=&z=13&ie=UTF8&iwloc=&output=embed"
                    width="100%"
                    height="300"
                    frameborder="0"
                    style="border:0;"
                    allowfullscreen="">
                </iframe>
            </div>
            <div class="col-md-6 mb-3 ps-md-5">
                <h3>Fakultas Teknik</h3>
                <p>Jl. Raya K.H Abdul Halim No.103, Majalengka Kulon, Kec. Majalengka, Kabupaten Majalengka, Jawa Barat 45418</p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-primary"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="btn btn-danger"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="btn btn-dark"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="btn btn-info"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>


    <?php
    require "footer.php"
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
</body>

</html>