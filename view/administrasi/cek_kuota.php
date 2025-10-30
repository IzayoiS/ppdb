<?php
include('../../config/connection.php');

if (isset($_GET['jurusan'])) {
    $jurusan = mysqli_real_escape_string($conn, $_GET['jurusan']);

    $query = mysqli_query($conn, "SELECT kuota_total, kuota_terisi, (kuota_total - kuota_terisi) as tersisa 
                                 FROM setting_kuota WHERE jurusan = '$jurusan'");

    if ($data = mysqli_fetch_assoc($query)) {
        echo json_encode([
            'total' => $data['kuota_total'],
            'terisi' => $data['kuota_terisi'],
            'tersisa' => $data['tersisa']
        ]);
    } else {
        echo json_encode(['total' => 0, 'terisi' => 0, 'tersisa' => 0]);
    }
}
?>