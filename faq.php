<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - SiPBW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .faq-title {
            font-size: 2rem;
            font-weight: bold;
            color: #005b8f;
        }
        .faq-section {
            margin-top: 20px;
        }
        .accordion-button {
            background-color: #005b8f;
            color: white;
        }
        .accordion-button:focus {
            box-shadow: none;
        }
        .faq-container {
            padding: 20px;
        }
        .search-bar {
            width: 100%;
            margin-bottom: 20px;
        }
        .search-bar input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
        }
        .home-button {
            margin-top: 20px;
        }
    </style>
</head>

<body style="background-color: #f8f9fa;">
    <div class="container faq-container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="faq-title text-center">Pertanyaan yang Sering Diajukan</h1>
                <p class="text-center text-muted">Temukan jawaban untuk pertanyaan yang sering diajukan di sini.</p>
                
                <div class="search-bar">
                    <input type="text" id="searchFAQ" placeholder="Cari FAQ..." class="form-control">
                </div>

                <div class="accordion" id="faqAccordion">

                    <div class="faq-section">
                        <h4>Informasi Umum</h4>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Apa itu SiPBW?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    SiPBW (Sistem Informasi Perpustakaan Berbasis Web) adalah sistem manajemen perpustakaan berbasis web yang dirancang untuk memudahkan dan mempercepat pengelolaan perpustakaan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Bagaimana cara mendaftar di SiPBW?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Untuk mendaftar di SiPBW, cukup kunjungi halaman pendaftaran, isi data yang diperlukan, dan kirimkan informasi Anda. Setelah terdaftar, Anda dapat masuk ke akun Anda dan mulai menggunakan fitur-fitur yang tersedia.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-section">
                        <h4>Pertanyaan Penggunaan</h4>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    Bagaimana cara meminjam buku?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Untuk meminjam buku, cukup cari buku tersebut di katalog, periksa ketersediaannya, dan klik tombol "Pinjam". Ikuti petunjuk di layar untuk menyelesaikan proses peminjaman.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Bagaimana cara mengembalikan buku yang dipinjam?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Untuk mengembalikan buku, kunjungi perpustakaan, cari buku yang dipinjam, dan klik tombol "Kembalikan". Status buku akan diperbarui secara otomatis oleh sistem.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-section">
                        <h4>Donasi & Kontribusi</h4>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Bagaimana cara mendonasikan untuk SiPBW?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Untuk mendonasikan untuk SiPBW, kunjungi halaman donasi dan ikuti petunjuk untuk berkontribusi. Dukungan Anda membantu meningkatkan sistem untuk semua orang!
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Bisakah saya berkontribusi pada proyek SiPBW?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya! Anda dapat berkontribusi pada SiPBW dengan mengunjungi bagian "Kontribusi" di situs web kami, di mana Anda dapat menemukan petunjuk tentang cara terlibat dan berkontribusi dengan kode atau sumber daya.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-center home-button">
                    <a href="index.php" class="btn btn-primary btn-lg">
                        <i class="fa fa-home"></i> Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        const searchInput = document.getElementById('searchFAQ');
        searchInput.addEventListener('input', function () {
            const searchValue = searchInput.value.toLowerCase();
            const accordionItems = document.querySelectorAll('.accordion-item');
            accordionItems.forEach(function (item) {
                const question = item.querySelector('.accordion-button').innerText.toLowerCase();
                if (question.includes(searchValue)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
