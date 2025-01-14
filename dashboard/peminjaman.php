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
                <div class="col-12 col-md-6">
                    <h3 style="color: #005b8f;">Pinjam Buku</h3>

                    <form action="" method="post" enctype="multipart/form-data">
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
                        $bukuID = $_POST['BukuID'];
                        $tanggalPeminjaman = $_POST['TanggalPeminjaman'];
                        $tanggalPengembalian = $_POST['TanggalPengembalian'];
                        $jumlahBuku = 1;
                        $userID = $_SESSION['user']['UserID'];

                        $status = 'pending';

                        $tanggalPeminjamanObj = new DateTime($tanggalPeminjaman);
                        $tanggalPengembalianObj = new DateTime($tanggalPengembalian);
                        $selisihHari = $tanggalPengembalianObj->diff($tanggalPeminjamanObj)->days;

                        if ($selisihHari > 7) {
                            echo '<div class="alert alert-warning">Batas maksimal peminjaman adalah 7 hari.</div>';
                        } else {
                            $cekPinjamanBuku = "SELECT * FROM peminjaman WHERE UserID = $userID AND BukuID = $bukuID AND StatusPeminjaman = 'pinjam'";
                            $cekResult = $conn->query($cekPinjamanBuku);

                            if ($cekResult->num_rows > 0) {
                                echo '<div class="alert alert-warning">Anda sudah meminjam buku ini. Silakan kembalikan terlebih dahulu sebelum meminjam lagi.</div>';
                            } else {
                                $sql = "SELECT JumlahBuku FROM buku WHERE BukuID = $bukuID";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();

                                if ($row) {
                                    $stokBuku = $row['JumlahBuku'];

                                    if ($stokBuku == 0) {
                                        echo '<div class="alert alert-warning">Buku yang Anda pinjam tidak tersedia.</div>';
                                    } elseif ($jumlahBuku <= $stokBuku) {
                                        $sql = "INSERT INTO peminjaman (UserID, BukuID, TanggalPeminjaman, TanggalPengembalian, JumlahBuku, StatusPeminjaman) 
                                                VALUES ($userID, $bukuID, '$tanggalPeminjaman', '$tanggalPengembalian', $jumlahBuku, '$status')";

                                        if ($conn->query($sql) === TRUE) {
                                            $newStock = $stokBuku - $jumlahBuku;
                                            $sql = "UPDATE buku SET JumlahBuku = $newStock WHERE BukuID = $bukuID";
                                            $conn->query($sql);

                                            echo "<script>alert('Peminjaman Buku dipending, hubungi petugas yang terkait untuk verifikasi!');</script>";
                                            echo '<meta http-equiv="refresh" content="1; url=peminjaman.php" />';
                                        } else {
                                            echo '<div class="alert alert-danger">Gagal menyimpan data peminjaman: ' . $conn->error . '</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-warning">Stok tidak cukup untuk peminjaman ini.</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger">Buku tidak ditemukan.</div>';
                                }
                            }
                        }
                    }
                    ?>

                </div>

                <div class="mt-5">
                    <p><i class="fas fa-arrow-right"></i> <a href="../buku_list.php" target="blank">List Buku</a></p>
                    <h3 style="color: #005b8f;">List Peminjaman Buku</h3>

                    <div class="table-responsive mt-3">
                        <table class="table" style="color: white;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Cover</th>
                                    <th>Nama Buku</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Status Peminjaman</th>
                                    <th>Jumlah</th>
                                    <th>Terlambat</th>
                                    <th>Detail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $user = $_SESSION['user']['UserID'];

                                $queryPeminjaman = "SELECT p.*, b.Judul, b.Gambar, b.ISBN, b.Penulis, b.Penerbit, b.TahunTerbit, kb.NamaKategori 
                                                    FROM peminjaman p 
                                                    JOIN buku b ON p.BukuID = b.BukuID 
                                                    JOIN kategoribuku_relasi kbr ON b.BukuID = kbr.BukuID 
                                                    JOIN kategoribuku kb ON kbr.KategoriID = kb.KategoriID 
                                                    WHERE p.UserID = $user 
                                                    AND p.StatusPeminjaman IN ('pinjam', 'pending')
                                                    ORDER BY 
                                                        CASE 
                                                            WHEN p.StatusPeminjaman = 'pinjam' THEN 1
                                                            WHEN p.StatusPeminjaman = 'pending' THEN 2
                                                            ELSE 3
                                                        END;";

                                $resultPeminjaman = $conn->query($queryPeminjaman);

                                if ($resultPeminjaman->num_rows == 0) {
                                    echo '<tr><td colspan="8" class="text-center">List Buku yang dipinjam Tidak Tersedia!</td></tr>';
                                } else {
                                    $jumlah = 1;
                                    while ($data = $resultPeminjaman->fetch_assoc()) {
                                        $tanggalPengembalian = new DateTime($data['TanggalPengembalian']);
                                        $tanggalSekarang = new DateTime();

                                        if ($tanggalSekarang > $tanggalPengembalian) {
                                            $hariTerlambat = $tanggalSekarang->diff($tanggalPengembalian)->days;
                                        } else {
                                            $hariTerlambat = 0;
                                        }

                                        $denda = $hariTerlambat > 0 ? $hariTerlambat * 2500 : 0;

                                        $statusKeterlambatan = $hariTerlambat > 0 ? "<span style='color: red;'>$hariTerlambat hari (Denda: $denda)</span>" : "0 hari";

                                        if ($data['StatusPeminjaman'] === 'pending') {
                                            $actionButton = '';
                                        } else {
                                            if ($hariTerlambat > 0) {
                                                $actionUrl = "peminjaman_denda.php?id=" . $data['PeminjamanID'];
                                                $actionButton = "<a href='#' class='btn btn-light' data-toggle='modal' data-target='#modalDenda" . $data['PeminjamanID'] . "'><i class='fas fa-exclamation'></i></a>";
                                            } else {
                                                $actionUrl = "peminjaman_detail.php?id=" . $data['PeminjamanID'];
                                                $actionButton = "<a href='$actionUrl' class='btn btn-light'><i class='fas fa-edit'></i></a>";
                                            }
                                        }
                                ?>
                                        <tr>
                                            <td><?php echo $jumlah; ?></td>
                                            <td>
                                                <img src="imgbuku/<?php echo $data['Gambar']; ?>" alt="Gambar Buku" style="width: 50px; height: auto;">
                                            </td>
                                            <td><?php echo htmlspecialchars($data['Judul']); ?></td>
                                            <td><?php echo htmlspecialchars($data['NamaKategori']); ?></td>
                                            <td><?php echo htmlspecialchars($data['TanggalPeminjaman']); ?></td>
                                            <td><?php echo htmlspecialchars($data['TanggalPengembalian']); ?></td>
                                            <td><?php echo htmlspecialchars($data['StatusPeminjaman']); ?></td>
                                            <td><?php echo htmlspecialchars($data['JumlahBuku']); ?></td>
                                            <td><?php echo $statusKeterlambatan; ?></td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalDetailBuku<?php echo $data['PeminjamanID']; ?>">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo $actionButton; ?>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modalDetailBuku<?php echo $data['PeminjamanID']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo htmlspecialchars($data['Judul']); ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Judul:</strong> <?php echo htmlspecialchars($data['Judul']); ?></p>
                                                        <p><strong>Kategori:</strong> <?php echo htmlspecialchars($data['NamaKategori']); ?></p>
                                                        <p><strong>Penulis:</strong> <?php echo htmlspecialchars($data['Penulis']); ?></p>
                                                        <p><strong>Penerbit:</strong> <?php echo htmlspecialchars($data['Penerbit']); ?></p>
                                                        <p><strong>Tahun Terbit:</strong> <?php echo htmlspecialchars($data['TahunTerbit']); ?></p>
                                                        <p><strong>ISBN:</strong> <?php echo htmlspecialchars($data['ISBN']); ?></p>
                                                        <p><strong>Cover Buku:</strong><br>
                                                            <img src="imgbuku/<?php echo $data['Gambar']; ?>" alt="Cover Buku" style="width: 100px;">
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="modalDenda<?php echo $data['PeminjamanID']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDenda" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabelDenda">Peminjaman Melebihi Batas Waktu</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Peminjaman buku <strong><?php echo htmlspecialchars($data['Judul']); ?></strong> telah melebihi batas waktu pengembalian.</p>
                                                        <p>Silahkan Hubungi admin untuk konfirmasi!</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
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