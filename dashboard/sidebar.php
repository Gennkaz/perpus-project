<?php
$sql_account = "SELECT COUNT(*) FROM user WHERE status = 'unactive'";
$result_account = mysqli_query($conn, $sql_account);
$row_account = mysqli_fetch_assoc($result_account);
$jumlah_account = $row_account['COUNT(*)'];

$sql = "SELECT COUNT(*) FROM peminjaman WHERE StatusPeminjaman = 'pending'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$jumlah_konfirmasi = $row['COUNT(*)'];
?>

<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="dashboard.php" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>FT Unma</h3>
        </a>
        <div class="navbar-nav w-100">
            <?php
            $cek_file = basename($_SERVER['PHP_SELF']);
            ?>
            <a href="dashboard.php" class="nav-item nav-link <?php echo $cek_file == 'dashboard.php' ? 'active' : ''; ?>"><i class="fa fa-th-large me-2"></i>Dashboard</a>

            <?php if (isset($_SESSION['user']['role'])) {
                if ($_SESSION['user']['role'] == 'admin') { ?>
                    <a href="kategori_buku.php" class="nav-item nav-link <?php echo $cek_file == 'kategori_buku.php' ? 'active' : ''; ?>"><i class="fas fa-tags me-2"></i>Kategori Buku</a>
                    <a href="buku.php" class="nav-item nav-link <?php echo $cek_file == 'buku.php' ? 'active' : ''; ?>"><i class="fas fa-book me-2"></i>Data Buku</a>
                    <a href="ebook.php" class="nav-item nav-link <?php echo $cek_file == 'ebook.php' ? 'active' : ''; ?>"><i class="fas fa-tablet-alt me-2"></i>Data E-book</a>
                    <a href="laporan.php" class="nav-item nav-link <?php echo $cek_file == 'laporan.php' ? 'active' : ''; ?>"><i class="fas fa-file-alt me-2"></i>Laporan</a>
                    <a href="list_ulasan.php" class="nav-item nav-link <?php echo $cek_file == 'list_ulasan.php' ? 'active' : ''; ?>"><i class="fas fa-star me-2"></i>Ulasan</a>
                    <a href="ketentuan.php" class="nav-item nav-link <?php echo $cek_file == 'ketentuan.php' ? 'active' : ''; ?>"><i class="fas fa-info me-2"></i>Ketentuan</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="daftar_kunjungan.php" class="dropdown-item">Daftar Kunjungan</a>
                            <a href="anggota.php" class="dropdown-item">Data Anggota</a>
                            <a href="akun.php" class="dropdown-item">
                                Data Account
                                <?php if ($jumlah_account > 0) { ?>
                                    <span class="badge bg-primary ms-1"><?php echo $jumlah_account; ?></span> <!-- Notification for unverified accounts -->
                                <?php } ?>
                            </a>
                            <a href="profile.php" class="dropdown-item">Profile</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>

                    <?php } elseif ($_SESSION['user']['role'] == 'petugas') { ?>
                    <a href="kategori_buku.php" class="nav-item nav-link <?php echo $cek_file == 'kategori_buku.php' ? 'active' : ''; ?>"><i class="fas fa-tags me-2"></i>Kategori Buku</a>
                    <a href="buku.php" class="nav-item nav-link <?php echo $cek_file == 'buku.php' ? 'active' : ''; ?>"><i class="fas fa-book me-2"></i>Data Buku</a>
                    <a href="laporan.php" class="nav-item nav-link <?php echo $cek_file == 'laporan.php' ? 'active' : ''; ?>"><i class="fas fa-file-alt me-2"></i>Laporan</a>
                    <a href="list_ulasan.php" class="nav-item nav-link <?php echo $cek_file == 'list_ulasan.php' ? 'active' : ''; ?>"><i class="fas fa-star me-2"></i>Ulasan</a>
                    <a href="ketentuan.php" class="nav-item nav-link <?php echo $cek_file == 'ketentuan.php' ? 'active' : ''; ?>"><i class="fas fa-info me-2"></i>Ketentuan</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="peminjaman_konfirmasi.php" class="dropdown-item">
                                Peminjaman pending
                                <?php if ($jumlah_konfirmasi > 0) { ?>
                                    <span class="badge bg-primary ms-1"><?php echo $jumlah_konfirmasi; ?></span>
                                <?php } ?>
                            </a>
                            <a href="denda_konfirmasi.php" class="dropdown-item">Konfirmasi Denda</a>
                            <a href="anggota.php" class="dropdown-item">Data Anggota</a>
                            <a href="profile.php" class="dropdown-item">Profile</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>

                <?php } else { ?>
                    <a href="peminjaman.php" class="nav-item nav-link <?php echo $cek_file == 'peminjaman.php' ? 'active' : ''; ?>"><i class="fas fa-book-reader me-2"></i>Peminjaman</a>
                    <a href="history_peminjaman.php" class="nav-item nav-link <?php echo $cek_file == 'history_peminjaman.php' ? 'active' : ''; ?>"><i class="fas fa-history me-2"></i>History</a>
                    <a href="ulasan.php" class="nav-item nav-link <?php echo $cek_file == 'ulasan.php' ? 'active' : ''; ?>"><i class="fas fa-star me-2"></i>Ulasan</a>
                    <a href="koleksi.php" class="nav-item nav-link <?php echo $cek_file == 'koleksi.php' ? 'active' : ''; ?>"><i class="fas fa-th-list me-2"></i>Koleksi</a>
                    <a href="ebook_list.php" class="nav-item nav-link <?php echo $cek_file == 'ebook_list.php' ? 'active' : ''; ?>"><i class="fas fa-tablet-alt me-2"></i>E-book</a>
                    <a href="ketentuan.php" class="nav-item nav-link <?php echo $cek_file == 'ketentuan.php' ? 'active' : ''; ?>"><i class="fas fa-info me-2"></i>Ketentuan</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="profile.php" class="dropdown-item">Profile</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </nav>
</div>