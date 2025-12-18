<?php
$title = "Kelola Kuota";

include('../../config/connection.php');

// Update kuota
if (isset($_POST['updateKuota'])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'kuota_') === 0) {
            $jurusan = strtoupper(str_replace('kuota_', '', $key));
            mysqli_query($conn, "UPDATE setting_kuota SET kuota_total = '$value' WHERE jurusan = '$jurusan'");
        }
    }

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
                        <?php foreach ($kuota_data as $jurusan => $data): ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kuota <?= $jurusan ?></label>
                                            <input type="number" class="form-control" name="kuota_<?= strtolower($jurusan) ?>"
                                                value="<?= $data['kuota_total'] ?>" required>
                                            <small class="text-muted">Terisi: <?= $data['kuota_terisi'] ?> siswa</small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="submit" name="updateKuota" class="btn btn-primary">Update Kuota</button>
                        </form>

                
                            <hr>
                            <h5>Statistik Pendaftaran</h5>

                            <div class="row">

                            <?php foreach($kuota_data as $jurusan => $data): 
                                $percentage = $data['kuota_total'] > 0 
                                    ? ($data['kuota_terisi'] / $data['kuota_total']) * 100 
                                    : 0;
                            ?>
                                <div class="col-md-6">
                                    <div class="card card-info">
                                        <div class="card-body">
                                            <h6><?= $jurusan ?></h6>
                                            <p>Terisi: <?= $data['kuota_terisi'] ?>/<?= $data['kuota_total'] ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: <?= $percentage ?>%">
                                                    <?= round($percentage) ?>%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
