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

// Ambil data dokumen dan nilai
$id_siswa = $data['Id_Identitas_Siswa'];

// Ambil dokumen
$q_dok = mysqli_query($conn, "SELECT * FROM dokumen_siswa WHERE id_siswa = '$id_siswa'");
$dokumen = [];
while ($d = mysqli_fetch_assoc($q_dok)) {
    $dokumen[$d['jenis_dokumen']] = $d;
}

function getDocFile($jenis_doc, $dokumen)
{
    if (isset($dokumen[$jenis_doc])) {
        return $dokumen[$jenis_doc]['nama_file'];
    }
    return 'Belum upload';
}

function getDocPath($jenis_doc, $dokumen)
{
    if (isset($dokumen[$jenis_doc])) {
        return $dokumen[$jenis_doc]['path_file'];
    }
    return '#';
}

function getTranskripFile($semester, $dokumen)
{
    $jenis_doc = "Transkrip Semester " . $semester;
    if (isset($dokumen[$jenis_doc])) {
        return $dokumen[$jenis_doc]['nama_file'];
    }
    return 'Belum upload';
}

function getTranskripPath($semester, $dokumen)
{
    $jenis_doc = "Transkrip Semester " . $semester;
    if (isset($dokumen[$jenis_doc])) {
        return $dokumen[$jenis_doc]['path_file'];
    }
    return '#';
}

// Ambil nilai rapor
$q_nilai = mysqli_query($conn, "SELECT * FROM nilai_rapor WHERE id_siswa = '$id_siswa' ORDER BY semester ASC");
$nilai_data = [];
while ($n = mysqli_fetch_assoc($q_nilai)) {
    $nilai_data[] = $n;
}

// Jika belum bayar, redirect ke halaman pembayaran
if ($data['status_administrasi'] == 0) {
    header('Location: daftarSiswa.php');
    exit();
}

