<?php
include "../koneksi.php";
include_once "cek-akses.php";

$filter_keperluan = isset($_GET['filter_keperluan']) ? $_GET['filter_keperluan'] : '';
$filter_tanggal = isset($_GET['filter_tanggal']) ? $_GET['filter_tanggal'] : '';

$query = "SELECT * FROM daftar_hadir WHERE 1";
if (!empty($filter_keperluan)) {
    $query .= " AND Keperluan = '$filter_keperluan'";
}
if (!empty($filter_tanggal)) {
    $query .= " AND DATE(TimeStamp) = '$filter_tanggal'";
}

$sql = mysqli_query($conn, $query);
$count = mysqli_num_rows($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header img {
            height: 70px;
            margin-right: 20px;
        }

        .header .text {
            flex: 1;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 22px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 20px;
        }

        .header p {
            margin: 0;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
        }

        .print-actions {
            text-align: center;
            margin-top: 20px;
        }

        .print-button {
            margin: 5px;
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            background-color: #005b8f;
            color: white;
            border-radius: 5px;
        }

        .print-button:hover {
            background-color: rgb(0, 26, 41);
        }

        @media print {
            body {
                margin: 0;
                font-size: 12px;
            }

            @page {
                size: landscape;
                margin: 20mm;
            }

            table {
                width: 100%;
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .print-actions {
                display: none;
            }

            .header,
            .footer {
                font-size: 14px;
                margin-bottom: 10px;
            }

            th,
            td {
                padding: 12px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="img/ft.png" alt="Logo Fakultas Teknik">
        <div class="text">
            <h1>Perpustakaan Fakultas Teknik UNMA</h1>
            <h2>Laporan Kunjungan Perpustakaan</h2>
            <p>Majalengka, <?php echo date('d F Y'); ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Lengkap</th>
                <th>Nomor Pokok Mahasiswa</th>
                <th>Prodi</th>
                <th>Angkatan</th>
                <th>Keperluan</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($count == 0) {
                echo '<tr><td colspan="7" class="text-center">Data tidak tersedia</td></tr>';
            } else {
                $no = 1;
                while ($data = mysqli_fetch_array($sql)) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$data['NamaLengkap']}</td>
                        <td>{$data['NPM']}</td>
                        <td>{$data['Prodi']}</td>
                        <td>{$data['Angkatan']}</td>
                        <td>{$data['Keperluan']}</td>
                        <td>{$data['TimeStamp']}</td>
                    </tr>";
                    $no++;
                }
            }
            ?>
        </tbody>
    </table>

    <div class="print-actions">
        <a href="daftar_kunjungan.php" class="print-button">Kembali</a>
        <a href="javascript:window.print()" class="print-button">Cetak Laporan</a>
    </div>

</body>

</html>
