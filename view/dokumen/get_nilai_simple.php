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
    id_nilai,
    id_siswa,
    mata_pelajaran,
    semester,
    nilai,
    tgl_input
FROM nilai_rapor 
WHERE id_siswa = '$id_siswa'";

// Add semester filter if provided
if ($semester !== null) {
    $query .= " AND semester = $semester";
}

$query .= " ORDER BY semester ASC, mata_pelajaran ASC";

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
    $data[] = [
        'id_nilai' => $row['id_nilai'],
        'id_siswa' => $row['id_siswa'],
        'mata_pelajaran' => $row['mata_pelajaran'],
        'semester' => $row['semester'],
        'nilai' => $row['nilai'],
        'tgl_input' => $row['tgl_input']
    ];
}

echo json_encode([
    'status' => true,
    'data' => $data,
    'count' => count($data)
]);
?>