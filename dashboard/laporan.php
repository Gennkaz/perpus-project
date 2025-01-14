<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan</title>
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

        <?php require "sidebar.php"; ?>

        <div class="content">
            <?php require "navbar.php"; ?>

            <div class="container-fluid pt-4 px-4">
                <h3 style="color: #005b8f;">List Laporan Peminjaman</h3>

                <form method="GET" action="" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-select text-white bg-light" name="status_peminjaman">
                                <option value="">Pilih Status Peminjaman</option>
                                <option value="pinjam" <?php echo (isset($_GET['status_peminjaman']) && $_GET['status_peminjaman'] == 'pinjam') ? 'selected' : ''; ?>>Dipinjam</option>
                                <option value="Dikembalikan" <?php echo (isset($_GET['status_peminjaman']) && $_GET['status_peminjaman'] == 'Dikembalikan') ? 'selected' : ''; ?>>Dikembalikan</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select class="form-select text-white bg-light" name="denda">
                                <option value="">Pilih Denda</option>
                                <option value="ada" <?php echo (isset($_GET['denda']) && $_GET['denda'] == 'ada') ? 'selected' : ''; ?>>Ada Denda</option>
                                <option value="tidak" <?php echo (isset($_GET['denda']) && $_GET['denda'] == 'tidak') ? 'selected' : ''; ?>>Tidak Ada Denda</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="cetak.php?status_peminjaman=<?php echo isset($_GET['status_peminjaman']) ? $_GET['status_peminjaman'] : ''; ?>&denda=<?php echo isset($_GET['denda']) ? $_GET['denda'] : ''; ?>" class="btn btn-primary">
                                <i class="fas fa-print"> Cetak Laporan</i>
                            </a>
                        </div>

                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table mt-1" style="color: white;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Lengkap</th>
                                <th>NPM</th>
                                <th>Buku</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Status Peminjaman</th>
                                <th>Keterangan Denda</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $status_peminjaman = isset($_GET['status_peminjaman']) ? $_GET['status_peminjaman'] : '';
                            $denda = isset($_GET['denda']) ? $_GET['denda'] : '';

                            $sql = "SELECT * FROM peminjaman
                                    LEFT JOIN user ON user.UserID = peminjaman.UserID
                                    LEFT JOIN buku ON buku.BukuID = peminjaman.BukuID
                                    WHERE 1=1";

                            if ($status_peminjaman != '') {
                                $sql .= " AND peminjaman.StatusPeminjaman = '$status_peminjaman'";
                            }

                            if ($denda == 'ada') {
                                $sql .= " AND DATEDIFF(CURDATE(), peminjaman.TanggalPengembalian) > 0";
                            } elseif ($denda == 'tidak') {
                                $sql .= " AND DATEDIFF(CURDATE(), peminjaman.TanggalPengembalian) <= 0";
                            }

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) == 0) {
                                echo '<tr><td colspan="9" class="text-center">List Laporan Peminjaman Tidak Tersedia!</td></tr>';
                            } else {
                                $no = 1;
                                while ($data = mysqli_fetch_array($result)) {
                                    $tanggalPengembalian = new DateTime($data['TanggalPengembalian']);
                                    $tanggalSekarang = new DateTime();
                                
                                    $hariTerlambat = 0;
                                    $denda = 0;
                                    
                                    if ($data['StatusPeminjaman'] != 'dikembalikan' && $data['StatusPeminjaman'] != 'pending')  {
                                        if ($tanggalSekarang > $tanggalPengembalian) {
                                            $hariTerlambat = $tanggalSekarang->diff($tanggalPengembalian)->days;
                                            $denda = $hariTerlambat * 2500;
                                        }
                                    }
                                
                                    if ($denda > 0) {
                                        $alertMessage = $hariTerlambat . ' Hari <br>Denda: Rp ' . number_format($denda, 0, ',', '.');
                                        $alertClass = 'color: red;';
                                    } else {
                                        if ($data['StatusPeminjaman'] == 'dikembalikan' || $data['StatusPeminjaman'] == 'pending') {
                                            $alertMessage = 'Tidak ada denda';
                                            $alertClass = 'color: white;';
                                        } else {
                                            $alertMessage = 'Tidak ada denda';
                                            $alertClass = 'color: white;';
                                        }
                                    }
                                
                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td>{$data['NamaLengkap']}</td>
                                            <td>{$data['NPM']}</td>
                                            <td>{$data['Judul']}</td>
                                            <td>{$data['TanggalPeminjaman']}</td>
                                            <td>{$data['TanggalPengembalian']}</td>
                                            <td>{$data['StatusPeminjaman']}</td>
                                            <td><div style='{$alertClass}'>{$alertMessage}</div></td>
                                            <td>{$data['Created']}</td>
                                            <td><a href='laporan_detail.php?id={$data['PeminjamanID']}' class='btn btn-light'><i class='fas fa-search'></i></a></td>
                                        </tr>";
                                    $no++;
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