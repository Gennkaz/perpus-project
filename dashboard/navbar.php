<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <div class="nav-item ms-auto">
        <span style="color: white;">Role: </span>
        <span><?php echo $_SESSION['user']['role'] ?></span>
    </div>
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <?php if (isset($data['Gambar'])): ?>
                    <img class="rounded-circle me-lg-2" src="img/<?php echo htmlspecialchars($data['Gambar']); ?>" alt="" style="width: 40px; height: 40px;">
                <?php else: ?>
                    <img class="rounded-circle me-lg-2" src="img/default.jpg" alt="" style="width: 40px; height: 40px;">
                <?php endif; ?>
                <span class="d-none d-lg-inline-flex"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <a href="profile.php" class="dropdown-item">My Profile</a>
                <a href="logout.php" class="dropdown-item">Log Out</a>
            </div>
        </div>
    </div>
</nav>