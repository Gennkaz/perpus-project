<?php
include "../koneksi.php";

$register_message = "";
if (isset($_SESSION["login"])) {
    header("location: dashboard.php");
    exit();
}

if (isset($_POST['registerbtn'])) {
    $username = htmlspecialchars($_POST['Username']);
    $password = htmlspecialchars($_POST['Password']);
    $npm = $_POST['NPM'];
    $fullname = $_POST['NamaLengkap'];
    $email = $_POST['Email'];
    $alamat = $_POST['Alamat'];

    if (!is_numeric($npm) || strlen($npm) != 10) {
        echo "<script>alert('NPM harus terdiri dari 10 digit angka!');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check_query = $conn->prepare("SELECT * FROM user WHERE username = ? OR npm = ?");
        $check_query->bind_param("ss", $username, $npm);
        $check_query->execute();
        $result = $check_query->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username atau NPM sudah digunakan, ganti dengan yang lain!');</script>";
        } else {
            $status = 'unactive';
            $role = 'user';

            $sql = "INSERT INTO user (username, password, npm, namalengkap, email, alamat, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $conn->prepare($sql);

            if (!$query) {
                die("Prepare statement failed: " . $conn->error);
            }

            $query->bind_param("ssssssss", $username, $hashed_password, $npm, $fullname, $email, $alamat, $role, $status);

            if ($query->execute()) {
                echo "<script>alert('Registrasi berhasil, tunggu admin memverifikasi akun anda!');</script>";
                echo '<meta http-equiv="refresh" content="1; url=login.php" />';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error inserting user: ' . mysqli_error($conn) . '</div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="img/ft.png" />
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
</head>

<style>
    .container {
        margin-top: 5%;
    }

    ::-webkit-scrollbar {
        width: 15px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #005b8f;
    }

    ::-webkit-scrollbar-track {
        background-color: black;
        width: 50px;
    }
</style>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <i class="fa-solid fa-user-plus me-2"></i><strong>Register</strong>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="Username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" class="form-control" id="Username" name="Username" placeholder="Enter your username" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter your password" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="NPM" class="form-label">NPM</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-id-card"></i></span>
                                    <input type="text" class="form-control" id="NPM" name="NPM" placeholder="Enter your NPM (10 digits)" autocomplete="off" required pattern="\d{10}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="NamaLengkap" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-user-tag"></i></span>
                                    <input type="text" class="form-control" id="NamaLengkap" name="NamaLengkap" placeholder="Enter your full name" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter your email" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Alamat" class="form-label">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control" id="Alamat" name="Alamat" placeholder="Enter your address" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a href="../index.php" class="text-secondary">Kembali</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" name="registerbtn">Register</button>
                        </form>
                        <div class="register-link text-center mt-3">
                            <p>Have an Account? <a href="login.php" class="text-primary">Login</a></p>
                        </div>
                        <?php if (!empty($register_message)): ?>
                            <div class="alert alert-warning text-center mt-3">
                                <?php echo $register_message; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>