$title = "Dokumen Pendukung";
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
                                <li><a class="nav-link" href="dashboard.php">Data Siswa</a></li>
                                <li><a class="nav-link" href="daftarOrtu.php">Data Orang Tua</a></li>
                                <li class="active"><a class="nav-link" href="dokumenPendukung.php">Dokumen Pendukung</a>
                                </li>
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="index.php" type="button"
                                            class="btn btn-primary daterange-btn icon-left btn-icon">
                                            <i class="fas fa-arrow-left"></i> Halaman Utama
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <form action="../../controller/admin/dokumen.php" method="POST"
                                            enctype="multipart/form-data">
                                            <input type="hidden" name="id_siswa" value="<?= $id_siswa ?>">

                                            <h5 class="mb-3">Upload Dokumen</h5>

                                            <div class="form-group">
                                                <label>Upload KK</label>
                                                <input type="file" class="form-control" name="kk">
                                                <small class="text-muted">
                                                    File saat ini: <strong><?= getDocFile('KK', $dokumen) ?></strong>
                                                    <?php if (isset($dokumen['KK'])): ?>
                                                        | <a href="<?= getDocPath('KK', $dokumen) ?>" target="_blank"
                                                            download>
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    <?php endif; ?>
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label>Upload Akte Kelahiran</label>
                                                <input type="file" class="form-control" name="akte_kelahiran">
                                                <small class="text-muted">
                                                    File saat ini:
                                                    <strong><?= getDocFile('Akte Kelahiran', $dokumen) ?></strong>
                                                    <?php if (isset($dokumen['Akte Kelahiran'])): ?>
                                                        | <a href="<?= getDocPath('Akte Kelahiran', $dokumen) ?>"
                                                            target="_blank" download>
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    <?php endif; ?>
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label>Upload Kartu NISN</label>
                                                <input type="file" class="form-control" name="kartu_nisn">
                                                <small class="text-muted">
                                                    File saat ini:
                                                    <strong><?= getDocFile('Kartu NISN', $dokumen) ?></strong>
                                                    <?php if (isset($dokumen['Kartu NISN'])): ?>
                                                        | <a href="<?= getDocPath('Kartu NISN', $dokumen) ?>"
                                                            target="_blank" download>
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    <?php endif; ?>
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label>Upload Ijazah SMP/MTS</label>
                                                <input type="file" class="form-control" name="ijazah">
                                                <small class="text-muted">
                                                    File saat ini:
                                                    <strong><?= getDocFile('Ijazah', $dokumen) ?></strong>
                                                    <?php if (isset($dokumen['Ijazah'])): ?>
                                                        | <a href="<?= getDocPath('Ijazah', $dokumen) ?>" target="_blank"
                                                            download>
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    <?php endif; ?>
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label>Upload KTP Orang Tua / Wali</label>
                                                <input type="file" class="form-control" name="ktp_orang_tua">
                                                <small class="text-muted">
                                                    File saat ini:
                                                    <strong><?= getDocFile('KTP Orang Tua', $dokumen) ?></strong>
                                                    <?php if (isset($dokumen['KTP Orang Tua'])): ?>
                                                        | <a href="<?= getDocPath('KTP Orang Tua', $dokumen) ?>"
                                                            target="_blank" download>
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    <?php endif; ?>
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label>Upload Pas Foto</label>
                                                <input type="file" class="form-control" name="pas_foto">
                                                <small class="text-muted">
                                                    File saat ini:
                                                    <strong><?= getDocFile('Pas Foto', $dokumen) ?></strong>
                                                    <?php if (isset($dokumen['Pas Foto'])): ?>
                                                        | <a href="<?= getDocPath('Pas Foto', $dokumen) ?>" target="_blank"
                                                            download>
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    <?php endif; ?>
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label>Upload File Nilai</label>
                                                <input type="file" class="form-control" name="nilai_file">
                                                <small class="text-muted">
                                                    File saat ini: <strong><?= getDocFile('Nilai', $dokumen) ?></strong>
                                                    <?php if (isset($dokumen['Nilai'])): ?>
                                                        | <a href="<?= getDocPath('Nilai', $dokumen) ?>" target="_blank"
                                                            download>
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    <?php endif; ?>
                                                </small>
                                            </div>

                                            <hr class="my-4">

                                            <div class="form-section mt-4">
                                                <h5 class="mb-3">Input Nilai Rapor</h5>
                                                <small class="text-muted d-block mb-3">Semester 1-6 | Nilai dari 5 mata
                                                    pelajaran utama (0-100)</small>

                                                <!-- Hidden input untuk data dari database -->
                                                <input type="hidden" id="nilai-dari-db"
                                                    value='<?= json_encode($nilai_data) ?>'>

                                                <div id="nilai-semester-container">
                                                    <?php for ($semester = 1; $semester <= 6; $semester++): ?>
                                                        <div class="card mb-4" id="semester-card-<?= $semester ?>">
                                                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                                                <h6 class="mb-0">Semester <?= $semester ?></h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <!-- Transkrip Upload Section -->
                                                                <div class="form-group mb-4">
                                                                    <label class="font-weight-bold">Upload Transkrip Nilai Semester <?= $semester ?></label>
                                                                    <input type="file" class="form-control" name="transkrip_semester_<?= $semester ?>" 
                                                                        accept=".pdf,.jpg,.jpeg,.png">
                                                                    <small class="text-muted">
                                                                        <?php 
                                                                        $currentFile = getTranskripFile($semester, $dokumen);
                                                                        echo 'File saat ini: <strong>' . htmlspecialchars($currentFile) . '</strong>';
                                                                        if ($currentFile !== 'Belum upload'): 
                                                                            echo ' | <a href="' . htmlspecialchars(getTranskripPath($semester, $dokumen)) . '" target="_blank" download>
                                                                                <i class="fas fa-download"></i> Download
                                                                            </a>';
                                                                        endif;
                                                                        ?>
                                                                    </small>
                                                                </div>
                                                                <hr>
                                                                <!-- Input Nilai Section -->
                                                                <h6 class="mb-3">Input Nilai Mata Pelajaran</h6>
                                                                
                                                                <div id="nilai-fields-<?= $semester ?>">
                                                                    <!-- Nilai fields akan di-generate oleh JavaScript -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>

                                            <button class="btn btn-primary btn-lg mt-4" type="submit" name="submit_dokumen">
                                                <i class="fas fa-save"></i> Simpan Semua Data
                                            </button>
                                        </form>
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

        document.addEventListener('DOMContentLoaded', function () {
            const nilaiDbInput = document.getElementById('nilai-dari-db');
            let nilaiDatabase = [];

            // Parse data dari database
            try {
                nilaiDatabase = JSON.parse(nilaiDbInput.value || '[]');
            } catch (e) {
                console.error('Error parsing nilai data:', e);
                nilaiDatabase = [];
            }

            // Daftar mata pelajaran
            const mataPelajaranList = [
                'Pendidikan Agama',
                'Pendidikan Kewarganegaraan',
                'Bahasa Indonesia',
                'Bahasa Inggris',
                'Matematika'
            ];

            // Cari nilai dari database
            function findNilaiFromDb(semester, mataPelajaran) {
                const found = nilaiDatabase.find(item =>
                    item.semester == semester && item.mata_pelajaran == mataPelajaran
                );
                return found ? found.nilai : '';
            }

            // Generate form untuk setiap semester
            for (let semester = 1; semester <= 6; semester++) {
                const container = document.getElementById(`nilai-fields-${semester}`);
                
                // Generate form group untuk setiap mata pelajaran
                mataPelajaranList.forEach((mataPelajaran, index) => {
                    const nilaiDariDb = findNilaiFromDb(semester, mataPelajaran);

                    const formGroup = document.createElement('div');
                    formGroup.className = 'form-group mb-3';
                    formGroup.innerHTML = `
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label class="mb-0">${mataPelajaran}</label>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" 
                                        class="form-control nilai-input" 
                                        name="nilai_semester_${semester}[]"
                                        data-semester="${semester}"
                                        data-mata-pelajaran="${mataPelajaran}"
                                        min="0" 
                                        max="100" 
                                        step="0.1"
                                        value="${nilaiDariDb}"
                                        placeholder="0-100">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas ${nilaiDariDb ? 'fa-check text-success' : 'fa-minus text-muted'}"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <small class="form-text ${nilaiDariDb ? 'text-success' : 'text-muted'}">
                                    ${nilaiDariDb ? '✓ Tersimpan' : 'Belum diisi'}
                                </small>
                            </div>
                        </div>
                    `;

                    container.appendChild(formGroup);

                    // Event listener untuk validasi dan update status
                    const input = formGroup.querySelector('input');
                    input.addEventListener('input', function () {
                        const small = formGroup.querySelector('small');
                        const icon = formGroup.querySelector('.input-group-text i');

                        // Validasi nilai
                        let nilai = parseFloat(this.value);
                        if (nilai < 0) this.value = 0;
                        if (nilai > 100) this.value = 100;

                        // Update status
                        if (this.value && this.value !== '') {
                            small.textContent = '✓ Akan disimpan';
                            small.className = 'form-text text-info';
                            icon.className = 'fas fa-edit text-info';
                        } else {
                            small.textContent = 'Belum diisi';
                            small.className = 'form-text text-muted';
                            icon.className = 'fas fa-minus text-muted';
                        }
                    });
                });
            }

            // Validasi form sebelum submit
            const form = document.querySelector('form');
            form.addEventListener('submit', function (e) {
                const nilaiInputs = document.querySelectorAll('.nilai-input');
                let hasInvalidValue = false;

                nilaiInputs.forEach(input => {
                    if (input.value !== '') {
                        const nilai = parseFloat(input.value);
                        if (isNaN(nilai) || nilai < 0 || nilai > 100) {
                            hasInvalidValue = true;
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    }
                });

                // Validasi file transkrip (opsional, bisa dikosongkan)
                const fileInputs = document.querySelectorAll('input[type="file"][name^="transkrip_semester_"]');
                fileInputs.forEach(input => {
                    if (input.files.length > 0) {
                        const file = input.files[0];
                        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
                        const maxSize = 5 * 1024 * 1024; // 5MB
                        
                        if (!allowedTypes.includes(file.type)) {
                            alert(`File transkrip semester ${input.name.match(/\d+/)[0]} harus berupa PDF, JPG, atau PNG!`);
                            e.preventDefault();
                            return false;
                        }
                        
                        if (file.size > maxSize) {
                            alert(`File transkrip semester ${input.name.match(/\d+/)[0]} terlalu besar (max 5MB)!`);
                            e.preventDefault();
                            return false;
                        }
                    }
                });

                if (hasInvalidValue) {
                    e.preventDefault();
                    alert('Mohon periksa kembali nilai yang diinput. Nilai harus antara 0-100.');
                    return false;
                }

                return confirm('Apakah Anda yakin ingin menyimpan semua data?');
            });
        });
    </script>
</body>

</html>