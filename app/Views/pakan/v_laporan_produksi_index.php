<!-- application/Views/pakan/v_laporan_produksi_index.php -->

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
                <div class="box-tools pull-right">
                    <a href="<?= site_url('pakan/laporan_produksi_create') ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah Laporan
                    </a>
                </div>
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
                                    <td colspan="8" class="text-center">Tidak ada data laporan produksi pada periode ini</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($laporan as $row) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row->id_laporan; ?></td>
                                        <td><?= htmlspecialchars($row->nama_kelompok); ?></td>
                                        <td>
                                            <?php 
                                            $months = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            ];
                                            echo isset($months[$row->bulan]) ? $months[$row->bulan] : $row->bulan;
                                            ?>
                                        </td>
                                        <td><?= $row->tahun; ?></td>
                                        <td><b><?= number_format($row->total_produksi, 0, ',', '.'); ?></b></td>
                                        <td>
                                            <?php if($row->status == 'verified'): ?>
                                                <span class="label label-success">Verified</span>
                                            <?php elseif($row->status == 'submitted'): ?>
                                                <span class="label label-warning">Submitted</span>
                                            <?php else: ?>
                                                <span class="label label-info">Draft</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('pakan/laporan_produksi_detail/' . $row->id_laporan); ?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Detail</a>
                                            <a href="<?= site_url('pakan/laporan_produksi_edit/' . $row->id_laporan); ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="<?= site_url('pakan/laporan_produksi_delete/' . $row->id_laporan); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini?');"><i class="fa fa-trash"></i> Hapus</a>
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