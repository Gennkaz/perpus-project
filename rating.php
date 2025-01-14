<?php
include "koneksi.php";

$sql = "SELECT*FROM ulasanbuku
        LEFT JOIN user ON user.UserID = ulasanbuku.UserID 
        LEFT JOIN buku ON buku.BukuID = ulasanbuku.BukuID";
$result = $conn->query($sql);
$count = mysqli_num_rows($result);

$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="dashboard/img/ft.png" />
    <title>KazPus | Rating</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css?version=1.4">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner2 d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Rating Buku</h1>
        </div>
    </div>

    <div class="container-fluid py-5">
    <div class="container">
        <div class="row mt-3">
            <?php
            if ($count > 0) {
                while ($data = mysqli_fetch_array($result)) { ?>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="dashboard/imgbuku/<?php echo htmlspecialchars($data['Gambar']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($data['Judul']); ?>">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($data['Judul']); ?></h5>
                                <p class="card-text text-truncate">Nama: <?php echo htmlspecialchars($data['NamaLengkap']); ?></p>
                                <p class="card-text ulasan-text">Ulasan: <?php echo nl2br(htmlspecialchars($data['Ulasan'])); ?></p>
                                <p class="card-text text-truncate">Rating:  <?php echo htmlspecialchars($data['Rating']); ?>/10</p>
                                <p class="card-text text-truncate">Created at: <?php echo htmlspecialchars($data['Created_at']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php 
                } 
            } else {
                ?>
                <div class="col-sm-6 col-md-3 mb-3">
                    <h3>Rating buku tidak tersedia!</h3>
                </div>
                <?php 
            }
            ?>
        </div>
    </div>
</div>

    <?php require "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
</body>

</html>