<?php
include "../koneksi.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$username = isset($_GET['username']) ? $_GET['username'] : null;

if ($id) {
    $sql = mysqli_query($conn, "SELECT * FROM user WHERE UserID='$id'");
    $data = mysqli_fetch_array($sql);
} elseif ($username) {
    $sql = mysqli_query($conn, "SELECT * FROM user WHERE Username='$username'");
    $data = mysqli_fetch_array($sql);
} else {
    echo '<div class="alert alert-danger" role="alert">Data tidak ditemukan!</div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<style>
    .main {
        height: 100vh;
    }

    .login-box {
        width: 500px;
        height: auto;
        box-sizing: border-box;
        border-radius: 10px;
    }
</style>

<body style="background-color: black;">
    <div class="main d-flex justify-content-center mt-1">
        <div class="login-box p-4">
            <h3 style="color: #005b8f;"><?php echo $id ? 'Edit Profile' : 'Change Password'; ?></h3>

            <form action="" method="post" enctype="multipart/form-data">
                <?php if ($id): ?>
                    <div class="my-2">
                        <label for="NamaLengkap" class="mb-2" style="color: white;">Nama Lengkap</label>
                        <input type="text" name="NamaLengkap" id="NamaLengkap" class="form-control" value="<?php echo $data['NamaLengkap']; ?>" required>
                    </div>
                    <div class="my-2">
                        <label for="Username" class="mb-2" style="color: white;">Username</label>
                        <input type="text" name="Username" id="Username" class="form-control" value="<?php echo $data['Username']; ?>" autocomplete="off" required>
                    </div>
                    <div class="my-2">
                        <label for="NPM" class="mb-2" style="color: white;">NPM</label>
                        <input type="text" name="NPM" id="NPM" class="form-control" value="<?php echo $data['NPM']; ?>" required pattern="\d{10}" title="NPM harus terdiri dari 10 digit angka.">
                    </div>
                    <div class="my-2">
                        <label for="Email" class="mb-2" style="color: white;">Email</label>
                        <input type="email" name="Email" id="Email" class="form-control" value="<?php echo $data['Email']; ?>" required readonly>
                    </div>
                    <div class="my-2">
                        <label for="Alamat" class="mb-2" style="color: white;">Alamat</label>
                        <input type="text" name="Alamat" id="Alamat" class="form-control" value="<?php echo $data['Alamat']; ?>" required>
                    </div>
                    <div>
                        <label for="currentFoto" style="color: white;">Gambar</label>
                        <img src="img/<?php echo $data['Gambar'] ?>" alt="Profile Picture" width="150px;">
                    </div>
                    <div>
                        <label for="Gambar" style="color: white;">Gambar</label>
                        <input type="file" name="Gambar" id="Gambar" class="form-control">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-secondary mt-2" name="simpan">Simpan</button>
                    </div>
                    <div class="mt-2">
                        <a href="profile.php" style="color: #005b8f;">Kembali</a>
                    </div>
                <?php elseif ($username): ?>
                    <div class="my-2">
                        <label for="Password" class="mb-2" style="color: white;">Password Baru</label>
                        <input type="password" name="Password" id="Password" class="form-control" required>
                    </div>
                    <div class="my-2">
                        <label for="ConfirmPassword" class="mb-2" style="color: white;">Konfirmasi Password</label>
                        <input type="password" name="ConfirmPassword" id="ConfirmPassword" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-secondary mt-2" name="ubahPassword">Ubah Password</button>
                    </div>
                    <div class="mt-2">
                        <a href="profile.php" style="color: #005b8f;">Kembali</a>
                    </div>
                <?php endif; ?>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $namaLengkap = mysqli_real_escape_string($conn, $_POST['NamaLengkap']);
                $username = mysqli_real_escape_string($conn, $_POST['Username']);
                $npm = mysqli_real_escape_string($conn, $_POST['NPM']);
                $email = mysqli_real_escape_string($conn, $_POST['Email']);
                $alamat = mysqli_real_escape_string($conn, $_POST['Alamat']);
                $gambarLama = $data['Gambar'];

                $gambar = '';
                if ($_FILES['Gambar']['name']) {
                    $targetDir = "img/";
                    $gambar = basename($_FILES['Gambar']['name']);
                    $targetFilePath = $targetDir . $gambar;
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                    $validTypes = ['jpg', 'jpeg', 'png'];
                    if (in_array($fileType, $validTypes)) {
                        if ($gambarLama && file_exists($targetDir . $gambarLama)) {
                            unlink($targetDir . $gambarLama);
                        }

                        if (move_uploaded_file($_FILES['Gambar']['tmp_name'], $targetFilePath)) {
                            $gambar = $gambar;
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Gambar gagal diupload!</div>';
                            exit;
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Hanya file JPG, JPEG, dan PNG yang diperbolehkan!</div>';
                        exit;
                    }
                } else {
                    $gambar = $gambarLama;
                }

                $sqlUpdate = "UPDATE user SET NamaLengkap='$namaLengkap', Username='$username', NPM='$npm', Email='$email', Alamat='$alamat', Gambar='$gambar' WHERE UserID='{$data['UserID']}'";
                if (mysqli_query($conn, $sqlUpdate)) {
                    echo '<div class="alert alert-success" role="alert">Profile berhasil diperbarui!</div>';
                    echo '<meta http-equiv="refresh" content="1; url=profile.php" />';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($conn) . '</div>';
                }
            }

            if (isset($_POST['ubahPassword'])) {
                $password = mysqli_real_escape_string($conn, $_POST['Password']);
                $confirmPassword = mysqli_real_escape_string($conn, $_POST['ConfirmPassword']);

                if ($password === $confirmPassword) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $sqlUpdatePassword = "UPDATE user SET Password='$hashedPassword' WHERE Username='{$data['Username']}'";
                    if (mysqli_query($conn, $sqlUpdatePassword)) {
                        echo '<div class="alert alert-success" role="alert">Password berhasil diubah!</div>';
                        echo '<meta http-equiv="refresh" content="1; url=profile.php" />';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($conn) . '</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Password dan konfirmasi password tidak cocok!</div>';
                }
            }
            ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
