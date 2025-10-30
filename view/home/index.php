<!-- Header -->
<?php
  $title = "Dashboard"; // Judulnya
  require("../template/header.php"); // include headernya

  include('../../config/connection.php'); // database
?>



<!-- Isinya -->

<section class="section">
  <div class="section-header">
    <h1><?= $title; ?></h1>
  </div>

  <?php
    if (isset($_SESSION['alert'])) {
      echo $_SESSION['alert'];
      unset($_SESSION['alert']);
    }
  ?>

  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="far fa-user"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Admin</h4>
          </div>
          <div class="card-body">
            <?= mysqli_num_rows(mysqli_query($conn, "SELECT id FROM user WHERE hak = 'admin'")); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-info">
          <i class="far fa-user"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Pegawai</h4>
          </div>
          <div class="card-body">
            <?= mysqli_num_rows(mysqli_query($conn, "SELECT id FROM user WHERE hak = 'pegawai'")); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="far fa-file"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Pendaftar Tahun ini</h4>
          </div>
          <div class="card-body">
            <?= mysqli_num_rows(mysqli_query($conn, "SELECT tgl_buat FROM identitas_siswa WHERE DATE_FORMAT(tgl_buat, 'Y') = DATE_FORMAT(NOW(), 'Y')")); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
          <i class="fas fa-circle"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Pendaftar </h4>
          </div>
          <div class="card-body">
            <?= mysqli_num_rows(mysqli_query($conn, "SELECT tgl_buat FROM identitas_siswa")); ?>
          </div>
        </div>
      </div>
    </div>
    <?php
    // Ambil semua data jurusan dari tabel setting_kuota
    $query = mysqli_query($conn, "SELECT jurusan, kuota_total, kuota_terisi FROM setting_kuota");

    while ($row = mysqli_fetch_assoc($query)) {
        $jurusan = $row['jurusan'];
        $kuota_total = $row['kuota_total'];
        $kuota_terisi = $row['kuota_terisi'];
        $persentase = $kuota_total > 0 ? round(($kuota_terisi / $kuota_total) * 100) : 0;

        // Tentukan warna ikon sesuai jurusan
        switch ($jurusan) {
            case 'TKJT':
                $bg_color = 'bg-success';
                $icon = 'fa-network-wired';
                break;
            case 'PPLG':
                $bg_color = 'bg-secondary';
                $icon = 'fa-laptop-code';
                break;
            default:
                $bg_color = 'bg-primary';
                $icon = 'fa-school';
                break;
        }
    ?>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon <?= $bg_color ?>">
                    <i class="fas <?= $icon ?>"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Kuota <?= htmlspecialchars($jurusan) ?></h4>
                    </div>
                    <div class="card-body">
                        <?= $kuota_terisi ?> / <?= $kuota_total ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
  </div>

  <!-- hmm -->

  </div>
</section>

<!-- Penutup Isinya -->



<!-- Footer -->
<?php require("../template/footer.php");?>