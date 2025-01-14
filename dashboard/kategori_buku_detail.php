<?php
include "../koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM kategoribuku WHERE KategoriID='$id'");
$data = mysqli_fetch_array($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
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
    <div class="main d-flex justify-content-center mt-5">
        <div class="login-box p-4">
            <h3 style="color: #005b8f;">Edit dan Hapus Data Kategori</h3>

            <form action="" method="post">
                <div class="my-4">
                    <label for="NamaKategori" class="mb-2" style="color: white;">Nama Kategori</label>
                    <input type="text" name="NamaKategori" id="NamaKategori" class="form-control" value="<?php echo $data['NamaKategori']; ?>" autocomplete="off" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-secondary mt-2" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger mt-2" name="hapus">Delete</button>
                </div>
                <div class="mt-2">
                    <a href="kategori_buku.php" style="color: #005b8f;">Kembali</a>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['NamaKategori']);

                $queryUpdate = mysqli_query($conn, "UPDATE kategoribuku SET NamaKategori='$nama' 
                 WHERE KategoriID='$id'");

                if ($queryUpdate) {
            ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Kategori berhasil Diupdate!
                    </div>

                    <meta http-equiv="refresh" content="1, url=kategori_buku.php" />
                <?php
                } else {
                    echo mysqli_error($conn);
                }
            }

            if (isset($_POST['hapus'])) {
                $queryHapus = mysqli_query($conn, "DELETE FROM kategoribuku WHERE KategoriID='$id'");

                if ($queryHapus) {
                ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Kategori berhasil Dihapus!
                    </div>

                    <meta http-equiv="refresh" content="1, url=kategori_buku.php" />
                <?php
                } else {
                ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Kategori tidak bisa dihapus Karena sedang digunakan!
                    </div>
            <?php
                }
            }
            ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>