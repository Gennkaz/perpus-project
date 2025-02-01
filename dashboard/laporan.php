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

<style>
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
                <div class="col-12 col-md-6">
                    <h3 style="color: #005b8f;">Tambah Peminjaman</h3>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="my-3">
                            <label for="NamaLengkap" class="mb-2" style="color: white;">Nama Peminjam</label>
                            <select id="NamaLengkap" name="NamaLengkap" class="form-control">
                                <option value="">Pilih Nama Peminjam</option>
                                <?php
                                $sql = "SELECT UserID, NamaLengkap FROM user WHERE role='user'";
                                $result = $conn->query($sql);

                                while ($row = $result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['UserID'] ?>"><?php echo $row['NamaLengkap'] ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="my-3">
                            <label for="BukuID" class="mb-2 text-white">Nama Buku</label>
                            <select id="BukuID" name="BukuID" class="form-control" onchange="updateStock()">
                                <option value="">Pilih Buku</option>
                                <?php
                                $selectedBukuID = isset($_GET['BukuID']) ? $_GET['BukuID'] : '';

                                $sql = "SELECT * FROM buku";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($row['BukuID'] == $selectedBukuID) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($row['BukuID']) . '" data-stok="' . htmlspecialchars($row['JumlahBuku']) . '" ' . $selected . '>' . htmlspecialchars($row['Judul']) . '</option>';
                                }
                                ?>
                            </select>
                            <p class="mt-2">Stok tersedia: <span id="stokBuku">0</span></p>
                        </div>
                        <div class="my-3">
                            <label for="TanggalPeminjaman" class="mb-2 text-white">Tanggal Peminjaman</label>
                            <input type="date" id="TanggalPeminjaman" name="TanggalPeminjaman" class="form-control bg-white text-dark" readonly required>
                        </div>
                        <div class="my-3">
                            <label for="TanggalPengembalian" class="mb-2 text-white">Tanggal Pengembalian</label>
                            <input type="date" id="TanggalPengembalian" name="TanggalPengembalian" class="form-control bg-white text-dark" required>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-light mb-2" name="simpan">Simpan</button>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['simpan'])) {
                        $userID = $_POST['NamaLengkap'];
                        $bukuID = $_POST['BukuID'];
                        $tanggalPeminjaman = $_POST['TanggalPeminjaman'];
                        $tanggalPengembalian = $_POST['TanggalPengembalian'];
                        $jumlahBuku = 1;

                        $sqlCheck = "SELECT * FROM peminjaman WHERE UserID = $userID AND BukuID = $bukuID AND StatusPeminjaman = 'pinjam'";
                        $resultCheck = $conn->query($sqlCheck);

                        if ($resultCheck->num_rows > 0) {
                            echo '<div class="alert alert-warning">Peminjam ini sudah meminjam buku tersebut. Tidak bisa meminjam buku yang sama lagi.</div>';
                        } else {
                            $tanggalPeminjamanObj = new DateTime($tanggalPeminjaman);
                            $tanggalPengembalianObj = new DateTime($tanggalPengembalian);
                            $selisihHari = $tanggalPengembalianObj->diff($tanggalPeminjamanObj)->days;

                            if ($selisihHari > 7) {
                                echo '<div class="alert alert-warning">Batas maksimal peminjaman adalah 7 hari.</div>';
                            } else {
                                $sql = "SELECT JumlahBuku FROM buku WHERE BukuID = $bukuID";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $stokBuku = $row['JumlahBuku'];

                                if ($stokBuku == 0) {
                                    echo '<div class="alert alert-warning">Buku yang Anda pilih tidak tersedia.</div>';
                                } else {
                                    $status = 'pending';
                                    $sqlInsert = "INSERT INTO peminjaman (UserID, BukuID, TanggalPeminjaman, TanggalPengembalian, JumlahBuku, StatusPeminjaman) 
                              VALUES ($userID, $bukuID, '$tanggalPeminjaman', '$tanggalPengembalian', $jumlahBuku, '$status')";

                                    if ($conn->query($sqlInsert) === TRUE) {
                                        $newStock = $stokBuku - 1;
                                        $sqlUpdate = "UPDATE buku SET JumlahBuku = $newStock WHERE BukuID = $bukuID";
                                        if ($conn->query($sqlUpdate) === TRUE) {
                                            echo "<script>alert('Peminjaman berhasil diproses, status pending.');</script>";
                                            echo '<meta http-equiv="refresh" content="1; url=laporan.php" />';
                                        } else {
                                            echo '<div class="alert alert-danger">Gagal memperbarui stok buku: ' . $conn->error . '</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger">Gagal menyimpan data peminjaman: ' . $conn->error . '</div>';
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </div>

                <div class="card-body">
                    <h3 style="color: #005b8f;" class="mb-3">List Laporan Peminjaman</h3>

                    <form method="GET" action="" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="Peminjaman" class="form-label">Filter Status Peminjaman</label>
                            <select class="form-select text-white bg-light" name="status_peminjaman">
                                <option value="">Pilih Status Peminjaman</option>
                                <option value="pinjam" <?php echo (isset($_GET['status_peminjaman']) && $_GET['status_peminjaman'] == 'pinjam') ? 'selected' : ''; ?>>Dipinjam</option>
                                <option value="Dikembalikan" <?php echo (isset($_GET['status_peminjaman']) && $_GET['status_peminjaman'] == 'Dikembalikan') ? 'selected' : ''; ?>>Dikembalikan</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="Denda" class="form-label">Filter Denda</label>
                            <select class="form-select text-white bg-light" name="denda">
                                <option value="">Pilih Denda</option>
                                <option value="ada" <?php echo (isset($_GET['denda']) && $_GET['denda'] == 'ada') ? 'selected' : ''; ?>>Ada Denda</option>
                                <option value="tidak" <?php echo (isset($_GET['denda']) && $_GET['denda'] == 'tidak') ? 'selected' : ''; ?>>Tidak Ada Denda</option>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-3"><i class="fas fa-filter me-2"></i>Filter</button>
                            <a href="laporan.php" class="btn btn-light me-3"><i class="fas fa-sync-alt me-2"></i>Reset</a>
                            <a href="cetak.php?status_peminjaman=<?php echo isset($_GET['status_peminjaman']) ? $_GET['status_peminjaman'] : ''; ?>&denda=<?php echo isset($_GET['denda']) ? $_GET['denda'] : ''; ?>" class="btn btn-primary">
                                <i class="fas fa-print me-2"></i>Cetak
                            </a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table" style="color: white;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Lengkap</th>
                                <th>NPM</th>
                                <th>Cover</th>
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

                                    if ($data['StatusPeminjaman'] != 'dikembalikan' && $data['StatusPeminjaman'] != 'pending') {
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
                                            <td>
                                                <img src='imgbuku/" . htmlspecialchars($data['Gambar']) . "' alt='Gambar Buku' style='width: 50px; height: auto;'>
                                            </td>
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
    <script>
        function updateStock() {
            var select = document.getElementById("BukuID");
            var selectedOption = select.options[select.selectedIndex];
            var stok = selectedOption.getAttribute("data-stok");
            document.getElementById("stokBuku").innerText = stok;
        }

        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("TanggalPeminjaman").value = today;

            document.getElementById("TanggalPeminjaman").readOnly = true;

            var tanggalPeminjamanInput = document.getElementById("TanggalPeminjaman");
            var tanggalPengembalianInput = document.getElementById("TanggalPengembalian");

            tanggalPeminjamanInput.addEventListener("change", function() {
                var tanggalPeminjaman = new Date(tanggalPeminjamanInput.value);
                tanggalPeminjaman.setDate(tanggalPeminjaman.getDate() + 1);

                var minTanggalPengembalian = tanggalPeminjaman.toISOString().split('T')[0];
                tanggalPengembalianInput.setAttribute("min", minTanggalPengembalian);
                tanggalPengembalianInput.value = minTanggalPengembalian;
            });

            tanggalPeminjamanInput.dispatchEvent(new Event("change"));
        });
    </script>
    </script>
</body>

</html>