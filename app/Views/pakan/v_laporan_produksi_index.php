<!-- application/Views/pakan/v_laporan_produksi_index.php -->

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <div class="box-body">
                <?php if(session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fa fa-check mr-1"></i> Sukses!</h5>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- Filter Form -->
                <form method="get" action="<?= site_url('pakan/laporan_produksi') ?>" id="filterForm" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter-bulan">Filter Bulan</label>
                                <select name="bulan" id="filter-bulan" class="form-control" onchange="document.getElementById('filterForm').submit();">
                                    <option value="all" <?= $selected_bulan == 'all' ? 'selected' : '' ?>>Semua Bulan</option>
                                    <?php 
                                    $months = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    foreach ($months as $num => $name): 
                                    ?>
                                        <option value="<?= $num ?>" <?= $selected_bulan == $num ? 'selected' : '' ?>><?= $name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter-tahun">Filter Tahun</label>
                                <select name="tahun" id="filter-tahun" class="form-control" onchange="document.getElementById('filterForm').submit();">
                                    <option value="all" <?= $selected_tahun == 'all' ? 'selected' : '' ?>>Semua Tahun</option>
                                    <?php 
                                    $current_year = date('Y');
                                    for ($y = 2020; $y <= $current_year + 1; $y++): 
                                    ?>
                                        <option value="<?= $y ?>" <?= $selected_tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>ID Laporan</th>
                                <th>Nama Kelompok</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Total Produksi (KG)</th>
                                <th>Status</th>
                                <th style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($laporan)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada kelompok yang terdaftar</td>
                                </tr>
                            <?php else: ?>
                                <?php 
                                $months = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ];
                                $no = 1; 
                                foreach ($laporan as $row) : 
                                    $is_unsubmitted = empty($row->id_laporan);
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $is_unsubmitted ? '-' : $row->id_laporan; ?></td>
                                        <td><?= htmlspecialchars($row->nama_kelompok); ?></td>
                                        <td>
                                            <?php 
                                            $display_bulan = !$is_unsubmitted ? $row->bulan : ($selected_bulan !== 'all' ? $selected_bulan : '-');
                                            if ($display_bulan !== '-') {
                                                echo isset($months[$display_bulan]) ? $months[$display_bulan] : $display_bulan;
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= !$is_unsubmitted ? $row->tahun : ($selected_tahun !== 'all' ? $selected_tahun : '-'); ?>
                                        </td>
                                        <td><b><?= number_format($row->total_produksi ?: 0, 0, ',', '.'); ?></b></td>
                                        <td>
                                            <?php if ($is_unsubmitted): ?>
                                                <span class="label label-danger">Belum Input</span>
                                            <?php elseif($row->status == 'verified'): ?>
                                                <span class="label label-success">Verified</span>
                                            <?php elseif($row->status == 'submitted'): ?>
                                                <span class="label label-warning">Submitted</span>
                                            <?php else: ?>
                                                <span class="label label-info">Draft</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($is_unsubmitted): ?>
                                                <?php 
                                                $input_url = 'pakan/laporan_produksi_create?id_kelompok=' . $row->id_kelompok;
                                                if ($selected_bulan !== 'all') {
                                                    $input_url .= '&bulan=' . $selected_bulan;
                                                }
                                                if ($selected_tahun !== 'all') {
                                                    $input_url .= '&tahun=' . $selected_tahun;
                                                }
                                                ?>
                                                <a href="<?= site_url($input_url); ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Input Laporan</a>
                                            <?php else: ?>
                                                <a href="#" data-id="<?= $row->id_laporan; ?>" class="btn btn-info btn-xs view-detail-modal"><i class="fa fa-eye"></i> Detail</a>
                                                <a href="<?= site_url('pakan/laporan_produksi_edit/' . $row->id_laporan); ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="<?= site_url('pakan/laporan_produksi_delete/' . $row->id_laporan); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini?');"><i class="fa fa-trash"></i> Hapus</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Laporan -->
<div class="modal fade" id="modalDetailLaporan" tabindex="-1" role="dialog" aria-labelledby="modalDetailLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold text-primary" id="modalDetailLaporanLabel"><i class="fas fa-file-alt mr-1"></i> Detail Laporan Produksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6 border-right">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 40%">ID Laporan</th>
                                <td>: <span id="modal-id-laporan">-</span></td>
                            </tr>
                            <tr>
                                <th>Nama Kelompok</th>
                                <td>: <strong id="modal-nama-kelompok">-</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 pl-md-4">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 40%">Periode Laporan</th>
                                <td>: <span id="modal-periode">-</span></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: <span id="modal-status">-</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <h5 class="text-primary font-weight-bold mb-3"><i class="fas fa-clipboard-list mr-1"></i> Rincian Produksi Pakan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 10%" class="text-center">No</th>
                                <th>Jenis Pakan</th>
                                <th>Jumlah Produksi</th>
                            </tr>
                        </thead>
                        <tbody id="modal-detail-rows">
                            <!-- Rows injected here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/admin_template/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>
<script>
$(document).ready(function() {
    $('.view-detail-modal').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        // Clear previous content
        $('#modal-id-laporan').text('-');
        $('#modal-nama-kelompok').text('-');
        $('#modal-periode').text('-');
        $('#modal-status').html('-');
        $('#modal-detail-rows').html('<tr><td colspan="3" class="text-center"><i class="fa fa-spinner fa-spin mr-1"></i> Memuat data...</td></tr>');
        
        $('#modalDetailLaporan').modal('show');
        
        $.ajax({
            url: "<?= site_url('pakan/laporan_produksi_detail_json/') ?>" + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var l = response.laporan;
                var d = response.detail;
                
                $('#modal-id-laporan').text(l.id_laporan);
                $('#modal-nama-kelompok').text(l.nama_kelompok);
                
                var months = {
                    1: 'Januari', 2: 'Februari', 3: 'Maret', 4: 'April', 
                    5: 'Mei', 6: 'Juni', 7: 'Juli', 8: 'Agustus', 
                    9: 'September', 10: 'Oktober', 11: 'November', 12: 'Desember'
                };
                var monthName = months[l.bulan] || l.bulan;
                $('#modal-periode').text(monthName + ' ' + l.tahun);
                
                var statusBadge = '';
                if (l.status === 'verified') {
                    statusBadge = '<span class="label label-success">Verified</span>';
                } else if (l.status === 'submitted') {
                    statusBadge = '<span class="label label-warning">Submitted</span>';
                } else {
                    statusBadge = '<span class="label label-info">Draft</span>';
                }
                $('#modal-status').html(statusBadge);
                
                var rows = '';
                if (d && d.length > 0) {
                    var idx = 1;
                    $.each(d, function(key, val) {
                        var valProd = val.jumlah_produksi ? parseFloat(val.jumlah_produksi).toLocaleString('id-ID') : '0';
                        rows += '<tr><td class="text-center">' + idx++ + '</td><td>' + val.nama_jenis + '</td><td><b>' + valProd + '</b> ' + (val.satuan || 'KG') + '</td></tr>';
                    });
                } else {
                    rows = '<tr><td colspan="3" class="text-center text-muted">Tidak ada rincian produksi</td></tr>';
                }
                $('#modal-detail-rows').html(rows);
            },
            error: function() {
                $('#modal-detail-rows').html('<tr><td colspan="3" class="text-center text-danger"><i class="fa fa-exclamation-triangle mr-1"></i> Gagal memuat data laporan</td></tr>');
            }
        });
    });
});
</script>