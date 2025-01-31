<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Koleksi</title>
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

        <?php
        require "sidebar.php";
        ?>

        <div class="content">
            <?php
            require "navbar.php";
            ?>

            <div class="container-fluid pt-4 px-4">
                <div class="col-12 col-md-6">
                    <h3 style="color: #005b8f;">Tambah Koleksi Buku</h3>

                    <form action="" method="POST">
                        <div class="my-3">
                            <label for="BukuID" class="mb-2 text-white">Nama Buku</label>
                            <select id="BukuID" name="BukuID" class="form-control" required>
                                <option value="">Pilih Buku</option>
                                <?php
                                $sql = "SELECT * FROM buku";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($row['BukuID']) . '">' . htmlspecialchars($row['Judul']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-light" name="simpan">Simpan</button>
                        </div>
                        <?php
                        if (isset($_POST['simpan'])) {
                            $bukuID = $_POST['BukuID'];
                            $userID = $_SESSION['user']['UserID'];

                            if ($userID) {
                                $insertQuery = "INSERT INTO koleksipribadi (UserID, BukuID) VALUES ('$userID', '$bukuID')";
                                if (mysqli_query($conn, $insertQuery)) {
                                    echo "<script>alert('Koleksi Buku berhasil ditambahkan!');</script>";
                                    echo '<meta http-equiv="refresh" content="1; url=koleksi.php" />';
                                } else {
                                    echo '<div class="alert alert-danger">Gagal menyimpan koleksi buku: ' . $conn->error . '</div>';
                                }
                            } else {
                                echo "Pengguna tidak ditemukan.";
                            }
                        }
                        ?>
                    </form>
                </div>

                <div class="mt-5">
                    <p><i class="fas fa-arrow-right"></i> <a href="../buku_list.php" target="blank">List Buku</a></p>
                    <h3 style="color: #005b8f;">List Koleksi Buku</h3>

                    <div class="table-responsive mt-4">
                        <table class="table" style="color: white;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Cover</th>
                                    <th>Nama Buku</th>
                                    <th>Pinjam</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $userID = $_SESSION['user']['UserID'];

                                $koleksiQuery = mysqli_query($conn, "SELECT*FROM koleksipribadi
                                LEFT JOIN user ON user.UserID = koleksipribadi.UserID
                                LEFT JOIN buku ON buku.BukuID = koleksipribadi.BukuID
                                WHERE koleksipribadi.UserID='$userID'");

                                $count = mysqli_num_rows($koleksiQuery);

                                if ($count == 0) {
                                ?>
                                    <tr>
                                        <td colspan="5" class="text-center">List Koleksi Tidak Tersedia!</td>
                                    </tr>
                                    <?php
                                } else {
                                    $jumlah = 1;
                                    while ($data = mysqli_fetch_array($koleksiQuery)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $jumlah; ?></td>
                                            <td>
                                                <img src="imgbuku/<?php echo $data['Gambar']; ?>" alt="Gambar Buku" style="width: 50px; height: auto;">
                                            </td>
                                            <td><?php echo $data['Judul']; ?></td>
                                            <td>
                                                <a href="peminjaman.php?BukuID=<?php echo urlencode($data['BukuID']); ?>&Judul=<?php echo urlencode($data['Judul']); ?>" class="btn btn-light">
                                                    <i class="fas fa-book-reader"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="koleksi_detail.php?id=<?php echo $data['KoleksiID']; ?>"
                                                    class="btn btn-light"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                <?php
                                        $jumlah++;
                                    }
                                }
                                ?>
                            </tbody>
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