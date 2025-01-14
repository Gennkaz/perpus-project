<?php
include "../koneksi.php";

$id = $_GET['id'];

$sql = mysqli_query($conn, "SELECT * FROM user WHERE UserID='$id'");
$row = mysqli_fetch_array($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Akun</title>
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
            <h3 style="color: #005b8f;">Edit Akun</h3>

            <form action="" method="post">
                <div class="my-3">
                    <label for="Role" class="mb-2" style="color: white;">Role</label>
                    <select name="Role" id="Role" class="form-control" required>
                        <option value="<?php echo $row['Role']; ?>"><?php echo $row['Role']; ?></option>
                        <option value="user">user</option>
                        <option value="petugas">petugas</option>
                    </select>
                </div>
                <div class="my-3">
                    <label for="status" class="mb-2" style="color: white;">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></option>
                        <option value="active">active</option>
                        <option value="unactive">unactive</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-secondary mt-2" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger mt-2" name="hapus">Delete</button>
                </div>
                <div class="mt-2">
                    <a href="akun.php" style="color: #005b8f;">Kembali</a>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $role = $_POST['Role'];
                $status = $_POST['status'];

                $sqlUpdate = mysqli_query($conn, "UPDATE user SET Role='$role', status='$status' WHERE UserID='$id'");
                if ($sqlUpdate) {
            ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Data akun berhasil diperbarui!
                    </div>

                    <meta http-equiv="refresh" content="1, url=akun.php" />
                <?php
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($conn) . '</div>';
                }
            }

            if (isset($_POST['hapus'])) {
                $queryHapus = mysqli_query($conn, "DELETE FROM user WHERE UserID='$id'");

                if ($queryHapus) {
                ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Data akun berhasil dihapus!
                    </div>

                    <meta http-equiv="refresh" content="0, url=akun.php" />
                <?php
                } else {
                    echo '<div class="alert alert-warning mt-3" role="alert">Akun ini tidak bisa dihapus karena sedang meminjam Buku!</div>';
                }
            }
            ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>