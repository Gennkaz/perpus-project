<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

$filter_keperluan = isset($_POST['filter_keperluan']) ? $_POST['filter_keperluan'] : '';
$filter_tanggal = isset($_POST['filter_tanggal']) ? $_POST['filter_tanggal'] : '';

$query = "SELECT * FROM daftar_hadir WHERE 1";
if (!empty($filter_keperluan)) {
    $query .= " AND Keperluan = '$filter_keperluan'";
}
if (!empty($filter_tanggal)) {
    $query .= " AND DATE(TimeStamp) = '$filter_tanggal'";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Data Kunjungan</title>
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

<style>
    @media print {
        @page {
            size: landscape;
            color: black;
        }

        th:nth-child(8),
        td:nth-child(8) {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            font-size: 12px;
            color: black;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .print-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .print-header h3 {
            font-size: 18px;
            margin: 0;
            color: black;
        }

        .print-header p {
            font-size: 14px;
            margin: 0;
        }
    }
</style>


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

            <div class="container-fluid pt-4 px-4 text-white">
                <div class="card-body">
                    <h3 class="text-primary mb-4">Laporan Kunjungan Perpustakaan</h3>

                    <form action="" method="POST" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="filter_keperluan" class="form-label">Filter Keperluan</label>
                            <select name="filter_keperluan" id="filter_keperluan" class="form-select text-white bg-light">
                                <option value="">Semua Keperluan</option>
                                <option value="Membaca Buku" <?= $filter_keperluan == "Membaca Buku" ? 'selected' : '' ?>>Membaca Buku</option>
                                <option value="Meminjam Buku" <?= $filter_keperluan == "Meminjam Buku" ? 'selected' : '' ?>>Meminjam Buku</option>
                                <option value="Mengerjakan Tugas" <?= $filter_keperluan == "Mengerjakan Tugas" ? 'selected' : '' ?>>Mengerjakan Tugas</option>
                                <option value="Keperluan Lainnya" <?= $filter_keperluan == "Keperluan Lainnya" ? 'selected' : '' ?>>Keperluan Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filter_tanggal" class="form-label">Filter Tanggal</label>
                            <input type="date" name="filter_tanggal" id="filter_tanggal" class="form-control text-white bg-light" value="<?= $filter_tanggal ?>">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-3"><i class="fas fa-filter me-2"></i>Filter</button>
                            <a href="daftar_kunjungan.php" class="btn btn-light me-3"><i class="fas fa-sync-alt me-2"></i>Reset</a>
                            <a href="cetak_kunjungan.php?filter_keperluan=<?= $filter_keperluan ?>&filter_tanggal=<?= $filter_tanggal ?>" class="btn btn-primary">
                                <i class="fas fa-print me-2"></i>Cetak
                            </a>
                        </div>

                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-white">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nomor Pokok Mahasiswa</th>
                                    <th>Prodi</th>
                                    <th>Angkatan</th>
                                    <th>Keperluan</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($conn, $query);
                                $count = mysqli_num_rows($sql);

                                if ($count == 0) {
                                ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data kunjungan!</td>
                                    </tr>
                                    <?php
                                } else {
                                    $jumlah = 1;
                                    while ($data = $sql->fetch_assoc()) {
                                    ?>
                                        <tr class="text-white">
                                            <td><?= $jumlah; ?></td>
                                            <td><?= $data['NamaLengkap']; ?></td>
                                            <td><?= $data['NPM']; ?></td>
                                            <td><?= $data['Prodi']; ?></td>
                                            <td><?= $data['Angkatan']; ?></td>
                                            <td><?= $data['Keperluan']; ?></td>
                                            <td><?= $data['TimeStamp']; ?></td>
                                            <td>
                                                <a href="daftar_detail.php?id=<?= $data['id']; ?>" class="btn btn-light"><i class="fas fa-edit"></i></a>
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