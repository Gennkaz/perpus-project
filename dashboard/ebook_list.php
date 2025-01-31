<?php
include "../koneksi.php";
include_once "cek-akses.php";
include "get_gambar.php";

$query = "SELECT * FROM ebook ORDER BY Created_at";
$ebook = mysqli_query($conn, $query);
$count = mysqli_num_rows($ebook);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ebook</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="css/bootstrap.min.css?version=1.2" rel="stylesheet">
    <link href="css/style.css?version=1.1" rel="stylesheet">

    <style>
        .image-box {
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .image-box img {
            height: 180px;
            width: auto;
            object-fit: cover;
            object-position: center;
        }

        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .ulasan-text {
            max-height: 50px;
            overflow-y: auto;
            white-space: normal;
        }

        p{
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .col-12.col-sm-6.col-md-4.col-lg-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 576px) {
            .col-12.col-sm-6.col-md-4.col-lg-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <?php include "sidebar.php"; ?>

        <div class="content">
            <?php include "navbar.php"; ?>

            <div class="container-fluid pt-4 px-4">
                <h3 style="color: #005b8f;">Daftar Ebook</h3>
                <div class="row mt-4">
                    <?php
                    if ($count == 0) {
                    ?>
                        <div class="col-12">
                            <div class="alert alert-info" role="alert">
                                Tidak ada ebook tersedia.
                            </div>
                        </div>
                        <?php
                    } else {
                        $no = 1;
                        while ($data = $ebook->fetch_assoc()) {
                        ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card h-100">
                                    <div class="image-box">
                                        <?php if (!empty($data['Gambar'])): ?>
                                            <img src="imgbuku/<?php echo $data['Gambar']; ?>" class="card-img-top" alt="Gambar Ebook">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Gambar Ebook">
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-dark"><?php echo $data['Judul']; ?></h5>
                                        <p class="card-text ulasan-text mb-2 text-dark">Penulis: <?php echo $data['Penulis']; ?></p>
                                        <p class="card-text ulasan-text mb-2 text-dark">Penerbit: <?php echo $data['Penerbit']; ?></p>
                                        <p class="card-text text-truncate mb-2 text-dark">Tahun Terbit: <?php echo $data['TahunTerbit']; ?></p>

                                        <a href="<?php echo $data['LinkDownload']; ?>" class="btn btn-primary" target="_blank">Telusuri Ebook</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>