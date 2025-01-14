<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ulasan</title>
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
                <div class="col-12 col-md-6">
                    <h3 style="color: #005b8f;">Tambah Ulasan Buku</h3>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="my-3">
                            <label for="BukuID" class="mb-2 text-white">Nama Buku</label>
                            <select id="BukuID" name="BukuID" class="form-control" required>
                                <option value="">Pilih Buku</option>
                                <?php
                                $UserID = $_SESSION['user']['UserID'];

                                $sql = "SELECT buku.BukuID, buku.Judul 
                                        FROM buku 
                                        JOIN peminjaman ON buku.BukuID = peminjaman.BukuID 
                                        WHERE peminjaman.UserID = '$UserID' 
                                        AND (peminjaman.StatusPeminjaman = 'pinjam' OR peminjaman.StatusPeminjaman = 'dikembalikan')";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($row['BukuID']) . '">' . htmlspecialchars($row['Judul']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="" disabled>Pinjamlah buku jika ingin menambahkan ulasan</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="my-3">
                            <label for="Ulasan" class="mb-2" style="color: white;">Ulasan</label>
                            <textarea class="form-control" style="color: black; background: white;" name="Ulasan" id="Ulasan" required></textarea>
                        </div>
                        <div class="my-3">
                            <label for="Rating" class="mb-2" style="color: white;">Rating</label>
                            <select name="Rating" class="form-control" id="Rating" required>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-light" name="simpan">Simpan</button>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['simpan'])) {
                        $BukuID = $conn->real_escape_string($_POST['BukuID']);
                        $UserID = $_SESSION['user']['UserID'];
                        $Ulasan = $conn->real_escape_string($_POST['Ulasan']);
                        $Rating = (int)$_POST['Rating'];

                        $sql = "INSERT INTO ulasanbuku (UserID, BukuID, Ulasan, Rating) VALUES ('$UserID', '$BukuID', '$Ulasan', '$Rating')";
                        if ($conn->query($sql)) {
                            echo "<script>alert('Ulasan berhasil ditambahkan!');</script>";
                            echo '<meta http-equiv="refresh" content="1; url=ulasan.php" />';
                        } else {
                            die("Error inserting review: " . $conn->error);
                        }
                    }
                    ?>
                </div>

                <div class="mt-5">
                    <h3 style="color: #005b8f;">List Ulasan Buku</h3>

                    <div class="table-responsive mt-4">
                        <table class="table" style="color: white;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Cover</th>
                                    <th>Buku</th>
                                    <th>Ulasan</th>
                                    <th>Rating</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $userID = $_SESSION['user']['UserID'];

                                $sql = mysqli_query($conn, "SELECT*FROM ulasanbuku 
                                LEFT JOIN user ON user.UserID = ulasanbuku.UserID 
                                LEFT JOIN buku ON buku.BukuID = ulasanbuku.BukuID
                                WHERE ulasanbuku.UserID = '$userID'");

                                $count = mysqli_num_rows($sql);

                                if ($count == 0) {
                                ?>
                                    <tr>
                                        <td colspan="6" class="text-center">List Ulasan Tidak Tersedia!</td>
                                    </tr>
                                    <?php
                                } else {
                                    $jumlah = 1;
                                    while ($data = $sql->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $jumlah; ?></td>
                                            <td>
                                                <img src="imgbuku/<?php echo $data['Gambar']; ?>" alt="Gambar Buku" style="width: 50px; height: auto;">
                                            </td>
                                            <td><?php echo $data['Judul']; ?></td>
                                            <td><?php echo $data['Ulasan']; ?></td>
                                            <td><?php echo $data['Rating']; ?>/10</td>
                                            <td><?php echo $data['Created_at']; ?></td>
                                            <td>
                                                <a href="ulasan_detail.php?id=<?php echo $data['UlasanID']; ?>" class="btn btn-light"><i class="fas fa-edit"></i></a>
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