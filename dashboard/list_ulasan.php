<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>List Ulasan</title>
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
                <h3 style="color: #005b8f;">Daftar Ulasan</h3>

                <div class="table-responsive mt-4">
                    <table class="table">
                        <thead>
                            <tr style="color: white;">
                                <th>Nama</th>
                                <th>Cover</th>
                                <th>Nama Buku</th>
                                <th>Ulasan</th>
                                <th>Rating</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT ulasanbuku.*, user.*, buku.*
                            FROM ulasanbuku
                            LEFT JOIN user ON user.UserID = ulasanbuku.UserID 
                            LEFT JOIN buku ON buku.BukuID = ulasanbuku.BukuID";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr style="color: white;">
                                        <td><?php echo htmlspecialchars($row['NamaLengkap']); ?></td>
                                        <td>
                                            <img src="imgbuku/<?php echo $row['Gambar']; ?>" alt="Gambar Buku" style="width: 50px; height: auto;">
                                        </td>
                                        <td><?php echo htmlspecialchars($row['Judul']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Ulasan']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Rating']); ?>/10</td>
                                        <td>
                                            <form method="post" action="">
                                                <input type="hidden" name="UlasanID" value="<?php echo $row['UlasanID']; ?>">
                                                <button type="submit" name="hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');" class="btn btn-danger">
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>Tidak ada ulasan</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hapus'])) {
                    $ulasan_id = $_POST['UlasanID'];

                    $delete_sql = "DELETE FROM ulasanbuku WHERE UlasanID = ?";
                    $stmt = $conn->prepare($delete_sql);
                    $stmt->bind_param("i", $ulasan_id);

                    if ($stmt->execute()) {
                        echo "<script>alert('Ulasan berhasil dihapus!'); window.location.reload();</script>";
                    } else {
                        echo "<script>alert('Gagal menghapus ulasan!');</script>";
                    }

                    $stmt->close();
                }
                $conn->close();
                ?>
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