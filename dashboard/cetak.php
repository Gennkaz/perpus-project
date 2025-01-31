<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Buku</title>
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

        .denda {
            color: red;
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
        <img src="img/ft.png" alt="Logo Universitas">
        <div class="text">
            <h1>Perpustakaan Fakultas Teknik UNMA</h1>
            <h2>Laporan Peminjaman Buku</h2>
            <p>Majalengka, <?php echo date('d F Y'); ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Lengkap</th>
                <th>NPM</th>
                <th>Buku</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
                <th>Keterangan Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../koneksi.php";

            $status_peminjaman = isset($_GET['status_peminjaman']) ? $_GET['status_peminjaman'] : '';
            $denda = isset($_GET['denda']) ? $_GET['denda'] : '';

            $sql = "SELECT * FROM peminjaman
                    LEFT JOIN user ON user.UserID = peminjaman.UserID
                    LEFT JOIN buku ON buku.BukuID = peminjaman.BukuID
                    WHERE 1";

            if ($status_peminjaman) {
                $sql .= " AND peminjaman.StatusPeminjaman = '$status_peminjaman'";
            }

            if ($denda) {
                if ($denda == 'ada') {
                    $sql .= " AND DATEDIFF(CURRENT_DATE, peminjaman.TanggalPengembalian) > 0";
                } elseif ($denda == 'tidak') {
                    $sql .= " AND DATEDIFF(CURRENT_DATE, peminjaman.TanggalPengembalian) <= 0";
                }
            }

            $query = mysqli_query($conn, $sql);

            if (mysqli_num_rows($query) == 0) {
                echo '<tr><td colspan="8">Data tidak tersedia</td></tr>';
            } else {
                $no = 1;
                while ($data = mysqli_fetch_array($query)) {
                    $tanggalPengembalian = new DateTime($data['TanggalPengembalian']);
                    $tanggalSekarang = new DateTime();
                    $hariTerlambat = $tanggalSekarang > $tanggalPengembalian ? $tanggalSekarang->diff($tanggalPengembalian)->days : 0;
                    $dendaAmount = $hariTerlambat * 2500;

                    if ($data['StatusPeminjaman'] == 'dikembalikan' || $data['StatusPeminjaman'] == 'pending') {
                        $keteranganDenda = "Tidak ada denda";
                    } else {
                        $keteranganDenda = $hariTerlambat > 0 ? "<span class='denda'>{$hariTerlambat} hari (Denda: Rp $dendaAmount)</span>" : "Tidak ada denda";
                    }

                    echo "<tr>
                    <td>{$no}</td>
                    <td>{$data['NamaLengkap']}</td>
                    <td>{$data['NPM']}</td>
                    <td>{$data['Judul']}</td>
                    <td>{$data['TanggalPeminjaman']}</td>
                    <td>{$data['TanggalPengembalian']}</td>
                    <td>{$data['StatusPeminjaman']}</td>
                    <td>{$keteranganDenda}</td>
                </tr>";
                    $no++;
                }
            }
            ?>
        </tbody>
    </table>

    <div class="print-actions">
        <a href="laporan.php" class="print-button">Kembali</a>
        <a href="javascript:window.print()" class="print-button">Cetak Laporan</a>
    </div>

</body>

</html>
