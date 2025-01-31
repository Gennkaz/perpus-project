<?php
include "../koneksi.php";

if (isset($_GET['id'])) {
    $peminjamanID = $_GET['id'];
    $sql = "SELECT p.*, b.Judul, b.JumlahBuku, p.TanggalPeminjaman
            FROM peminjaman p 
            JOIN buku b ON p.BukuID = b.BukuID 
            WHERE p.PeminjamanID = $peminjamanID";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
} else {
    echo '<script>alert("Invalid ID!"); window.location.href="peminjaman.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman</title>
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

            <form action="" method="post" enctype="multipart/form-data" style="color: white;" onsubmit="return validateDates()">
                <div class="my-2">
                    <label for="Judul" class="mb-2">Nama Buku</label>
                    <input type="text" name="Judul" id="Judul" class="form-control" value="<?php echo htmlspecialchars($data['Judul']); ?>" disabled>
                </div>
                <div class="my-2">
                    <label for="TanggalPengembalian" class="mb-2">Tanggal Pengembalian</label>
                    <input type="date" name="TanggalPengembalian" id="TanggalPengembalian" class="form-control"
                        value="<?php echo htmlspecialchars($data['TanggalPengembalian']); ?>"
                        <?php echo ($data['StatusPeminjaman'] == 'dikembalikan') ? 'readonly' : 'required'; ?>
                        onchange="updateDateRange()" />
                </div>
                <div class="my-2">
                    <label for="StatusPeminjaman" class="mb-2">Status Peminjaman</label>
                    <select name="StatusPeminjaman" id="StatusPeminjaman" class="form-control"
                        <?php echo ($data['StatusPeminjaman'] == 'dikembalikan') ? 'disabled' : 'required'; ?>>
                        <option value="pinjam" <?php echo ($data['StatusPeminjaman'] == 'pinjam') ? 'selected' : ''; ?>>Dipinjam</option>
                        <option value="dikembalikan" <?php echo ($data['StatusPeminjaman'] == 'dikembalikan') ? 'selected' : ''; ?>>Dikembalikan</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <?php if ($data['StatusPeminjaman'] !== 'dikembalikan') : ?>
                        <button type="submit" class="btn btn-secondary mt-2" name="simpan">Simpan</button>
                    <?php endif; ?>
                </div>
                <div class="mt-2">
                    <a href="peminjaman.php" style="color: #005b8f;">Kembali</a>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $tanggalPengembalian = $_POST['TanggalPengembalian'];
                $statusPeminjaman = $_POST['StatusPeminjaman'];
                $bukuID = $data['BukuID'];

                $sqlUpdate = "UPDATE peminjaman 
                              SET TanggalPengembalian = '$tanggalPengembalian', 
                                  StatusPeminjaman = '$statusPeminjaman', 
                                  Created = CURRENT_TIMESTAMP 
                              WHERE PeminjamanID = $peminjamanID";

                if ($conn->query($sqlUpdate) === TRUE) {
                    if ($statusPeminjaman == 'dikembalikan') {
                        $sqlGetJumlahBuku = "SELECT JumlahBuku FROM buku WHERE BukuID = $bukuID";
                        $result = $conn->query($sqlGetJumlahBuku);
                        $row = $result->fetch_assoc();

                        if ($row) {
                            $jumlahBukuSaatIni = $row['JumlahBuku'];
                            $jumlahBukuBaru = $jumlahBukuSaatIni + 1;

                            $sqlUpdateBuku = "UPDATE buku SET JumlahBuku = $jumlahBukuBaru WHERE BukuID = $bukuID";
                            if ($conn->query($sqlUpdateBuku) === TRUE) {
            ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Data peminjaman berhasil diperbarui!
                                </div>

                                <meta http-equiv="refresh" content="1; url=peminjaman.php" />
                        <?php
                            } else {
                                echo '<div class="alert alert-danger">Gagal memperbarui jumlah buku: ' . $conn->error . '</div>';
                            }
                        } else {
                            echo '<div class="alert alert-warning">Buku tidak ditemukan.</div>';
                        }
                    } else {
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Data peminjaman berhasil diperbarui!
                        </div>

                        <meta http-equiv="refresh" content="1; url=peminjaman.php" />
            <?php
                    }
                } else {
                    echo '<div class="alert alert-danger">Gagal memperbarui data: ' . $conn->error . '</div>';
                }
            }
            ?>

        </div>
    </div>

    <script>
        function updateDateRange() {
            const tanggalPengembalian = document.getElementById('TanggalPengembalian').value;

            if (tanggalPengembalian) {
                const returnDate = new Date(tanggalPengembalian);
                const maxDate = new Date(returnDate);
                maxDate.setDate(returnDate.getDate() + 6);

                const minDate = returnDate.toISOString().split('T')[0];
                const maxDateStr = maxDate.toISOString().split('T')[0];

                document.getElementById('TanggalPengembalian').setAttribute('min', minDate);
                document.getElementById('TanggalPengembalian').setAttribute('max', maxDateStr);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateDateRange();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>
