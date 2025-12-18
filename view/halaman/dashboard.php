<!-- Header -->
<?php
session_start();
// Cek login dan status pembayaran
if (!isset($_SESSION['noTelpPeserta'])) {
    header('Location: daftarSiswa.php');
    exit();
}

include('../../config/connection.php');
$no_telp = $_SESSION['noTelpPeserta'];
$query = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE no_telepon = '$no_telp'");
$data = mysqli_fetch_assoc($query);

// Jika belum bayar, redirect ke halaman pembayaran
if ($data['status_administrasi'] == 0) {
    header('Location: daftarSiswa.php');
    exit();
}

$title = "Dashboard Siswa";
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
    <script src="../../assets/bootstrap-4/js/moment.min.js"></script>
    <script src="../../assets/js/stisla.js"></script>
    <script src="../../assets/dataTables/js/jquery.dataTables.js"></script>
    <script src="../../assets/dataTables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>
    <script src="../../assets/js/custom.js"></script>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>

            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="../../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block"><?= $_SESSION['namaPeserta']; ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="../../controller/admin/daftar.php?logout"
                                class="dropdown-item has-icon text-danger">
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
                        <li class="menu-header">Menu</li>
                        <li class="nav-item dropdown active">
                            <a href="#" class="nav-link has-dropdown"><i
                                    class="fas fa-book"></i><span>Pendatar</span></a>
                            <ul class="dropdown-menu">
                                <li class="active"><a class="nav-link" href="dashboard.php">Data Siswa</a></li>
                                <li><a class="nav-link" href="daftarOrtu.php">Data Orang Tua</a></li>
                                <li><a class="nav-link" href="dokumenPendukung.php">Dokumen Pendukung</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <button class="btn btn-primary btn-lg btn-block btn-icon-split"
                            onclick="cetak(<?= $_SESSION['noTelpPeserta']; ?>)">
                            <i class="fas fa-sign-out-alt"></i> Cetak Kartu Peserta
                        </button>
                    </div>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
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

                    <div class="section-body">
                        <div class="row">
                            <?php
                            $query_jurusan = mysqli_query($conn, "SELECT * FROM setting_kuota ORDER BY jurusan ASC");

                            while ($jurusan = mysqli_fetch_assoc($query_jurusan)) {

                                $kuota_terisi = $jurusan['kuota_terisi'];
                                $kuota_total = $jurusan['kuota_total'];
                                $bg_color = 'bg-primary';
                                ?>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon <?= $bg_color ?>">
                                            <i class="fas fa-network-wired"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4><?= $jurusan['jurusan'] ?></h4>
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="index.php" type="button"
                                            class="btn btn-primary daterange-btn icon-left btn-icon">
                                            <i class="fas fa-arrow-left"></i> Halaman Utama
                                        </a>
                                    </div>
                                    <div class="card-body">

                                        <?php
                                        $no_telp = $_SESSION['noTelpPeserta'];
                                        $data = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE no_telepon = '$no_telp'") or die(mysqli_error($conn));

                                        if (mysqli_num_rows($data) != 1) {
                                            echo "<script>window.location.href = 'daftarSiswa.php';</script>";
                                        }

                                        foreach ($data as $row) {
                                            ?>

                                            <div class="section-title mt-0 ml-4">Ubah Data Peserta</div>
                                            
                                            <!-- Form Ubah Data -->
                                            <form class="needs-validation" novalidate=""
                                                action="../../controller/admin/daftar.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id"
                                                        value="<?= $row['Id_Identitas_Siswa']; ?>">

                                                    <div class="form-group">
                                                        <label>NISN</label>
                                                        <input type="text" class="form-control" name="nisn" required
                                                            minlength="10" maxlength="10" value="<?= $row['NISN']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib 10 kata</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>No. KK</label>
                                                        <input type="text" class="form-control" name="no_kk" required
                                                            minlength="16" maxlength="16" value="<?= $row['No_KK']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib 16 kata</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>NIK</label>
                                                        <input type="text" class="form-control" name="nik" required
                                                            minlength="16" maxlength="16" value="<?= $row['NIK']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib 16 kata</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nama Panggilan</label>
                                                        <input type="text" class="form-control" name="nama_panggilan"
                                                            required value="<?= $row['Nama_Panggilan']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nama Lengkap Peserta Didik</label>
                                                        <input type="text" class="form-control" name="nama_lengkap" required
                                                            value="<?= $row['Nama_Peserta_Didik']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Tempat Lahir</label>
                                                        <input type="text" class="form-control" name="tempat_lahir" required
                                                            value="<?= $row['Tempat_Lahir']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" class="form-control" name="tanggal_lahir"
                                                            required value="<?= $row['Tanggal_Lahir']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Pilihan Jurusan</label>
                                                        <select class="form-control" id="jurusan_pilihan" name="jurusan_pilihan" required>
                                                            <option value="" disabled selected>Pilih Jurusan</option>
                                                            <?php
                                                                $query_jurusan = mysqli_query($conn, "SELECT * FROM setting_kuota");
                                                                while ($jurusan = mysqli_fetch_assoc($query_jurusan)) {
                                                                    $tersisa = $jurusan['kuota_total'] - $jurusan['kuota_terisi'];
                                                                    $status = $tersisa > 0 ? " (Tersisa: $tersisa)" : " (KUOTA PENUH)";
                                                                    $disabled = $tersisa <= 0 ? "disabled" : "";
                                                                    $selected = $row['jurusan_pilihan'] == $jurusan['jurusan'] ? "selected" : "";

                                                                echo "<option 
                                                                        value='{$jurusan['jurusan']}' 
                                                                        data-tersisa='{$tersisa}'
                                                                        data-total='{$jurusan['kuota_total']}'
                                                                        data-terisi='{$jurusan['kuota_terisi']}'
                                                                        $selected $disabled>
                                                                        {$jurusan['jurusan']}
                                                                    </option>";

                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">Pilih salah satu jurusan</div>
                                                        
                                                        <!-- Info Kuota -->
                                                        <div id="info-kuota" class="mt-2"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>
                                                        <select class="form-control" name="jenis_kelamin" required>
                                                            <option value="" disabled selected>~~~ PILIH JENIS KELAMIN ~~~
                                                            </option>
                                                            <option value="Laki-Laki" <?php if ($row['Jenis_Kelamin'] == 'Laki-Laki') {
                                                                echo 'selected';
                                                            } ?>>Laki-Laki</option>
                                                            <option value="Perempuan" <?php if ($row['Jenis_Kelamin'] == 'Perempuan') {
                                                                echo 'selected';
                                                            } ?>>Perempuan</option>
                                                        </select>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Agama</label>
                                                        <select class="form-control" name="agama" required>
                                                            <option value="">-- Pilih Agama --</option>
                                                            <option value="Islam" <?= $row['Agama'] == 'Islam' ? 'selected' : ''; ?>>Islam</option>
                                                            <option value="Kristen" <?= $row['Agama'] == 'Kristen' ? 'selected' : ''; ?>>Kristen</option>
                                                            <option value="Katolik" <?= $row['Agama'] == 'Katolik' ? 'selected' : ''; ?>>Katolik</option>
                                                            <option value="Hindu" <?= $row['Agama'] == 'Hindu' ? 'selected' : ''; ?>>Hindu</option>
                                                            <option value="Buddha" <?= $row['Agama'] == 'Buddha' ? 'selected' : ''; ?>>Buddha</option>
                                                            <option value="Konghucu" <?= $row['Agama'] == 'Konghucu' ? 'selected' : ''; ?>>Konghucu</option>
                                                            <option value="Lainnya" <?= $row['Agama'] == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                                                        </select>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kelainan Jasmani</label>
                                                        <input type="text" class="form-control" name="kelainan_jasmani"
                                                            value="<?= $row['Kelainan_Jasmani']; ?>">
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kebutuhan Khusus</label>
                                                        <input type="text" class="form-control" name="kebutuhan_khusus"
                                                            value="<?= $row['Kebutuhan_Khusus']; ?>" required>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Hobi</label>
                                                        <input type="text" class="form-control" name="hobi"
                                                            value="<?= $row['Hobi']; ?>" required>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nama Ayah</label>
                                                        <input type="text" class="form-control" name="nama_ayah"
                                                            value="<?= $row['Nama_Ayah']; ?>" required>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nama Ibu</label>
                                                        <input type="text" class="form-control" name="nama_ibu"
                                                            value="<?= $row['Nama_Ibu']; ?>" required>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Alamat Lengkap Orang Tua / Wali</label>
                                                        <textarea class="form-control" name="alamat_ortu" rows="2" required><?= $row['Alamat_Ortu']; ?></textarea>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>No. Telepon</label>
                                                        <input type="text" class="form-control" name="no_telp"
                                                            value="<?= $row['No_Telp']; ?>" required>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="<?= $row['Email']; ?>" required>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Asal Sekolah</label>
                                                        <input type="text" class="form-control" name="asal_sekolah"
                                                            value="<?= $row['asal_sekolah']; ?>" required>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Alamat Sekolah</label>
                                                        <textarea class="form-control" name="alamat_sekolah"  required><?= $row['Alamat_Sekolah']; ?></textarea>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Tinggal Bersama</label>
                                                        <select class="form-control" name="tinggal_bersama" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Orang Tua" <?= $row['Tinggal_Bersama'] == 'Orang Tua' ? 'selected' : '' ?>>Orang Tua</option>
                                                            <option value="Wali" <?= $row['Tinggal_Bersama'] == 'Wali' ? 'selected' : '' ?>>Wali</option>
                                                            <option value="Saudara" <?= $row['Tinggal_Bersama'] == 'Saudara' ? 'selected' : '' ?>>Saudara</option>
                                                            <option value="Asrama" <?= $row['Tinggal_Bersama'] == 'Asrama' ? 'selected' : '' ?>>Asrama</option>
                                                            <option value="Sendiri" <?= $row['Tinggal_Bersama'] == 'Sendiri' ? 'selected' : '' ?>>Sendiri</option>
                                                        </select>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib dipilih!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Transport ke Sekolah</label>
                                                        <select class="form-control" name="transport" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Jalan Kaki" <?= $row['Transport'] == 'Jalan Kaki' ? 'selected' : '' ?>>Jalan Kaki</option>
                                                            <option value="Sepeda" <?= $row['Transport'] == 'Sepeda' ? 'selected' : '' ?>>Sepeda</option>
                                                            <option value="Motor" <?= $row['Transport'] == 'Motor' ? 'selected' : '' ?>>Motor</option>
                                                            <option value="Mobil" <?= $row['Transport'] == 'Mobil' ? 'selected' : '' ?>>Mobil</option>
                                                            <option value="Angkutan Umum" <?= $row['Transport'] == 'Angkutan Umum' ? 'selected' : '' ?>>Angkutan Umum</option>
                                                            <option value="Ojek Online" <?= $row['Transport'] == 'Ojek Online' ? 'selected' : '' ?>>Ojek Online</option>
                                                        </select>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib dipilih!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Golongan Darah</label>
                                                        <select class="form-control" name="gol_darah" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="A" <?= $row['Gol_Darah'] == 'A' ? 'selected' : '' ?>>A</option>
                                                            <option value="B" <?= $row['Gol_Darah'] == 'B' ? 'selected' : '' ?>>B</option>
                                                            <option value="AB" <?= $row['Gol_Darah'] == 'AB' ? 'selected' : '' ?>>AB</option>
                                                            <option value="O" <?= $row['Gol_Darah'] == 'O' ? 'selected' : '' ?>>O</option>
                                                            <option value="Tidak Tahu" <?= $row['Gol_Darah'] == 'Tidak Tahu' ? 'selected' : '' ?>>Tidak Tahu</option>
                                                        </select>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib dipilih!</div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label>Tinggi Badan (Cm)</label>
                                                        <input type="number" class="form-control" name="tinggi_badan"
                                                            required value="<?= $row['Tinggi_Badan']; ?>" required>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Berat Badan (Kg)</label>
                                                        <input type="number" class="form-control" name="berat_badan"
                                                            required value="<?= $row['Berat_Badan']; ?>" required>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Suku</label>
                                                        <input type="text" class="form-control" name="suku" required
                                                            value="<?= $row['Suku']; ?>" required>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Bahasa</label>
                                                        <input type="text" class="form-control" name="bahasa" required
                                                            value="<?= $row['Bahasa']; ?>" required>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kewarganegaraan</label>
                                                        <input type="text" class="form-control" name="kewarganegaraan"
                                                            required value="<?= $row['Kewarganegaraan']; ?>" required>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Status Anak</label>
                                                        <input type="text" class="form-control" name="status_anak" required
                                                            value="<?= $row['Status_Anak']; ?>" required>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Anak Ke</label>
                                                        <input type="number" class="form-control" name="anak_ke" required
                                                            value="<?= $row['Anak_Ke']; ?>" required>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Jumlah Saudara</label>
                                                        <input type="number" class="form-control" name="jumlah_saudara"
                                                            required value="<?= $row['Jml_Saudara']; ?>" required>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Jenis Tinggal</label>
                                                        <select class="form-control" name="jenis_tinggal" required>
                                                            <option value="">-- Pilih Jenis Tinggal --</option>
                                                            <option value="Bersama Orang Tua" <?= $row['Jenis_Tinggal'] == 'Bersama Orang Tua' ? 'selected' : ''; ?>>Bersama Orang Tua</option>
                                                            <option value="Wali" <?= $row['Jenis_Tinggal'] == 'Wali' ? 'selected' : ''; ?>>Wali</option>
                                                            <option value="Kost" <?= $row['Jenis_Tinggal'] == 'Kost' ? 'selected' : ''; ?>>Kost</option>
                                                            <option value="Asrama" <?= $row['Jenis_Tinggal'] == 'Asrama' ? 'selected' : ''; ?>>Asrama</option>
                                                            <option value="Panti Asuhan" <?= $row['Jenis_Tinggal'] == 'Panti Asuhan' ? 'selected' : ''; ?>>Panti Asuhan</option>
                                                            <option value="Lainnya" <?= $row['Jenis_Tinggal'] == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                                                        </select>
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <textarea type="text" class="form-control" name="alamat_tinggal"
                                                            required
                                                            style="height:80px"><?= $row['Alamat_Tinggal']; ?></textarea>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Provinsi</label>
                                                        <input type="text" class="form-control" name="provinsi_tinggal"
                                                            required value="<?= $row['Provinsi_Tinggal']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kabupaten / Kota</label>
                                                        <input type="text" class="form-control" name="kab_kota_tinggal"
                                                            required value="<?= $row['Kab_Kota_Tinggal']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kecamatan</label>
                                                        <input type="text" class="form-control" name="kecamatan_tinggal"
                                                            required value="<?= $row['Kec_Tinggal']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kelurahan</label>
                                                        <input type="text" class="form-control" name="kelurahan_tinggal"
                                                            required value="<?= $row['Kelurahan_Tinggal']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kode POS</label>
                                                        <input type="number" class="form-control" name="kode_pos" required
                                                            value="<?= $row['Kode_POS']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Jarak Ke Sekolah (Meter)</label>
                                                        <input type="number" class="form-control" name="jarak_ke_sekolah"
                                                            required value="<?= $row['Jarak_Ke_Sekolah']; ?>">
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Riwayat Penyakit</label>
                                                        <textarea type="text" class="form-control" name="riwayat_penyakit"
                                                            required
                                                            style="height:80px"><?= $row['Riwayat_Penyakit']; ?></textarea>
                                                        <div class="valid-feedback">Baguss!</div>
                                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                                    </div>

                                                    <div class="modal-footer bg-whitesmoke br">
                                                        <button class="btn btn-primary" name="ubahDataSiswa">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>

                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Footer -->
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2025 <div class="bullet"></div> <a href="https://www.smkbinarahayu.sch.id/">SMK
                        BINA RAHAYU</a>
                </div>
                <div class="footer-right">
                    Modified By : <a>Mahasiswa Unpam</a>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script type="text/javascript">
        function cetak(id) {
            window.open("../cetak/index.php?id=" + id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=100,width=900,height=460");
        }

        // Alert kuota real-time
        const jurusanSelect = document.getElementById('jurusanSelect');
        if (jurusanSelect) {
            jurusanSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const kuotaSisa = parseInt(selectedOption.getAttribute('data-kuota'));
                const alertDiv = document.getElementById('alertKuota');

                if (kuotaSisa === 0) {
                    alertDiv.innerHTML = '<div class="alert alert-danger">Maaf, kuota untuk jurusan ini sudah penuh!</div>';
                    alertDiv.style.display = 'block';
                } else if (kuotaSisa <= 5) {
                    alertDiv.innerHTML = '<div class="alert alert-warning">Kuota hampir penuh! Tersisa ' + kuotaSisa + ' kursi.</div>';
                    alertDiv.style.display = 'block';
                } else {
                    alertDiv.style.display = 'none';
                }
            });
        }

        // Validasi sebelum submit
        const formElement = document.querySelector('form');
        if (formElement) {
            formElement.addEventListener('submit', function (e) {
                const jurusanSelect = document.getElementById('jurusanSelect');
                if (jurusanSelect) {
                    const selectedOption = jurusanSelect.options[jurusanSelect.selectedIndex];
                    const kuotaSisa = parseInt(selectedOption.getAttribute('data-kuota'));

                    if (kuotaSisa === 0) {
                        e.preventDefault();
                        alert('Maaf, kuota untuk jurusan ini sudah penuh. Silakan pilih jurusan lain.');
                        return false;
                    }
                }
            });
        }

        function cekKuota(jurusan) {
            if (jurusan === '') {
                document.getElementById('pesan-kuota').innerHTML = '';
                return;
            }
            
            // AJAX request untuk cek kuota
            fetch('../../controller/admin/cek_kuota.php?jurusan=' + jurusan)
                .then(response => response.json())
                .then(data => {
                    const pesanElement = document.getElementById('pesan-kuota');
                    if (data.tersisa > 0) {
                        pesanElement.innerHTML = 'Kuota tersisa: ' + data.tersisa + ' dari ' + data.total;
                        pesanElement.className = 'form-text text-success';
                    } else {
                        pesanElement.innerHTML = '❌ Kuota sudah penuh untuk jurusan ini';
                        pesanElement.className = 'form-text text-danger';
                        document.getElementById('jurusan_pilihan').value = '';
                    }
                });
        }

        // Cek kuota saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const jurusanSelect = document.getElementById('jurusan_pilihan');
            if (jurusanSelect.value) {
                cekKuota(jurusanSelect.value);
            }
        });

    </script>
</body>

</html>