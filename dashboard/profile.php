<?php
include "../koneksi.php";
include_once "cek-akses.php";

require_once 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Encoding\Encoding;



$username = $_SESSION['username'];
$sql = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
$data = mysqli_fetch_array($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Profile</title>
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
                <h3 style="color: #005b8f;">Profile</h3>

                <div class="row">
                    <div class="col-md-6">
                        <form action="" method="post">
                            <div class="my-3">
                                <label for="NPM" class="mb-2" style="color: white;">Nomor Pokok Mahasiswa (NPM)</label>
                                <input type="text" class="form-control bg-secondary" value="<?php echo $data['NPM']; ?>" disabled>
                            </div>
                            <div class="my-3">
                                <label for="Judul" class="mb-2" style="color: white;">Nama Lengkap</label>
                                <input type="text" class="form-control bg-secondary" value="<?php echo $data['NamaLengkap']; ?>" disabled>
                            </div>
                            <div class="my-3">
                                <label for="Username" class="mb-2" style="color: white;">Username</label>
                                <input type="text" class="form-control bg-secondary" value="<?php echo $data['Username']; ?>" disabled>
                            </div>
                            <div class="my-3">
                                <label for="Email" class="mb-2" style="color: white;">Email</label>
                                <input type="text" class="form-control bg-secondary" value="<?php echo $data['Email']; ?>" disabled>
                            </div>
                            <div class="my-3">
                                <label for="Alamat" class="mb-2" style="color: white;">Alamat</label>
                                <input type="text" class="form-control bg-secondary" value="<?php echo $data['Alamat']; ?>" disabled>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="profile_detail.php?id=<?php echo $data['UserID']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                <a href="profile_detail.php?username=<?php echo $data['Username']; ?>" class="btn btn-primary"><i class="fas fa-key"></i> Change Password</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 bg-secondary mt-4 mx-4" style="max-width: 300px; padding: 20px; border-radius: 8px; height: 100%;">
                        <div class="text-center">
                            <?php if (isset($data['Gambar'])): ?>
                                <img src="img/<?php echo $data['Gambar']; ?>" alt="Foto Profil" style="width: 125px; height: 120px; border-radius: 100%;">
                            <?php else: ?>
                                <img src="img/default.jpg" alt="Foto Profil" style="width: 125px; height: 120px; border-radius: 100%;">
                            <?php endif; ?>
                            <h5 class="mt-3"><?php echo $data['NamaLengkap']; ?></h5>
                            <p>Created Akun: <br><?php echo $data['created_at']; ?></p>
                            <?php
                            $namaLengkap = $data['NamaLengkap'];
                            $npm = $data['NPM'];
                            $email = $data['Email'];


                            $qrData = "Nama Lengkap: $namaLengkap\nNPM: $npm\nEmail: $email";
                            $qrCode = new QrCode($qrData);
                            $qrCode->setSize(100);
                            $qrCode->setEncoding(new Encoding('UTF-8'));
                            $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevelLow());

                            $writer = new PngWriter();
                            $qrImage = $writer->write($qrCode)->getDataUri();
                            ?>

                            <img src="<?php echo $qrImage; ?>" alt="QR Code" style="width: 150px; height: 150px; border-radius: 8px;">
                        </div>
                    </div>
                </div>
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