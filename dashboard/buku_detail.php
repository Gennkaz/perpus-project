<?php
include "../koneksi.php";

$id = $_GET['id'];

$id = mysqli_real_escape_string($conn, $id);

$buku = mysqli_query(
    $conn,
    "SELECT b.bukuID, b.Judul, b.Penulis, b.Penerbit, b.TahunTerbit, b.JumlahBuku, b.ISBN, b.Gambar, k.KategoriID, k.NamaKategori
     FROM buku b
     LEFT JOIN kategoribuku_relasi r ON b.bukuID = r.bukuID
     LEFT JOIN kategoribuku k ON r.KategoriID = k.KategoriID
     WHERE b.bukuID='$id'"
);

$data = mysqli_fetch_assoc($buku);

$queryKategori = mysqli_query($conn, "SELECT * FROM kategoribuku");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<style>
    .main {
        height: 100vh;
    }

    .login-box {
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 10px;
    }
</style>

<body style="background-color: black;">
    <div class="main d-flex justify-content-center mt-1">
        <div class="login-box p-4">
            <h3 style="color: #005b8f;">Edit dan hapus data produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="my-2">
                    <label for="Judul" class="mb-2" style="color: white;">Nama Buku</label>
                    <input type="text" name="Judul" id="Judul" class="form-control" value="<?php echo $data['Judul']; ?>" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="KategoriID" class="form-label" style="color: white;">Kategori</label>
                    <select name="KategoriID" id="KategoriID" class="form-select" required>
                        <?php while ($row = mysqli_fetch_assoc($queryKategori)) { ?>
                            <option value="<?php echo $row['KategoriID']; ?>" <?php echo ($row['KategoriID'] == $data['KategoriID']) ? 'selected' : ''; ?>>
                                <?php echo $row['NamaKategori']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="my-2">
                    <label for="Penulis" class="mb-2" style="color: white;">Penulis</label>
                    <input type="text" name="Penulis" id="Penulis" class="form-control" value="<?php echo $data['Penulis']; ?>" autocomplete="off" required>
                </div>
                <div class="my-2">
                    <label for="Penerbit" class="mb-2" style="color: white;">Penerbit</label>
                    <input type="text" name="Penerbit" id="Penerbit" class="form-control" value="<?php echo $data['Penerbit']; ?>" autocomplete="off" required>
                </div>
                <div class="my-2">
                    <label for="TahunTerbit" class="mb-2" style="color: white;">Tahun Terbit</label>
                    <input type="number" name="TahunTerbit" id="TahunTerbit" class="form-control" value="<?php echo $data['TahunTerbit']; ?>" autocomplete="off" required>
                </div>
                <div class="my-2">
                    <label for="ISBN" class="mb-2" style="color: white;">ISBN</label>
                    <input type="number" name="ISBN" id="ISBN" class="form-control" value="<?php echo $data['ISBN']; ?>" autocomplete="off" required>
                </div>
                <div class="my-2">
                    <label for="JumlahBuku" class="mb-2" style="color: white;">Stok Buku</label>
                    <input type="number" name="JumlahBuku" id="JumlahBuku" class="form-control" value="<?php echo $data['JumlahBuku']; ?>" autocomplete="off" required>
                </div>
                <div>
                    <label for="currentFoto" style="color: white;">Cover</label>
                    <?php if (!empty($data['Gambar'])): ?>
                        <img src="imgbuku/<?php echo $data['Gambar']; ?>" alt="Gambar Buku" width="100px;">
                    <?php else: ?>
                        <p style="color: white;">Gambar tidak tersedia.</p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="Gambar" style="color: white;">Gambar</label>
                    <input type="file" name="Gambar" id="Gambar" class="form-control">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-secondary mt-2" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger mt-2" name="hapus">Delete</button>
                </div>
                <div class="mt-2">
                    <a href="buku.php" style="color: #005b8f;">Kembali</a>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $judul = mysqli_real_escape_string($conn, $_POST['Judul']);
                $penulis = mysqli_real_escape_string($conn, $_POST['Penulis']);
                $penerbit = mysqli_real_escape_string($conn, $_POST['Penerbit']);
                $tahunTerbit = mysqli_real_escape_string($conn, $_POST['TahunTerbit']);
                $jumlahBuku = mysqli_real_escape_string($conn, $_POST['JumlahBuku']);
                $kategoriID = mysqli_real_escape_string($conn, $_POST['KategoriID']);
                $ISBN = mysqli_real_escape_string($conn, $_POST['ISBN']);

                if (!empty($_FILES['Gambar']['name'])) {
                    $gambar = $_FILES['Gambar']['name'];
                    $tmp_name = $_FILES['Gambar']['tmp_name'];
                    $ekstensi = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
                    $ekstensiDiizinkan = ['jpg', 'jpeg', 'png'];

                    if (in_array($ekstensi, $ekstensiDiizinkan)) {
                        if (!empty($data['Gambar'])) {
                            unlink('imgbuku/' . $data['Gambar']);
                        }
                        $gambarBaru = 'buku_' . uniqid() . '.' . $ekstensi;
                        move_uploaded_file($tmp_name, 'imgbuku/' . $gambarBaru);
                    } else {
                        echo '<div class="alert alert-info" role="alert">Hanya file JPG, JPEG, dan PNG yang diizinkan!</div>';
                        exit;
                    }
                } else {
                    $gambarBaru = $data['Gambar'];
                }

                $sqlUpdate = "UPDATE buku SET Judul='$judul', Penulis='$penulis', Penerbit='$penerbit', TahunTerbit='$tahunTerbit', ISBN='$ISBN', JumlahBuku='$jumlahBuku', Gambar='$gambarBaru' WHERE bukuID='$id'";

                if (mysqli_query($conn, $sqlUpdate)) {
                    $sqlRelasi = "UPDATE kategoribuku_relasi SET KategoriID='$kategoriID' WHERE bukuID='$id'";
                    mysqli_query($conn, $sqlRelasi);

                    echo "<script>alert('Data Buku berhasil diperbarui!');</script>";
                    echo '<meta http-equiv="refresh" content="1; url=buku.php" />';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error updating book: ' . mysqli_error($conn) . '</div>';
                }
            }

            if (isset($_POST['hapus'])) {
                $queryGambar = mysqli_query($conn, "SELECT Gambar FROM buku WHERE BukuID='$id'");
                $data = mysqli_fetch_assoc($queryGambar);

                $deleteRelasi = mysqli_query($conn, "DELETE FROM kategoribuku_relasi WHERE BukuID='$id'");

                $queryHapus = mysqli_query($conn, "DELETE FROM buku WHERE BukuID='$id'");

                if ($queryHapus) {
                    if (!empty($data['Gambar'])) {
                        unlink('imgbuku/' . $data['Gambar']);
                    }

                    echo '<div class="alert alert-danger mt-3" role="alert">Data Buku berhasil Dihapus!</div>';
                    echo '<meta http-equiv="refresh" content="1; url=buku.php" />';
                } else {
                    echo '<div class="alert alert-warning mt-3" role="alert">Buku tidak bisa dihapus karena sedang dipinjam!</div>';
                }
            }
            ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>