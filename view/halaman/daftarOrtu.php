<!-- Header -->
<?php
session_start();
$title = "Dashboard Orang Tua";
if (!isset($_SESSION['noTelpPeserta'])) {
    echo "<script>window.location.href = 'daftarSiswa.php';</script>";
    die();
}
include('../../config/connection.php');

// Ambil data siswa
$no_telp = $_SESSION['noTelpPeserta'];
$data_siswa = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE no_telepon = '$no_telp'");
$row = mysqli_fetch_assoc($data_siswa);
$status_pembayaran = $row['status_administrasi'];

// Ambil data orang tua jika sudah ada
$data_ortu = array();
if ($row['status_ortu'] == 1) {
    $query_ortu = mysqli_query($conn, "SELECT * FROM orang_tua_wali WHERE Id_Identitas_Siswa = '{$row['Id_Identitas_Siswa']}'");
    $data_ortu = mysqli_fetch_assoc($query_ortu);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= $title; ?> | PPDB</title>
    <link rel="icon" href="../../assets/img/avatar/icone.png">
    <link rel="stylesheet" href="../../assets/bootstrap-4/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../assets/dataTables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/components.css">
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

            <!-- Navbar -->
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
                            <div class="d-sm-none d-lg-inline-block"><?= $_SESSION['namaPeserta']; ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="../../controller/admin/daftar.php?logout" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Sidebar -->
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href=""><img src="../../assets/img/avatar/icone.png" alt="LP" width="30px"> PPDB</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Menu</li>
                        <li class="nav-item dropdown active">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Pendaftar</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="dashboard.php">Data Siswa</a></li>
                                <li class="active"><a class="nav-link" href="daftarOrtu.php">Data Orang Tua</a></li>
                                <li><a class="nav-link" href="dokumenPendukung.php">Dokumen Pendukung</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <button class="btn btn-primary btn-lg btn-block btn-icon-split" onclick="cetak(<?= $_SESSION['noTelpPeserta']; ?>)">
                            <i class="fas fa-print"></i> Cetak Kartu Peserta
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
                        <div class="card">
                            <div class="card-header">
                                <a href="dashboard.php" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Halaman Utama
                                </a>
                            </div>
                            <div class="card-body">

                                <?php if ($status_pembayaran == 0): ?>
                                    <!-- ❌ JIKA BELUM BAYAR - TAMPILKAN PESAN TERKUNCI -->
                                    <div class="text-center p-5">
                                        <i class="fas fa-lock fa-4x text-secondary mb-3"></i>
                                        <h4 class="text-muted">Data Orang Tua Terkunci</h4>
                                        <p class="text-muted">Anda belum melakukan pembayaran formulir PPDB.<br>Silakan selesaikan pembayaran terlebih dahulu untuk melanjutkan pengisian data.</p>

                                        <?php
                                        $nama_siswa = $row['Nama_Peserta_Didik'];
                                        $pesan = "Halo Admin, saya $nama_siswa ingin melakukan pembayaran formulir PPDB.";
                                        $pesan_encoded = urlencode($pesan);
                                        $nomor_wa = "6285121015646";
                                        $url_wa = "https://wa.me/$nomor_wa?text=$pesan_encoded";
                                        ?>
                                        <a href="<?= $url_wa ?>" target="_blank" class="btn btn-success btn-lg">
                                            <i class="fab fa-whatsapp"></i> Hubungi Admin untuk Pembayaran
                                        </a>
                                    </div>

                                <?php else: ?>
                                    <!-- ✅ JIKA SUDAH LUNAS - TAMPILKAN FORM -->

                                    <?php if ($row['status_ortu'] == 0): ?>
                                        <!-- 📝 FORM TAMBAH DATA ORANG TUA -->
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb bg-primary text-white-all">
                                                <li class="breadcrumb-item active" aria-current="page">Tambah Data Orang Tua</li>
                                            </ol>
                                        </nav>

                                        <form class="needs-validation" novalidate action="../../controller/admin/daftar.php" method="POST">
                                            <input type="hidden" name="peserta" value="<?= $row['Id_Identitas_Siswa']; ?>">
                                            
                                            <!-- DATA AYAH -->
                                            <div class="section-title mt-3">Data Ayah</div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Nama Ayah <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nama_ayah" required>
                                                    <div class="invalid-feedback">Nama ayah wajib diisi</div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Status Ayah <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="status_ayah" required>
                                                        <option value="">~~~ PILIH STATUS ~~~</option>
                                                        <option value="Masih Hidup">Masih Hidup</option>
                                                        <option value="Meninggal">Meninggal</option>
                                                        <option value="Cerai">Cerai</option>
                                                    </select>
                                                    <div class="invalid-feedback">Status ayah wajib dipilih</div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="tanggal_lahir_ayah" required>
                                                    <div class="invalid-feedback">Tanggal lahir wajib diisi</div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Telepon <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="telepon_ayah" required>
                                                    <div class="invalid-feedback">Telepon wajib diisi</div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Pendidikan Terakhir <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="pendidikan_terakhir_ayah" required>
                                                        <option value="">~~~ PILIH DISINI ~~~</option>
                                                        <option>SD</option>
                                                        <option>SMP</option>
                                                        <option>SMA/SEDERAJAT</option>
                                                        <option>S1</option>
                                                        <option>S2</option>
                                                        <option>S3</option>
                                                    </select>
                                                    <div class="invalid-feedback">Pendidikan wajib dipilih</div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Pekerjaan Ayah <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="pekerjaan_ayah" required>
                                                    <div class="invalid-feedback">Pekerjaan wajib diisi</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Penghasilan Ayah <span class="text-danger">*</span></label>
                                                <select class="form-control" name="penghasilan_ayah" required>
                                                    <option value="">~~~ PILIH PENGHASILAN ~~~</option>
                                                    <option value="< 1 Juta">< 1 Juta</option>
                                                    <option value="1 - 3 Juta">1 - 3 Juta</option>
                                                    <option value="3 - 5 Juta">3 - 5 Juta</option>
                                                    <option value="5 - 10 Juta">5 - 10 Juta</option>
                                                    <option value="> 10 Juta">> 10 Juta</option>
                                                </select>
                                                <div class="invalid-feedback">Penghasilan wajib dipilih</div>
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat Ayah <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="alamat_ayah" required></textarea>
                                                <div class="invalid-feedback">Alamat wajib diisi</div>
                                            </div>

                                            <!-- DATA IBU -->
                                            <div class="section-title mt-3">Data Ibu</div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Nama Ibu <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nama_ibu" required>
                                                    <div class="invalid-feedback">Nama ibu wajib diisi</div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Status Ibu <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="status_ibu" required>
                                                        <option value="">~~~ PILIH STATUS ~~~</option>
                                                        <option value="Masih Hidup">Masih Hidup</option>
                                                        <option value="Meninggal">Meninggal</option>
                                                        <option value="Cerai">Cerai</option>
                                                    </select>
                                                    <div class="invalid-feedback">Status ibu wajib dipilih</div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="tanggal_lahir_ibu" required>
                                                    <div class="invalid-feedback">Tanggal lahir wajib diisi</div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Telepon <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="telepon_ibu" required>
                                                    <div class="invalid-feedback">Telepon wajib diisi</div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Pendidikan Terakhir <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="pendidikan_terakhir_ibu" required>
                                                        <option value="">~~~ PILIH DISINI ~~~</option>
                                                        <option>SD</option>
                                                        <option>SMP</option>
                                                        <option>SMA/SEDERAJAT</option>
                                                        <option>S1</option>
                                                        <option>S2</option>
                                                        <option>S3</option>
                                                    </select>
                                                    <div class="invalid-feedback">Pendidikan wajib dipilih</div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Pekerjaan Ibu <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="pekerjaan_ibu" required>
                                                    <div class="invalid-feedback">Pekerjaan wajib diisi</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Penghasilan Ibu <span class="text-danger">*</span></label>
                                                <select class="form-control" name="penghasilan_ibu" required>
                                                    <option value="">~~~ PILIH PENGHASILAN ~~~</option>
                                                    <option value="< 1 Juta">< 1 Juta</option>
                                                    <option value="1 - 3 Juta">1 - 3 Juta</option>
                                                    <option value="3 - 5 Juta">3 - 5 Juta</option>
                                                    <option value="5 - 10 Juta">5 - 10 Juta</option>
                                                    <option value="> 10 Juta">> 10 Juta</option>
                                                </select>
                                                <div class="invalid-feedback">Penghasilan wajib dipilih</div>
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat Ibu <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="alamat_ibu" required></textarea>
                                                <div class="invalid-feedback">Alamat wajib diisi</div>
                                            </div>

                                            <!-- DATA WALI (OPSIONAL) -->
                                            <div class="section-title mt-3">Data Wali (Opsional)</div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Nama Wali</label>
                                                    <input type="text" class="form-control" name="nama_wali">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Status Wali</label>
                                                    <select class="form-control" name="status_wali">
                                                        <option value="">Tidak Ada</option>
                                                        <option value="Wali">Wali</option>
                                                        <option value="Kakek">Kakek</option>
                                                        <option value="Nenek">Nenek</option>
                                                        <option value="Paman">Paman</option>
                                                        <option value="Bibi">Bibi</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Tanggal Lahir Wali</label>
                                                    <input type="date" class="form-control" name="tanggal_lahir_wali">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Telepon Wali</label>
                                                    <input type="number" class="form-control" name="telepon_wali">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Pendidikan Terakhir Wali</label>
                                                    <select class="form-control" name="pendidikan_terakhir_wali">
                                                        <option value="">Pilih Pendidikan</option>
                                                        <option>SD</option>
                                                        <option>SMP</option>
                                                        <option>SMA/SEDERAJAT</option>
                                                        <option>S1</option>
                                                        <option>S2</option>
                                                        <option>S3</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Pekerjaan Wali</label>
                                                    <input type="text" class="form-control" name="pekerjaan_wali">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Penghasilan Wali</label>
                                                <select class="form-control" name="penghasilan_wali">
                                                    <option value="">Pilih Penghasilan</option>
                                                    <option value="< 1 Juta">< 1 Juta</option>
                                                    <option value="1 - 3 Juta">1 - 3 Juta</option>
                                                    <option value="3 - 5 Juta">3 - 5 Juta</option>
                                                    <option value="5 - 10 Juta">5 - 10 Juta</option>
                                                    <option value="> 10 Juta">> 10 Juta</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat Wali</label>
                                                <textarea class="form-control" name="alamat_wali"></textarea>
                                            </div>

                                            <div class="modal-footer bg-whitesmoke br">
                                                <button class="btn btn-primary" name="tambahDataOrtu">Simpan Data Orang Tua</button>
                                            </div>
                                        </form>

                                    <?php else: ?>
                                        <!-- 📄 FORM EDIT DATA ORANG TUA -->
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb bg-success text-white-all">
                                                <li class="breadcrumb-item active" aria-current="page">Edit Data Orang Tua</li>
                                            </ol>
                                        </nav>

                                        <form class="needs-validation" novalidate action="../../controller/admin/daftar.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $data_ortu['Id_Orang_Tua_Wali']; ?>">
                                            <input type="hidden" name="peserta" value="<?= $row['Id_Identitas_Siswa']; ?>">
                                            
                                            <!-- DATA AYAH -->
                                            <div class="section-title mt-3">Data Ayah</div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Nama Ayah <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nama_ayah" value="<?= htmlspecialchars($data_ortu['Nama_Ayah'] ?? ''); ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Status Ayah <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="status_ayah" required>
                                                        <option value="">~~~ PILIH STATUS ~~~</option>
                                                        <option value="Masih Hidup" <?= ($data_ortu['Status_Ayah'] ?? '') == 'Masih Hidup' ? 'selected' : '' ?>>Masih Hidup</option>
                                                        <option value="Meninggal" <?= ($data_ortu['Status_Ayah'] ?? '') == 'Meninggal' ? 'selected' : '' ?>>Meninggal</option>
                                                        <option value="Cerai" <?= ($data_ortu['Status_Ayah'] ?? '') == 'Cerai' ? 'selected' : '' ?>>Cerai</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="tanggal_lahir_ayah" value="<?= $data_ortu['Tgl_Lahir_Ayah'] ?? ''; ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Telepon <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="telepon_ayah" value="<?= $data_ortu['Telepon_Ayah'] ?? ''; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Pendidikan Terakhir <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="pendidikan_terakhir_ayah" required>
                                                        <option value="">~~~ PILIH DISINI ~~~</option>
                                                        <?php
                                                        $pendidikan = ['SD', 'SMP', 'SMA/SEDERAJAT', 'S1', 'S2', 'S3'];
                                                        foreach ($pendidikan as $p) {
                                                            $selected = ($data_ortu['Pendidikan_Terakhir_Ayah'] ?? '') == $p ? 'selected' : '';
                                                            echo "<option value='$p' $selected>$p</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Pekerjaan Ayah <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="pekerjaan_ayah" value="<?= htmlspecialchars($data_ortu['Pekerjaan_Ayah'] ?? ''); ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Penghasilan Ayah <span class="text-danger">*</span></label>
                                                <select class="form-control" name="penghasilan_ayah" required>
                                                    <option value="">~~~ PILIH PENGHASILAN ~~~</option>
                                                    <?php
                                                    $penghasilan = ["< 1 Juta", "1 - 3 Juta", "3 - 5 Juta", "5 - 10 Juta", "> 10 Juta"];
                                                    foreach ($penghasilan as $p) {
                                                        $selected = ($data_ortu['Penghasilan_Ayah'] ?? '') == $p ? 'selected' : '';
                                                        echo "<option value='$p' $selected>$p</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat Ayah <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="alamat_ayah" required><?= htmlspecialchars($data_ortu['Alamat_Ayah'] ?? ''); ?></textarea>
                                            </div>

                                            <!-- DATA IBU -->
                                            <div class="section-title mt-3">Data Ibu</div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Nama Ibu <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nama_ibu" value="<?= htmlspecialchars($data_ortu['Nama_Ibu'] ?? ''); ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Status Ibu <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="status_ibu" required>
                                                        <option value="">~~~ PILIH STATUS ~~~</option>
                                                        <option value="Masih Hidup" <?= ($data_ortu['Status_Ibu'] ?? '') == 'Masih Hidup' ? 'selected' : '' ?>>Masih Hidup</option>
                                                        <option value="Meninggal" <?= ($data_ortu['Status_Ibu'] ?? '') == 'Meninggal' ? 'selected' : '' ?>>Meninggal</option>
                                                        <option value="Cerai" <?= ($data_ortu['Status_Ibu'] ?? '') == 'Cerai' ? 'selected' : '' ?>>Cerai</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="tanggal_lahir_ibu" value="<?= $data_ortu['Tgl_Lahir_Ibu'] ?? ''; ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Telepon <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="telepon_ibu" value="<?= $data_ortu['Telepon_Ibu'] ?? ''; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Pendidikan Terakhir <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="pendidikan_terakhir_ibu" required>
                                                        <option value="">~~~ PILIH DISINI ~~~</option>
                                                        <?php
                                                        foreach ($pendidikan as $p) {
                                                            $selected = ($data_ortu['Pendidikan_Terakhir_Ibu'] ?? '') == $p ? 'selected' : '';
                                                            echo "<option value='$p' $selected>$p</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Pekerjaan Ibu <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="pekerjaan_ibu" value="<?= htmlspecialchars($data_ortu['Pekerjaan_Ibu'] ?? ''); ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Penghasilan Ibu <span class="text-danger">*</span></label>
                                                <select class="form-control" name="penghasilan_ibu" required>
                                                    <option value="">~~~ PILIH PENGHASILAN ~~~</option>
                                                    <?php
                                                    foreach ($penghasilan as $p) {
                                                        $selected = ($data_ortu['Penghasilan_Ibu'] ?? '') == $p ? 'selected' : '';
                                                        echo "<option value='$p' $selected>$p</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat Ibu <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="alamat_ibu" required><?= htmlspecialchars($data_ortu['Alamat_Ibu'] ?? ''); ?></textarea>
                                            </div>

                                            <!-- DATA WALI (OPSIONAL) -->
                                            <div class="section-title mt-3">Data Wali (Opsional)</div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Nama Wali</label>
                                                    <input type="text" class="form-control" name="nama_wali" value="<?= htmlspecialchars($data_ortu['Nama_Wali'] ?? ''); ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Status Wali</label>
                                                    <select class="form-control" name="status_wali">
                                                        <option value="">Tidak Ada</option>
                                                        <option value="Wali" <?= ($data_ortu['Status_Wali'] ?? '') == 'Wali' ? 'selected' : '' ?>>Wali</option>
                                                        <option value="Kakek" <?= ($data_ortu['Status_Wali'] ?? '') == 'Kakek' ? 'selected' : '' ?>>Kakek</option>
                                                        <option value="Nenek" <?= ($data_ortu['Status_Wali'] ?? '') == 'Nenek' ? 'selected' : '' ?>>Nenek</option>
                                                        <option value="Paman" <?= ($data_ortu['Status_Wali'] ?? '') == 'Paman' ? 'selected' : '' ?>>Paman</option>
                                                        <option value="Bibi" <?= ($data_ortu['Status_Wali'] ?? '') == 'Bibi' ? 'selected' : '' ?>>Bibi</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Tanggal Lahir Wali</label>
                                                    <input type="date" class="form-control" name="tanggal_lahir_wali" value="<?= $data_ortu['Tgl_Lahir_Wali'] ?? ''; ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Telepon Wali</label>
                                                    <input type="number" class="form-control" name="telepon_wali" value="<?= $data_ortu['Telepon_Wali'] ?? ''; ?>">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Pendidikan Terakhir Wali</label>
                                                    <select class="form-control" name="pendidikan_terakhir_wali">
                                                        <option value="">Pilih Pendidikan</option>
                                                        <?php
                                                        foreach ($pendidikan as $p) {
                                                            $selected = ($data_ortu['Pendidikan_Terakhir_Wali'] ?? '') == $p ? 'selected' : '';
                                                            echo "<option value='$p' $selected>$p</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Pekerjaan Wali</label>
                                                    <input type="text" class="form-control" name="pekerjaan_wali" value="<?= htmlspecialchars($data_ortu['Pekerjaan_Wali'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Penghasilan Wali</label>
                                                <select class="form-control" name="penghasilan_wali">
                                                    <option value="">Pilih Penghasilan</option>
                                                    <?php
                                                    foreach ($penghasilan as $p) {
                                                        $selected = ($data_ortu['Penghasilan_Wali'] ?? '') == $p ? 'selected' : '';
                                                        echo "<option value='$p' $selected>$p</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat Wali</label>
                                                <textarea class="form-control" name="alamat_wali"><?= htmlspecialchars($data_ortu['Alamat_Wali'] ?? ''); ?></textarea>
                                            </div>

                                            <div class="modal-footer bg-whitesmoke br">
                                                <button class="btn btn-primary" name="ubahDataOrtu">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    <?php endif; ?>

                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Footer -->
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2025 <a href="https://www.smkbinarahayu.sch.id/">SMK BINA RAHAYU</a>
                </div>
                <div class="footer-right">
                    Modified By : Mahasiswa Unpam
                </div>
            </footer>

        </div>
    </div>

    <script>
        function cetak(id) {
            window.open("../cetak/index.php?id=" + id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=100,width=900,height=460");
        }

        // JavaScript for form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

</body>

</html>