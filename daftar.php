<?php
    include "koneksi.php";

    if (isset($_POST['simpan'])) {
      $npm = $_POST['NPM'];
      $nama = $_POST['NamaLengkap'];
      $prodi = $_POST['Prodi'];
      $angkatan = $_POST['Angkatan'];
      $keperluan = $_POST['Keperluan'];
  
      if (!empty($npm) && !empty($nama) && !empty($prodi) && !empty($angkatan) && !empty($keperluan)) {
          $query = "INSERT INTO daftar_hadir (NPM, NamaLengkap, Prodi, Angkatan, Keperluan) 
                    VALUES ('$npm', '$nama', '$prodi', '$angkatan', '$keperluan')";
  
          if (mysqli_query($conn, $query)) {
              $message = "Daftar Hadir berhasil!";
              $alert_class = "alert-success";
          } else {
              $message = "Daftar Hadir gagal!: " . mysqli_error($conn);
              $alert_class = "alert-danger";
          }
      } else {
          $message = "Harap isi semua field!";
          $alert_class = "alert-warning";
      }
  }
  
    $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-icon" href="dashboard/img/ft.png" />
  <title>Form Daftar Hadir</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

  <link rel="stylesheet" href="style.css?version=1.4">
</head>

<body>
  <?php
    require "navbar.php";
  ?>

  <?php if (isset($message)): ?>
    <div class="alert <?php echo $alert_class; ?> text-center">
        <?php echo $message; ?>
    </div>
  <?php endif; ?>

  <div class="container my-4">
    <div class="card mb-4">
      <div class="card-header card-header-custom bg-primary text-white">
        Tata Tertib Layanan Perpustakaan
      </div>
      <div class="card-body">
        <h6>Jam Buka:</h6>
        <ul>
          <li>Senin-Jumat: 08.00 - 16.00 WIB</li>
          <li>Sabtu: 08.00 - 15.00 WIB</li>
          <li>Istirahat: 12.00 - 13.00 WIB</li>
        </ul>
        <h6>Ketentuan Pemakaian Bahan Pustaka:</h6>
        <ol>
          <li>Diprioritaskan membaca koleksi perpustakaan di tempat.</li>
          <li>Bahan pustaka hanya diperbolehkan dipinjam dengan ketentuan tertentu.</li>
          <li>Setiap keterlambatan pengembalian dikenakan denda sebesar Rp 1.000 per hari.</li>
          <li>Pelanggaran tata tertib akan dilaporkan ke pihak terkait.</li>
        </ol>
        <p class="note">*Informasi lebih lanjut dapat ditanyakan pada petugas perpustakaan.</p>
      </div>
    </div>

    <div class="card">
      <div class="card-header card-header-custom text-center bg-primary text-white">
        DAFTAR HADIR PENGUNJUNG
      </div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label for="NPM" class="form-label">Nomor Pokok Mahasiswa <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="NPM" name="NPM" placeholder="Input NPM" autocomplete="off" required>
          </div>
          <div class="mb-3">
            <label for="NamaLengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="NamaLengkap" name="NamaLengkap" placeholder="Input Nama Lengkap" autocomplete="off" required>
          </div>
          <div class="mb-3">
            <label for="Prodi" class="form-label">Prodi <span class="text-danger">*</span></label>
            <select class="form-select" id="Prodi" name="Prodi" required>
              <option value="" disabled selected>Pilih Program Studi</option>
              <option value="Informatika">Informatika</option>
              <option value="Teknik Sipil">Teknik Sipil</option>
              <option value="Teknik Mesin">Teknik Mesin</option>
              <option value="Teknik Industri">Teknik Industri</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="Angkatan" class="form-label">Angkatan <span class="text-danger">*</span></label>
            <select class="form-select" id="Angkatan" name="Angkatan" required>
              <option value="" disabled selected>Pilih Tahun Angkatan</option>
              <option value="2020/2021">2020/2021</option>
              <option value="2021/2022">2021/2022</option>
              <option value="2022/2023">2022/2023</option>
              <option value="2023/2024">2023/2024</option>
              <option value="2024/2025">2024/2025</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="Keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
            <select class="form-select" id="Keperluan" name="Keperluan" required>
              <option value="" disabled selected>Pilih Keperluan</option>
              <option value="Membaca Buku">Membaca Buku</option>
              <option value="Meminjam Buku">Meminjam Buku</option>
              <option value="Mengerjakan Tugas">Mengerjakan Tugas</option>
              <option value="Keperluan Lainnya">Keperluan Lainnya</option>
            </select>
          </div>
          <div class="text-center mb-4">
            <button type="submit" class="btn btn-primary w-100" name="simpan">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
    require "footer.php"
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>