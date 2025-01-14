<nav class="navbar navbar-expand-lg navbar-dark warna1">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="dashboard/img/ft.png" alt="Logo Kiri" style="width: 50px; height: 50px; margin-right: 10px;">
            <span>Fakultas Teknik</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item me-4">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="index.php">Beranda</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'buku_list.php') ? 'active' : ''; ?>" href="buku_list.php">Buku</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'rating.php') ? 'active' : ''; ?>" href="rating.php">Rating</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'informasi.php') ? 'active' : ''; ?>" href="informasi.php">Informasi</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'daftar.php') ? 'active' : ''; ?>" href="daftar.php">Daftar Hadir</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link" href="dashboard/login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
