<?php
session_start();
include("../../config/connection.php");

// Tambah Data Awal (Form Pendaftaran Sederhana)
if (isset($_POST['tambahDataSiswa'])) {
    $nisn = mysqli_real_escape_string($conn, $_POST['nisn']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $no_telepon = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
    $asal_sekolah = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
    $tgl_buat = date('Y-m-d H:i:s');

    // Cek apakah NISN sudah ada
    $cek_nisn = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE NISN = '$nisn'");
    if (mysqli_num_rows($cek_nisn) > 0) {
        $_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon" id="alert">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                      <button class="close" data-dismiss="alert">
                                        <span>×</span>
                                      </button>
                                      <div class="alert-title">Gagal</div>
                                      NISN sudah terdaftar.
                                    </div>
                                  </div>';
        header('Location: ../../view/siswa/daftar.php');
        exit();
    }

    // Cek apakah NIK sudah ada
    $cek_nik = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE NIK = '$nik'");
    if (mysqli_num_rows($cek_nik) > 0) {
        $_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon" id="alert">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                      <button class="close" data-dismiss="alert">
                                        <span>×</span>
                                      </button>
                                      <div class="alert-title">Gagal</div>
                                      NIK sudah terdaftar.
                                    </div>
                                  </div>';
        header('Location: ../../view/siswa/daftar.php');
        exit();
    }

    $query = mysqli_query($conn, "INSERT INTO identitas_siswa SET 
                                      NISN = '$nisn',
                                      NIK = '$nik',
                                      Nama_Peserta_Didik = '$nama_lengkap',
                                      no_telepon = '$no_telepon',
                                      Tanggal_Lahir = '$tanggal_lahir',
                                      asal_sekolah = '$asal_sekolah',
                                      status_pendaftaran = 'Menunggu Verifikasi',
                                      status_ortu = 0,
                                      status_administrasi = 0,
                                      tgl_buat = '$tgl_buat' ");

    if ($query) {
        // session login untuk siswa
        $_SESSION['nisnPeserta'] = $nisn;       
        $_SESSION['namaPeserta'] = $nama_lengkap;
        $_SESSION['tlPeserta'] = $tanggal_lahir;
        $_SESSION['status_pembayaran'] = 'Belum Lunas';

        $_SESSION['alert'] = '<div class="alert alert-success alert-has-icon" id="alert">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                      <button class="close" data-dismiss="alert">
                                        <span>×</span>
                                      </button>
                                      <div class="alert-title">Berhasil</div>
                                      Pendaftaran berhasil! Silakan lanjutkan pembayaran formulir.
                                    </div>
                                  </div>';
        header('Location: ../../view/halaman/daftarSiswa.php');
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon" id="alert">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                      <button class="close" data-dismiss="alert">
                                        <span>×</span>
                                      </button>
                                      <div class="alert-title">Gagal</div>
                                      Pendaftaran gagal: ' . mysqli_error($conn) . '
                                    </div>
                                  </div>';
        header('Location: ../../view/siswa/daftar.php');
    }
}

// Login Siswa
if (isset($_POST['loginSiswa'])) {
  $no_telepon = mysqli_real_escape_string($conn, $_POST['no_telepon']);
  $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);

  $query = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE no_telepon = '$no_telepon' AND Tanggal_Lahir = '$tanggal_lahir'");

  if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    $_SESSION['noTelpPeserta'] = $no_telepon;
    $_SESSION['namaPeserta'] = $row['Nama_Peserta_Didik'];
    $_SESSION['tlPeserta'] = $tanggal_lahir;
    $_SESSION['idPeserta'] = $row['Id_Identitas_Siswa'];
    $_SESSION['status_administrasi'] = $row['status_administrasi'];

    header('Location: ../../view/halaman/daftarSiswa.php');
  } else {
    $_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
              <button class="close" data-dismiss="alert"><span>×</span></button>
              <div class="alert-title">Login Gagal</div>
              Nomor Telepon dan Tanggal Lahir tidak cocok.
            </div>
           </div>';
    header('Location: ../../view/siswa/login.php');
  }
}

// Logout Siswa
if (isset($_GET['logout'])) {
  unset($_SESSION['noTelpPeserta'], $_SESSION['namaPeserta'], $_SESSION['tlPeserta'], $_SESSION['status_pembayaran']);
}
?>