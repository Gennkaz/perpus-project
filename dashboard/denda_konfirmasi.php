<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Peminjaman Buku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Peminjaman buku">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">

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

        <?php require "sidebar.php"; ?>

        <div class="content">
            <?php require "navbar.php"; ?>

            <div class="container-fluid pt-4 px-4">
                <div class="mt-3">
                    <h3 style="color: #005b8f;">Konfirmasi Denda</h3>

                    <div class="table-responsive mt-3">
                        <table class="table" style="color: white;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nama Buku</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Status Peminjaman</th>
                                    <th>Terlambat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $queryPeminjaman = "SELECT p.*, b.Judul, b.Gambar, b.ISBN, b.Penulis, b.Penerbit, b.TahunTerbit, kb.NamaKategori, u.NamaLengkap 
                                                    FROM peminjaman p 
                                                    JOIN buku b ON p.BukuID = b.BukuID 
                                                    JOIN kategoribuku_relasi kbr ON b.BukuID = kbr.BukuID 
                                                    JOIN kategoribuku kb ON kbr.KategoriID = kb.KategoriID
                                                    JOIN user u ON p.UserID = u.UserID
                                                    WHERE StatusPeminjaman='pinjam'";

                                $resultPeminjaman = $conn->query($queryPeminjaman);

                                if ($resultPeminjaman->num_rows == 0) {
                                    echo '<tr><td colspan="8" class="text-center">List Buku yang dipinjam Tidak Tersedia!</td></tr>';
                                } else {
                                    $jumlah = 1;
                                    $dataFound = false;

                                    while ($data = $resultPeminjaman->fetch_assoc()) {
                                        if ($data['TanggalPengembalian'] === null || $data['TanggalPengembalian'] === '') {
                                            continue;
                                        }

                                        $tanggalPengembalian = new DateTime($data['TanggalPengembalian']);
                                        $tanggalSekarang = new DateTime();

                                        if ($tanggalSekarang > $tanggalPengembalian) {
                                            $hariTerlambat = $tanggalSekarang->diff($tanggalPengembalian)->days;
                                            $denda = $hariTerlambat * 2500;
                                            $statusKeterlambatan = "<span style='color: red;'>$hariTerlambat hari (Denda: $denda)</span>";

                                            $dataFound = true;
                                ?>
                                            <tr>
                                                <td><?php echo $jumlah; ?></td>
                                                <td><?php echo htmlspecialchars($data['NamaLengkap']); ?></td>
                                                <td><?php echo htmlspecialchars($data['Judul']); ?></td>
                                                <td><?php echo htmlspecialchars($data['TanggalPeminjaman']); ?></td>
                                                <td><?php echo htmlspecialchars($data['TanggalPengembalian']); ?></td>
                                                <td><?php echo htmlspecialchars($data['StatusPeminjaman']); ?></td>
                                                <td><?php echo $statusKeterlambatan; ?></td>
                                                <td>
                                                    <a href="denda_detail.php?id=<?php echo $data['PeminjamanID']; ?>" class="btn btn-light"><i class="fas fa-exclamation"></i></a>
                                                </td>
                                            </tr>
                                <?php
                                            $jumlah++;
                                        }
                                    }

                                    if (!$dataFound) {
                                        echo '<tr><td colspan="8" class="text-center">List Buku yang harus dikonfirmasi Tidak Tersedia!</td></tr>';
                                    }
                                }
                                ?>
                            </tbody>


                        </table>
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