<?php

session_start();
include("../../config/connection.php");

// Tambah Data
if (isset($_POST['tambahData'])) {
	$nisn = mysqli_real_escape_string($conn, $_POST['nisn']);
	$no_kk = mysqli_real_escape_string($conn, $_POST['no_kk']);
	$nik = mysqli_real_escape_string($conn, $_POST['nik']);
	$nama_panggilan = mysqli_real_escape_string($conn, $_POST['nama_panggilan']);
	$nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
	$tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
	$tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
	$jurusan_pilihan = mysqli_real_escape_string($conn, $_POST['jurusan_pilihan']);
	$jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
	$agama = mysqli_real_escape_string($conn, $_POST['agama']);
	$kelainan_jasmani = mysqli_real_escape_string($conn, $_POST['kelainan_jasmani']);
	$kebutuhan_khusus = mysqli_real_escape_string($conn, $_POST['kebutuhan_khusus']);
	$hobi = mysqli_real_escape_string($conn, $_POST['hobi']);
	$nama_ayah = mysqli_real_escape_string($conn, $_POST['nama_ayah']);
	$nama_ibu = mysqli_real_escape_string($conn, $_POST['nama_ibu']);
	$alamat_ortu = mysqli_real_escape_string($conn, $_POST['alamat_ortu']);
	$no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$asal_sekolah = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
	$alamat_sekolah = mysqli_real_escape_string($conn, $_POST['alamat_sekolah']);
	$tinggal_bersama = mysqli_real_escape_string($conn, $_POST['tinggal_bersama']);
	$transport = mysqli_real_escape_string($conn, $_POST['transport']);
	$gol_darah = mysqli_real_escape_string($conn, $_POST['gol_darah']);
	$tinggi_badan = mysqli_real_escape_string($conn, $_POST['tinggi_badan']);
	$berat_badan = mysqli_real_escape_string($conn, $_POST['berat_badan']);
	$suku = mysqli_real_escape_string($conn, $_POST['suku']);
	$bahasa = mysqli_real_escape_string($conn, $_POST['bahasa']);
	$kewarganegaraan = mysqli_real_escape_string($conn, $_POST['kewarganegaraan']);
	$status_anak = mysqli_real_escape_string($conn, $_POST['status_anak']);
	$anak_ke = mysqli_real_escape_string($conn, $_POST['anak_ke']);
	$jumlah_saudara = mysqli_real_escape_string($conn, $_POST['jumlah_saudara']);
	$jenis_tinggal = mysqli_real_escape_string($conn, $_POST['jenis_tinggal']);
	$alamat_tinggal = mysqli_real_escape_string($conn, $_POST['alamat_tinggal']);
	$provinsi_tinggal = mysqli_real_escape_string($conn, $_POST['provinsi_tinggal']);
	$kab_kota_tinggal = mysqli_real_escape_string($conn, $_POST['kab_kota_tinggal']);
	$kecamatan_tinggal = mysqli_real_escape_string($conn, $_POST['kecamatan_tinggal']);
	$kelurahan_tinggal = mysqli_real_escape_string($conn, $_POST['kelurahan_tinggal']);
	$kode_pos = mysqli_real_escape_string($conn, $_POST['kode_pos']);
	$jarak_ke_sekolah = mysqli_real_escape_string($conn, $_POST['jarak_ke_sekolah']);
	$riwayat_penyakit = mysqli_real_escape_string($conn, $_POST['riwayat_penyakit']);
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
		header('Location: ../../view/siswa/tambahData.php');
		exit();
	}

	$query = mysqli_query($conn, "INSERT INTO identitas_siswa SET 
			NISN = '$nisn',
			No_KK = '$no_kk',
			NIK = '$nik',
			Nama_Panggilan = '$nama_panggilan',
			Nama_Peserta_Didik = '$nama_lengkap',
			Tempat_Lahir = '$tempat_lahir',
			Tanggal_Lahir = '$tanggal_lahir',
			jurusan_pilihan = '$jurusan_pilihan',
			Jenis_Kelamin = '$jenis_kelamin',
			Agama = '$agama',
			Kelainan_Jasmani = '$kelainan_jasmani',
			Kebutuhan_Khusus = '$kebutuhan_khusus',
			Hobi = '$hobi',
			Nama_Ayah = '$nama_ayah',
			Nama_Ibu = '$nama_ibu',
			Alamat_Ortu = '$alamat_ortu',
			No_Telp = '$no_telp',
			Email = '$email',
			asal_sekolah = '$asal_sekolah',
			Alamat_Sekolah = '$alamat_sekolah',
			Tinggal_Bersama = '$tinggal_bersama',
			Transport = '$transport',
			Gol_Darah = '$gol_darah',
			Tinggi_Badan = '$tinggi_badan',
			Berat_Badan = '$berat_badan',
			Suku = '$suku',
			Bahasa = '$bahasa',
			Kewarganegaraan = '$kewarganegaraan',
			Status_Anak = '$status_anak',
			Anak_Ke = '$anak_ke',
			Jml_Saudara = '$jumlah_saudara',
			Jenis_Tinggal = '$jenis_tinggal',
			Alamat_Tinggal = '$alamat_tinggal',
			Provinsi_Tinggal = '$provinsi_tinggal',
			Kab_Kota_Tinggal = '$kab_kota_tinggal',
			Kec_Tinggal = '$kecamatan_tinggal',
			Kelurahan_Tinggal = '$kelurahan_tinggal',
			Kode_POS = '$kode_pos',
			Jarak_ke_Sekolah = '$jarak_ke_sekolah',
			Riwayat_Penyakit = '$riwayat_penyakit',
			tgl_buat = '$tgl_buat' ");

	if ($query) {
		// Update kuota terisi untuk jurusan yang dipilih
		$update_kuota = mysqli_query($conn, "UPDATE setting_kuota SET kuota_terisi = kuota_terisi + 1 WHERE jurusan = '$jurusan_pilihan'");

		$_SESSION['alert'] = '<div class="alert alert-success alert-has-icon" id="alert">
			                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                        <div class="alert-body">
			                          <button class="close" data-dismiss="alert">
			                            <span>×</span>
			                          </button>
			                          <div class="alert-title">Berhasil</div>
			                          Data berhasil ditambahkan.
			                        </div>
			                      </div>';
		header('Location: ../../view/siswa/tampilData.php');
	} else {
		$_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon" id="alert">
			                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                        <div class="alert-body">
			                          <button class="close" data-dismiss="alert">
			                            <span>×</span>
			                          </button>
			                          <div class="alert-title">Gagal</div>
			                          Data gagal ditambahkan. Error: ' . mysqli_error($conn) . '
			                        </div>
			                      </div>';
		header('Location: ../../view/siswa/tambahData.php');
	}
}

