<?php
session_start();
// Redirect jika belum login atau belum bayar
if (!isset($_SESSION['nisnSiswa']) || $_SESSION['status_administrasi'] != 1) {
    header('Location: login.php');
    exit();
}

$title = "Dashboard Siswa";
include("../../config/connection.php");

// Ambil data lengkap siswa
$nisn = $_SESSION['nisnSiswa'];
$query = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE NISN = '$nisn'");
$siswa = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $title; ?> | PPDB</title>
  <link rel="icon" href="../../assets/img/avatar/icone.png">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../../assets/bootstrap-4/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="../../assets/dataTables/css/dataTables.bootstrap4.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link rel="stylesheet" href="../../assets/css/components.css">

  <!-- General JS Scripts -->
  <script src="../../assets/bootstrap-4/js/jquery-3.3.1.min.js"></script>
  <script src="../../assets/bootstrap-4/js/popper.min.js"></script>
  <script src="../../assets/bootstrap-4/js/bootstrap.min.js"></script>
  <script src="../../assets/bootstrap-4/js/jquery.nicescroll.min.js"></script>
  <script src="../../assets/js/stisla.js"></script>
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      
      <!-- NAVBAR -->
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="../../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
              <div class="d-sm-none d-lg-inline-block"><?= $_SESSION['namaSiswa']; ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="../../controller/siswa/daftar.php?logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Keluar
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <!-- SIDEBAR -->
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href=""><img src="../../assets/img/avatar/icone.png" alt="LP" width="30px"> PPDB</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href=""><img src="../../assets/img/avatar/icone.png" alt="LP" width="47px"></a>
          </div>
          
          <ul class="sidebar-menu">
            <li class="menu-header">Menu Siswa</li>
            
            <li class="nav-item active">
              <a href="dashboard.php" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <li class="nav-item dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>Biodata</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="data_diri.php">Data Diri Lengkap</a></li>
                <li><a class="nav-link" href="data_ortu.php">Data Orang Tua</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="status.php" class="nav-link"><i class="fas fa-tasks"></i><span>Status Pendaftaran</span></a>
            </li>
          </ul>

          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <button class="btn btn-primary btn-lg btn-block btn-icon-split" onclick="cetakKartu()">
              <i class="fas fa-print"></i> Cetak Kartu Peserta
            </button>
          </div>
        </aside>
      </div>

      <!-- MAIN CONTENT -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Dashboard Siswa</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active">Dashboard</div>
            </div>
          </div>

          <?php
          if (isset($_SESSION['alert'])) {
              echo $_SESSION['alert'];
              unset($_SESSION['alert']);
          }
          ?>

          <div class="section-body">
            <!-- Welcome Message -->
            <div class="card">
              <div class="card-header">
                <h4>Selamat Datang, <?= $_SESSION['namaSiswa']; ?>!</h4>
              </div>
              <div class="card-body">
                <p>Pembayaran formulir Anda sudah dikonfirmasi. Silakan lengkapi data diri untuk melanjutkan proses pendaftaran.</p>
                
                <!-- Progress Status -->
                <div class="row mt-4">
                  <div class="col-md-4">
                    <div class="card card-primary">
                      <div class="card-header">
                        <h4>Pembayaran</h4>
                      </div>
                      <div class="card-body">
                        <span class="badge badge-success">LUNAS</span>
                        <p class="mt-2">Formulir sudah dibayar</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="card card-info">
                      <div class="card-header">
                        <h4>Data Diri</h4>
                      </div>
                      <div class="card-body">
                        <?php if ($siswa['status_ortu'] == 0): ?>
                              <span class="badge badge-warning">BELUM LENGKAP</span>
                              <p class="mt-2">Lengkapi data diri</p>
                              <a href="data_diri.php" class="btn btn-sm btn-primary">Lengkapi</a>
                        <?php else: ?>
                              <span class="badge badge-success">LENGKAP</span>
                              <p class="mt-2">Data sudah lengkap</p>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="card card-success">
                      <div class="card-header">
                        <h4>Status</h4>
                      </div>
                      <div class="card-body">
                        <span class="badge badge-info"><?= $siswa['status_pendaftaran']; ?></span>
                        <p class="mt-2">Menunggu verifikasi</p>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                  <div class="col-md-6">
                    <a href="data_diri.php" class="btn btn-primary btn-lg btn-block">
                      <i class="fas fa-user-edit"></i><br>
                      Lengkapi Data Diri
                    </a>
                  </div>
                  <div class="col-md-6">
                    <a href="status.php" class="btn btn-info btn-lg btn-block">
                      <i class="fas fa-tasks"></i><br>
                      Lihat Status
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2025 <div class="bullet"></div> <a href="#">SMK BINA RAHAYU</a>
        </div>
        <div class="footer-right">
          Modified By : <a>Mahasiswa Unpam</a> 
        </div>
      </footer>
    </div>
  </div>

  <script>
    function cetakKartu() {
      alert('Fitur cetak kartu peserta akan segera tersedia!');
    }
  </script>
</body>
</html>