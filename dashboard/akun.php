<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

$message = "!";

if (isset($_POST['verifybtn'])) {
    $username_to_verify = $_POST['verifikasi'];

    $update_query = $conn->prepare("UPDATE user SET status = 'active' WHERE Username = ?");
    $update_query->bind_param("s", $username_to_verify);

    if ($update_query->execute()) {
        echo "<script>alert('Verifikasi Berhasil!');</script>";
        echo '<meta http-equiv="refresh" content="1; url=akun.php" />';
    } else {
        echo "<script>alert('Verifikasi gagal!');</script>";
    }
}

$query_unactive = mysqli_query($conn, "SELECT NamaLengkap, Username FROM user WHERE status = 'unactive'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Data Akun</title>
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
                <div class="mt-3">
                    <h3 style="color: #005b8f;">Verifikasi Akun</h3>

                    <?php

                    if ($query_unactive->num_rows > 0) {
                    ?>
                        <div class="table-responsive mt-3">
                            <table class="table mt-3">
                                <thead style="color: white;">
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $query_unactive->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['NamaLengkap']); ?></td>
                                            <td><?php echo htmlspecialchars($row['Username']); ?></td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="hidden" name="verifikasi" value="<?php echo htmlspecialchars($row['Username']); ?>">
                                                    <button type="submit" class="btn btn-light" name="verifybtn">Verifikasi</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                    } else {
                    ?>
                        <table class="table mt-3">
                            <thead style="color: white;">
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-center">Akun yang harus diverifikasi tidak ada!</td>
                                </tr>
                            </tbody>
                        </table>
                    <?php
                    }
                    ?>
                </div>


                <div class="table-responsive mt-4">
                    <h3 style="color: #005b8f;">List Akun</h3>
                    <table class="table mt-3" style="color: white;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Foto</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = mysqli_query($conn, "SELECT * FROM user");
                            $count = mysqli_num_rows($sql);

                            if ($count == 0) {
                            ?>
                                <tr>
                                    <td colspan="7" class="text-center">List Buku Tidak Tersedia!</td>
                                </tr>
                                <?php
                            } else {
                                $jumlah = 1;
                                while ($data = $sql->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?php echo $jumlah; ?></td>
                                        <td>
                                            <img src="img/<?php echo $data['Gambar']; ?>" style="width: 50px; height: auto;">
                                        </td>
                                        <td><?php echo $data['NamaLengkap']; ?></td>
                                        <td><?php echo $data['Username']; ?></td>
                                        <td><?php echo $data['Email']; ?></td>
                                        <td><?php echo $data['Role']; ?></td>
                                        <td><?php echo $data['status']; ?></td>
                                        <td>
                                            <a href="akun_detail.php?id=<?php echo $data['UserID']; ?>" class="btn btn-light"><i class="fas fa-edit"></i></a>
                                        </td>
                                        <td style="color: #005b8f;">
                                            <?php
                                            if ($data['status'] === 'unactive') {
                                                echo $message;
                                            } else {
                                                echo "";
                                            }
                                            ?>
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