// Ubah Data
if (isset($_POST['ubahData'])) {
	$id = $_POST['id'];
	$nisn = mysqli_real_escape_string($conn, $_POST['nisn']);
	$no_kk = mysqli_real_escape_string($conn, $_POST['no_kk']);
	$nik = mysqli_real_escape_string($conn, $_POST['nik']);
	$nama_panggilan = mysqli_real_escape_string($conn, $_POST['nama_panggilan']);
	$nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
	$tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
	$tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
	$jurusan_pilihan = mysqli_real_escape_string($conn, $_POST['jurusan_pilihan']);
	$jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
	$agama = mysqli_real_escape_string($conn, $_POST['agama']);
	$kelainan_jasmani = mysqli_real_escape_string($conn, $_POST['kelainan_jasmani']);
	$kebutuhan_khusus = mysqli_real_escape_string($conn, $_POST['kebutuhan_khusus']);
	$hobi = mysqli_real_escape_string($conn, $_POST['hobi']);
	$nama_ayah = mysqli_real_escape_string($conn, $_POST['nama_ayah']);
	$nama_ibu = mysqli_real_escape_string($conn, $_POST['nama_ibu']);
	$alamat_ortu = mysqli_real_escape_string($conn, $_POST['alamat_ortu']);
	$no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$asal_sekolah = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
	$alamat_sekolah = mysqli_real_escape_string($conn, $_POST['alamat_sekolah']);
	$tinggal_bersama = mysqli_real_escape_string($conn, $_POST['tinggal_bersama']);
	$transport = mysqli_real_escape_string($conn, $_POST['transport']);
	$gol_darah = mysqli_real_escape_string($conn, $_POST['gol_darah']);
	$tinggi_badan = mysqli_real_escape_string($conn, $_POST['tinggi_badan']);
	$berat_badan = mysqli_real_escape_string($conn, $_POST['berat_badan']);
	$suku = mysqli_real_escape_string($conn, $_POST['suku']);
	$bahasa = mysqli_real_escape_string($conn, $_POST['bahasa']);
	$kewarganegaraan = mysqli_real_escape_string($conn, $_POST['kewarganegaraan']);
	$status_anak = mysqli_real_escape_string($conn, $_POST['status_anak']);
	$anak_ke = mysqli_real_escape_string($conn, $_POST['anak_ke']);
	$jumlah_saudara = mysqli_real_escape_string($conn, $_POST['jumlah_saudara']);
	$jenis_tinggal = mysqli_real_escape_string($conn, $_POST['jenis_tinggal']);
	$alamat_tinggal = mysqli_real_escape_string($conn, $_POST['alamat_tinggal']);
	$provinsi_tinggal = mysqli_real_escape_string($conn, $_POST['provinsi_tinggal']);
	$kab_kota_tinggal = mysqli_real_escape_string($conn, $_POST['kab_kota_tinggal']);
	$kecamatan_tinggal = mysqli_real_escape_string($conn, $_POST['kecamatan_tinggal']);
	$kelurahan_tinggal = mysqli_real_escape_string($conn, $_POST['kelurahan_tinggal']);
	$kode_pos = mysqli_real_escape_string($conn, $_POST['kode_pos']);
	$jarak_ke_sekolah = mysqli_real_escape_string($conn, $_POST['jarak_ke_sekolah']);
	$riwayat_penyakit = mysqli_real_escape_string($conn, $_POST['riwayat_penyakit']);

	// Ambil jurusan lama untuk update kuota
	$query_old = mysqli_query($conn, "SELECT jurusan_pilihan FROM identitas_siswa WHERE Id_Identitas_Siswa = '$id'");
	$old_data = mysqli_fetch_assoc($query_old);
	$old_jurusan = $old_data['jurusan_pilihan'];

	$query = mysqli_query($conn, "UPDATE identitas_siswa SET 
			NISN = '$nisn',
			No_KK = '$no_kk',
			NIK = '$nik',
			Nama_Panggilan = '$nama_panggilan',
			Nama_Peserta_Didik = '$nama_lengkap',
			Tempat_Lahir = '$tempat_lahir',
			Tanggal_Lahir = '$tanggal_lahir',
			jurusan_pilihan = '$jurusan_pilihan',
			Jenis_Kelamin = '$jenis_kelamin',
			Agama = '$agama',
			Kelainan_Jasmani = '$kelainan_jasmani',
			Kebutuhan_Khusus = '$kebutuhan_khusus',
			Hobi = '$hobi',
			Nama_Ayah = '$nama_ayah',
			Nama_Ibu = '$nama_ibu',
			Alamat_Ortu = '$alamat_ortu',
			No_Telp = '$no_telp',
			Email = '$email',
			asal_sekolah = '$asal_sekolah',
			Alamat_Sekolah = '$alamat_sekolah',
			Tinggal_Bersama = '$tinggal_bersama',
			Transport = '$transport',
			Gol_Darah = '$gol_darah',
			Tinggi_Badan = '$tinggi_badan',
			Berat_Badan = '$berat_badan',
			Suku = '$suku',
			Bahasa = '$bahasa',
			Kewarganegaraan = '$kewarganegaraan',
			Status_Anak = '$status_anak',
			Anak_Ke = '$anak_ke',
			Jml_Saudara = '$jumlah_saudara',
			Jenis_Tinggal = '$jenis_tinggal',
			Alamat_Tinggal = '$alamat_tinggal',
			Provinsi_Tinggal = '$provinsi_tinggal',
			Kab_Kota_Tinggal = '$kab_kota_tinggal',
			Kec_Tinggal = '$kecamatan_tinggal',
			Kelurahan_Tinggal = '$kelurahan_tinggal',
			Kode_POS = '$kode_pos',
			Jarak_ke_Sekolah = '$jarak_ke_sekolah',
			Riwayat_Penyakit = '$riwayat_penyakit'
			WHERE Id_Identitas_Siswa = '$id' ") or die(mysqli_error($conn));

	if ($query) {
		// Update kuota jika jurusan berubah
		if ($old_jurusan != $jurusan_pilihan) {
			// Kurangi kuota jurusan lama
			mysqli_query($conn, "UPDATE setting_kuota SET kuota_terisi = kuota_terisi - 1 WHERE jurusan = '$old_jurusan'");
			// Tambah kuota jurusan baru
			mysqli_query($conn, "UPDATE setting_kuota SET kuota_terisi = kuota_terisi + 1 WHERE jurusan = '$jurusan_pilihan'");
		}

		$_SESSION['alert'] = '<div class="alert alert-success alert-has-icon" id="alert">
			                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                        <div class="alert-body">
			                          <button class="close" data-dismiss="alert">
			                            <span>×</span>
			                          </button>
			                          <div class="alert-title">Berhasil</div>
			                          Data berhasil diubah.
			                        </div>
			                      </div>';
		header('Location: ../../view/siswa/tampilData.php');
	} else {
		$_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon" id="alert">
			                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                        <div class="alert-body">
			                          <button class="close" data-dismiss="alert">
			                            <span>×</span>
			                          </button>
			                          <div class="alert-title">Gagal</div>
			                          Data gagal diubah.
			                        </div>
			                      </div>';
		header('Location: ../../view/siswa/tampilData.php');
	}
}

// Hapus Data
if (isset($_GET['hapusData'])) {
	$id = $_GET['hapusData'];

	// Ambil jurusan untuk update kuota
	$query_jurusan = mysqli_query($conn, "SELECT jurusan_pilihan FROM identitas_siswa WHERE Id_Identitas_Siswa = $id");
	$data_jurusan = mysqli_fetch_assoc($query_jurusan);
	$jurusan = $data_jurusan['jurusan_pilihan'];

	// Hapus data terkait dulu
	mysqli_query($conn, "DELETE FROM administrasi WHERE id_identitas_siswa = $id");
	mysqli_query($conn, "DELETE FROM orang_tua_wali WHERE Id_Identitas_Siswa = $id");

	// Baru hapus data siswa
	$query = mysqli_query($conn, "DELETE FROM identitas_siswa WHERE Id_Identitas_Siswa = $id");

	if ($query) {
		// Kurangi kuota terisi
		mysqli_query($conn, "UPDATE setting_kuota SET kuota_terisi = kuota_terisi - 1 WHERE jurusan = '$jurusan'");

		$_SESSION['alert'] = '<div class="alert alert-success alert-has-icon" id="alert">
				<div class="alert-icon"><i class="far fa-lightbulb"></i></div>
				<div class="alert-body">
					<button class="close" data-dismiss="alert"><span>×</span></button>
					<div class="alert-title">Berhasil</div>
					Data berhasil dihapus.
				</div>
			</div>';
	} else {
		$_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon" id="alert">
				<div class="alert-icon"><i class="far fa-lightbulb"></i></div>
				<div class="alert-body">
					<button class="close" data-dismiss="alert"><span>×</span></button>
					<div class="alert-title">Gagal</div>
					Data gagal dihapus.
				</div>
			</div>';
	}

	header('Location: ../../view/siswa/tampilData.php');
}

?>