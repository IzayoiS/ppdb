<?php
session_start();
include("../../config/connection.php");

// Tambah Data
if (isset($_POST['tambahData'])) {
	$peserta = $_POST['peserta'];
	$harga = $_POST['harga'];
	$status = $_POST['status'];
	$tgl_buat = date('Y-m-d H:i:s');

	$stmt = $conn->prepare("INSERT INTO administrasi (id_identitas_siswa, harga, status, tgl_buat) VALUES (?, ?, ?, ?)");
	if ($stmt) {
		$stmt->bind_param("sdss", $peserta, $harga, $status, $tgl_buat);
		$query = $stmt->execute();
		$stmt->close();
	} else {
		$query = false;
	}

	$_SESSION['alert'] = $query
		? '<div class="alert alert-success alert-has-icon" id="alert">
              <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <div class="alert-title">Berhasil</div> Data berhasil ditambahkan.
              </div>
           </div>'
		: '<div class="alert alert-danger alert-has-icon" id="alert">
              <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <div class="alert-title">Gagal</div> Data gagal ditambahkan.
              </div>
           </div>';

	header('Location: ../../view/administrasi/tampilData.php');
	exit;
}

// Ubah Data
if (isset($_POST['ubahData'])) {
	$id = $_POST['id'];
	$peserta = $_POST['peserta'];
	$harga = $_POST['harga'];
	$status = $_POST['status'];

	$stmt = $conn->prepare("UPDATE administrasi 
                            SET id_identitas_siswa = ?, harga = ?, status = ?
                            WHERE id_administrasi = ?");
	if ($stmt) {
		$stmt->bind_param("sdsi", $peserta, $harga, $status, $id);
		$query = $stmt->execute();
		$stmt->close();
	} else {
		$query = false;
	}

	$_SESSION['alert'] = $query
		? '<div class="alert alert-success alert-has-icon" id="alert">
              <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <div class="alert-title">Berhasil</div> Data berhasil diubah.
              </div>
           </div>'
		: '<div class="alert alert-danger alert-has-icon" id="alert">
              <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <div class="alert-title">Gagal</div> Data gagal diubah.
              </div>
           </div>';

	header('Location: ../../view/administrasi/tampilData.php');
	exit;
}

// Hapus Data
if (isset($_GET['hapusData'])) {
	$id = $_GET['hapusData'];

	$stmt = $conn->prepare("DELETE FROM administrasi WHERE id_administrasi = ?");
	if ($stmt) {
		$stmt->bind_param("i", $id);
		$query = $stmt->execute();
		$stmt->close();
	} else {
		$query = false;
	}

	$_SESSION['alert'] = $query
		? '<div class="alert alert-success alert-has-icon" id="alert">
              <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <div class="alert-title">Berhasil</div> Data berhasil dihapus.
              </div>
           </div>'
		: '<div class="alert alert-danger alert-has-icon" id="alert">
              <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <div class="alert-title">Gagal</div> Data gagal dihapus.
              </div>
           </div>';

	header('Location: ../../view/administrasi/tampilData.php');
	exit;
}

// === UPDATE LUNAS ===
if (isset($_POST['updateLunas'])) {
    $id = $_POST['id_administrasi'];
    $id_identitas_siswa = $_POST['id_identitas_siswa'];
    $nominal = $_POST['nominal'];
    $tgl_ubah = date('Y-m-d H:i:s');

    if (empty($id)) {
        // Buat data baru jika belum ada
        $stmt = $conn->prepare("INSERT INTO administrasi (id_identitas_siswa, harga, status, tgl_buat, tgl_ubah) 
                                VALUES (?, ?, 'Lunas', ?, ?)");
        $stmt->bind_param("idss", $id_identitas_siswa, $nominal, $tgl_ubah, $tgl_ubah);
        $stmt->execute();
        $stmt->close();
    } else {
        // Update data lama
        $stmt = $conn->prepare("UPDATE administrasi SET harga = ?, status = 'Lunas', tgl_ubah = ? 
                                WHERE id_administrasi = ?");
        $stmt->bind_param("dsi", $nominal, $tgl_ubah, $id);
        $stmt->execute();
        $stmt->close();
    }

    // === Update status administrasi di tabel identitas_siswa ===
    $stmt2 = $conn->prepare("UPDATE identitas_siswa 
                             SET status_administrasi = 1, tgl_ubah = ? 
                             WHERE Id_Identitas_Siswa = ?");
    $stmt2->bind_param("si", $tgl_ubah, $id_identitas_siswa);
    $stmt2->execute();
    $stmt2->close();

    $_SESSION['alert'] = '
        <div class="alert alert-success alert-has-icon" id="alert">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <div class="alert-title">Berhasil</div>
                Status pembayaran telah dilunasi.
            </div>
        </div>';
    header('Location: ../../view/administrasi/tampilData.php');
    exit;
}

// === TOGGLE STATUS LUNAS / BELUM LUNAS ===
if (isset($_POST['toggleLunas'])) {
    $id_administrasi = $_POST['id_administrasi'];
    $id_identitas_siswa = $_POST['id_identitas_siswa'];
    $tgl_ubah = date('Y-m-d H:i:s');

    // Ambil status sekarang
    $statusNow = null;
    if (!empty($id_administrasi)) {
        $result = $conn->query("SELECT status FROM administrasi WHERE id_administrasi = '$id_administrasi'");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $statusNow = $row['status'];
        }
    }

    if (empty($id_administrasi)) {
        // Jika belum ada data administrasi → buat baru langsung Lunas
        $stmt = $conn->prepare("INSERT INTO administrasi (id_identitas_siswa, harga, status, tgl_buat, tgl_ubah)
                                VALUES (?, 0, 'Lunas', ?, ?)");
        $stmt->bind_param("iss", $id_identitas_siswa, $tgl_ubah, $tgl_ubah);
        $stmt->execute();
        $stmt->close();

        // Update identitas_siswa jadi Lunas
        $stmt2 = $conn->prepare("UPDATE identitas_siswa 
                                 SET status_administrasi = 1, tgl_ubah = ? 
                                 WHERE Id_Identitas_Siswa = ?");
        $stmt2->bind_param("si", $tgl_ubah, $id_identitas_siswa);
        $stmt2->execute();
        $stmt2->close();
    } else {
        // Toggle status
        $newStatus = ($statusNow == 'Lunas') ? 'Belum Lunas' : 'Lunas';
        $stmt = $conn->prepare("UPDATE administrasi SET status = ?, tgl_ubah = ? WHERE id_administrasi = ?");
        $stmt->bind_param("ssi", $newStatus, $tgl_ubah, $id_administrasi);
        $stmt->execute();
        $stmt->close();

        // Update identitas_siswa juga
        $statusAdm = ($newStatus == 'Lunas') ? 1 : 0;
        $stmt2 = $conn->prepare("UPDATE identitas_siswa 
                                 SET status_administrasi = ?, tgl_ubah = ? 
                                 WHERE Id_Identitas_Siswa = ?");
        $stmt2->bind_param("isi", $statusAdm, $tgl_ubah, $id_identitas_siswa);
        $stmt2->execute();
        $stmt2->close();
    }

    $_SESSION['alert'] = '
        <div class="alert alert-success alert-has-icon" id="alert">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <div class="alert-title">Berhasil</div>
                Status pembayaran telah diperbarui.
            </div>
        </div>';
    header('Location: ../../view/administrasi/tampilData.php');
    exit;
}


?>