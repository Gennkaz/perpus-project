<?php
require_once 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Encoding\Encoding;

include "../koneksi.php";

$id = $_GET['id'];
$sql = mysqli_query($conn, "SELECT * FROM user WHERE UserID = '$id'");
$data = mysqli_fetch_assoc($sql);

if (!$data) {
    echo "User tidak ditemukan!";
    exit;
}

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cetak Kartu Anggota</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            width: 100%;
        }

        .card {
            width: 450px;
            height: 250px;
            background-color: #fff;
            border: 2px solid #005b8f;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            margin-bottom: 20px;
            text-align: center;
        }

        .card .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #005b8f;
            color: #fff;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .card .header img {
            height: 40px;
            margin-right: 10px;
            margin-left: 10px;
            vertical-align: middle;
            border-radius: 5px;
        }

        .card .header .address {
            font-size: 10px;
            font-weight: normal;
            text-align: center;
            flex-grow: 1;
        }

        .card .content {
            flex: 1;
            display: flex;
            flex-direction: row;
            padding: 25px;
            text-align: left;
        }

        .card .content .details {
            flex: 2;
        }

        .card .content .details h2 {
            font-size: 18px;
            margin: 5px 0;
            color: #005b8f;
        }

        .card .content .details p {
            font-size: 16px;
            margin: 3px 0;
        }

        .card .content img {
            flex: 1;
            max-width: 130px;
            max-height: 130px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 20px;
            border: 2px solid #005b8f;
        }

        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #005b8f;
            width: 30%;
            color: #fff;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        @media print {
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                padding: 0;
                margin: 0;
            }

            .print-button {
                display: none;
            }

            .card-container {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
                justify-content: center;
                width: 100%;
            }

            .card {
                box-shadow: none;
                border: 2px solid #005b8f;
                margin: 0 auto;
                width: 450px !important;
                height: 250px !important;
                page-break-inside: avoid;
                text-align: center;
            }

            .card .header {
                background-color: #005b8f !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: #fff !important;
            }

            .card .content {
                display: flex;
                flex-direction: row;
                padding: 25px;
                text-align: left;
            }

            .card .content .details {
                text-align: left;
            }

            .card .content img {
                max-width: 130px;
                max-height: 130px;
                border-radius: 50%;
                object-fit: cover;
                margin-left: 20px;
                border: 2px solid #005b8f;
            }

        }
    </style>
</head>

<body>
    <div class="card-container">
        <div class="card">
            <div class="header">
                <img src="img/ft.png" alt="Logo HMI">
                <div class="address"><span style="font-size: 18px; font-weight: bold;">PERPUSTAKAAN FT UNMA</span><br>Jln. K.H. Abdul Halim No.103, Majalengka</div>
                <img src="<?php echo $qrImage; ?>" alt="QR Code" class="qr">
            </div>

            <div class="content">
                <div class="details">
                    <h2>Kartu Anggota Perpustakaan</h2>
                    <p><strong>Nama:</strong> <?php echo $data['NamaLengkap']; ?></p>
                    <p><strong>NPM:</strong> <?php echo $data['NPM']; ?></p>
                    <p><strong>Alamat:</strong> <?php echo $data['Alamat']; ?></p>
                    <p><strong>Email:</strong> <?php echo $data['Email']; ?></p>
                    <p><strong>Status:</strong> <?php echo $data['status']; ?></p>
                </div>
                <img src="img/<?php echo $data['Gambar']; ?>" alt="Foto Profil">
            </div>
        </div>
    </div>

    <a href="javascript:window.print()" class="print-button">Cetak Kartu</a>
    <a href="anggota.php" class="print-button">Kembali</a>

</body>

</html>
