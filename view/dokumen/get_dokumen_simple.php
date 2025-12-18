<?php
session_start();
include('../../config/connection.php');

header('Content-Type: application/json');

if (!isset($_GET['id_siswa'])) {
    echo json_encode([
        'status' => false,
        'message' => 'ID Siswa tidak ditemukan'
    ]);
    exit;
}

$id_siswa = mysqli_real_escape_string($conn, $_GET['id_siswa']);
$semester = isset($_GET['semester']) && $_GET['semester'] !== '' ? intval($_GET['semester']) : null;

// Build query
$query = "SELECT 
    id_dokumen,
    id_siswa,
    jenis_dokumen,
    nama_file,
    path_file,
    tgl_upload
FROM dokumen_siswa 
WHERE id_siswa = '$id_siswa'";

// Add semester filter if provided (untuk transkrip)
if ($semester !== null) {
    $query .= " AND jenis_dokumen LIKE '%Semester $semester%'";
}

$query .= " ORDER BY tgl_upload DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode([
        'status' => false,
        'message' => 'Query error: ' . mysqli_error($conn)
    ]);
    exit;
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Generate URL untuk akses file
    $url = '../../uploads/dokumen_siswa/' . $row['nama_file'];

    $data[] = [
        'id_dokumen' => $row['id_dokumen'],
        'id_siswa' => $row['id_siswa'],
        'jenis_dokumen' => $row['jenis_dokumen'],
        'nama_file' => $row['nama_file'],
        'path_file' => $row['path_file'],
        'url' => $url,
        'tgl_upload' => $row['tgl_upload']
    ];
}

echo json_encode([
    'status' => true,
    'data' => $data,
    'count' => count($data)
]);
?>