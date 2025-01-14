<?php
include "../koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT*FROM koleksipribadi
LEFT JOIN user ON user.UserID = koleksipribadi.UserID
LEFT JOIN buku ON buku.BukuID = koleksipribadi.BukuID
WHERE KoleksiID = '$id'");

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Koleksi</title>
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
            <h3 style="color: red;">Edit dan Hapus Koleksi Buku</h3>

            <form action="" method="post" style="color: white;">
                <div class="my-3">
                    <label for="BukuID" class="mb-2">Nama Buku</label>
                    <select id="BukuID" name="BukuID" class="form-control" required>
                        <?php
                        $sqlBuku = mysqli_query($conn, "SELECT * FROM buku");
                        while ($buku = mysqli_fetch_array($sqlBuku)) {
                            $selected = ($buku['BukuID'] == $data['BukuID']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($buku['BukuID']) . '" ' . $selected . '>' . htmlspecialchars($buku['Judul']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-secondary mt-2" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger mt-2" name="hapus">Delete</button>
                </div>
                <div class="my-2">
                    <a href="koleksi.php" style="color: red;">Kembali</a>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $bukuID = $_POST['BukuID'];
            
                $updateQuery = "UPDATE koleksipribadi SET BukuID='$bukuID' WHERE KoleksiID='$id'";
                
                if (mysqli_query($conn, $updateQuery)) {
                    echo '<div class="alert alert-success">Data koleksi berhasil diperbarui!</div>';
                    echo '<meta http-equiv="refresh" content="1; url=koleksi.php" />';
                } else {
                    echo '<div class="alert alert-danger">Gagal memperbarui data: ' . mysqli_error($conn) . '</div>';
                }
            }

            if (isset($_POST['hapus'])) {
                $deleteQuery = "DELETE FROM koleksipribadi WHERE KoleksiID='$id'";
            
                if (mysqli_query($conn, $deleteQuery)) {
                    echo '<div class="alert alert-success">Data koleksi berhasil dihapus!</div>';
                    echo '<meta http-equiv="refresh" content="1; url=koleksi.php" />';
                } else {
                    echo '<div class="alert alert-danger">Gagal menghapus data: ' . mysqli_error($conn) . '</div>';
                }
            }
            ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>