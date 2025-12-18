<?php
session_start();
include("../../config/connection.php");

// Tambah Nilai
if (isset($_POST['tambah'])) {
    $id_siswa = $_POST['id_siswa'];
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $semester = $_POST['semester'];
    $nilai = $_POST['nilai'];

    $query = "INSERT INTO nilai_rapor (id_siswa, mata_pelajaran, semester, nilai) 
              VALUES ('$id_siswa', '$mata_pelajaran', '$semester', '$nilai')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Nilai rapor berhasil ditambahkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> ' . mysqli_error($conn) . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
    header('Location: ../../view/dokumen/tampilData.php');
    exit;
}

// Edit Nilai
if (isset($_POST['edit'])) {
    $id_nilai = $_POST['id_nilai'];
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $semester = $_POST['semester'];
    $nilai = $_POST['nilai'];

    $query = "UPDATE nilai_rapor 
              SET mata_pelajaran = '$mata_pelajaran', semester = '$semester', nilai = '$nilai'
              WHERE id_nilai = '$id_nilai'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Nilai rapor berhasil diupdate.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> ' . mysqli_error($conn) . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
    header('Location: ../../view/dokumen/tampilData.php');
    exit;
}

// Hapus Nilai
if (isset($_POST['delete'])) {
    $id_nilai = $_POST['id_nilai'];

    $query = "DELETE FROM nilai_rapor WHERE id_nilai = '$id_nilai'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Nilai rapor berhasil dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> ' . mysqli_error($conn) . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
    header('Location: ../../view/dokumen/tampilData.php');
    exit;
}
?>