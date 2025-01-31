<?php
include "../koneksi.php";

$id = $_GET['id'];

$id = mysqli_real_escape_string($conn, $id);

$ebook = mysqli_query(
    $conn,
    "SELECT * FROM ebook WHERE EbookID='$id'"
);

$data = mysqli_fetch_assoc($ebook);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ebook</title>
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
            <h3 style="color: #005b8f;">Edit dan hapus data ebook</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="my-2">
                    <label for="Judul" class="mb-2" style="color: white;">Judul Ebook</label>
                    <input type="text" name="Judul" id="Judul" class="form-control" value="<?php echo $data['Judul']; ?>" autocomplete="off" required>
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
                    <label for="LinkDownload" class="mb-2" style="color: white;">Link Download</label>
                    <input type="url" name="LinkDownload" id="LinkDownload" class="form-control" value="<?php echo $data['LinkDownload']; ?>" required>
                </div>
                <div>
                    <label for="currentFoto" style="color: white;">Cover</label>
                    <?php if (!empty($data['Gambar'])): ?>
                        <img src="imgbuku/<?php echo $data['Gambar']; ?>" alt="Gambar Buku" width="70px;">
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
                    <button type="submit" class="btn btn-danger mt-2" name="hapus">Hapus</button>
                </div>
                <div class="mt-2">
                    <a href="ebook.php" style="color: #005b8f;">Kembali</a>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $judul = mysqli_real_escape_string($conn, $_POST['Judul']);
                $penulis = mysqli_real_escape_string($conn, $_POST['Penulis']);
                $penerbit = mysqli_real_escape_string($conn, $_POST['Penerbit']);
                $tahunTerbit = mysqli_real_escape_string($conn, $_POST['TahunTerbit']);
                $linkDownload = mysqli_real_escape_string($conn, $_POST['LinkDownload']);
            
                // Periksa jika ada gambar baru
                if (!empty($_FILES['Gambar']['name'])) {
                    // Menghapus gambar lama jika ada
                    if (!empty($data['Gambar'])) {
                        unlink('imgbuku/' . $data['Gambar']);
                    }
            
                    // Proses upload gambar baru
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
                    // Jika tidak ada gambar baru, gunakan gambar lama
                    $gambarBaru = $data['Gambar'];
                }
            
                // Update data ebook dengan gambar baru atau gambar lama
                $sqlUpdate = "UPDATE ebook SET Judul='$judul', Penulis='$penulis', Penerbit='$penerbit', TahunTerbit='$tahunTerbit', LinkDownload='$linkDownload', Gambar='$gambarBaru' WHERE EbookID='$id'";
            
                if (mysqli_query($conn, $sqlUpdate)) {
                    echo "<script>alert('Ebook berhasil diperbarui!');</script>";
                    echo '<meta http-equiv="refresh" content="1; url=ebook.php" />';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error updating ebook: ' . mysqli_error($conn) . '</div>';
                }
            }            
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
