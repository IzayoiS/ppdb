<?php
session_start();
// Redirect jika belum login
if (!isset($_SESSION['nisnSiswa'])) {
    header('Location: login.php');
    exit();
}

$title = "Pembayaran Formulir";
include("../../config/connection.php");

// Ambil data siswa
$nisn = $_SESSION['nisnSiswa'];
$query = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE NISN = '$nisn'");
$siswa = mysqli_fetch_assoc($query);

// Ambil data administrasi
$query_admin = mysqli_query($conn, "SELECT * FROM administrasi WHERE id_identitas_siswa = '" . $siswa['Id_Identitas_Siswa'] . "'");
$administrasi = mysqli_fetch_assoc($query_admin);
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

    <!-- Template CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">

                        <div class="card card-primary">
                            <div class="card-header text-center">
                                <h4>Pembayaran Formulir PPDB</h4>
                                <p class="text-muted">SMK BINA RAHAYU</p>
                            </div>

                            <div class="card-body">
                                <?php
                                if (isset($_SESSION['alert'])) {
                                    echo $_SESSION['alert'];
                                    unset($_SESSION['alert']);
                                }
                                ?>

                                <!-- Info Siswa -->
                                <div class="alert alert-info">
                                    <h5>Data Pendaftaran:</h5>
                                    <p><strong>Nama:</strong> <?= $siswa['Nama_Peserta_Didik']; ?></p>
                                    <p><strong>NISN:</strong> <?= $siswa['NISN']; ?></p>
                                    <p><strong>Jurusan:</strong> <?= $siswa['jurusan_pilihan']; ?></p>
                                </div>

                                <!-- Informasi Pembayaran -->
                                <div class="alert alert-warning">
                                    <h5>Informasi Pembayaran:</h5>
                                    <p><strong>Biaya Formulir:</strong> Rp 100.000</p>
                                    <p><strong>Rekening Tujuan:</strong> BRI - 1234-5678-9012 (a.n. SMK Bina Rahayu)</p>
                                    <p><strong>Status:</strong>
                                        <?php if ($siswa['status_administrasi'] == 1): ?>
                                            <span class="badge badge-success">LUNAS</span>
                                            <?php if ($administrasi): ?>
                                                <small class="text-muted">(Tanggal:
                                                    <?= date('d/m/Y H:i', strtotime($administrasi['tgl_buat'])) ?>)</small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge badge-warning">BELUM LUNAS</span>
                                        <?php endif; ?>
                                    </p>
                                </div>

                                <?php if ($siswa['status_administrasi'] == 0): ?>
                                    <!-- Tombol WhatsApp untuk pembayaran -->
                                    <div class="text-center">
                                        <?php
                                        // Format pesan WhatsApp
                                        $nama_siswa = $siswa['Nama_Peserta_Didik'];
                                        $nisn = $siswa['NISN'];
                                        $jurusan = $siswa['jurusan_pilihan'];
                                        $pesan = "Halo Admin, saya $nama_siswa (NISN: $nisn) ingin melakukan pembayaran formulir PPDB untuk jurusan $jurusan.";
                                        $pesan_encoded = urlencode($pesan);
                                        $nomor_wa = "6281234567890"; // Ganti dengan nomor admin
                                        $url_wa = "https://wa.me/$nomor_wa?text=$pesan_encoded";
                                        ?>

                                        <a href="<?= $url_wa ?>" target="_blank" class="btn btn-success btn-lg mb-3">
                                            <i class="fab fa-whatsapp"></i> Lanjutkan Pembayaran via WhatsApp
                                        </a>

                                        <p class="text-muted">
                                            <small>Klik tombol di atas untuk konfirmasi pembayaran ke admin</small>
                                        </p>
                                    </div>

                                    <!-- Informasi Proses -->
                                    <div class="mt-4">
                                        <h6>Alur Pembayaran:</h6>
                                        <ol>
                                            <li>Transfer biaya formulir Rp 100.000 ke rekening yang tertera</li>
                                            <li>Klik tombol "Lanjutkan Pembayaran" di atas</li>
                                            <li>Anda akan diarahkan ke WhatsApp admin</li>
                                            <li>Kirim bukti transfer/screenshot ke admin</li>
                                            <li>Tunggu konfirmasi pembayaran (1x24 jam)</li>
                                            <li>Setelah dikonfirmasi, Anda dapat login kembali untuk melengkapi data</li>
                                        </ol>
                                    </div>
                                <?php else: ?>
                                    <!-- Sudah Bayar -->
                                    <div class="text-center">
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle fa-2x mb-3"></i>
                                            <h5>Pembayaran Anda Sudah Dikonfirmasi!</h5>
                                            <p>Silakan login kembali untuk melengkapi data diri dan data orang tua.</p>
                                            <a href="login.php" class="btn btn-primary btn-lg">
                                                <i class="fas fa-sign-in-alt"></i> Login Kembali
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="text-center mt-4">
                                    <a href="login.php" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left"></i> Kembali ke Login
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-white">
                                &copy; 2025 SMK BINA RAHAYU<br>
                                <small>Modified By : Mahasiswa Unpam</small>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="../../assets/bootstrap-4/js/jquery-3.3.1.min.js"></script>
    <script src="../../assets/bootstrap-4/js/popper.min.js"></script>
    <script src="../../assets/bootstrap-4/js/bootstrap.min.js"></script>
</body>

</html>