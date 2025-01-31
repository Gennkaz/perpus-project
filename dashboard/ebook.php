<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

$query = "SELECT * FROM ebook ORDER BY Judul";
$ebook = mysqli_query($conn, $query);
$count = mysqli_num_rows($ebook);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ebook</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

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
        <?php include "sidebar.php"; ?>

        <div class="content">
            <?php include "navbar.php"; ?>

            <div class="container-fluid pt-4 px-4">
                <div class="col-12 col-md-6">
                    <h3 style="color: #005b8f;">Tambah Ebook</h3>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="my-3">
                            <label for="Judul" class="mb-2" style="color: white;">Judul Ebook</label>
                            <input type="text" id="Judul" name="Judul" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Masukkan judul" required>
                        </div>
                        <div class="my-3">
                            <label for="Penulis" class="mb-2" style="color: white;">Penulis</label>
                            <input type="text" id="Penulis" name="Penulis" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Masukkan nama penulis" required>
                        </div>
                        <div class="my-3">
                            <label for="Penerbit" class="mb-2" style="color: white;">Penerbit</label>
                            <input type="text" id="Penerbit" name="Penerbit" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Masukkan penerbit" required>
                        </div>
                        <div class="my-3">
                            <label for="TahunTerbit" class="mb-2" style="color: white;">Tahun Terbit</label>
                            <input type="number" id="TahunTerbit" name="TahunTerbit" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Masukkan tahun terbit" required>
                        </div>
                        <div class="my-3">
                            <label for="LinkDownload" class="mb-2" style="color: white;">Link Download</label>
                            <input type="url" id="LinkDownload" name="LinkDownload" class="form-control bg-white" style="color: black;" autocomplete="off" placeholder="Masukkan link download" required>
                        </div>
                        <div class="my-3">
                            <label for="Gambar" class="mb-2" style="color: white;">Gambar Ebook</label>
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
                        $linkDownload = $_POST['LinkDownload'];

                        if (!empty($_FILES['Gambar']['name'])) {
                            $gambar = $_FILES['Gambar']['name'];
                            $tmp_name = $_FILES['Gambar']['tmp_name'];
                            $ekstensi = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
                            $ekstensiDiizinkan = ['jpg', 'jpeg', 'png'];

                            if (in_array($ekstensi, $ekstensiDiizinkan)) {
                                $gambarBaru = 'ebook_' . uniqid() . '.' . $ekstensi;
                                move_uploaded_file($tmp_name, 'imgbuku/' . $gambarBaru);
                            } else {
                                echo '<div class="alert alert-info" role="alert">Hanya file JPG, JPEG, dan PNG yang diizinkan!</div>';
                                exit;
                            }
                        } else {
                            $gambarBaru = null;
                        }

                        $sqlEbook = "INSERT INTO ebook (Judul, Penulis, Penerbit, TahunTerbit, LinkDownload, Gambar) 
                                     VALUES ('$judul', '$penulis', '$penerbit', '$tahunTerbit', '$linkDownload', '$gambarBaru')";

                        if (mysqli_query($conn, $sqlEbook)) {
                            echo "<script>alert('Ebook berhasil ditambahkan!');</script>";
                            echo '<meta http-equiv="refresh" content="1; url=ebook.php" />';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($conn) . '</div>';
                        }
                    }
                    ?>

                </div>

                <div class="mt-5">
                    <h3 style="color: #005b8f;">List Ebook</h3>
                    <div class="table-responsive mt-3">
                        <table class="table" style="color: white;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tahun Terbit</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($count == 0) {
                                ?>
                                    <tr>
                                        <td colspan="8" class="text-center">List Ebook Tidak Tersedia!</td>
                                    </tr>
                                <?php
                                } else {
                                    $no = 1;
                                    while ($data = $ebook->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td>
                                                <?php if (!empty($data['Gambar'])): ?>
                                                    <img src="imgbuku/<?php echo $data['Gambar']; ?>" alt="Gambar Ebook" style="width: 50px; height: auto;">
                                                <?php else: ?>
                                                    Tidak Ada
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $data['Judul']; ?></td>
                                            <td><?php echo $data['Penulis']; ?></td>
                                            <td><?php echo $data['Penerbit']; ?></td>
                                            <td><?php echo $data['TahunTerbit']; ?></td>
                                            <td><a href="<?php echo $data['LinkDownload']; ?>" target="_blank">Telusuri</a></td>
                                            <td>
                                                <a href="ebook_detail.php?id=<?php echo $data['EbookID']; ?>" class="btn btn-light"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                <?php
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
    <script src="js/main.js"></script>
</body>

</html>
