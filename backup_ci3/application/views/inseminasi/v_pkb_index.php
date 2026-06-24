<!-- application/views/inseminasi/v_pkb_index.php -->

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
                <div class="box-tools pull-right">
                    <a href="<?= site_url('inseminasi/tambah_pkb') ?>" class="btn btn-primary btn-sm">
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
                    <table id="table-pkb" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl PKB</th>
                                <th>Nama Hewan</th>
                                <th>Tgl IB</th>
                                <th>Hasil</th>
                                <th>Umur Bunting (Hari)</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pkb)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">Data masih kosong</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach($pkb as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d/m/Y', strtotime($row->tanggal_pkb)) ?></td>
                                    <td><?= $row->nama_hewan ?> (<?= $row->id_hewan ?>)</td>
                                    <td><?= $row->tanggal_ib ? date('d/m/Y', strtotime($row->tanggal_ib)) : '-' ?></td>
                                    <td>
                                        <?php if($row->hasil_kebuntingan == 'Bunting'): ?>
                                            <span class="label label-success">Bunting</span>
                                        <?php else: ?>
                                            <span class="label label-danger">Tidak Bunting</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $row->umur_kebuntingan ?></td>
                                    <td><?= $row->nama_petugas ?></td>
                                    <td>
                                        <a href="<?= site_url('inseminasi/edit_pkb/' . $row->id_pkb) ?>" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="<?= site_url('inseminasi/destroy_pkb/' . $row->id_pkb) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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
