<?php 
	
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	include("../../config/connection.php");

	function uploadFile($file, $id_siswa, $jenis_dokumen, $conn)
	{
		$upload_dir = "../../uploads/dokumen_siswa/";

		// Buat folder jika belum ada
		if (!is_dir($upload_dir)) {
			mkdir($upload_dir, 0755, true);
		}

		// Validasi file
		if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
			return ['status' => false, 'message' => 'Error upload: ' . $_FILES[$file]['error']];
		}

		// Validasi ukuran file (max 5MB)
		if ($_FILES[$file]['size'] > 5242880) {
			return ['status' => false, 'message' => 'Ukuran file terlalu besar (max 5MB)'];
		}

		// Validasi tipe file
		$allowed_types = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime_type = finfo_file($finfo, $_FILES[$file]['tmp_name']);
		finfo_close($finfo);

		if (!in_array($mime_type, $allowed_types)) {
			return ['status' => false, 'message' => 'Tipe file tidak diizinkan'];
		}

		// Generate nama file unik
		$ext = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);
		$filename = $id_siswa . '_' . $jenis_dokumen . '_' . time() . '.' . $ext;
		$filepath = $upload_dir . $filename;

		// Move file
		if (move_uploaded_file($_FILES[$file]['tmp_name'], $filepath)) {
			// Simpan ke database
			$query = mysqli_query($conn, "INSERT INTO dokumen_siswa 
				(id_siswa, jenis_dokumen, nama_file, path_file, tgl_upload) 
				VALUES ('$id_siswa', '$jenis_dokumen', '$filename', '$filepath', NOW())");

			if ($query) {
				return ['status' => true, 'message' => 'File berhasil diupload'];
			} else {
				unlink($filepath); // Hapus file jika gagal simpan ke DB
				return ['status' => false, 'message' => 'Gagal menyimpan data ke database'];
			}
		} else {
			return ['status' => false, 'message' => 'Gagal memindahkan file'];
		}
	}


