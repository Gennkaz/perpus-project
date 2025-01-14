<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

require_once 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Encoding\Encoding;

$sql = mysqli_query($conn, "SELECT * FROM user WHERE Role='user' AND status='active'");
$count = mysqli_num_rows($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Data Anggota</title>
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
                <h3 style="color: #005b8f;">List Data Anggota</h3>

                <div class="text-right mb-3">
                    <a href="anggota_cetak.php" class="btn btn-primary">Print All Anggota</a>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table mt-3" style="color: white;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Foto</th>
                                <th>NPM</th>
                                <th>Nama Lengkap</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>QRCode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($count == 0) {
                            ?>
                                <tr>
                                    <td colspan="8" class="text-center">List Anggota Tidak Tersedia!</td>
                                </tr>
                                <?php
                            } else {
                                $jumlah = 1;
                                while ($data = $sql->fetch_assoc()) {
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
                                    <tr>
                                        <td><?php echo $jumlah; ?></td>
                                        <td>
                                            <img src="img/<?php echo $data['Gambar']; ?>" style="width: 50px; height: auto;">
                                        </td>
                                        <td><?php echo $data['NPM']; ?></td>
                                        <td><?php echo $data['NamaLengkap']; ?></td>
                                        <td><?php echo $data['Alamat']; ?></td>
                                        <td><?php echo $data['Email']; ?></td>
                                        <td><?php echo $data['Role']; ?></td>
                                        <td><?php echo $data['status']; ?></td>
                                        <td><img src="<?php echo $qrImage; ?>" alt="QR Code" width="50" height="50" style="margin-right: 10px;"></td>
                                        <td>
                                            <a href="anggota_detail.php?id=<?php echo $data['UserID']; ?>" class="btn btn-light"><i class="fas fa-print"></i></a>
                                        </td>
                                    </tr>
                            <?php
                                    $jumlah++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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