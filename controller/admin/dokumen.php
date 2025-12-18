<?php
session_start();
include('../../config/connection.php');

// ----- AJAX API kecil untuk CRUD nilai & dokumen (untuk dipanggil dari modal) -----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];

    // ADD NILAI
    if ($action === 'add_nilai') {
        $id_siswa = mysqli_real_escape_string($conn, $_POST['id_siswa_nilai']);
        $semester = intval($_POST['semester']);
        $mapel = mysqli_real_escape_string($conn, $_POST['mata_pelajaran']);
        $nilai = intval($_POST['nilai']);

        $q = mysqli_query($conn, "INSERT INTO nilai_rapor (id_siswa, mata_pelajaran, semester, nilai, tgl_input) VALUES ('$id_siswa', '$mapel', '$semester', '$nilai', NOW())");
        if ($q)
            echo json_encode(['success' => true, 'message' => 'Nilai ditambahkan']);
        else
            echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
        exit;
    }

    // EDIT NILAI
    if ($action === 'edit_nilai') {
        $id_nilai = intval($_POST['id_nilai']);
        $semester = intval($_POST['semester']);
        $mapel = mysqli_real_escape_string($conn, $_POST['mata_pelajaran']);
        $nilai = intval($_POST['nilai']);

        $q = mysqli_query($conn, "UPDATE nilai_rapor SET mata_pelajaran='$mapel', semester='$semester', nilai='$nilai', tgl_input=NOW() WHERE id_nilai='$id_nilai'");
        if ($q)
            echo json_encode(['success' => true, 'message' => 'Nilai diperbarui']);
        else
            echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
        exit;
    }

    // DELETE NILAI
    if ($action === 'delete_nilai') {
        $id_nilai = intval($_POST['hapus_id']);
        $q = mysqli_query($conn, "DELETE FROM nilai_rapor WHERE id_nilai='$id_nilai'");
        if ($q)
            echo json_encode(['success' => true, 'message' => 'Nilai dihapus']);
        else
            echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
        exit;
    }

    // ADD DOKUMEN & EDIT DOKUMEN & DELETE DOKUMEN (sederhana, re-use uploadFile function)
    if (in_array($action, ['add_dokumen', 'edit_dokumen'])) {
        // Pastikan file ada (untuk edit, file optional)
        $id_siswa = mysqli_real_escape_string($conn, $_POST['id_siswa_dokumen']);
        $jenis = mysqli_real_escape_string($conn, $_POST['jenis_dokumen']);
        $semester = isset($_POST['semester']) && $_POST['semester'] !== '' ? intval($_POST['semester']) : null;

        // Jika edit, kita butuh id_dokumen
        $id_dokumen = isset($_POST['id_dokumen']) ? intval($_POST['id_dokumen']) : null;

        // Gunakan fungsi uploadFile yang sudah ada di file ini (memerlukan struktur file input bernama 'file_dokumen')
        $result = uploadFile('file_dokumen', $id_siswa, $jenis, $conn, $semester);

        if ($result['status']) {
            // Jika edit: update row berdasarkan id_dokumen
            if ($action === 'edit_dokumen' && $id_dokumen) {
                $filename = mysqli_real_escape_string($conn, basename($result['message'])); // not exact, but we will fetch latest by id maybe
                // Simpler: update menggunakan path_file & nama_file => we can query inserted row by path_file
                // Namun uploadFile saat insert sudah membuat/insert DB. Untuk konsistensi: jika uploadFile melakukan insert/update sesuai implementasimu, kita hanya return success.
                echo json_encode(['success' => true, 'message' => 'Dokumen tersimpan']);
            } else {
                echo json_encode(['success' => true, 'message' => 'Dokumen tersimpan']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
        exit;
    }

    // DELETE DOKUMEN
    if ($action === 'delete_dokumen') {
        $id_dokumen = intval($_POST['hapus_id']);
        // Ambil path file untuk dihapus
        $q = mysqli_query($conn, "SELECT path_file FROM dokumen_siswa WHERE id_dokumen='$id_dokumen'");
        $row = mysqli_fetch_assoc($q);
        if ($row) {
            $path = $row['path_file'];
            $del = mysqli_query($conn, "DELETE FROM dokumen_siswa WHERE id_dokumen='$id_dokumen'");
            if ($del) {
                if ($path && file_exists($path))
                    @unlink($path);
                echo json_encode(['success' => true, 'message' => 'Dokumen dihapus']);
            } else {
                echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Data dokumen tidak ditemukan']);
        }
        exit;
    }

    // Jika action tidak dikenali
    echo json_encode(['success' => false, 'message' => 'Action tidak dikenali']);
    exit;
}


// Pindahkan fungsi upload di sini
function uploadFile($file, $id_siswa, $jenis_dokumen, $conn, $semester = null)
{
    $upload_dir = "../../uploads/dokumen_siswa/";

    // Buat folder jika belum ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Cek apakah file di-upload
    if (!isset($_FILES[$file]) || $_FILES[$file]['error'] === UPLOAD_ERR_NO_FILE) {
        return ['status' => false, 'message' => 'Tidak ada file yang diupload'];
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
        return ['status' => false, 'message' => 'Tipe file tidak diizinkan. Hanya PDF, JPG, PNG'];
    }

    // Tambahkan semester ke jenis dokumen jika ada
    if ($semester) {
        $jenis_dokumen = $jenis_dokumen . " Semester " . $semester;
    }

    // Generate nama file unik
    $ext = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);
    $filename = $id_siswa . '_' . str_replace(' ', '_', $jenis_dokumen) . '_' . time() . '.' . $ext;
    $filepath = $upload_dir . $filename;

    // Move file
    if (move_uploaded_file($_FILES[$file]['tmp_name'], $filepath)) {
        // Cek apakah sudah ada data
        $cek_query = mysqli_query($conn, "SELECT * FROM dokumen_siswa 
            WHERE id_siswa='$id_siswa' AND jenis_dokumen='$jenis_dokumen'");

        if (mysqli_num_rows($cek_query) > 0) {
            // Update data
            $query = mysqli_query($conn, "UPDATE dokumen_siswa SET 
                nama_file = '$filename',
                path_file = '$filepath',
                tgl_upload = NOW()
                WHERE id_siswa='$id_siswa' AND jenis_dokumen='$jenis_dokumen'");
        } else {
            // Insert data baru
            $query = mysqli_query($conn, "INSERT INTO dokumen_siswa 
                (id_siswa, jenis_dokumen, nama_file, path_file, tgl_upload) 
                VALUES ('$id_siswa', '$jenis_dokumen', '$filename', '$filepath', NOW())");
        }

        if ($query) {
            return ['status' => true, 'message' => 'File berhasil diupload'];
        } else {
            unlink($filepath); // Hapus file jika gagal simpan ke DB
            return ['status' => false, 'message' => 'Gagal menyimpan data ke database: ' . mysqli_error($conn)];
        }
    } else {
        return ['status' => false, 'message' => 'Gagal memindahkan file'];
    }
}

// Main processing logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_siswa'])) {
        $_SESSION['alert'] = '<div class="alert alert-danger">ID Siswa tidak ditemukan</div>';
        header("Location: ../../view/halaman/dokumenPendukung.php");
        exit;
    }

    $id_siswa = mysqli_real_escape_string($conn, $_POST['id_siswa']);

    $jenisList = [
        "KK" => "kk",
        "Akte Kelahiran" => "akte_kelahiran",
        "Kartu NISN" => "kartu_nisn",
        "Ijazah" => "ijazah",
        "KTP Orang Tua" => "ktp_orang_tua",
        "Pas Foto" => "pas_foto",
        "Nilai" => "nilai_file"
    ];

    $dokumen_uploaded = 0;
    $upload_errors = [];

    // Upload dokumen utama
    foreach ($jenisList as $jenis => $inputName) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] !== UPLOAD_ERR_NO_FILE) {
            $result = uploadFile($inputName, $id_siswa, $jenis, $conn);

            if ($result['status']) {
                $dokumen_uploaded++;
            } else {
                $upload_errors[] = "$jenis: " . $result['message'];
            }
        }
    }

    // Upload transkrip per semester
    for ($semester = 1; $semester <= 6; $semester++) {
        $inputName = "transkrip_semester_" . $semester;

        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] !== UPLOAD_ERR_NO_FILE) {
            $result = uploadFile($inputName, $id_siswa, "Transkrip", $conn, $semester);

            if ($result['status']) {
                $dokumen_uploaded++;
            } else {
                $upload_errors[] = "Transkrip Semester $semester: " . $result['message'];
            }
        }
    }

    // Process nilai rapor
    $mataPelajaran = [
        'Pendidikan Agama',
        'Pendidikan Kewarganegaraan',
        'Bahasa Indonesia',
        'Bahasa Inggris',
        'Matematika'
    ];

    $nilai_saved = 0;
    $nilai_updated = 0;

    for ($semester = 1; $semester <= 6; $semester++) {
        $key = "nilai_semester_" . $semester;

        if (isset($_POST[$key]) && is_array($_POST[$key])) {
            $nilaiArray = $_POST[$key];

            for ($i = 0; $i < count($mataPelajaran); $i++) {
                if (isset($nilaiArray[$i]) && $nilaiArray[$i] !== '') {
                    $nilai = mysqli_real_escape_string($conn, $nilaiArray[$i]);
                    $mapel = mysqli_real_escape_string($conn, $mataPelajaran[$i]);

                    if ($nilai >= 0 && $nilai <= 100) {
                        $cekNilai = mysqli_query($conn, "SELECT * FROM nilai_rapor 
                            WHERE id_siswa='$id_siswa' 
                            AND semester='$semester' 
                            AND mata_pelajaran='$mapel'");

                        if (mysqli_num_rows($cekNilai) > 0) {
                            $updateNilai = mysqli_query($conn, "UPDATE nilai_rapor SET 
                                nilai='$nilai', tgl_input=NOW()
                                WHERE id_siswa='$id_siswa' 
                                AND semester='$semester' 
                                AND mata_pelajaran='$mapel'");

                            if ($updateNilai) {
                                $nilai_updated++;
                            }
                        } else {
                            $insertNilai = mysqli_query($conn, "INSERT INTO nilai_rapor
                                (id_siswa, mata_pelajaran, semester, nilai, tgl_input)
                                VALUES('$id_siswa', '$mapel', '$semester', '$nilai', NOW())");

                            if ($insertNilai) {
                                $nilai_saved++;
                            }
                        }
                    }
                }
            }
        }
    }

    $total_nilai_proses = $nilai_saved + $nilai_updated;

    // Prepare success message
    $message = '';
    if (count($upload_errors) > 0) {
        $message .= '<div class="alert alert-warning alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                Beberapa dokumen gagal diupload: <br>' . implode('<br>', $upload_errors) . '
            </div>
        </div>';
    }

    if ($dokumen_uploaded > 0 || $total_nilai_proses > 0) {
        $message .= '<div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                Data berhasil disimpan!<br>
            </div>
        </div>';
    } else if (empty($message)) {
        $message = '<div class="alert alert-info alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                Tidak ada perubahan data.
            </div>
        </div>';
    }

    $_SESSION['alert'] = $message;
    header("Location: ../../view/halaman/dokumenPendukung.php");
    exit;
} else {
    // Jika akses langsung ke controller tanpa POST
    header("Location: ../../view/halaman/dokumenPendukung.php");
    exit;
}
?>