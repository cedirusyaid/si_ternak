<!-- application/Views/inseminasi/v_inseminasi_detail.php -->

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Detail Inseminasi Buatan</h3>
                <div class="card-tools">
                    <a href="<?= site_url('inseminasi/edit_ib/' . $ib->id_ib) ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit Data
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <h5 class="text-primary font-weight-bold mb-3"><i class="fas fa-venus-mars mr-1"></i> Data Inseminasi</h5>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th style="width: 40%">ID Inseminasi</th>
                                <td>: <strong><?= $ib->id_ib ?></strong></td>
                            </tr>
                            <tr>
                                <th>Tanggal IB</th>
                                <td>: <?= date('d F Y', strtotime($ib->tanggal_ib)) ?></td>
                            </tr>
                            <tr>
                                <th>Inseminasi Ke-</th>
                                <td>: <span class="badge badge-info">Ke-<?= $ib->ib_ke ?></span></td>
                            </tr>
                            <tr>
                                <th>ID Pejantan</th>
                                <td>: <?= $ib->id_pejantan ?: '<span class="text-muted">-</span>' ?></td>
                            </tr>
                            <tr>
                                <th>Bangsa Pejantan</th>
                                <td>: <?= $ib->bangsa_pejantan ?: '<span class="text-muted">-</span>' ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: 
                                    <?php if($ib->status == 'berhasil'): ?>
                                        <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>Berhasil</span>
                                    <?php elseif($ib->status == 'gagal'): ?>
                                        <span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i>Gagal</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning"><i class="fas fa-hourglass-half mr-1"></i>Menunggu</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6 pl-md-4">
                        <h5 class="text-primary font-weight-bold mb-3"><i class="fas fa-paw mr-1"></i> Data Hewan & Pemilik</h5>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th style="width: 40%">ID Hewan</th>
                                <td>: <strong><?= $ib->id_hewan ?></strong></td>
                            </tr>
                            <tr>
                                <th>Nama Hewan</th>
                                <td>: <?= $ib->nama_hewan ?></td>
                            </tr>
                            <tr>
                                <th>Pemilik (Peternak)</th>
                                <td>: <?= $ib->nama_peternak ?> (<?= $ib->id_peternak ?>)</td>
                            </tr>
                            <tr>
                                <th>Kecamatan Pemilik</th>
                                <td>: <?= $ib->peternak_kecamatan ?: '<span class="text-muted">-</span>' ?></td>
                            </tr>
                            <tr>
                                <th>Desa Pemilik</th>
                                <td>: <?= $ib->peternak_desa ?: '<span class="text-muted">-</span>' ?></td>
                            </tr>
                            <tr>
                                <th>Alamat Pemilik</th>
                                <td>: <?= $ib->alamat ?: '<span class="text-muted">-</span>' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <hr class="mt-4">
                
                <div class="row">
                    <div class="col-md-6 border-right">
                        <h5 class="text-secondary font-weight-bold mb-3"><i class="fas fa-user-tie mr-1"></i> Petugas Inseminator</h5>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th style="width: 40%">Nama Petugas</th>
                                <td>: <?= $ib->nama_petugas ?: '<span class="text-muted">Tidak Diketahui</span>' ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6 pl-md-4">
                        <h5 class="text-secondary font-weight-bold mb-3"><i class="fas fa-history mr-1"></i> Metadata</h5>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th style="width: 40%">Dibuat Oleh</th>
                                <td>: <?= !empty($ib->nama_pembuat) ? $ib->nama_pembuat : '<span class="text-muted">Administrator</span>' ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Input</th>
                                <td>: <?= date('d/m/Y H:i', strtotime($ib->created_at)) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="<?= site_url('inseminasi') ?>" class="btn btn-default">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                </a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</div>
