<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kategori buku</title>
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
                    <h3 style="color: #005b8f;">Tambah Kategori Buku</h3>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="my-4">
                            <label for="NamaKategori" class="mb-2" style="color: white;">Nama Kategori</label>
                            <input type="text" id="NamaKategori" name="NamaKategori" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Input nama kategori" required>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-light" name="simpan">Simpan</button>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['simpan'])) {
                        $nama = $_POST['NamaKategori'];

                        $sql = mysqli_query($conn, "INSERT INTO kategoribuku (NamaKategori) VALUES ('$nama')");

                        if (!$sql) {
                            die("Query Error : " . mysqli_errno($conn) . "-" . mysqli_error($conn));
                        } else {
                            echo "<script>alert('Kategori berhasil Ditambahkan!');</script>";
                    ?>
                            <meta http-equiv="refresh" content="1, url=kategori_buku.php" />
                    <?php
                        }
                    }
                    ?>

                </div>

                <div class="mt-5">
                    <h3 style="color: #005b8f;">List Kategori Buku</h3>

                    <div class="table-responsive mt-4">
                        <table class="table" style="color: white;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Buku</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($conn, "SELECT * FROM kategoribuku");
                                $count = mysqli_num_rows($sql);
                                
                                if ($count == 0) {
                                ?>
                                    <tr>
                                        <td colspan="3" class="text-center">List Kategori Tidak Tersedia!</td>
                                    </tr>
                                    <?php
                                } else {
                                    $jumlah = 1;
                                    while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $jumlah; ?></td>
                                            <td><?php echo $data['NamaKategori']; ?></td>
                                            <td>
                                                <a href="kategori_buku_detail.php?id=<?php echo $data['KategoriID']; ?>"
                                                    class="btn btn-light"><i class="fas fa-edit"></i></a>
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