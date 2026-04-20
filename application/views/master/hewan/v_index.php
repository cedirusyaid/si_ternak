<!-- application/views/master/hewan/v_index.php -->

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
                <div class="box-tools pull-right">
                    <a href="<?= site_url('master/hewan_add') ?>" class="btn btn-primary btn-sm">
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
                    <table id="table-hewan" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Hewan</th>
                                <th>Nama Hewan</th>
                                <th>Pemilik</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($hewan_list as $hewan): ?>
                                <tr>
                                    <td><?= $hewan->id_hewan ?></td>
                                    <td><?= $hewan->nama_hewan ?></td>
                                    <td><?= $hewan->nama_peternak ?></td>
                                    <td><?= ucfirst($hewan->jenis_kelamin) ?></td>
                                    <td><?= date('d/m/Y', strtotime($hewan->tanggal_lahir)) ?></td>
                                    <td><?= ucfirst($hewan->status) ?></td>
                                    <td>
                                        <a href="<?= site_url('master/hewan_edit/' . $hewan->id_hewan) ?>" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="<?= site_url('master/hewan_delete/' . $hewan->id_hewan) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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
