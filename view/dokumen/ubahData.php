<?php
$title = "Ubah Data Siswa";
require("../template/header.php");
include('../../config/connection.php');

// Ambil data siswa berdasarkan ID
if(!isset($_GET['id'])) {
    header('Location: tampilData.php');
    exit();
}

$id_siswa = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data siswa
$query = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE Id_Identitas_Siswa = '$id_siswa'");
if(mysqli_num_rows($query) == 0) {
    header('Location: tampilData.php');
    exit();
}

$siswa = mysqli_fetch_assoc($query);

// Ambil data dokumen
$dokumen_query = mysqli_query($conn, "
    SELECT * FROM dokumen_siswa 
    WHERE id_siswa = '$id_siswa' 
    ORDER BY jenis_dokumen ASC
");
$dokumen_data = [];
while($dok = mysqli_fetch_assoc($dokumen_query)) {
    $dokumen_data[$dok['jenis_dokumen']] = $dok;
}

// Ambil data nilai
$nilai_query = mysqli_query($conn, "
    SELECT * FROM nilai_rapor 
    WHERE id_siswa = '$id_siswa' 
    ORDER BY semester ASC, mata_pelajaran ASC
");
$nilai_data = [];
while($nilai = mysqli_fetch_assoc($nilai_query)) {
    $nilai_data[] = $nilai;
}

// Fungsi untuk mendapatkan file
function getDokumenFile($jenis, $dokumen_data) {
    return isset($dokumen_data[$jenis]) ? $dokumen_data[$jenis]['nama_file'] : '';
}

function getDokumenPath($jenis, $dokumen_data) {
    return isset($dokumen_data[$jenis]) ? $dokumen_data[$jenis]['path_file'] : '';
}
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
                        <h4>Form Ubah Data Siswa</h4>
                        <div class="card-header-action">
                            <span class="badge badge-info">ID: <?= $siswa['Id_Identitas_Siswa']; ?></span>
                            <span class="badge badge-<?= $siswa['status_pendaftaran'] == 'Diterima' ? 'success' : ($siswa['status_pendaftaran'] == 'Tidak Diterima' ? 'danger' : 'warning'); ?>">
                                <?= $siswa['status_pendaftaran']; ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="../../controller/admin/ubahData.php" method="POST" enctype="multipart/form-data" id="formUbah">
                            <input type="hidden" name="id" value="<?= $siswa['Id_Identitas_Siswa']; ?>">
                            
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
                                <li class="nav-item">
                                    <a class="nav-link" id="nilai-tab" data-toggle="tab" href="#nilai">
                                        <i class="fas fa-list-ol"></i> Nilai
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="status-tab" data-toggle="tab" href="#status">
                                        <i class="fas fa-check-circle"></i> Status
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3" id="formTabContent">
                                <!-- Tab 1: Data Diri -->
                                <div class="tab-pane fade show active" id="data-diri">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NISN</label>
                                                <input type="text" class="form-control" name="nisn" 
                                                    value="<?= htmlspecialchars($siswa['NISN'] ?? ''); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>No. KK</label>
                                                <input type="text" class="form-control" name="no_kk"
                                                    value="<?= htmlspecialchars($siswa['No_KK'] ?? ''); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>NIK</label>
                                                <input type="text" class="form-control" name="nik"
                                                    value="<?= htmlspecialchars($siswa['NIK'] ?? ''); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nama_lengkap" required
                                                    value="<?= htmlspecialchars($siswa['Nama_Peserta_Didik']); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Nama Panggilan</label>
                                                <input type="text" class="form-control" name="nama_panggilan"
                                                    value="<?= htmlspecialchars($siswa['Nama_Panggilan'] ?? ''); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Tempat Lahir</label>
                                                <input type="text" class="form-control" name="tempat_lahir"
                                                    value="<?= htmlspecialchars($siswa['Tempat_Lahir'] ?? ''); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="tanggal_lahir" required
                                                    value="<?= $siswa['Tanggal_Lahir']; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <select class="form-control" name="jenis_kelamin">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Laki-Laki" <?= $siswa['Jenis_Kelamin'] == 'Laki-Laki' ? 'selected' : ''; ?>>Laki-Laki</option>
                                                    <option value="Perempuan" <?= $siswa['Jenis_Kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Agama</label>
                                                <select class="form-control" name="agama">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Islam" <?= $siswa['Agama'] == 'Islam' ? 'selected' : ''; ?>>Islam</option>
                                                    <option value="Kristen" <?= $siswa['Agama'] == 'Kristen' ? 'selected' : ''; ?>>Kristen</option>
                                                    <option value="Katolik" <?= $siswa['Agama'] == 'Katolik' ? 'selected' : ''; ?>>Katolik</option>
                                                    <option value="Hindu" <?= $siswa['Agama'] == 'Hindu' ? 'selected' : ''; ?>>Hindu</option>
                                                    <option value="Buddha" <?= $siswa['Agama'] == 'Buddha' ? 'selected' : ''; ?>>Buddha</option>
                                                    <option value="Konghucu" <?= $siswa['Agama'] == 'Konghucu' ? 'selected' : ''; ?>>Konghucu</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Golongan Darah</label>
                                                <select class="form-control" name="gol_darah">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="A" <?= $siswa['Gol_Darah'] == 'A' ? 'selected' : ''; ?>>A</option>
                                                    <option value="B" <?= $siswa['Gol_Darah'] == 'B' ? 'selected' : ''; ?>>B</option>
                                                    <option value="AB" <?= $siswa['Gol_Darah'] == 'AB' ? 'selected' : ''; ?>>AB</option>
                                                    <option value="O" <?= $siswa['Gol_Darah'] == 'O' ? 'selected' : ''; ?>>O</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>No. Telepon <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="no_telepon" required
                                                    value="<?= htmlspecialchars($siswa['no_telepon']); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email"
                                                    value="<?= htmlspecialchars($siswa['Email'] ?? ''); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Alamat Tinggal</label>
                                                <textarea class="form-control" name="alamat_tinggal" rows="3"><?= htmlspecialchars($siswa['Alamat_Tinggal'] ?? ''); ?></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Tinggal Bersama</label>
                                                <select class="form-control" name="tinggal_bersama">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Orang Tua" <?= $siswa['Tinggal_Bersama'] == 'Orang Tua' ? 'selected' : ''; ?>>Orang Tua</option>
                                                    <option value="Wali" <?= $siswa['Tinggal_Bersame'] == 'Wali' ? 'selected' : ''; ?>>Wali</option>
                                                    <option value="Kost" <?= $siswa['Tinggal_Bersama'] == 'Kost' ? 'selected' : ''; ?>>Kost</option>
                                                    <option value="Asrama" <?= $siswa['Tinggal_Bersama'] == 'Asrama' ? 'selected' : ''; ?>>Asrama</option>
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
                                                <input type="text" class="form-control" name="asal_sekolah" required
                                                    value="<?= htmlspecialchars($siswa['asal_sekolah']); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Alamat Sekolah</label>
                                                <textarea class="form-control" name="alamat_sekolah" rows="3"><?= htmlspecialchars($siswa['Alamat_Sekolah'] ?? ''); ?></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Jurusan Pilihan</label>
                                                <select class="form-control" name="jurusan_pilihan">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="TKJT" <?= $siswa['jurusan_pilihan'] == 'TKJT' ? 'selected' : ''; ?>>TKJT</option>
                                                    <option value="PPLG" <?= $siswa['jurusan_pilihan'] == 'PPLG' ? 'selected' : ''; ?>>PPLG</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Tahun Ajaran</label>
                                                <select class="form-control" name="tahun_ajaran">
                                                    <option value="2024/2025" <?= $siswa['tahun_ajaran'] == '2024/2025' ? 'selected' : ''; ?>>2024/2025</option>
                                                    <option value="2025/2026" <?= $siswa['tahun_ajaran'] == '2025/2026' ? 'selected' : ''; ?>>2025/2026</option>
                                                    <option value="2026/2027" <?= $siswa['tahun_ajaran'] == '2026/2027' ? 'selected' : ''; ?>>2026/2027</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Transport ke Sekolah</label>
                                                <select class="form-control" name="transport">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Jalan Kaki" <?= $siswa['Transport'] == 'Jalan Kaki' ? 'selected' : ''; ?>>Jalan Kaki</option>
                                                    <option value="Sepeda" <?= $siswa['Transport'] == 'Sepeda' ? 'selected' : ''; ?>>Sepeda</option>
                                                    <option value="Sepeda Motor" <?= $siswa['Transport'] == 'Sepeda Motor' ? 'selected' : ''; ?>>Sepeda Motor</option>
                                                    <option value="Mobil" <?= $siswa['Transport'] == 'Mobil' ? 'selected' : ''; ?>>Mobil</option>
                                                    <option value="Angkutan Umum" <?= $siswa['Transport'] == 'Angkutan Umum' ? 'selected' : ''; ?>>Angkutan Umum</option>
                                                    <option value="Jemputan" <?= $siswa['Transport'] == 'Jemputan' ? 'selected' : ''; ?>>Jemputan</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Jarak ke Sekolah (KM)</label>
                                                <input type="number" class="form-control" name="jarak_ke_sekolah" step="0.1"
                                                    value="<?= $siswa['Jarak_ke_Sekolah'] ?? ''; ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Hobi</label>
                                                <input type="text" class="form-control" name="hobi"
                                                    value="<?= htmlspecialchars($siswa['Hobi'] ?? ''); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Kebutuhan Khusus</label>
                                                <textarea class="form-control" name="kebutuhan_khusus" rows="2"><?= htmlspecialchars($siswa['Kebutuhan_Khusus'] ?? ''); ?></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Kelainan Jasmani</label>
                                                <textarea class="form-control" name="kelainan_jasmani" rows="2"><?= htmlspecialchars($siswa['Kelainan_Jasmani'] ?? ''); ?></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Riwayat Penyakit</label>
                                                <textarea class="form-control" name="riwayat_penyakit" rows="2"><?= htmlspecialchars($siswa['Riwayat_Penyakit'] ?? ''); ?></textarea>
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
                                                <input type="text" class="form-control" name="nama_ayah"
                                                    value="<?= htmlspecialchars($siswa['Nama_Ayah'] ?? ''); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>No. Telepon Ayah</label>
                                                <input type="text" class="form-control" name="no_telp_ayah"
                                                    value="<?= htmlspecialchars($siswa['No_Telp'] ?? ''); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Pekerjaan Ayah</label>
                                                <input type="text" class="form-control" name="pekerjaan_ayah">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Alamat Ayah</label>
                                                <textarea class="form-control" name="alamat_ayah" rows="2"><?= htmlspecialchars($siswa['Alamat_Ortu'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <h6>Data Ibu</h6>
                                            <div class="form-group">
                                                <label>Nama Ibu</label>
                                                <input type="text" class="form-control" name="nama_ibu"
                                                    value="<?= htmlspecialchars($siswa['Nama_Ibu'] ?? ''); ?>">
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
                                                <textarea class="form-control" name="alamat_ibu" rows="2"><?= htmlspecialchars($siswa['Alamat_Ortu'] ?? ''); ?></textarea>
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
                                                <input type="file" class="form-control" name="kk" accept=".pdf,.jpg,.jpeg,.png">
                                                <?php if(getDokumenFile('KK', $dokumen_data)): ?>
                                                    <small class="text-muted">
                                                        File saat ini: <?= getDokumenFile('KK', $dokumen_data); ?>
                                                        <a href="<?= getDokumenPath('KK', $dokumen_data); ?>" target="_blank" class="ml-2">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Akte Kelahiran</label>
                                                <input type="file" class="form-control" name="akte_kelahiran" accept=".pdf,.jpg,.jpeg,.png">
                                                <?php if(getDokumenFile('Akte Kelahiran', $dokumen_data)): ?>
                                                    <small class="text-muted">
                                                        File saat ini: <?= getDokumenFile('Akte Kelahiran', $dokumen_data); ?>
                                                        <a href="<?= getDokumenPath('Akte Kelahiran', $dokumen_data); ?>" target="_blank" class="ml-2">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Kartu NISN</label>
                                                <input type="file" class="form-control" name="kartu_nisn" accept=".pdf,.jpg,.jpeg,.png">
                                                <?php if(getDokumenFile('Kartu NISN', $dokumen_data)): ?>
                                                    <small class="text-muted">
                                                        File saat ini: <?= getDokumenFile('Kartu NISN', $dokumen_data); ?>
                                                        <a href="<?= getDokumenPath('Kartu NISN', $dokumen_data); ?>" target="_blank" class="ml-2">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Ijazah SMP/MTS</label>
                                                <input type="file" class="form-control" name="ijazah" accept=".pdf,.jpg,.jpeg,.png">
                                                <?php if(getDokumenFile('Ijazah', $dokumen_data)): ?>
                                                    <small class="text-muted">
                                                        File saat ini: <?= getDokumenFile('Ijazah', $dokumen_data); ?>
                                                        <a href="<?= getDokumenPath('Ijazah', $dokumen_data); ?>" target="_blank" class="ml-2">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>KTP Orang Tua</label>
                                                <input type="file" class="form-control" name="ktp_orang_tua" accept=".pdf,.jpg,.jpeg,.png">
                                                <?php if(getDokumenFile('KTP Orang Tua', $dokumen_data)): ?>
                                                    <small class="text-muted">
                                                        File saat ini: <?= getDokumenFile('KTP Orang Tua', $dokumen_data); ?>
                                                        <a href="<?= getDokumenPath('KTP Orang Tua', $dokumen_data); ?>" target="_blank" class="ml-2">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Pas Foto</label>
                                                <input type="file" class="form-control" name="pas_foto" accept=".jpg,.jpeg,.png">
                                                <?php if(getDokumenFile('Pas Foto', $dokumen_data)): ?>
                                                    <small class="text-muted">
                                                        File saat ini: <?= getDokumenFile('Pas Foto', $dokumen_data); ?>
                                                        <a href="<?= getDokumenPath('Pas Foto', $dokumen_data); ?>" target="_blank" class="ml-2">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>File Nilai Rapor (PDF)</label>
                                                <input type="file" class="form-control" name="nilai_file" accept=".pdf">
                                                <?php if(getDokumenFile('Nilai', $dokumen_data)): ?>
                                                    <small class="text-muted">
                                                        File saat ini: <?= getDokumenFile('Nilai', $dokumen_data); ?>
                                                        <a href="<?= getDokumenPath('Nilai', $dokumen_data); ?>" target="_blank" class="ml-2">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Transkrip Per Semester -->
                                            <div class="form-group">
                                                <label>Transkrip Per Semester (Opsional)</label>
                                                <div class="row">
                                                    <?php for($i = 1; $i <= 6; $i++): 
                                                        $jenis_transkrip = "Transkrip Semester $i";
                                                        $file_transkrip = getDokumenFile($jenis_transkrip, $dokumen_data);
                                                    ?>
                                                    <div class="col-6">
                                                        <label class="d-block">Semester <?= $i ?></label>
                                                        <input type="file" class="form-control-file" name="transkrip_semester_<?= $i ?>" accept=".pdf,.jpg,.jpeg,.png">
                                                        <?php if($file_transkrip): ?>
                                                            <small class="text-muted">
                                                                File: <?= $file_transkrip; ?>
                                                                <a href="<?= getDokumenPath($jenis_transkrip, $dokumen_data); ?>" target="_blank" class="ml-1">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 5: Nilai -->
                                <div class="tab-pane fade" id="nilai">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>Edit Nilai Rapor</h5>
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
                                                        <?php 
                                                        // Buat array untuk memudahkan pencarian nilai
                                                        $nilai_map = [];
                                                        foreach($nilai_data as $nilai) {
                                                            $nilai_map[$nilai['semester']][$nilai['mata_pelajaran']] = $nilai['nilai'];
                                                        }
                                                        
                                                        for($i = 1; $i <= 6; $i++): 
                                                            $mata_pelajaran = [
                                                                'Pendidikan Agama',
                                                                'Pendidikan Kewarganegaraan',
                                                                'Bahasa Indonesia',
                                                                'Bahasa Inggris',
                                                                'Matematika'
                                                            ];
                                                        ?>
                                                        <tr>
                                                            <td>Semester <?= $i ?></td>
                                                            <?php foreach($mata_pelajaran as $mapel): 
                                                                $nilai = $nilai_map[$i][$mapel] ?? '';
                                                            ?>
                                                            <td>
                                                                <input type="number" 
                                                                       class="form-control" 
                                                                       name="nilai[<?= $i ?>][<?= $mapel ?>]" 
                                                                       min="0" max="100"
                                                                       value="<?= $nilai; ?>"
                                                                       placeholder="0-100">
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

                                <!-- Tab 6: Status -->
                                <div class="tab-pane fade" id="status">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status Pendaftaran</label>
                                                <select class="form-control" name="status_pendaftaran">
                                                    <option value="Menunggu Verifikasi" <?= $siswa['status_pendaftaran'] == 'Menunggu Verifikasi' ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                                                    <option value="Diverifikasi" <?= $siswa['status_pendaftaran'] == 'Diverifikasi' ? 'selected' : ''; ?>>Diverifikasi</option>
                                                    <option value="Diterima" <?= $siswa['status_pendaftaran'] == 'Diterima' ? 'selected' : ''; ?>>Diterima</option>
                                                    <option value="Tidak Diterima" <?= $siswa['status_pendaftaran'] == 'Tidak Diterima' ? 'selected' : ''; ?>>Tidak Diterima</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Status Orang Tua</label>
                                                <select class="form-control" name="status_ortu">
                                                    <option value="0" <?= $siswa['status_ortu'] == 0 ? 'selected' : ''; ?>>Belum Lengkap</option>
                                                    <option value="1" <?= $siswa['status_ortu'] == 1 ? 'selected' : ''; ?>>Lengkap</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status Administrasi</label>
                                                <select class="form-control" name="status_administrasi">
                                                    <option value="0" <?= $siswa['status_administrasi'] == 0 ? 'selected' : ''; ?>>Belum Bayar</option>
                                                    <option value="1" <?= $siswa['status_administrasi'] == 1 ? 'selected' : ''; ?>>Sudah Bayar</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Catatan Admin</label>
                                                <textarea class="form-control" name="catatan_admin" rows="4" placeholder="Masukkan catatan jika diperlukan..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirmData" required>
                                    <label class="form-check-label" for="confirmData">
                                        Saya telah memeriksa dan memastikan data yang diubah sudah benar
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group text-right">
                                <a href="tampilData.php" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary" name="ubahData">
                                    <i class="fas fa-save"></i> Simpan Perubahan
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
    $('#formUbah').submit(function(e) {
        // Validasi telepon
        const telepon = $('input[name="no_telepon"]').val();
        if(!/^[0-9]{10,15}$/.test(telepon)) {
            alert('Nomor telepon harus 10-15 digit angka');
            e.preventDefault();
            return false;
        }
        
        // Validasi email jika diisi
        const email = $('input[name="email"]').val();
        if(email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            alert('Format email tidak valid');
            e.preventDefault();
            return false;
        }
        
        // Validasi file upload (max 5MB)
        $('input[type="file"]').each(function() {
            if(this.files.length > 0) {
                const file = this.files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
                if(file.size > maxSize) {
                    alert(`File ${this.name} terlalu besar (max 5MB)`);
                    e.preventDefault();
                    return false;
                }
            }
        });
        
        return confirm('Apakah Anda yakin ingin menyimpan perubahan?');
    });
});
</script>

<?php require("../template/footer.php"); ?>