<div class="container-fluid py-3 content-subscribe text-light">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="dashboard/img/ft.png" alt="Logo Fakultas" style="width: 80px;">
                <h5 class="mt-2">Fakultas Teknik</h5>
                <ul class="list-unstyled mt-2">
                    <li><a href="buku_list.php" class="text-light text-decoration-none">Buku</a></li>
                    <li><a href="rating.php" class="text-light text-decoration-none">Rating</a></li>
                    <li><a href="informasi.php" class="text-light text-decoration-none">Informasi</a></li>
                    <li><a href="faq.php" class="text-light text-decoration-none">FAQ</a></li>
                </ul>
            </div>

            <div class="col-md-6 mb-3">
                <h5 class="mb-3">Tentang Kami</h5>
                <p style="font-size: 14px;">
                    Sebagai sistem manajemen perpustakaan lengkap, SiPBW (Sistem Informasi Perpustakaan Berbasis Web) memiliki banyak fitur yang akan membantu perpustakaan dan pustakawan untuk menjalankan tugas mereka dengan mudah dan cepat.
                </p>
            </div>

            <div class="col-md-4 mb-3">
                <h5 class="mb-3">Cari</h5>
                <div class="input-group mb-4">
                    <form method="get" action="buku_list.php">
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" placeholder="Masukan kata kunci" aria-label="Kata Kunci" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" autocomplete="off">
                            <button type="submit" class="btn warna1 text-white">Telusuri</button>
                        </div>
                    </form>
                </div>
                <hr style="color: blue;">
                <div>
                    <a href="#" class="btn warna1 btn-sm mb-2"><i class="fa fa-heart"></i> Donasi untuk SiPBW</a><br>
                    <a href="#" class="btn btn-outline-light btn-sm"><i class="fa fa-arrow-right"></i> Kontribusi untuk SiPBW?</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-3 warna1 text-light">
    <div class="container d-flex justify-content-between">
        <label for="">&copy; 2024 Fakultas Teknik UNMA</label>
        <label for="">Dibuat Oleh Akas pirdaus</label>
    </div>
</div>