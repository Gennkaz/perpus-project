<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

$kategoriFilter = isset($_GET['kategoriID']) ? $_GET['kategoriID'] : '';

$query = "SELECT b.bukuID, b.Judul, b.Penulis, b.Penerbit, b.TahunTerbit, b.JumlahBuku, b.ISBN, b.Gambar, k.NamaKategori
          FROM buku b
          LEFT JOIN kategoribuku_relasi r ON b.bukuID = r.bukuID
          LEFT JOIN kategoribuku k ON r.KategoriID = k.KategoriID";

if ($kategoriFilter != '') {
    $query .= " WHERE k.KategoriID = '$kategoriFilter'";
}

$query .= " ORDER BY k.NamaKategori, b.Judul";

$buku = mysqli_query($conn, $query);
$count = mysqli_num_rows($buku);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Buku</title>
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
                    <h3 style="color: #005b8f;">Tambah Buku</h3>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="my-3">
                            <label for="Judul" class="mb-2" style="color: white;">Nama Buku</label>
                            <input type="text" id="Judul" name="Judul" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Input nama buku" required>
                        </div>
                        <div class="my-3">
                            <label for="Penulis" class="mb-2" style="color: white;">Penulis</label>
                            <input type="text" id="Penulis" name="Penulis" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Input nama penulis" required>
                        </div>
                        <div class="my-3">
                            <label for="Penerbit" class="mb-2" style="color: white;">Penerbit</label>
                            <input type="text" id="Penerbit" name="Penerbit" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Input nama penerbit" required>
                        </div>
                        <div class="my-3">
                            <label for="TahunTerbit" class="mb-2" style="color: white;">Tahun Terbit</label>
                            <input type="number" id="TahunTerbit" name="TahunTerbit" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Input tahun terbit" required>
                        </div>
                        <div class="my-3">
                            <label for="JumlahBuku" class="mb-2" style="color: white;">Stok Buku</label>
                            <input type="number" id="JumlahBuku" name="JumlahBuku" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Input stok buku" required>
                        </div>
                        <div class="my-3">
                            <label for="ISBN" class="mb-2" style="color: white;">ISBN</label>
                            <input type="number" id="ISBN" name="ISBN" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Input ISBN" required>
                        </div>
                        <div class="my-3">
                            <label for="kategoriID" class="mb-2" style="color: white;">Kategori</label>
                            <select id="kategoriID" name="kategoriID" class="form-control">
                                <?php
                                $sql = "SELECT KategoriID, NamaKategori FROM kategoribuku";
                                $result = $conn->query($sql);

                                while ($row = $result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['KategoriID'] ?>"><?php echo $row['NamaKategori'] ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="my-3">
                            <label for="Gambar" class="mb-2" style="color: white;">Gambar Buku</label>
                            <input type="file" id="Gambar" name="Gambar" class="form-control bg-white" style="color: black;">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-light" name="simpan">Simpan</button>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['simpan'])) {
                        $judul = $_POST['Judul'];
                        $penulis = $_POST['Penulis'];
                        $penerbit = $_POST['Penerbit'];
                        $tahunTerbit = $_POST['TahunTerbit'];
                        $jumlahBuku = $_POST['JumlahBuku'];
                        $kategoriID = $_POST['kategoriID'];
                        $isbn = $_POST['ISBN'];

                        if (!empty($_FILES['Gambar']['name'])) {
                            $gambar = $_FILES['Gambar']['name'];
                            $tmp_name = $_FILES['Gambar']['tmp_name'];
                            $ekstensi = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
                            $ekstensiDiizinkan = ['jpg', 'jpeg', 'png'];

                            if (in_array($ekstensi, $ekstensiDiizinkan)) {
                                $gambarBaru = 'buku_' . uniqid() . '.' . $ekstensi;
                                move_uploaded_file($tmp_name, 'imgbuku/' . $gambarBaru);
                            } else {
                                echo '<div class="alert alert-info" role="alert">Hanya file JPG, JPEG, dan PNG yang diizinkan!</div>';
                                exit;
                            }
                        } else {
                            $gambarBaru = null;
                        }

                        $sqlBuku = "INSERT INTO buku (Judul, Penulis, Penerbit, TahunTerbit, JumlahBuku, Gambar, ISBN) VALUES ('$judul', '$penulis', '$penerbit', '$tahunTerbit', '$jumlahBuku', '$gambarBaru', '$isbn')";

                        if (mysqli_query($conn, $sqlBuku)) {
                            $bukuID = mysqli_insert_id($conn);
                            $sqlRelasi = "INSERT INTO kategoribuku_relasi (bukuID, KategoriID) VALUES ('$bukuID', '$kategoriID')";

                            if (mysqli_query($conn, $sqlRelasi)) {
                                echo "<script>alert('Buku berhasil ditambahkan!');</script>";
                                echo '<meta http-equiv="refresh" content="1; url=buku.php" />';
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Error inserting relation: ' . mysqli_error($conn) . '</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Error inserting book: ' . mysqli_error($conn) . '</div>';
                        }
                    }
                    ?>

                </div>

                <div class="mt-5">
                    <h3 style="color: #005b8f;">List Buku</h3>

                    <form method="get" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="kategoriID" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    <?php
                                    $sqlKategori = "SELECT KategoriID, NamaKategori FROM kategoribuku";
                                    $resultKategori = $conn->query($sqlKategori);

                                    while ($row = $resultKategori->fetch_assoc()) {
                                        $selected = ($row['KategoriID'] == $kategoriFilter) ? 'selected' : '';
                                        echo "<option value='" . $row['KategoriID'] . "' $selected>" . $row['NamaKategori'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive mt-3">
                        <table class="table" style="color: white;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Cover</th>
                                    <th>Nama Buku</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tahun Terbit</th>
                                    <th>ISBN</th>
                                    <th>Stok</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($count == 0) {
                                ?>
                                    <tr>
                                        <td colspan="10" class="text-center">List Buku Tidak Tersedia!</td>
                                    </tr>
                                    <?php
                                } else {
                                    $jumlah = 1;
                                    while ($data = $buku->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $jumlah; ?></td>
                                            <td>
                                                <img src="imgbuku/<?php echo $data['Gambar']; ?>" alt="Gambar Buku" style="width: 50px; height: auto;">
                                            </td>
                                            <td><?php echo $data['Judul']; ?></td>
                                            <td><?php echo $data['NamaKategori']; ?></td>
                                            <td><?php echo $data['Penulis']; ?></td>
                                            <td><?php echo $data['Penerbit']; ?></td>
                                            <td><?php echo $data['TahunTerbit']; ?></td>
                                            <td><?php echo $data['ISBN']; ?></td>
                                            <td><?php echo $data['JumlahBuku']; ?></td>
                                            <td>
                                                <a href="buku_detail.php?id=<?php echo $data['bukuID']; ?>" class="btn btn-light"><i class="fas fa-edit"></i></a>
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