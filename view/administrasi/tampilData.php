<!-- Header -->
<?php
$title = "Administrasi";
require("../template/header.php");
include('../../config/connection.php');
?>

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
            <h4>Data Administrasi Siswa</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th class="text-center">ID Siswa</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Ubah</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $data = mysqli_query($conn, "
                    SELECT 
                      b.Id_Identitas_Siswa,
                      b.NISN,
                      b.Nama_Peserta_Didik,
                      a.id_administrasi,
                      a.harga,
                      a.status,
                      a.tgl_ubah
                    FROM identitas_siswa b
                    LEFT JOIN administrasi a 
                    ON b.Id_Identitas_Siswa = a.id_identitas_siswa
                    ORDER BY b.Id_Identitas_Siswa ASC
                  ") or die(mysqli_error($conn));

                  foreach ($data as $row) {
                    ?>
                    <tr>
                      <td><?= $row['Id_Identitas_Siswa']; ?></td>
                      <td><?= $row['NISN']; ?></td>
                      <td><?= $row['Nama_Peserta_Didik']; ?></td>
                      <td><?= $row['harga'] ? number_format($row['harga']) : '-'; ?></td>
                      <td>
                        <?php if ($row['status'] == 'Lunas'): ?>
                          <span class="badge badge-success">Lunas</span>
                        <?php else: ?>
                          <span class="badge badge-danger">Belum Lunas</span>
                        <?php endif; ?>
                      </td>
                      <td><?= $row['tgl_ubah'] ?? '-'; ?></td>
                      <td class="text-center">
                        <?php
                        $isLunas = ($row['status'] == 'Lunas');
                        $btnClass = $isLunas ? 'btn-danger' : 'btn-success';
                        $btnText = $isLunas ? '<i class="fas fa-times"></i> Batalkan Lunas' : '<i class="fas fa-check"></i> Tandai Lunas';
                        ?>
                        <form method="POST" action="../../controller/admin/administrasi.php" style="display:inline;">
                          <input type="hidden" name="toggleLunas" value="1">
                          <input type="hidden" name="id_administrasi" value="<?= $row['id_administrasi']; ?>">
                          <input type="hidden" name="id_identitas_siswa" value="<?= $row['Id_Identitas_Siswa']; ?>">
                          <button type="submit" class="btn <?= $btnClass ?> btn-sm"><?= $btnText ?></button>
                        </form>
                      </td>
                    </tr>

                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function () {
    $('#table-1').DataTable();

    // Pass data ke modal
    $('#modalLunas').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var nama = button.data('nama');
      var identitas = button.data('identitas');
      $('#id_administrasi').val(id);
      $('#nama_siswa').val(nama);
      $('#id_identitas_siswa').val(identitas);
    });

  });
</script>

<!-- Footer -->
<?php require("../template/footer.php"); ?>