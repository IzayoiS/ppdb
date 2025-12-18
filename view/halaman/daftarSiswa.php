<!-- Header -->
<?php
session_start();
$title = "Pendaftaran Peserta Didik Baru"; // Judulnya
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

	<!-- CSS Libraries -->

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

	<!-- Template JS File -->
	<script src="../../assets/js/scripts.js"></script>
	<script src="../../assets/js/custom.js"></script>
</head>

<body>
	<div id="app">
		<div class="main-wrapper">
			<div class="navbar-bg"></div>

			<?php if (isset($_SESSION['noTelpPeserta'])) { ?>
				<nav class="navbar navbar-expand-lg main-navbar">
					<form class="form-inline mr-auto">
						<ul class="navbar-nav mr-3">
							<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
										class="fas fa-bars"></i></a></li>
						</ul>
					</form>
					<ul class="navbar-nav navbar-right">
						<li class="dropdown"><a href="#" data-toggle="dropdown"
								class="nav-link dropdown-toggle nav-link-lg nav-link-user">
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
			<?php } else {
				echo '<style>.main-content { padding-left: 30px; } .navbar { left: 30px; }</style>';
			} ?>

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
								<a href="index.php" type="button" class="btn btn-primary daterange-btn icon-left btn-icon">
									<i class="fas fa-arrow-left"></i> Halaman Utama
								</a>
							</div>
							<div class="card-body">
				
								<?php if (!isset($_SESSION['noTelpPeserta'])) { ?>
									<div class="section-title mt-0 ml-4">Data diri peserta</div>
				
									<!-- Form Tambah Data Siswa -->
									<form class="needs-validation" novalidate="" action="../../controller/admin/daftar.php" method="POST">
										<div class="modal-body">
											<div class="form-group">
												<label>Nama Lengkap Peserta Didik</label>
												<input type="text" class="form-control" name="nama_lengkap" required="">
												<div class="valid-feedback">Baguss!</div>
												<div class="invalid-feedback">Wajib Diisi!</div>
											</div>
				
											<div class="form-group">
												<label>Nomor Telepon (WhatsApp)</label>
												<input type="text" class="form-control" name="no_telp" required="">
												<div class="valid-feedback">Baguss!</div>
												<div class="invalid-feedback">Wajib Diisi!</div>
											</div>
				
											<div class="form-group">
												<label>Tanggal Lahir</label>
												<input type="date" class="form-control" name="tanggal_lahir" required="">
												<div class="valid-feedback">Baguss!</div>
												<div class="invalid-feedback">Wajib Diisi!</div>
											</div>
				
											<div class="form-group">
												<label>Asal Sekolah</label>
												<input type="text" class="form-control" name="asal_sekolah" required="">
												<div class="valid-feedback">Baguss!</div>
												<div class="invalid-feedback">Wajib Diisi!</div>
											</div>
				
											<br>
											<div class="modal-footer bg-whitesmoke br">
												<button class="btn btn-primary" name="tambahDataSiswa">Simpan</button>
											</div>
										</div>
									</form>
								<?php } else {
									include('../../config/connection.php');
									$id_peserta = isset($_SESSION['idPeserta']) ? $_SESSION['idPeserta'] : 0;
									$data = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE Id_Identitas_Siswa = '$id_peserta'");
									$row = mysqli_fetch_assoc($data);

									// Ambil data administrasi
									$query_administrasi = mysqli_query($conn, "SELECT a.* FROM administrasi a 
														WHERE a.id_identitas_siswa = '" . $row['Id_Identitas_Siswa'] . "'");
									$data_administrasi = mysqli_fetch_assoc($query_administrasi);

									$status_pembayaran = $row['status_administrasi'];
									?>

									<!-- Tampilkan Info Berdasarkan Status Pembayaran -->
									<div class="card shadow-sm border-0">
										<div class="card-body text-center">
											<?php if ($status_pembayaran == 0): ?>
												<h4 class="text-primary mb-2">
													<i class="fas fa-check-circle"></i> Pendaftaran Berhasil!
												</h4>
												<p class="text-muted mb-0">
													Selamat <strong><?= $_SESSION['noTelpPeserta']; ?></strong>, Anda telah terdaftar sebagai calon siswa.
												</p>
												<?php
												$nama_siswa = $row['Nama_Peserta_Didik'];
												$pesan = "Halo Admin, saya $nama_siswa ingin melakukan pembayaran formulir PPDB.";
												$pesan_encoded = urlencode($pesan);
												$nomor_wa = "6285121015646";
												$url_wa = "https://wa.me/$nomor_wa?text=$pesan_encoded";
												?>
												<a href="<?= $url_wa ?>" target="_blank" class="btn btn-primary btn-lg">
													<i class="fab fa-whatsapp"></i> Hubungi Admin untuk Pembayaran
												</a>
												<p class="text-muted mt-2"><small>Klik tombol di atas untuk menghubungi admin via WhatsApp.</small></p>
											<?php else: ?>
												<div class="text-center mt-3">
													<i class="fas fa-check-circle fa-2x text-success mb-2"></i>
													<h5 class="text-success">Pembayaran Telah Dikonfirmasi!</h5>
													<p class="text-muted">Anda dapat melanjutkan ke proses selanjutnya.</p>
													<a href="dashboard.php" class="btn btn-primary btn-lg">
														<i class="fas fa-user-edit"></i> Lengkapi Data Diri
													</a>
												</div>
											<?php endif; ?>
										</div>
									</div>

								<?php } ?>
							</div>
						</div>
					</div>
				</section>
				
				<!-- Fungsi untuk cetak -->
				<script type="text/javascript">
					function cetak(id) {
						window.open("../cetak/index.php?id=" + id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=100,width=900,height=460");
					}
				</script>

				<!-- Footer -->
</div>
<footer class="main-footer">
  <div class="footer-left">
    Copyright &copy; 2025 
    <div class="bullet"></div> 
    <a href="https://www.smkbinarahayu.sch.id/">SMK BINA RAHAYU</a>
  </div>
  <div class="footer-right">
    Modified By : <a>Mahasiswa Unpam</a>
  </div>
</footer>
</div>
</div>

</body>
</html>
