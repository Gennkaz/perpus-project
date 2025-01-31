<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

if (!isset($_SESSION['username'])) {
    header('location: login.php');
}

$query = "SELECT Role FROM user WHERE Username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$role = $user['Role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Perpustakaan</title>
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
    #combinedChart {
        height: 230px !important;
        width: 100% !important;
    }

    .chart-container {
        padding: 20px;
        background-color: #191C24;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .chart-title {
        font-size: 1.5rem;
        color: #fff;
        text-align: center;
        margin-bottom: 20px;
    }
</style>

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
                <div class="row g-4" style="color: white;">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-book fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Data Buku</p>
                                <h6 class="mb-0"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT*FROM buku")); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-user fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Data Peminjam</p>
                                <h6 class="mb-0"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT*FROM peminjaman")); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-star fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Data Ulasan</p>
                                <h6 class="mb-0"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT*FROM ulasanbuku")); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-user-shield fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Akun Pengguna</p>
                                <h6 class="mb-0"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT*FROM user")); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $lastThreeMonths = [];
            $peminjamanCounts = [];

            for ($i = 0; $i < 3; $i++) {
                $month = date('Y-m', strtotime("-$i month"));
                $query = "SELECT COUNT(*) as total FROM peminjaman WHERE DATE_FORMAT(TanggalPeminjaman, '%Y-%m') = '$month'";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    echo "Query Error: " . mysqli_error($conn);
                    exit;
                }
                $data = mysqli_fetch_assoc($result);
                $lastThreeMonths[] = date('F Y', strtotime("-$i month"));
                $peminjamanCounts[] = $data['total'];
            }

            $lastThreeMonths = array_reverse($lastThreeMonths);
            $peminjamanCounts = array_reverse($peminjamanCounts);

            $monthsJSON = json_encode($lastThreeMonths);
            $peminjamanCountsJSON = json_encode($peminjamanCounts);

            $kunjunganCounts = [];
            for ($i = 0; $i < 3; $i++) {
                $month = date('Y-m', strtotime("-$i month"));
                $query = "SELECT COUNT(*) as total FROM daftar_hadir WHERE DATE_FORMAT(TimeStamp, '%Y-%m') = '$month'";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    echo "Query Error: " . mysqli_error($conn);
                    exit;
                }
                $data = mysqli_fetch_assoc($result);
                $kunjunganCounts[] = $data['total'];
            }

            $kunjunganCounts = array_reverse($kunjunganCounts);
            $kunjunganCountsJSON = json_encode($kunjunganCounts);
            ?>

            <?php if ($role == 'admin' || $role == 'petugas'): ?>
                <div class="container-fluid pt-4 px-4">

                    <div class="chart-container">
                        <h4 class="chart-title">Grafik Peminjaman dan Kunjungan</h4>
                        <canvas id="combinedChart"></canvas>
                    </div>

                </div>
            <?php else: ?>
            <?php endif; ?>

            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">kazpus</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="https://htmlcodex.com">Akas</a>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const months = <?php echo $monthsJSON; ?>;
        const peminjamanCounts = <?php echo $peminjamanCountsJSON; ?>;
        const kunjunganCounts = <?php echo $kunjunganCountsJSON; ?>;

        const ctx = document.getElementById('combinedChart').getContext('2d');
        const combinedChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: peminjamanCounts,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                }, {
                    label: 'Jumlah Kunjungan',
                    data: kunjunganCounts,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.3)',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 3,
                            color: 'white',
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.3)',
                        },
                        ticks: {
                            autoSkip: true,
                            maxRotation: 45,
                            minRotation: 30,
                            color: 'white', // Ubah warna angka sumbu X menjadi putih
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        enabled: true,
                    }
                }
            }
        });
    </script>

</body>

</html>