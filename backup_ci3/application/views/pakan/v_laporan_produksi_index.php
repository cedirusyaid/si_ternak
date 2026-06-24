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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID Laporan</th>
                                <th>Nama Kelompok</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Total Produksi (KG)</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($laporan as $row) : ?>
                                <tr>
                                    <td><?= $row->id_laporan; ?></td>
                                    <td><?= $row->nama_kelompok; ?></td>
                                    <td><?= $row->bulan; ?></td>
                                    <td><?= $row->tahun; ?></td>
                                    <td><b><?= number_format($row->total_produksi, 0, ',', '.'); ?></b></td>
                                    <td><span class="label label-info"><?= $row->status; ?></span></td>
                                    <td>
                                        <a href="<?= site_url('pakan/laporan_produksi_detail/' . $row->id_laporan); ?>" class="btn btn-info btn-xs">Detail</a>
                                        <a href="<?= site_url('pakan/laporan_produksi_edit/' . $row->id_laporan); ?>" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="<?= site_url('pakan/laporan_produksi_delete/' . $row->id_laporan); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>