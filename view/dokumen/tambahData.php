<?php
$title = "Tambah Data Siswa";
require("../template/header.php");
include('../../config/connection.php');
?>

<section class="section">
    <div class="section-header">
        <h1><?= $title; ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="tampilData.php">Data Siswa</a></div>
            <div class="breadcrumb-item"><?= $title; ?></div>
        </div>
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
                        <h4>Form Tambah Data Siswa</h4>
                    </div>
                    <div class="card-body">
                        <form action="../../controller/admin/tambahData.php" method="POST" enctype="multipart/form-data"
                            id="formTambah">
                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs" id="formTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="data-diri-tab" data-toggle="tab" href="#data-diri">
                                        <i class="fas fa-user"></i> Data Diri
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sekolah-tab" data-toggle="tab" href="#sekolah">
                                        <i class="fas fa-school"></i> Data Sekolah
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="ortu-tab" data-toggle="tab" href="#ortu">
                                        <i class="fas fa-users"></i> Data Orang Tua
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="dokumen-tab" data-toggle="tab" href="#dokumen">
                                        <i class="fas fa-file"></i> Dokumen
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3" id="formTabContent">
                                <!-- Tab 1: Data Diri -->
                                <div class="tab-pane fade show active" id="data-diri">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NISN <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nisn" required>
                                            </div>

                                            <div class="form-group">
                                                <label>No. KK</label>
                                                <input type="text" class="form-control" name="no_kk">
                                            </div>

                                            <div class="form-group">
                                                <label>NIK</label>
                                                <input type="text" class="form-control" name="nik">
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nama_lengkap" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Panggilan</label>
                                                <input type="text" class="form-control" name="nama_panggilan">
                                            </div>

                                            <div class="form-group">
                                                <label>Tempat Lahir</label>
                                                <input type="text" class="form-control" name="tempat_lahir">
                                            </div>

                                            <div class="form-group">
                                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="tanggal_lahir" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <select class="form-control" name="jenis_kelamin">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Laki-Laki">Laki-Laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Agama</label>
                                                <select class="form-control" name="agama">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Kristen">Kristen</option>
                                                    <option value="Katolik">Katolik</option>
                                                    <option value="Hindu">Hindu</option>
                                                    <option value="Buddha">Buddha</option>
                                                    <option value="Konghucu">Konghucu</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Golongan Darah</label>
                                                <select class="form-control" name="gol_darah">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="AB">AB</option>
                                                    <option value="O">O</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>No. Telepon <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="no_telepon" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>

                                            <div class="form-group">
                                                <label>Alamat Tinggal</label>
                                                <textarea class="form-control" name="alamat_tinggal"
                                                    rows="3"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Tinggal Bersama</label>
                                                <select class="form-control" name="tinggal_bersama">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Orang Tua">Orang Tua</option>
                                                    <option value="Wali">Wali</option>
                                                    <option value="Kost">Kost</option>
                                                    <option value="Asrama">Asrama</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 2: Data Sekolah -->
                                <div class="tab-pane fade" id="sekolah">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Asal Sekolah <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="asal_sekolah" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Alamat Sekolah</label>
                                                <textarea class="form-control" name="alamat_sekolah"
                                                    rows="3"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Jurusan Pilihan</label>
                                                <select class="form-control" name="jurusan_pilihan">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="TKJT">TKJT</option>
                                                    <option value="PPLG">PPLG</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Tahun Ajaran</label>
                                                <select class="form-control" name="tahun_ajaran">
                                                    <option value="2024/2025">2024/2025</option>
                                                    <option value="2025/2026" selected>2025/2026</option>
                                                    <option value="2026/2027">2026/2027</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Transport ke Sekolah</label>
                                                <select class="form-control" name="transport">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Jalan Kaki">Jalan Kaki</option>
                                                    <option value="Sepeda">Sepeda</option>
                                                    <option value="Sepeda Motor">Sepeda Motor</option>
                                                    <option value="Mobil">Mobil</option>
                                                    <option value="Angkutan Umum">Angkutan Umum</option>
                                                    <option value="Jemputan">Jemputan</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Jarak ke Sekolah (KM)</label>
                                                <input type="number" class="form-control" name="jarak_ke_sekolah"
                                                    step="0.1">
                                            </div>

                                            <div class="form-group">
                                                <label>Hobi</label>
                                                <input type="text" class="form-control" name="hobi">
                                            </div>

                                            <div class="form-group">
                                                <label>Kebutuhan Khusus</label>
                                                <textarea class="form-control" name="kebutuhan_khusus"
                                                    rows="2"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Kelainan Jasmani</label>
                                                <textarea class="form-control" name="kelainan_jasmani"
                                                    rows="2"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Riwayat Penyakit</label>
                                                <textarea class="form-control" name="riwayat_penyakit"
                                                    rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Input Nilai Rapor -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h5>Input Nilai Rapor</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Semester</th>
                                                            <th>Pendidikan Agama</th>
                                                            <th>Pendidikan Kewarganegaraan</th>
                                                            <th>Bahasa Indonesia</th>
                                                            <th>Bahasa Inggris</th>
                                                            <th>Matematika</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 1; $i <= 6; $i++): ?>
                                                            <tr>
                                                                <td>Semester <?= $i ?></td>
                                                                <?php
                                                                $mata_pelajaran = ['pendidikan_agama', 'pkn', 'bahasa_indonesia', 'bahasa_inggris', 'matematika'];
                                                                foreach ($mata_pelajaran as $mapel): ?>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            name="nilai[<?= $i ?>][<?= $mapel ?>]" min="0"
                                                                            max="100" placeholder="0-100">
                                                                    </td>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        <?php endfor; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 3: Data Orang Tua -->
                                <div class="tab-pane fade" id="ortu">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Data Ayah</h6>
                                            <div class="form-group">
                                                <label>Nama Ayah</label>
                                                <input type="text" class="form-control" name="nama_ayah">
                                            </div>

                                            <div class="form-group">
                                                <label>No. Telepon Ayah</label>
                                                <input type="text" class="form-control" name="no_telp_ayah">
                                            </div>

                                            <div class="form-group">
                                                <label>Pekerjaan Ayah</label>
                                                <input type="text" class="form-control" name="pekerjaan_ayah">
                                            </div>

                                            <div class="form-group">
                                                <label>Alamat Ayah</label>
                                                <textarea class="form-control" name="alamat_ayah" rows="2"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <h6>Data Ibu</h6>
                                            <div class="form-group">
                                                <label>Nama Ibu</label>
                                                <input type="text" class="form-control" name="nama_ibu">
                                            </div>

                                            <div class="form-group">
                                                <label>No. Telepon Ibu</label>
                                                <input type="text" class="form-control" name="no_telp_ibu">
                                            </div>

                                            <div class="form-group">
                                                <label>Pekerjaan Ibu</label>
                                                <input type="text" class="form-control" name="pekerjaan_ibu">
                                            </div>

                                            <div class="form-group">
                                                <label>Alamat Ibu</label>
                                                <textarea class="form-control" name="alamat_ibu" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 4: Dokumen -->
                                <div class="tab-pane fade" id="dokumen">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kartu Keluarga (KK)</label>
                                                <input type="file" class="form-control" name="kk"
                                                    accept=".pdf,.jpg,.jpeg,.png">
                                            </div>

                                            <div class="form-group">
                                                <label>Akte Kelahiran</label>
                                                <input type="file" class="form-control" name="akte_kelahiran"
                                                    accept=".pdf,.jpg,.jpeg,.png">
                                            </div>

                                            <div class="form-group">
                                                <label>Kartu NISN</label>
                                                <input type="file" class="form-control" name="kartu_nisn"
                                                    accept=".pdf,.jpg,.jpeg,.png">
                                            </div>

                                            <div class="form-group">
                                                <label>Ijazah SMP/MTS</label>
                                                <input type="file" class="form-control" name="ijazah"
                                                    accept=".pdf,.jpg,.jpeg,.png">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>KTP Orang Tua</label>
                                                <input type="file" class="form-control" name="ktp_orang_tua"
                                                    accept=".pdf,.jpg,.jpeg,.png">
                                            </div>

                                            <div class="form-group">
                                                <label>Pas Foto</label>
                                                <input type="file" class="form-control" name="pas_foto"
                                                    accept=".jpg,.jpeg,.png">
                                            </div>

                                            <div class="form-group">
                                                <label>File Nilai Rapor (PDF)</label>
                                                <input type="file" class="form-control" name="nilai_file" accept=".pdf">
                                            </div>

                                            <div class="form-group">
                                                <label>Transkrip Nilai (Opsional)</label>
                                                <input type="file" class="form-control" name="transkrip"
                                                    accept=".pdf,.jpg,.jpeg,.png">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Upload Transkrip Per Semester -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h6>Upload Transkrip Per Semester (Opsional)</h6>
                                            <div class="row">
                                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Semester <?= $i ?></label>
                                                            <input type="file" class="form-control"
                                                                name="transkrip_semester_<?= $i ?>"
                                                                accept=".pdf,.jpg,.jpeg,.png">
                                                        </div>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirmData" required>
                                    <label class="form-check-label" for="confirmData">
                                        Saya telah memeriksa dan memastikan data yang diisi sudah benar
                                    </label>
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <a href="tampilData.php" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary" name="tambahData">
                                    <i class="fas fa-save"></i> Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        // Validasi form
        $('#formTambah').submit(function (e) {
            // Validasi NISN minimal 10 digit
            const nisn = $('input[name="nisn"]').val();
            if (nisn.length < 10) {
                alert('NISN harus minimal 10 digit');
                e.preventDefault();
                return false;
            }

            // Validasi telepon
            const telepon = $('input[name="no_telepon"]').val();
            if (!/^[0-9]{10,15}$/.test(telepon)) {
                alert('Nomor telepon harus 10-15 digit angka');
                e.preventDefault();
                return false;
            }

            // Validasi email jika diisi
            const email = $('input[name="email"]').val();
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Format email tidak valid');
                e.preventDefault();
                return false;
            }

            // Validasi file upload (max 5MB)
            $('input[type="file"]').each(function () {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    const maxSize = 5 * 1024 * 1024; // 5MB

                    if (file.size > maxSize) {
                        alert(`File ${this.name} terlalu besar (max 5MB)`);
                        e.preventDefault();
                        return false;
                    }
                }
            });

            return confirm('Apakah Anda yakin ingin menyimpan data?');
        });

        // Tab navigation dengan validasi
        $('#formTab a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>

<?php require("../template/footer.php"); ?>