// Tambah Data
	if (isset($_POST['tambahDataSiswa'])) {
		$nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
		$no_telepon = mysqli_real_escape_string($conn, $_POST['no_telp']);
		$tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
		$asal_sekolah = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
		$tgl_buat = date('Y-m-d H:i:s');

		$tahun = date('Y');
		$query_last = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(Id_Identitas_Siswa, 5) AS UNSIGNED)) as max_id FROM identitas_siswa WHERE SUBSTRING(Id_Identitas_Siswa, 1, 4) = '$tahun'");
		$row_last = mysqli_fetch_assoc($query_last);
		$next_id = ($row_last['max_id'] ?? 0) + 1;
		$id_siswa = $tahun . str_pad($next_id, 4, '0', STR_PAD_LEFT);

		$query = mysqli_query($conn, "INSERT INTO identitas_siswa SET 
										Id_Identitas_Siswa = '$id_siswa',
										Nama_Peserta_Didik = '$nama_lengkap',
										no_telepon = '$no_telepon',
										Tanggal_Lahir = '$tanggal_lahir',
										asal_sekolah = '$asal_sekolah',
										status_pendaftaran = 'Menunggu Verifikasi',
										status_ortu = 0,
										status_administrasi = 0,
										tgl_buat = '$tgl_buat'");
		if ($query) {
			$_SESSION['noTelpPeserta'] = $no_telepon;
			$_SESSION['namaPeserta'] = $nama_lengkap;
			$_SESSION['tlPeserta'] = $tanggal_lahir;
			$_SESSION['status_pembayaran'] = 'Belum Lunas';

			$_SESSION['alert'] = '<div class="alert alert-success alert-has-icon">
				<div class="alert-icon"><i class="far fa-lightbulb"></i></div>
				<div class="alert-body">
				<button class="close" data-dismiss="alert"><span>×</span></button>
				<div class="alert-title">Berhasil</div>
				Pendaftaran berhasil! ID Anda: ' . $id_siswa . '. Silakan lanjutkan ke pembayaran.
				</div>
			</div>';
			header('Location: ../../view/halaman/daftarSiswa.php');
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon">
				<div class="alert-icon"><i class="far fa-lightbulb"></i></div>
				<div class="alert-body">
				<button class="close" data-dismiss="alert"><span>×</span></button>
				<div class="alert-title">Gagal</div>
				Pendaftaran gagal: ' . mysqli_error($conn) . '
				</div>
			</div>';
			header('Location: ../../view/siswa/daftar.php');
		}
	}

	// Batalkan Pendaftaran / Hapus Data
	if (isset($_POST['hapusDataSiswa'])) {
		$id = $_POST['id'];
		
		// Ambil jurusan sebelum hapus
		$query_jurusan = mysqli_query($conn, "SELECT jurusan_pilihan FROM identitas_siswa WHERE Id_Identitas_Siswa = '$id'");
		$data = mysqli_fetch_assoc($query_jurusan);
		$jurusan = $data['jurusan_pilihan'];
		
		// Hapus data
		$query_hapus = mysqli_query($conn, "DELETE FROM identitas_siswa WHERE Id_Identitas_Siswa = '$id'");
		
		if($query_hapus) {
			// KURANGI KUOTA TERISI
			mysqli_query($conn, "UPDATE setting_kuota SET kuota_terisi = kuota_terisi - 1 WHERE jurusan = '$jurusan'");
			
			$_SESSION['alert'] = '<div class="alert alert-success">Data berhasil dihapus.</div>';
		}
	}

	// Ubah Data
	if (isset($_POST['ubahDataSiswa'])) {
		$id 				= $_POST['id'];
		$nisn 				= mysqli_real_escape_string($conn, $_POST['nisn'] ?? ''); 
		$no_kk 				= mysqli_real_escape_string($conn, $_POST['no_kk'] ?? ''); 
		$nik 				= mysqli_real_escape_string($conn, $_POST['nik'] ?? ''); 
		$nama_panggilan		= mysqli_real_escape_string($conn, $_POST['nama_panggilan'] ?? ''); 
		$nama_lengkap		= mysqli_real_escape_string($conn, $_POST['nama_lengkap'] ?? ''); 
		$tempat_lahir		= mysqli_real_escape_string($conn, $_POST['tempat_lahir'] ?? ''); 
		$tanggal_lahir		= mysqli_real_escape_string($conn, $_POST['tanggal_lahir'] ?? ''); 
		$jenis_kelamin		= mysqli_real_escape_string($conn, $_POST['jenis_kelamin'] ?? ''); 
		$agama				= mysqli_real_escape_string($conn, $_POST['agama'] ?? ''); 
		$gol_darah			= mysqli_real_escape_string($conn, $_POST['gol_darah'] ?? ''); 
		$tinggi_badan		= mysqli_real_escape_string($conn, $_POST['tinggi_badan' ?? '']);
		$berat_badan		= mysqli_real_escape_string($conn, $_POST['berat_badan'] ?? ''); 
		$suku				= mysqli_real_escape_string($conn, $_POST['suku' ?? '']);
		$bahasa				= mysqli_real_escape_string($conn, $_POST['bahasa' ?? '']);
		$kewarganegaraan	= mysqli_real_escape_string($conn, $_POST['kewarganegaraan' ?? '']);
		$status_anak		= mysqli_real_escape_string($conn, $_POST['suku' ?? '']);
		$anak_ke			= mysqli_real_escape_string($conn, $_POST['anak_ke' ?? '']);
		$jumlah_saudara		= mysqli_real_escape_string($conn, $_POST['jumlah_saudara' ?? '']);
		$jenis_tinggal		= mysqli_real_escape_string($conn, $_POST['jenis_tinggal' ?? '']);
		$alamat_tinggal		= mysqli_real_escape_string($conn, $_POST['alamat_tinggal' ?? '']);
		$provinsi_tinggal	= mysqli_real_escape_string($conn, $_POST['provinsi_tinggal' ?? '']);
		$kab_kota_tinggal	= mysqli_real_escape_string($conn, $_POST['kab_kota_tinggal' ?? '']);
		$kecamatan_tinggal	= mysqli_real_escape_string($conn, $_POST['kecamatan_tinggal' ?? '']);
		$kelurahan_tinggal	= mysqli_real_escape_string($conn, $_POST['kelurahan_tinggal' ?? '']);
		$kode_pos			= mysqli_real_escape_string($conn, $_POST['kode_pos' ?? '']);
		$jarak_ke_sekolah	= mysqli_real_escape_string($conn, $_POST['jarak_ke_sekolah' ?? '']);
		$riwayat_penyakit	= mysqli_real_escape_string($conn, $_POST['riwayat_penyakit' ?? '']);
		$jurusan_pilihan = mysqli_real_escape_string($conn, $_POST['jurusan_pilihan'] ?? '');
		$kelainan_jasmani = mysqli_real_escape_string($conn, $_POST['kelainan_jasmani'] ?? '');
		$kebutuhan_khusus = mysqli_real_escape_string($conn, $_POST['kebutuhan_khusus'] ?? '');
		$hobi = mysqli_real_escape_string($conn, $_POST['hobi'] ?? '');
		$nama_ayah = mysqli_real_escape_string($conn, $_POST['nama_ayah'] ?? '');
		$nama_ibu = mysqli_real_escape_string($conn, $_POST['nama_ibu'] ?? '');
		$alamat_ortu = mysqli_real_escape_string($conn, $_POST['alamat_ortu'] ?? '');
		$no_telp = mysqli_real_escape_string($conn, $_POST['no_telp'] ?? '');
		$email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
		$asal_sekolah = mysqli_real_escape_string($conn, $_POST['asal_sekolah'] ?? '');
		$alamat_sekolah = mysqli_real_escape_string($conn, $_POST['alamat_sekolah'] ?? '');
		$tinggal_bersama = mysqli_real_escape_string($conn, $_POST['tinggal_bersama'] ?? '');
		$transport = mysqli_real_escape_string($conn, $_POST['transport'] ?? '');
		$tgl_ubah = date('Y-m-d H:i:s');

		$dokumen_list = [
			'kk' => 'KK',
			'akte_kelahiran' => 'Akte Kelahiran',
			'kartu_nisn' => 'Kartu NISN',
			'ijazah' => 'Ijazah',
			'ktp_orang_tua' => 'KTP Orang Tua',
			'pas_foto' => 'Pas Foto'
		];

		$upload_errors = [];
		foreach ($dokumen_list as $field => $nama_dokumen) {
			if (isset($_FILES[$field]) && $_FILES[$field]['size'] > 0) {
				$result = uploadFile($field, $id, $nama_dokumen, $conn);
				if (!$result['status']) {
					$upload_errors[] = "$nama_dokumen: " . $result['message'];
				}
			}
		}

		$jurusan_pilihan_baru = mysqli_real_escape_string($conn, $_POST['jurusan_pilihan'] ?? '');
		
		// Ambil jurusan lama
		$query_jurusan_lama = mysqli_query($conn, "SELECT jurusan_pilihan FROM identitas_siswa WHERE Id_Identitas_Siswa = '$id'");
		$data_jurusan = mysqli_fetch_assoc($query_jurusan_lama);
		$jurusan_pilihan_lama = $data_jurusan['jurusan_pilihan'];

		// Jika jurusan berubah
		if ($jurusan_pilihan_lama != $jurusan_pilihan_baru) {

			// Cek kuota baru
			$query_kuota_baru = mysqli_query($conn, "SELECT kuota_total, kuota_terisi FROM setting_kuota WHERE jurusan = '$jurusan_pilihan_baru'");
			$kuota_baru = mysqli_fetch_assoc($query_kuota_baru);

			if (!$kuota_baru) {
				throw new Exception("Jurusan $jurusan_pilihan_baru tidak ditemukan");
			}

			if ($kuota_baru['kuota_terisi'] >= $kuota_baru['kuota_total']) {
				throw new Exception("Kuota jurusan $jurusan_pilihan_baru sudah penuh");
			}

			// Kurangi kuota lama hanya jika masih lebih dari 0
			mysqli_query($conn, "UPDATE setting_kuota 
				SET kuota_terisi = GREATEST(kuota_terisi - 1, 0)
				WHERE jurusan = '$jurusan_pilihan_lama'");

			// Tambah kuota baru (tapi pastikan belum penuh)
			mysqli_query($conn, "UPDATE setting_kuota 
				SET kuota_terisi = kuota_terisi + 1
				WHERE TRIM(jurusan) = TRIM('$jurusan_pilihan_baru')
				AND kuota_terisi < kuota_total");


			if (mysqli_affected_rows($conn) == 0) {
				throw new Exception("Gagal menambah kuota pada jurusan baru (mungkin sudah penuh)");
			}
		}


		
		$query = mysqli_query($conn, "UPDATE identitas_siswa SET NISN = '$nisn',
																 No_KK = '$no_kk',
																 NIK = '$nik',
																 Nama_Panggilan = '$nama_panggilan',
																 Nama_Peserta_Didik = '$nama_lengkap',
																 Tempat_Lahir = '$tempat_lahir',
																 Tanggal_Lahir = '$tanggal_lahir',
																 Jenis_Kelamin = '$jenis_kelamin',
																 Agama = '$agama',
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
																 Jurusan_Pilihan = '$jurusan_pilihan',
																 Kebutuhan_Khusus = '$kebutuhan_khusus',
																 Hobi = '$hobi',
																 Nama_Ayah = '$nama_ayah',
																 Nama_Ibu = '$nama_ibu',
																 Alamat_Ortu = '$alamat_ortu',
																 No_Telp = '$no_telp',
																 Email = '$email',
																 Asal_Sekolah = '$asal_sekolah',
																 Alamat_Sekolah = '$alamat_sekolah',
																 Tinggal_Bersama = '$tinggal_bersama',
																 Transport = '$transport',
																 tgl_ubah = '$tgl_ubah'
									  					WHERE Id_Identitas_Siswa = '$id' ") or die(mysqli_error($conn));

		if (isset($_POST['semester']) && is_array($_POST['semester'])) {
			$id_siswa = $_POST['id'];
			$semesters = $_POST['semester'];
			$mata_pelajarans = $_POST['mata_pelajaran'];
			$nilais = $_POST['nilai'];

			for ($i = 0; $i < count($semesters); $i++) {
				if (!empty($semesters[$i]) && !empty($mata_pelajarans[$i]) && !empty($nilais[$i])) {
					$semester = mysqli_real_escape_string($conn, $semesters[$i]);
					$mata_pelajaran = mysqli_real_escape_string($conn, $mata_pelajarans[$i]);
					$nilai = (int)$nilais[$i];

					// Cek apakah sudah ada data dengan semester dan mata pelajaran yang sama
					$cek_query = mysqli_query($conn, "SELECT id_nilai FROM nilai_rapor 
													WHERE id_siswa = '$id_siswa' 
													AND semester = '$semester' 
													AND mata_pelajaran = '$mata_pelajaran'");

					if (mysqli_num_rows($cek_query) > 0) {
						// Update jika sudah ada
						$result = mysqli_query($conn, "UPDATE nilai_rapor 
													SET nilai = '$nilai', 
														tgl_input = NOW()
													WHERE id_siswa = '$id_siswa' 
													AND semester = '$semester' 
													AND mata_pelajaran = '$mata_pelajaran'");
					} else {
						// Insert jika belum ada
						$result = mysqli_query($conn, "INSERT INTO nilai_rapor 
													(id_siswa, mata_pelajaran, semester, nilai, tgl_input)
													VALUES ('$id_siswa', '$mata_pelajaran', '$semester', '$nilai', NOW())");
					}

					if (!$result) {
						error_log("Error saving nilai_rapor: " . mysqli_error($conn));
					}
				}
			}
		}

		if($query) {
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
			header('Location: ../../view/halaman/dashboard.php');
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
			header('Location: ../../view/halaman/dashboard.php');
		}
	}

	// Update Status Pembayaran
	if (isset($_POST['updateStatusPembayaran'])) {
		$id_siswa = $_POST['id_siswa'];
		$status = $_POST['status'];

		if ($status == 'Lunas') {
			// Update di tabel identitas_siswa
			$query1 = mysqli_query($conn, "UPDATE identitas_siswa SET status_administrasi = 1 WHERE Id_Identitas_Siswa = '$id_siswa'");

			// Update atau insert di tabel administrasi
			$cek_administrasi = mysqli_query($conn, "SELECT * FROM administrasi WHERE id_identitas_siswa = '$id_siswa'");

			if (mysqli_num_rows($cek_administrasi) > 0) {
				// Update jika sudah ada
				$query2 = mysqli_query($conn, "UPDATE administrasi SET status = 'Lunas', tgl_ubah = NOW() WHERE id_identitas_siswa = '$id_siswa'");
			} else {
				// Insert baru jika belum ada
				$query2 = mysqli_query($conn, "INSERT INTO administrasi (id_identitas_siswa, harga, status, tgl_buat) 
											VALUES ('$id_siswa', 100000, 'Lunas', NOW())");
			}

			if ($query1 && $query2) {
				$_SESSION['alert'] = '<div class="alert alert-success">Status pembayaran berhasil diupdate menjadi LUNAS.</div>';
			} else {
				$_SESSION['alert'] = '<div class="alert alert-danger">Gagal update status pembayaran.</div>';
			}
		}

		header('Location: ../../view/admin/daftarSiswa.php');
		exit();
	}

	// Tambah Data Ortu
	if (isset($_POST['tambahDataOrtu'])) {
		//Peserta
		$peserta 					= mysqli_real_escape_string($conn, $_POST['peserta']); 
		// Data Ayah
		$nama_ayah 					= mysqli_real_escape_string($conn, $_POST['nama_ayah']); 
		$status_ayah 				= mysqli_real_escape_string($conn, $_POST['status_ayah']); 
		$tanggal_lahir_ayah 		= mysqli_real_escape_string($conn, $_POST['tanggal_lahir_ayah']); 
		$telepon_ayah				= mysqli_real_escape_string($conn, $_POST['telepon_ayah']); 
		$pendidikan_terakhir_ayah	= mysqli_real_escape_string($conn, $_POST['pendidikan_terakhir_ayah']); 
		$pekerjaan_ayah				= mysqli_real_escape_string($conn, $_POST['pekerjaan_ayah']); 
		$penghasilan_ayah			= mysqli_real_escape_string($conn, $_POST['penghasilan_ayah']); 
		$alamat_ayah				= mysqli_real_escape_string($conn, $_POST['alamat_ayah']); 
		// Data Ibu
		$nama_ibu 					= mysqli_real_escape_string($conn, $_POST['nama_ibu']); 
		$status_ibu 				= mysqli_real_escape_string($conn, $_POST['status_ibu']); 
		$tanggal_lahir_ibu 			= mysqli_real_escape_string($conn, $_POST['tanggal_lahir_ibu']); 
		$telepon_ibu				= mysqli_real_escape_string($conn, $_POST['telepon_ibu']); 
		$pendidikan_terakhir_ibu	= mysqli_real_escape_string($conn, $_POST['pendidikan_terakhir_ibu']); 
		$pekerjaan_ibu				= mysqli_real_escape_string($conn, $_POST['pekerjaan_ibu']); 
		$penghasilan_ibu			= mysqli_real_escape_string($conn, $_POST['penghasilan_ibu']); 
		$alamat_ibu					= mysqli_real_escape_string($conn, $_POST['alamat_ibu']); 
		// Data Wali
		$tanggal_lahir_wali_sql = !empty($_POST['tanggal_lahir_wali']) ? "'" . $_POST['tanggal_lahir_wali'] . "'" : "NULL";
		// $nama_wali = !empty($_POST['nama_wali']) ? $_POST['nama_wali'] : NULL;
		// $status_wali = !empty($_POST['status_wali']) ? $_POST['status_wali'] : NULL;
		// $telepon_wali = !empty($_POST['telepon_wali']) ? $_POST['telepon_wali'] : NULL;
		// $pendidikan_terakhir_wali = !empty($_POST['pendidikan_terakhir_wali']) ? $_POST['pendidikan_terakhir_wali'] : NULL;
		// $pekerjaan_wali = !empty($_POST['pekerjaan_wali']) ? $_POST['pekerjaan_wali'] : NULL;
		// $penghasilan_wali = !empty($_POST['penghasilan_wali']) ? $_POST['penghasilan_wali'] : NULL;
		// $alamat_wali = !empty($_POST['alamat_wali']) ? $_POST['alamat_wali'] : NULL;
		
		$tgl_buat 					= date('Y-m-d H:i:s');

	$query = mysqli_query($conn, "INSERT INTO orang_tua_wali SET Id_Identitas_Siswa = '$peserta',
																	  Nama_Ayah = '$nama_ayah',
																	  Status_Ayah = '$status_ayah',
																	  Tgl_Lahir_Ayah = '$tanggal_lahir_ayah',
																	  Telepon_Ayah = '$telepon_ayah',
																	  Pendidikan_Terakhir_Ayah = '$pendidikan_terakhir_ayah',
																	  Pekerjaan_Ayah = '$pekerjaan_ayah',
																	  Penghasilan_Ayah = '$penghasilan_ayah',
																	  Alamat_Ayah = '$alamat_ayah',
																	  Nama_Ibu = '$nama_ibu',
																	  Status_Ibu = '$status_ibu',
																	  Tgl_Lahir_Ibu = '$tanggal_lahir_ibu',
																	  Telepon_Ibu = '$telepon_ibu',
																	  Pendidikan_Terakhir_Ibu = '$pendidikan_terakhir_ibu',
																	  Pekerjaan_Ibu = '$pekerjaan_ibu',
																	  Penghasilan_Ibu = '$penghasilan_ibu',
																	  Alamat_Ibu = '$alamat_ibu',
																	  Nama_Wali = " . (!empty($nama_wali) ? "'$nama_wali'" : "NULL") . ",
																		Status_Wali = " . (!empty($status_wali) ? "'$status_wali'" : "NULL") . ",
																		Tgl_Lahir_Wali = $tanggal_lahir_wali_sql,
																		Telepon_Wali = " . (!empty($telepon_wali) ? "'$telepon_wali'" : "NULL") . ",
																		Pendidikan_Terakhir_Wali = " . (!empty($pendidikan_terakhir_wali) ? "'$pendidikan_terakhir_wali'" : "NULL") . ",
																		Pekerjaan_Wali = " . (!empty($pekerjaan_wali) ? "'$pekerjaan_wali'" : "NULL") . ",
																		Penghasilan_Wali = " . (!empty($penghasilan_wali) ? "'$penghasilan_wali'" : "NULL") . ",
																		Alamat_Wali = " . (!empty($alamat_wali) ? "'$alamat_wali'" : "NULL") . ",
																	  tgl_buat = '$tgl_buat' ");
		if($query) {
			$_SESSION['status_ortu'] = 1; 
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
			header('Location: ../../view/halaman/daftarOrtu.php');
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon" id="alert">
			                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                        <div class="alert-body">
			                          <button class="close" data-dismiss="alert">
			                            <span>×</span>
			                          </button>
			                          <div class="alert-title">Gagal</div>
			                          Data gagal ditambahkan.
			                        </div>
			                      </div>';
			header('Location: ../../view/halaman/daftarOrtu.php'); 
		}
	}

	// Ubah Data Ortu
	if (isset($_POST['ubahDataOrtu'])) {
		$id = $_POST['id'];
		//Peserta
		$peserta 					= mysqli_real_escape_string($conn, $_POST['peserta']); 
		// Data Ayah
		$nama_ayah 					= mysqli_real_escape_string($conn, $_POST['nama_ayah']); 
		$status_ayah 				= mysqli_real_escape_string($conn, $_POST['status_ayah']); 
		$tanggal_lahir_ayah 		= mysqli_real_escape_string($conn, $_POST['tanggal_lahir_ayah']); 
		$telepon_ayah				= mysqli_real_escape_string($conn, $_POST['telepon_ayah']); 
		$pendidikan_terakhir_ayah	= mysqli_real_escape_string($conn, $_POST['pendidikan_terakhir_ayah']); 
		$pekerjaan_ayah				= mysqli_real_escape_string($conn, $_POST['pekerjaan_ayah']); 
		$penghasilan_ayah			= mysqli_real_escape_string($conn, $_POST['penghasilan_ayah']); 
		$alamat_ayah				= mysqli_real_escape_string($conn, $_POST['alamat_ayah']); 
		// Data Ibu
		$nama_ibu 					= mysqli_real_escape_string($conn, $_POST['nama_ibu']); 
		$status_ibu 				= mysqli_real_escape_string($conn, $_POST['status_ibu']); 
		$tanggal_lahir_ibu 			= mysqli_real_escape_string($conn, $_POST['tanggal_lahir_ibu']); 
		$telepon_ibu				= mysqli_real_escape_string($conn, $_POST['telepon_ibu']); 
		$pendidikan_terakhir_ibu	= mysqli_real_escape_string($conn, $_POST['pendidikan_terakhir_ibu']); 
		$pekerjaan_ibu				= mysqli_real_escape_string($conn, $_POST['pekerjaan_ibu']); 
		$penghasilan_ibu			= mysqli_real_escape_string($conn, $_POST['penghasilan_ibu']); 
		$alamat_ibu					= mysqli_real_escape_string($conn, $_POST['alamat_ibu']); 
		// Data Wali
		$nama_wali 					= mysqli_real_escape_string($conn, $_POST['nama_wali']); 
		$status_wali 				= mysqli_real_escape_string($conn, $_POST['status_wali']); 
		$tanggal_lahir_wali 		= mysqli_real_escape_string($conn, $_POST['tanggal_lahir_wali']); 
		$telepon_wali				= mysqli_real_escape_string($conn, $_POST['telepon_wali']); 
		$pendidikan_terakhir_wali	= mysqli_real_escape_string($conn, $_POST['pendidikan_terakhir_wali']); 
		$pekerjaan_wali				= mysqli_real_escape_string($conn, $_POST['pekerjaan_wali']); 
		$penghasilan_wali			= mysqli_real_escape_string($conn, $_POST['penghasilan_wali']); 
		$alamat_wali				= mysqli_real_escape_string($conn, $_POST['alamat_wali']);

		$tgl_ubah = date('Y-m-d H:i:s');

		$query = mysqli_query($conn, "UPDATE orang_tua_wali SET Id_Identitas_Siswa = '$peserta',
																Nama_Ayah = '$nama_ayah',
																Status_Ayah = '$status_ayah',
																Tgl_Lahir_Ayah = '$tanggal_lahir_ayah',
																Telepon_Ayah = '$telepon_ayah',
																Pendidikan_Terakhir_Ayah = '$pendidikan_terakhir_ayah',
																Pekerjaan_Ayah = '$pekerjaan_ayah',
																Penghasilan_Ayah = '$penghasilan_ayah',
																Alamat_Ayah = '$alamat_ayah',
																Nama_Ibu = '$nama_ibu',
																Status_Ibu = '$status_ibu',
																Tgl_Lahir_Ibu = '$tanggal_lahir_ibu',
																Telepon_Ibu = '$telepon_ibu',
																Pendidikan_Terakhir_Ibu = '$pendidikan_terakhir_ibu',
																Pekerjaan_Ibu = '$pekerjaan_ibu',
																Penghasilan_Ibu = '$penghasilan_ibu',
																Alamat_Ibu = '$alamat_ibu',
																Nama_Wali = '$nama_wali',
																Status_Wali = '$status_wali',
																Tgl_Lahir_Wali = '$tanggal_lahir_wali',
																Telepon_Wali = '$telepon_wali',
																Pendidikan_Terakhir_Wali = '$pendidikan_terakhir_wali',
																Pekerjaan_Wali = '$pekerjaan_wali',
																Penghasilan_Wali = '$penghasilan_wali',
																Alamat_Wali = '$alamat_wali',
																tgl_buat = '$tgl_buat'  
									  					WHERE Id_Orang_Tua_Wali = '$id' ") or die(mysqli_error($conn));

		if($query) {
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
			header('Location: ../../view/halaman/daftarOrtu.php');
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
			header('Location: ../../view/halaman/daftarOrtu.php');
		}
	}

	// Login Peserta
	if (isset($_POST['loginDataPeserta'])) {
		$no_telepon = mysqli_real_escape_string($conn, $_POST['no_telepon']);
		$tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);

		$query = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE no_telepon = '$no_telepon' AND Tanggal_Lahir = '$tanggal_lahir'");

		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_assoc($query);
			$_SESSION['noTelpPeserta'] = $no_telepon;
			$_SESSION['namaPeserta'] = $row['Nama_Peserta_Didik'];
			$_SESSION['tlPeserta'] = $tanggal_lahir;
			$_SESSION['idPeserta'] = $row['Id_Identitas_Siswa'];
			$_SESSION['status_ortu'] = $row['status_ortu'];
			$_SESSION['status_administrasi'] = $row['status_administrasi'];

			header('Location: ../../view/halaman/dashboard.php');
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon">
				<div class="alert-icon"><i class="far fa-lightbulb"></i></div>
				<div class="alert-body">
				<button class="close" data-dismiss="alert"><span>×</span></button>
				<div class="alert-title">Login Gagal</div>
				Nomor Telepon dan Tanggal Lahir tidak cocok.
				</div>
			</div>';
			header('Location: ../../view/halaman/login.php');
		}
	}


	// Logout
	if (isset($_GET['logout'])) {
		unset($_SESSION['noTelpPeserta'], $_SESSION['namaPeserta'], $_SESSION['tlPeserta'], $_SESSION['status_ortu'], $_SESSION['status_pembayaran']);
		header('Location: ../../view/halaman');
	}
?>