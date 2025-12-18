<?php
$title = "Dokumen Pendukung";
require("../template/header.php");
include('../../config/connection.php');

// Define mata pelajaran options
$mataPelajaranList = [
    'Pendidikan Agama',
    'Pendidikan Kewarganegaraan',
    'Bahasa Indonesia',
    'Bahasa Inggris',
    'Matematika'
];

// Define jenis dokumen options
$jenisDokumenList = [
    'KK',
    'Akte Kelahiran',
    'Kartu NISN',
    'Ijazah',
    'KTP Orang Tua',
    'Pas Foto',
    'Nilai',
    'Transkrip'
];
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tableDataSiswa">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID Siswa</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th class="text-center">Dokumen</th>
                                        <th class="text-center">Nilai</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $siswa = mysqli_query($conn, "
                                        SELECT 
                                            s.Id_Identitas_Siswa,
                                            s.NISN,
                                            s.Nama_Peserta_Didik,
                                            COUNT(DISTINCT d.id_dokumen) as jumlah_dokumen,
                                            COUNT(DISTINCT n.id_nilai) as jumlah_nilai
                                        FROM identitas_siswa s
                                        LEFT JOIN dokumen_siswa d ON s.Id_Identitas_Siswa = d.id_siswa
                                        LEFT JOIN nilai_rapor n ON s.Id_Identitas_Siswa = n.id_siswa
                                        GROUP BY s.Id_Identitas_Siswa
                                        ORDER BY s.Id_Identitas_Siswa DESC
                                    ");

                                    while ($row = mysqli_fetch_assoc($siswa)) {
                                        $q_transkrip = mysqli_query($conn, "
                                            SELECT COUNT(*) as jumlah 
                                            FROM dokumen_siswa 
                                            WHERE id_siswa = '{$row['Id_Identitas_Siswa']}' 
                                            AND jenis_dokumen LIKE 'Transkrip Semester%'
                                        ");
                                        $transkrip = mysqli_fetch_assoc($q_transkrip);
                                        ?>
                                        <tr>
                                            <td><?= $row['Id_Identitas_Siswa']; ?></td>
                                            <td><?= $row['NISN'] ?: '-'; ?></td>
                                            <td><strong><?= $row['Nama_Peserta_Didik']; ?></strong></td>
                                            <td class="text-center">
                                                <?php if ($row['jumlah_dokumen'] > 0): ?>
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-file"></i> <?= $row['jumlah_dokumen']; ?>
                                                    </span>
                                                    <?php if ($transkrip['jumlah'] > 0): ?>
                                                        <small class="d-block text-muted">
                                                            Transkrip: <?= $transkrip['jumlah']; ?> semester
                                                        </small>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">
                                                        <i class="fas fa-times"></i> 0
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($row['jumlah_nilai'] > 0): ?>
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-list-ol"></i> <?= $row['jumlah_nilai']; ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">
                                                        <i class="fas fa-times"></i> 0
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-info btn-sm lihatDetailBtn"
                                                        data-id="<?= $row['Id_Identitas_Siswa']; ?>"
                                                        data-nama="<?= htmlspecialchars($row['Nama_Peserta_Didik']); ?>"
                                                        data-toggle="modal" data-target="#modalDetail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
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

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-graduate"></i> Detail Siswa — <span id="detail_nama_siswa"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="detail_id_siswa">

                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" id="detailTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="nilai-tab" data-toggle="tab" href="#nilaiContent">
                            <i class="fas fa-chart-line"></i> Nilai
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dokumen-tab" data-toggle="tab" href="#dokumenContent">
                            <i class="fas fa-folder"></i> Dokumen
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="detailTabContent">
                    <!-- TAB NILAI -->
                    <div class="tab-pane fade show active" id="nilaiContent">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="col-md-4 pl-0">
                                <label>Filter Semester</label>
                                <select id="filter_semester_detail" class="form-control">
                                    <option value="">-- Semua Semester --</option>
                                    <?php for ($i = 1; $i <= 6; $i++): ?>
                                        <option value="<?= $i; ?>">Semester <?= $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary" id="btnTambahNilai">
                                <i class="fas fa-plus"></i> Tambah Nilai
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th>Semester</th>
                                        <th>Mata Pelajaran</th>
                                        <th class="text-center">Nilai</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="detailNilaiContent">
                                    <tr>
                                        <td colspan="4" class="text-center">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB DOKUMEN -->
                    <div class="tab-pane fade" id="dokumenContent">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="col-md-4 pl-0">
                                <label>Filter Semester</label>
                                <select id="filter_semester_dokumen" class="form-control">
                                    <option value="">-- Semua Semester --</option>
                                    <?php for ($i = 1; $i <= 6; $i++): ?>
                                        <option value="<?= $i; ?>">Semester <?= $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary" id="btnTambahDokumen">
                                <i class="fas fa-plus"></i> Tambah Dokumen
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>Jenis Dokumen</th>
                                        <th>Nama File</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="detailDokumenContent">
                                    <tr>
                                        <td colspan="3" class="text-center">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH/EDIT NILAI -->
<div class="modal fade" id="modalNilai" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNilaiTitle"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formNilai">
                <div class="modal-body">
                    <input type="hidden" name="action" id="nilai_action" value="add_nilai">
                    <input type="hidden" id="nilai_id_siswa" name="id_siswa_nilai">
                    <input type="hidden" id="nilai_id" name="id_nilai">

                    <div class="form-group">
                        <label for="nilai_semester">Semester <span class="text-danger">*</span></label>
                        <select class="form-control" id="nilai_semester" name="semester" required>
                            <option value="">-- Pilih Semester --</option>
                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                <option value="<?= $i; ?>">Semester <?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nilai_mata_pelajaran">Mata Pelajaran <span class="text-danger">*</span></label>
                        <select class="form-control" id="nilai_mata_pelajaran" name="mata_pelajaran" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            <?php foreach ($mataPelajaranList as $mapel): ?>
                                <option value="<?= $mapel; ?>"><?= $mapel; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nilai_nilai">Nilai (0-100) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nilai_nilai" name="nilai" min="0" max="100"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH DOKUMEN -->
<div class="modal fade" id="modalDokumen" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formDokumen" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_dokumen">
                    <input type="hidden" id="dokumen_id_siswa" name="id_siswa_dokumen">

                    <div class="form-group">
                        <label for="dokumen_jenis">Jenis Dokumen <span class="text-danger">*</span></label>
                        <select class="form-control" id="dokumen_jenis" name="jenis_dokumen" required>
                            <option value="">-- Pilih Jenis Dokumen --</option>
                            <?php foreach ($jenisDokumenList as $jenis): ?>
                                <option value="<?= $jenis; ?>"><?= $jenis; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" id="semester_group" style="display: none;">
                        <label for="dokumen_semester">Semester <span class="text-danger">*</span></label>
                        <select class="form-control" id="dokumen_semester" name="semester">
                            <option value="">-- Pilih Semester --</option>
                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                <option value="<?= $i; ?>">Semester <?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <small class="text-muted">Wajib diisi untuk dokumen transkrip</small>
                    </div>

                    <div class="form-group">
                        <label for="dokumen_file">File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="dokumen_file" name="file_dokumen" required
                            accept=".pdf,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">Format: PDF, JPG, PNG (Max: 5MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTable
        $('#tableDataSiswa').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)"
            }
        });

        // Show/hide semester field based on document type
        $('#dokumen_jenis').change(function () {
            if ($(this).val() === 'Transkrip') {
                $('#semester_group').show();
                $('#dokumen_semester').prop('required', true);
            } else {
                $('#semester_group').hide();
                $('#dokumen_semester').prop('required', false);
                $('#dokumen_semester').val('');
            }
        });

        // Modal Detail - Load data when opened
        $(document).on('click', '.lihatDetailBtn', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');

            $('#detail_id_siswa').val(id);
            $('#detail_nama_siswa').text(nama);

            // Reset tabs
            $('#nilai-tab').tab('show');

            // Load data
            loadNilaiData(id);
            loadDokumenData(id);
        });

        // Filter semester (nilai)
        $('#filter_semester_detail').change(function () {
            const semester = $(this).val();
            const id = $('#detail_id_siswa').val();
            loadNilaiData(id, semester);
        });

        // Filter semester (dokumen)
        $('#filter_semester_dokumen').change(function () {
            const semester = $(this).val();
            const id = $('#detail_id_siswa').val();
            loadDokumenData(id, semester);
        });

        // Button tambah nilai
        $('#btnTambahNilai').click(function () {
            const id = $('#detail_id_siswa').val();

            $('#modalNilaiTitle').text('Tambah Nilai');
            $('#nilai_action').val('add_nilai');
            $('#nilai_id_siswa').val(id);
            $('#nilai_id').val('');
            $('#nilai_semester').val('');
            $('#nilai_mata_pelajaran').val('');
            $('#nilai_nilai').val('');

            $('#modalNilai').modal('show');
        });

        // Button tambah dokumen
        $('#btnTambahDokumen').click(function () {
            const id = $('#detail_id_siswa').val();

            $('#dokumen_id_siswa').val(id);
            $('#dokumen_jenis').val('').trigger('change');
            $('#dokumen_semester').val('');
            $('#dokumen_file').val('');

            $('#modalDokumen').modal('show');
        });

        // Submit form nilai
        $('#formNilai').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: '../../controller/admin/dokumen.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#modalNilai').modal('hide');
                        const id = $('#detail_id_siswa').val();
                        loadNilaiData(id);
                        alert(response.message);
                    } else {
                        alert(response.message || 'Gagal menyimpan nilai');
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr);
                    alert('Terjadi kesalahan saat menyimpan nilai');
                }
            });
        });

        // Submit form dokumen
        $('#formDokumen').submit(function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '../../controller/admin/dokumen.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#modalDokumen').modal('hide');
                        const id = $('#detail_id_siswa').val();
                        loadDokumenData(id);
                        alert(response.message);
                    } else {
                        alert(response.message || 'Gagal upload dokumen');
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr);
                    alert('Terjadi kesalahan saat upload dokumen');
                }
            });
        });

        // Load data nilai
        function loadNilaiData(id, semester = '') {
            $.ajax({
                url: './get_nilai_simple.php',
                type: 'GET',
                data: {
                    id_siswa: id,
                    semester: semester
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        let html = '';

                        if (response.data.length > 0) {
                            response.data.forEach(item => {
                                let badgeClass = 'secondary';
                                if (item.nilai >= 85) badgeClass = 'success';
                                else if (item.nilai >= 70) badgeClass = 'primary';
                                else if (item.nilai >= 60) badgeClass = 'warning';
                                else badgeClass = 'danger';

                                html += `
                                <tr>
                                    <td>Semester ${item.semester}</td>
                                    <td>${item.mata_pelajaran}</td>
                                    <td class="text-center">
                                        <span class="badge badge-${badgeClass}" style="font-size: 14px; padding: 5px 10px;">
                                            ${item.nilai}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-warning btn-edit-nilai" 
                                                data-id="${item.id_nilai}"
                                                data-semester="${item.semester}"
                                                data-mata-pelajaran="${item.mata_pelajaran}"
                                                data-nilai="${item.nilai}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-hapus-nilai" 
                                                data-id="${item.id_nilai}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            });
                        } else {
                            html = '<tr><td colspan="4" class="text-center text-muted">Tidak ada data nilai</td></tr>';
                        }

                        $('#detailNilaiContent').html(html);
                    } else {
                        $('#detailNilaiContent').html('<tr><td colspan="4" class="text-center text-danger">Gagal memuat data</td></tr>');
                    }
                },
                error: function (xhr) {
                    console.error('Error loading nilai:', xhr);
                    $('#detailNilaiContent').html('<tr><td colspan="4" class="text-center text-danger">Terjadi kesalahan</td></tr>');
                }
            });
        }

        // Load data dokumen
        function loadDokumenData(id, semester = '') {
            $.ajax({
                url: './get_dokumen_simple.php',
                type: 'GET',
                data: {
                    id_siswa: id,
                    semester: semester
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        let html = '';

                        if (response.data.length > 0) {
                            response.data.forEach(item => {
                                html += `
                                <tr>
                                    <td>${item.jenis_dokumen}</td>
                                    <td>${item.nama_file}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="${item.url}" target="_blank" class="btn btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="${item.url}" download class="btn btn-success" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button class="btn btn-danger btn-hapus-dokumen" 
                                                data-id="${item.id_dokumen}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            });
                        } else {
                            html = '<tr><td colspan="3" class="text-center text-muted">Tidak ada data dokumen</td></tr>';
                        }

                        $('#detailDokumenContent').html(html);
                    } else {
                        $('#detailDokumenContent').html('<tr><td colspan="3" class="text-center text-danger">Gagal memuat data</td></tr>');
                    }
                },
                error: function (xhr) {
                    console.error('Error loading dokumen:', xhr);
                    $('#detailDokumenContent').html('<tr><td colspan="3" class="text-center text-danger">Terjadi kesalahan</td></tr>');
                }
            });
        }

        // Edit nilai
        $(document).on('click', '.btn-edit-nilai', function () {
            $('#modalNilaiTitle').text('Edit Nilai');
            $('#nilai_action').val('edit_nilai');
            $('#nilai_id').val($(this).data('id'));
            $('#nilai_semester').val($(this).data('semester'));
            $('#nilai_mata_pelajaran').val($(this).data('mata-pelajaran'));
            $('#nilai_nilai').val($(this).data('nilai'));

            $('#modalNilai').modal('show');
        });

        // Hapus nilai
        $(document).on('click', '.btn-hapus-nilai', function () {
            if (!confirm('Apakah Anda yakin ingin menghapus nilai ini?')) return;

            const id = $(this).data('id');
            const siswaId = $('#detail_id_siswa').val();

            $.ajax({
                url: '../../controller/admin/dokumen.php',
                type: 'POST',
                data: {
                    action: 'delete_nilai',
                    hapus_id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        loadNilaiData(siswaId);
                        alert(response.message);
                    } else {
                        alert(response.message || 'Gagal menghapus nilai');
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr);
                    alert('Terjadi kesalahan saat menghapus nilai');
                }
            });
        });

        // Hapus dokumen
        $(document).on('click', '.btn-hapus-dokumen', function () {
            if (!confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) return;

            const id = $(this).data('id');
            const siswaId = $('#detail_id_siswa').val();

            $.ajax({
                url: '../../controller/admin/dokumen.php',
                type: 'POST',
                data: {
                    action: 'delete_dokumen',
                    hapus_id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        loadDokumenData(siswaId);
                        alert(response.message);
                    } else {
                        alert(response.message || 'Gagal menghapus dokumen');
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr);
                    alert('Terjadi kesalahan saat menghapus dokumen');
                }
            });
        });
    });
</script>

<?php require("../template/footer.php"); ?>