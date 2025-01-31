<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

if (isset($_POST['delete'])) {
    $peminjamanID = $_POST['peminjamanID'];

    $queryDelete = "DELETE FROM peminjaman WHERE PeminjamanID = $peminjamanID";

    if ($conn->query($queryDelete) === TRUE) {
        header("Location: history_peminjaman.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>History Peminjaman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Peminjaman buku">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">

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

        <?php require "sidebar.php"; ?>

        <div class="content">
            <?php require "navbar.php"; ?>

            <div class="container-fluid pt-4 px-4">
                <div class="mt-3">
                    <h3 style="color: #005b8f;">History Peminjaman Buku</h3>

                    <div class="table-responsive mt-3">
                        <table class="table">
                            <thead style="color: white;">
                                <tr>
                                    <th>No.</th>
                                    <th>Cover</th>
                                    <th>Nama Buku</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Status Peminjaman</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $user = $_SESSION['user']['UserID'];

                                $queryPeminjaman = "SELECT p.*, b.Judul, b.Gambar, kb.NamaKategori 
                                                    FROM peminjaman p 
                                                    JOIN buku b ON p.BukuID = b.BukuID 
                                                    JOIN kategoribuku_relasi kbr ON b.BukuID = kbr.BukuID 
                                                    JOIN kategoribuku kb ON kbr.KategoriID = kb.KategoriID 
                                                    WHERE p.UserID = $user AND p.StatusPeminjaman = 'dikembalikan'";

                                $resultPeminjaman = $conn->query($queryPeminjaman);

                                if ($resultPeminjaman->num_rows == 0) {
                                    echo '<tr><td colspan="7" class="text-center">History Peminjaman Buku Tidak Tersedia!</td></tr>';
                                } else {
                                    $jumlah = 1;
                                    while ($data = $resultPeminjaman->fetch_assoc()) {
                                ?>
                                        <form method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus history peminjamanan ini?');">
                                            <tr>
                                                <td><?php echo $jumlah; ?></td>
                                                <td>
                                                    <img src="imgbuku/<?php echo $data['Gambar']; ?>" alt="Gambar Buku" style="width: 50px; height: auto;">
                                                </td>
                                                <td><?php echo $data['Judul']; ?></td>
                                                <td><?php echo $data['NamaKategori']; ?></td>
                                                <td><?php echo $data['TanggalPeminjaman']; ?></td>
                                                <td><?php echo $data['TanggalPengembalian']; ?></td>
                                                <td><?php echo $data['StatusPeminjaman']; ?></td>
                                                <td>
                                                    <input type="hidden" name="peminjamanID" value="<?php echo $data['PeminjamanID']; ?>">
                                                    <button type="submit" name="delete" class="btn btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </form>
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
