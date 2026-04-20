<!-- application/views/master/peternak/v_index.php -->

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
                <div class="box-tools pull-right">
                    <a href="<?= site_url('master/peternak_add') ?>" class="btn btn-primary btn-sm">
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
                    <table id="table-peternak" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Peternak</th>
                                <th>Nama Peternak</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Jumlah Hewan (Aktif)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($peternak_list as $peternak): ?>
                                <tr>
                                    <td><?= $peternak->id_peternak ?></td>
                                    <td><?= $peternak->nama_peternak ?></td>
                                    <td><?= $peternak->alamat ?>, <?= $peternak->desa ?>, <?= $peternak->kecamatan ?></td>
                                    <td><?= $peternak->no_hp ?></td>
                                    <td><span class="badge bg-blue"><?= $peternak->jumlah_hewan ?></span></td>
                                    <td>
                                        <a href="<?= site_url('master/peternak_edit/' . $peternak->id_peternak) ?>" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="<?= site_url('master/peternak_delete/' . $peternak->id_peternak) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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
