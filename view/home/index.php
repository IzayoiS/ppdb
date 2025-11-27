<!-- Header -->
<?php
  $title = "Dashboard"; // Judulnya
  require("../template/header.php"); // include headernya

  include('../../config/connection.php'); // database

  $tahun_query = mysqli_query($conn, "SELECT DISTINCT tahun_ajaran FROM identitas_siswa WHERE tahun_ajaran IS NOT NULL ORDER BY tahun_ajaran DESC");
  $tahun_options = [];
  while ($row = mysqli_fetch_assoc($tahun_query)) {
    $tahun_options[] = $row['tahun_ajaran'];
  }

  $tahun_sekarang = date('Y') . '/' . (date('Y') + 1);
  $tahun_selected = isset($_GET['tahun']) ? $_GET['tahun'] : $tahun_sekarang;
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

  <div class="row mb-3">
    <div class="col-md-3">
      <form method="GET" class="form-inline">
        <div class="form-group w-100">
          <label for="tahun" class="mr-2">Filter Tahun Pelajaran:</label>
          <select name="tahun" id="tahun" class="form-control w-75" onchange="this.form.submit()">
            <option value="">-- Pilih Tahun --</option>
            <?php foreach ($tahun_options as $tahun): ?>
              <option value="<?= $tahun ?>" <?= $tahun_selected == $tahun ? 'selected' : '' ?>>
                <?= $tahun ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </form>
    </div>
  </div>

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
            <h4>Total Pendaftar Tahun <?= htmlspecialchars($tahun_selected) ?></h4>
          </div>
          <div class="card-body">
            <?= mysqli_num_rows(mysqli_query($conn, "SELECT Id_Identitas_Siswa FROM identitas_siswa WHERE tahun_ajaran = '$tahun_selected'")); ?>
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