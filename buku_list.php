<?php
include "koneksi.php";

$is_logged_in = isset($_SESSION['login']) && $_SESSION['login'] === true;

$queryKategori = mysqli_query($conn, "SELECT * FROM kategoribuku");

$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
$namaKategori = isset($_GET['NamaKategori']) ? mysqli_real_escape_string($conn, $_GET['NamaKategori']) : '';

if ($keyword) {
    $queryBuku = mysqli_query($conn, "SELECT * FROM buku
        LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
        LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
        WHERE buku.Judul LIKE '%$keyword%' 
        OR buku.Penulis LIKE '%$keyword%' 
        OR buku.Penerbit LIKE '%$keyword%' 
        OR kategoribuku.NamaKategori LIKE '%$keyword%'");
} elseif ($namaKategori) {
    $queryGetKategoriId = mysqli_query($conn, "SELECT KategoriID FROM kategoribuku WHERE NamaKategori='$namaKategori'");
    if ($queryGetKategoriId) {
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);
        if ($kategoriId) {
            $queryBuku = mysqli_query($conn, "SELECT * FROM buku
                LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
                LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
                WHERE kategoribuku_relasi.KategoriID='{$kategoriId['KategoriID']}'");
        } else {
            $queryBuku = mysqli_query($conn, "SELECT * FROM buku");
        }
    } else {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
} else {
    $queryBuku = mysqli_query($conn, "SELECT * FROM buku
        LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
        LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID");
}

if (!$queryBuku) {
    echo "Error: " . mysqli_error($conn);
    exit;
}

$countData = mysqli_num_rows($queryBuku);

if (isset($_POST['add_to_favorites'])) {
    if ($is_logged_in) {
        $bukuID = $_POST['BukuID'];
        $userID = $_SESSION['user']['UserID'];

        $insertQuery = "INSERT INTO koleksipribadi (UserID, BukuID) VALUES ('$userID', '$bukuID')";
        if (mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('Buku telah ditambahkan ke koleksi favorit!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan buku ke koleksi favorit.');</script>";
        }
    } else {
        echo "<script>alert('Silakan login untuk menambahkan buku ke koleksi favorit.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="dashboard/img/ft.png" />
    <title>KazPus | Buku List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?version=1.4">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner2 d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Buku</h1>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <h3 class="mb-3">Kategori</h3>
                <ul class="list-group mb-3">
                    <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                        <a class="no-decoration" href="buku_list.php?NamaKategori=<?php echo urlencode($kategori['NamaKategori']); ?>">
                            <li class="list-group-item"><?php echo htmlspecialchars($kategori['NamaKategori']); ?></li>
                        </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Buku</h3>

                <?php if ($countData < 1) { ?>
                    <h4 class="text-center my-5">Buku yang anda cari tidak ditemukan!</h4>
                <?php } ?>

                <div class="row">
                    <?php while ($data = mysqli_fetch_array($queryBuku)) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="image-box">
                                    <img src="dashboard/imgbuku/<?php echo htmlspecialchars($data['Gambar']); ?>" class="card-img-top" alt="Gambar Buku">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($data['Judul']); ?></h5>
                                    <p class="card-text ulasan-text mb-2">Penulis: <?php echo htmlspecialchars($data['Penulis']); ?></p>
                                    <p class="card-text ulasan-text mb-2">Penerbit: <?php echo htmlspecialchars($data['Penerbit']); ?></p>
                                    <p class="card-text text-truncate mb-2">Tahun Terbit: <?php echo htmlspecialchars($data['TahunTerbit']); ?></p>
                                    <p class="card-text ulasan-text mb-2">Kategori: <?php echo htmlspecialchars($data['NamaKategori']); ?></p>
                                    <p class="card-text text-truncate mb-2">ISBN: <?php echo htmlspecialchars($data['ISBN']); ?></p>

                                    <?php if ($is_logged_in): ?>
                                        <form action="" method="POST" class="mb-2">
                                            <input type="hidden" name="BukuID" value="<?php echo $data['BukuID']; ?>">
                                            <button type="submit" name="add_to_favorites" class="btn btn-danger">
                                                <i class="fas fa-heart"></i> Add
                                            </button>
                                        </form>

                                        <a href="peminjaman.php?BukuID=<?php echo urlencode($data['BukuID']); ?>&Judul=<?php echo urlencode($data['Judul']); ?>" class="btn btn-primary">Pinjam</a>
                                    <?php else: ?>
                                        <a href="login.php" class="btn btn-primary">Login untuk Pinjam</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


    <?php require "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
</body>

</html>