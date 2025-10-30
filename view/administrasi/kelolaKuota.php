<?php
$title = "Kelola Kuota";

include('../../config/connection.php');

// Update kuota
if (isset($_POST['updateKuota'])) {
    $tkjt = $_POST['kuota_tkjt'];
    $pplg = $_POST['kuota_pplg'];

    mysqli_query($conn, "UPDATE setting_kuota SET kuota_total = '$tkjt' WHERE jurusan = 'TKJT'");
    mysqli_query($conn, "UPDATE setting_kuota SET kuota_total = '$pplg' WHERE jurusan = 'PPLG'");

    $_SESSION['alert'] = '<div class="alert alert-success">Kuota berhasil diupdate!</div>';
    header('Location: kelolaKuota.php');
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM setting_kuota");
$kuota_data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $kuota_data[$row['jurusan']] = $row;
}
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
        <h4>Kelola Kuota Jurusan</h4>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kuota TKJT</label>
                        <input type="number" class="form-control" name="kuota_tkjt"
                            value="<?= $kuota_data['TKJT']['kuota_total'] ?>" required>
                                        <small class="text-muted">Terisi: <?= $kuota_data['TKJT']['kuota_terisi'] ?> siswa</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kuota PPLG</label>
                                        <input type="number" class="form-control" name="kuota_pplg"
                                            value="<?= $kuota_data['PPLG']['kuota_total'] ?>" required>
                                        <small class="text-muted">Terisi: <?= $kuota_data['PPLG']['kuota_terisi'] ?> siswa</small>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="updateKuota" class="btn btn-primary">Update Kuota</button>
                        </form>
                
                        <hr>
                
                        <h5>Statistik Pendaftaran</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-primary">
                                    <div class="card-body">
                                        <h6>TKJT</h6>
                                        <p>Terisi: <?= $kuota_data['TKJT']['kuota_terisi'] ?>/<?= $kuota_data['TKJT']['kuota_total'] ?>
                                        </p>
                                        <div class="progress">
                                            <div class="progress-bar"
                                                style="width: <?= ($kuota_data['TKJT']['kuota_terisi'] / $kuota_data['TKJT']['kuota_total']) * 100 ?>%">
                                                <?= round(($kuota_data['TKJT']['kuota_terisi'] / $kuota_data['TKJT']['kuota_total']) * 100) ?>%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-body">
                                        <h6>PPLG</h6>
                                        <p>Terisi: <?= $kuota_data['PPLG']['kuota_terisi'] ?>/<?= $kuota_data['PPLG']['kuota_total'] ?>
                                        </p>
                                        <div class="progress">
                                            <div class="progress-bar"
                                                style="width: <?= ($kuota_data['PPLG']['kuota_terisi'] / $kuota_data['PPLG']['kuota_total']) * 100 ?>%">
                                                <?= round(($kuota_data['PPLG']['kuota_terisi'] / $kuota_data['PPLG']['kuota_total']) * 100) ?>%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
