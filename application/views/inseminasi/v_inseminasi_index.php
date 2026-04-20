<!-- application/views/inseminasi/v_inseminasi_index.php -->

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
                <div class="box-tools pull-right">
                    <a href="<?= site_url('inseminasi/tambah_ib') ?>" class="btn btn-primary btn-sm">
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
                    <table id="table-inseminasi" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl IB</th>
                                <th>Nama Hewan</th>
                                <th>Nama Peternak</th>
                                <th>Kecamatan</th>
                                <th>Petugas IB</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($inseminasi)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">Data masih kosong</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach($inseminasi as $ib): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d/m/Y', strtotime($ib->tanggal_ib)) ?></td>
                                    <td><?= $ib->nama_hewan ?></td>
                                    <td><?= $ib->nama_peternak ?></td>
                                    <td><?= $ib->kecamatan ?></td>
                                    <td><?= $ib->nama_petugas ?></td>
                                    <td>
                                        <?php if($ib->status == 'berhasil'): ?>
                                            <span class="label label-success">Berhasil</span>
                                        <?php elseif($ib->status == 'gagal'): ?>
                                            <span class="label label-danger">Gagal</span>
                                        <?php else: ?>
                                            <span class="label label-warning">Menunggu</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-xs">Detail</a>
                                        <a href="<?= site_url('inseminasi/edit_ib/' . $ib->id_ib) ?>" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="<?= site_url('inseminasi/destroy_ib/' . $ib->id_ib) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
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

<script>
// Inisialisasi DataTables jika diperlukan
// $(document).ready(function() {
//     $('#table-inseminasi').DataTable();
// });
</script>
