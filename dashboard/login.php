<?php
include "../koneksi.php";

$login_message = "";

if (isset($_SESSION["login"])) {
    header("location: dashboard.php");
    exit();
}

if (isset($_POST['loginbtn'])) {
    $input = htmlspecialchars($_POST['Username']);
    $password = htmlspecialchars($_POST['Password']);

    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        $query = $conn->prepare("SELECT UserID, username, email, password, status, role FROM user WHERE email = ?");
    } else {
        $query = $conn->prepare("SELECT UserID, username, email, password, status, role FROM user WHERE username = ?");
    }

    $query->bind_param("s", $input);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            if ($user['status'] === 'unactive') {
                $login_message = "Akun anda belum diverifikasi. Silakan hubungi admin.";
            } else {
                $_SESSION["login"] = true;
                $_SESSION["username"] = $user['username'];
                $_SESSION['user'] = array(
                    'role' => $user['role'],
                    'UserID' => $user['UserID']
                );
                header("location: dashboard.php");
                exit();
            }
        } else {
            $login_message = "Password salah.";
        }
    } else {
        $login_message = "Username atau email tidak ditemukan.";
    }
}

    $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="img/ft.png" />
    <title>Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
</head>

<body>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <i class="fa-solid fa-user-lock me-2"></i><strong>Login</strong>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="Username" class="form-label">Username or Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" class="form-control" id="Username" name="Username" placeholder="Enter your username or email" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter your password" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a href="../index.php" class="text-secondary">Kembali</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" name="loginbtn">Login</button>
                        </form>
                        <div class="register-link text-center mt-3">
                            <p>Don't Have an Account? <a href="register.php" class="text-primary">Register</a></p>
                        </div>
                        <?php if (!empty($login_message)): ?>
                            <div class="alert alert-warning text-center mt-3">
                                <?php echo $login_message; ?>
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
