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
    .login-box {
        max-width: 500px;
        width: 100%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: #005b8f;
        color: white;
        border-radius: 25px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #003d5c;
    }
</style>

<body style="background-color: black;">
    <div class="main d-flex justify-content-center align-items-center mt-1">
        <div class="login-box p-5 rounded shadow-lg" style="background: #f4f6f9; border-radius: 10px;">
            <h3 class="text-center" style="color: #005b8f; font-weight: bold;">Konfirmasi Denda</h3>

            <div class="text-center mt-4">
                <h1 style="color: #e74c3c; font-size: 2.5rem; font-weight: bold;">💸 Hubungi Admin untuk Konfirmasi Denda Anda!</h1>
                <p style="font-size: 1.2rem; color: #555555; margin-top: 10px;">
                    Jika Anda merasa ada ketidaksesuaian dalam denda yang dikenakan,
                    segera hubungi admin untuk klarifikasi dan pengaturan lebih lanjut.
                </p>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn btn-primary btn-lg" style="font-size: 1.1rem; padding: 10px 30px; background-color: #005b8f; border: none;">
                    Hubungi Admin
                </a><br>
                <a href="peminjaman.php">Kembali</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>