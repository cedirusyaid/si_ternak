<!-- application/views/inseminasi/v_kelahiran_index.php -->

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
                <div class="box-tools pull-right">
                    <a href="<?= site_url('inseminasi/tambah_kelahiran') ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah Data
                    </a>
                </div>
            </div>
            <div class="box-body">
                <?php if($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table id="table-kelahiran" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl Laporan</th>
                                <th>Tgl Kelahiran</th>
                                <th>Nama Induk</th>
                                <th>Jenis Kelamin Anak</th>
                                <th>Metode Kawin</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($kelahiran)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">Data masih kosong</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach($kelahiran as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d/m/Y', strtotime($row->tgl_laporan)) ?></td>
                                    <td><?= date('d/m/Y', strtotime($row->tgl_kelahiran)) ?></td>
                                    <td><?= $row->nama_hewan ?> (<?= $row->id_hewan ?>)</td>
                                    <td><?= ucfirst($row->jenis_kelamin) ?></td>
                                    <td><?= $row->metode_kawin ?></td>
                                    <td><?= $row->nama_petugas ?></td>
                                    <td>
                                        <a href="<?= site_url('inseminasi/edit_kelahiran/' . $row->id_laporan) ?>" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="<?= site_url('inseminasi/destroy_kelahiran/' . $row->id_laporan) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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
