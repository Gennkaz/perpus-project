<?php
include "../koneksi.php";

if (isset($_GET['id'])) {
    $ulasanID = $_GET['id'];
    $sql = "SELECT*FROM ulasanbuku 
            LEFT JOIN user ON user.UserID = ulasanbuku.UserID 
            LEFT JOIN buku ON buku.BukuID = ulasanbuku.BukuID
            WHERE UlasanID='$ulasanID'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
} else {
    echo '<script>alert("Invalid ID!"); window.location.href="ulasan.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ulasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<style>
    .main {
        height: 100vh;
    }

    .login-box {
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 10px;
    }
</style>

<body style="background-color: black;">
    <div class="main d-flex justify-content-center mt-1">
        <div class="login-box p-4">
            <h3 style="color: #005b8f;">Edit Peminjaman</h3>

            <form action="" method="post" style="color: white;">
                <div class="my-2">
                    <label for="BukuID" class="mb-2">Nama Buku</label>
                    <select id="BukuID" name="BukuID" class="form-control" required disabled>
                        <?php
                        $sqlBuku = mysqli_query($conn, "SELECT * FROM buku");
                        while ($buku = mysqli_fetch_array($sqlBuku)) {
                            $selected = ($buku['BukuID'] == $data['BukuID']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($buku['BukuID']) . '" ' . $selected . '>' . htmlspecialchars($buku['Judul']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="my-2">
                    <label for="Ulasan" class="mb-2">Ulasan</label>
                    <textarea class="form-control" name="Ulasan" id="Ulasan" required><?php echo htmlspecialchars($data['Ulasan']); ?></textarea>
                </div>
                <div class="my-2">
                    <label for="Rating" class="mb-2">Rating</label>
                    <select name="Rating" class="form-control" id="Rating" required>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php if ($i == $data['Rating']) echo 'selected'; ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-secondary mt-2" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger mt-2" name="hapus">Delete</button>
                </div>
                <div class="mt-2">
                    <a href="ulasan.php" style="color: #005b8f;">Kembali</a>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $BukuID = $conn->real_escape_string($_POST['BukuID']);
                $Ulasan = $conn->real_escape_string($_POST['Ulasan']);
                $Rating = (int)$_POST['Rating'];

                $sqlUpdate = "UPDATE ulasanbuku SET BukuID = '$BukuID', Ulasan = '$Ulasan', Rating = '$Rating' WHERE UlasanID = '$ulasanID'";

                if ($conn->query($sqlUpdate) === TRUE) {
                    echo '<div class="alert alert-success mt-3" role="alert">Data ulasan berhasil diperbarui!</div>';
                    echo '<meta http-equiv="refresh" content="1; url=ulasan.php" />';
                } else {
                    echo '<div class="alert alert-danger">Gagal memperbarui data: ' . $conn->error . '</div>';
                }
            }

            if (isset($_POST['hapus'])) {
                $sqlDelete = "DELETE FROM ulasanbuku WHERE UlasanID = '$ulasanID'";
                if ($conn->query($sqlDelete) === TRUE) {
                    echo "<script>alert('Ulasan berhasil dihapus!'); window.location.href='ulasan.php';</script>";
                } else {
                    echo '<div class="alert alert-danger">Gagal menghapus ulasan: ' . $conn->error . '</div>';
                }
            }
            ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>