<?php
include "../koneksi.php";
include_once "cek-akses.php";

require_once 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Encoding\Encoding;

$id = mysqli_real_escape_string($conn, $_GET['id']);

$queryDetail = mysqli_query($conn, "SELECT peminjaman.*, user.*, buku.Judul, buku.Penulis, buku.Penerbit, buku.TahunTerbit, user.Gambar
    FROM peminjaman 
    LEFT JOIN user ON user.UserID = peminjaman.UserID 
    LEFT JOIN buku ON buku.BukuID = peminjaman.BukuID 
    WHERE peminjaman.PeminjamanID = '$id'");

$data = mysqli_fetch_assoc($queryDetail);

$tanggalPengembalian = new DateTime($data['TanggalPengembalian']);
$tanggalSekarang = new DateTime();
$denda = 0;
$hariTerlambat = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .card {
            border-radius: 10px;
        }

        .card-header {
            background-color: #005b8f;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-custom {
            background-color: #005b8f;
            color: white;
        }

        .btn-custom:hover {
            background-color: #00407a;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .badge-custom {
            font-size: 16px;
            padding: 8px 15px;
        }

        .badge-danger {
            background-color: red;
        }

        .badge-success {
            background-color: green;
        }

        .user-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 5px solid #005b8f;
            border-radius: 10%;
            margin-bottom: 5px;
        }

        .header-img {
            width: 40px;
            height: 40px;
            margin-left: 10px;
            vertical-align: middle;
        }

        .btn-print {
            background-color: #005b8f;
            color: white;
            margin-left: 10px;
        }

        .btn-print:hover {
            background-color: #00407a;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btn-container .btn {
            margin: 0 10px;
        }

        @media print {
            .btn-container,
            .btn-custom,
            .btn-print {
                display: none;
            }

            .card-header {
                background-color: #005b8f !important;
                color: black !important;
            }

            .user-image {
                width: 100px;
                height: 100px;
                object-fit: cover;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header">
                <h4><i class="fas fa-book"></i> Detail Laporan Peminjaman</h4>
                <img src="img/ft.png" alt="Icon" class="header-img">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="img/<?php echo $data['Gambar']; ?>" alt="User Image" class="user-image">
                        <h5><strong>Nama Lengkap:</strong> <?php echo $data['NamaLengkap']; ?></h5>
                        <p><strong>NPM:</strong> <?php echo $data['NPM']; ?></p>
                    </div>
                    <div class="col-md-4">
                        <h5><strong>Judul Buku:</strong> <?php echo $data['Judul']; ?></h5>
                        <p><strong>Penulis:</strong> <?php echo $data['Penulis']; ?></p>
                        <p><strong>Penerbit:</strong> <?php echo $data['Penerbit']; ?></p>
                        <p><strong>Tahun Terbit:</strong> <?php echo $data['TahunTerbit']; ?></p>
                    </div>
                    <div class="col-md-4">
                        <h5><strong>Tanggal Peminjaman:</strong> <?php echo $data['TanggalPeminjaman']; ?></h5>
                        <h5><strong>Tanggal Pengembalian:</strong> <?php echo $data['TanggalPengembalian']; ?></h5>
                        <h5><strong>Status Peminjaman:</strong> <?php echo $data['StatusPeminjaman']; ?></h5>

                        <?php
                        if ($data['StatusPeminjaman'] != 'dikembalikan' && $data['StatusPeminjaman'] != 'pending') {
                            if ($tanggalSekarang > $tanggalPengembalian) {
                                $hariTerlambat = $tanggalSekarang->diff($tanggalPengembalian)->days;
                                $denda = $hariTerlambat * 2500;
                            }
                        }

                        $qrData = "Nama Lengkap: " . $data['NamaLengkap'] . "\n";
                        $qrData .= "Judul Buku: " . $data['Judul'] . "\n";
                        $qrData .= "Tanggal Peminjaman: " . $data['TanggalPeminjaman'] . "\n";
                        $qrData .= "Tanggal Pengembalian: " . $data['TanggalPengembalian'] . "\n";
                        $qrData .= "Hari Terlambat: " . number_format($hariTerlambat, 0, ',', '.') . " Hari\n";
                        $qrData .= "Denda: Rp " . number_format($denda, 0, ',', '.');

                        $qrCode = new QrCode($qrData);
                        $qrCode->setSize(100);
                        $qrCode->setEncoding(new Encoding('UTF-8'));
                        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevelLow());

                        $writer = new PngWriter();
                        $result = $writer->write($qrCode);

                        echo '<img src="data:image/png;base64,' . base64_encode($result->getString()) . '" alt="QR Code">';
                        ?>
                    </div>
                </div>

                <hr>

                <?php
                if ($data['StatusPeminjaman'] != 'dikembalikan' && $data['StatusPeminjaman'] != 'pending') {
                    if ($denda > 0) {
                        echo '<div class="alert alert-danger"><strong>Hari Terlambat:</strong> ' . $hariTerlambat . ' Hari <br> <strong>Denda:</strong> Rp ' . number_format($denda, 0, ',', '.') . '</div>';
                    } else {
                        echo '<div class="alert alert-success"><strong>Status Denda:</strong> Tidak ada denda</div>';
                    }
                } else {
                    echo '<div class="alert alert-success"><strong>Status Denda:</strong> Tidak ada denda</div>';
                }
                ?>

                <hr>

                <div class="btn-container">
                    <a href="laporan.php" class="btn btn-custom"><i class="fas fa-arrow-left"></i> Kembali ke Laporan</a>
                    <a href="javascript:void(0)" onclick="window.print();" class="btn btn-print"><i class="fas fa-print"></i> Print</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
