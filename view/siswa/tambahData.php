<!-- Header -->
<?php
$title = "Data Siswa"; // Judulnya
require("../template/header.php"); // include headernya
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

	<div class="section-body">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<!-- <h4>Basic DataTables</h4> -->
						<a href="tampilData.php" type="button" class="btn btn-primary daterange-btn icon-left btn-icon">
							<i class="fas fa-arrow-left"></i> Kembali
						</a>
					</div>
					<div class="card-body">

						<div class="section-title mt-0 ml-4">Tambah Data Siswa</div>

						<!-- Tambah Data -->
						<form class="needs-validation" novalidate="" action="../../controller/admin/siswa.php"
							method="POST">
							<div class="modal-body">
								<div class="form-group">
									<label>NISN</label>
									<input type="text" class="form-control" name="nisn" required="" minlength="10" maxlength="10">
									<div class="valid-feedback"> Baguss! </div>
									<div class="invalid-feedback"> Minimal 10 kata</div>
								</div>

								<div class="form-group">
									<label>No. KK</label>
									<input type="text" class="form-control" name="no_kk" required="" minlength="16" maxlength="16" >
									<div class="valid-feedback"> Baguss! </div>
									<div class="invalid-feedback"> Minimal 16 kata</div>
								</div>

								<div class="form-group">
									<label>NIK</label>
									<input type="text" class="form-control" name="nik" required="" minlength="16" maxlength="16" >
									<div class="valid-feedback"> Baguss! </div>
									<div class="invalid-feedback"> Minimal 8 kata </div>
								</div>

								<div class="form-group">
									<label>Nama Panggilan</label>
									<input type="text" class="form-control" name="nama_panggilan" required="">
									<div class="valid-feedback"> Baguss! </div>
									<div class="invalid-feedback"> Wajib Diisi! </div>
								</div>

								<div class="form-group">
									<label>Nama Lengkap Peserta Didik</label>
									<input type="text" class="form-control" name="nama_lengkap" required="">
									<div class="valid-feedback"> Baguss! </div>
									<div class="invalid-feedback"> Wajib Diisi! </div>
								</div>

								<div class="form-group">
									<label>Tempat Lahir</label>
									<input type="text" class="form-control" name="tempat_lahir" required="">
									<div class="valid-feedback"> Baguss! </div>
									<div class="invalid-feedback"> Wajib Diisi! </div>
								</div>

								<div class="form-group">
									<label>Tanggal Lahir</label>
									<input type="date" class="form-control" name="tanggal_lahir" required="">
									<div class="valid-feedback"> Baguss! </div>
									<div class="invalid-feedback"> Wajib Diisi! </div>
								</div>

								<div class="form-group">
									<label>Pilihan Jurusan</label>
									<select name="jurusan_pilihan" class="form-control" required>
										<option value="" disabled selected>Pilih Jurusan</option>
										<option value="TKJT">TKJT</option>
										<option value="PPLG">PPLG</option>
										<option value="PPLG KUBINAR">PPLG KUBINAR</option>
									</select>
								</div>

								<div class="form-group">
									<label>Jenis Kelamin</label>
									<select class="form-control" name="jenis_kelamin" required>
										<option value="" disabled selected>~~~ PILIH JENIS KELAMIN ~~~
										</option>
										<option value="Laki-Laki">Laki-Laki</option>
										<option value="Perempuan">Perempuan</option>
									</select>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Agama</label>
									<select class="form-control" name="agama" required>
										<option value="">-- Pilih Agama --</option>
										<option value="Islam" >Islam</option>
										<option value="Kristen" >Kristen</option>
										<option value="Katolik">Katolik</option>
										<option value="Hindu">Hindu</option>
										<option value="Buddha" >Buddha</option>
										<option value="Konghucu" Konghucu</option>
										<option value="Lainnya" >Lainnya</option>
									</select>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Kelainan Jasmani</label>
									<input type="text" class="form-control" name="kelainan_jasmani">
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Kebutuhan Khusus</label>
									<input type="text" class="form-control" name="kebutuhan_khusus" required>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Hobi</label>
									<input type="text" class="form-control" name="hobi"
										required>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Nama Ayah</label>
									<input type="text" class="form-control" name="nama_ayah"
										 required>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Nama Ibu</label>
									<input type="text" class="form-control" name="nama_ibu"
										 required>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Alamat Lengkap Orang Tua / Wali</label>
									<textarea class="form-control" name="alamat_ortu" rows="2"
										required></textarea>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>No. Telepon</label>
									<input type="text" class="form-control" name="no_telp"
										required>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" name="email" 
										required>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Asal Sekolah</label>
									<input type="text" class="form-control" name="asal_sekolah"
										 required>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Alamat Sekolah</label>
									<textarea class="form-control" name="alamat_sekolah"
										required></textarea>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Tinggal Bersama</label>
									<select class="form-control" name="tinggal_bersama" required>
										<option value="">-- Pilih --</option>
										<option value="Orang Tua">Orang Tua</option>
										<option value="Wali">Wali</option>
										<option value="Saudara">Saudara</option>
										<option value="Asrama">Asrama</option>
										<option value="Sendiri">Sendiri</option>
									</select>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib dipilih!</div>
								</div>

								<div class="form-group">
									<label>Transport ke Sekolah</label>
									<select class="form-control" name="transport" required>
										<option value="">-- Pilih --</option>
										<option value="Jalan Kaki">Jalan Kaki</option>
										<option value="Sepeda">Sepeda</option>
										<option value="Motor" >Motor
										</option>
										<option value="Mobil">Mobil
										</option>
										<option value="Angkutan Umum">Ojek Online</option>
									</select>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib dipilih!</div>
								</div>

								<div class="form-group">
									<label>Golongan Darah</label>
									<select class="form-control" name="gol_darah" required>
										<option value="">-- Pilih --</option>
										<option value="A">A</option>
										<option value="B">B</option>
										<option value="AB">AB</option>
										<option value="O">O</option>
										<option value="Tidak Tahu">Tidak Tahu</option>
									</select>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib dipilih!</div>
								</div>


								<div class="form-group">
									<label>Tinggi Badan (Cm)</label>
									<input type="number" class="form-control" name="tinggi_badan" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Berat Badan (Kg)</label>
									<input type="number" class="form-control" name="berat_badan" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Suku</label>
									<input type="text" class="form-control" name="suku" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Bahasa</label>
									<input type="text" class="form-control" name="bahasa" required
										>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Kewarganegaraan</label>
									<input type="text" class="form-control" name="kewarganegaraan" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Status Anak</label>
									<input type="text" class="form-control" name="status_anak" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Anak Ke</label>
									<input type="number" class="form-control" name="anak_ke" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Jumlah Saudara</label>
									<input type="number" class="form-control" name="jumlah_saudara" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Jenis Tinggal</label>
									<select class="form-control" name="jenis_tinggal" required>
										<option value="">-- Pilih Jenis Tinggal --</option>
										<option value="Bersama Orang Tua" >Bersama Orang Tua</option>
										<option value="Wali" >Wali
										</option>
										<option value="Kost">Kost
										</option>
										<option value="Asrama" >
											Asrama</option>
										<option value="Panti Asuhan" >Panti Asuhan</option>
										<option value="Lainnya" >Lainnya</option>
									</select>
									<div class="valid-feedback">Bagus!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>


								<div class="form-group">
									<label>Alamat</label>
									<textarea type="text" class="form-control" name="alamat_tinggal" required
										style="height:80px"></textarea>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Provinsi</label>
									<input type="text" class="form-control" name="provinsi_tinggal" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Kabupaten / Kota</label>
									<input type="text" class="form-control" name="kab_kota_tinggal" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Kecamatan</label>
									<input type="text" class="form-control" name="kecamatan_tinggal" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>

								<div class="form-group">
									<label>Kelurahan</label>
									<input type="text" class="form-control" name="kelurahan_tinggal" required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>
								<div class="form-group">
									<label>Kode POS</label>
									<input type="number" class="form-control" name="kode_pos" required="">
									<div class="valid-feedback"> Baguss! </div>
									<div class="invalid-feedback"> Wajib Diisi! </div>
								</div>
								<div class="form-group">
									<label>Jarak Ke Sekolah (Meter)</label>
									<input type="number" class="form-control" name="jarak_ke_sekolah" required="">
									<div class="valid-feedback"> Baguss! </div>
									<div class="invalid-feedback"> Wajib Diisi! </div>
								</div>
								<div class="form-group">
									<label>Riwayat Penyakit</label>
									<textarea type="text" class="form-control" name="riwayat_penyakit" required=""
										style="height:80px"></textarea>
									<div class="valid-feedback"> Baguss! </div>
									<div class="invalid-feedback"> Wajib Diisi! </div>
								</div>
								<div class="form-group">
									<label>Upload KK</label>
									<input type="file" class="form-control" name="kk"
										required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>
								<div class="form-group">
									<label>Upload Akte Kelahiran</label>
									<input type="file" class="form-control" name="akte_kelahiran"
										required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>
								<div class="form-group">
									<label>Upload Kartu NISN</label>
									<input type="file" class="form-control" name="kartu_nisn"
										required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>
								<div class="form-group">
									<label>Upload SMP/MTS</label>
									<input type="file" class="form-control" name="ijazah"
										required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>
								<div class="form-group">
									<label>Upload KTP Orang Tua / Wali</label>
									<input type="file" class="form-control" name="ktp_orang_tua"
										required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>
								<div class="form-group">
									<label>Upload Pas Foto</label>
									<input type="file" class="form-control" name="pas_foto"
										required>
									<div class="valid-feedback">Baguss!</div>
									<div class="invalid-feedback">Wajib Diisi!</div>
								</div>
								<br>
								<div class="modal-footer bg-whitesmoke br">
									<a href="tampilData.php" type="button" class="btn btn-secondary">Batal</a>
									<button class="btn btn-primary" name="tambahData">Simpan</button>
								</div>
							</div>
						</form>
						<!-- penutup Tambah Data -->

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Penutup Isinya -->



<!-- Footer -->
<?php require("../template/footer.php"); ?>