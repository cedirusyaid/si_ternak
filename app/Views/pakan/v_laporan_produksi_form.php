<!-- application/Views/pakan/v_laporan_produksi_form.php -->

<?php 
    $is_edit = isset($laporan);
    $action_url = $is_edit ? site_url('pakan/laporan_produksi_update/' . $laporan->id_laporan) : site_url('pakan/laporan_produksi_store');
?>

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit mr-1"></i> <?= $title ?></h3>
            </div>
            <!-- /.card-header -->
            
            <form action="<?= $action_url ?>" method="post" role="form">
                <?= csrf_field() ?>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id_kelompok">Kelompok Ternak</label>
                        <select class="form-control" name="id_kelompok" required>
                            <option value="">-- Pilih Kelompok --</option>
                            <?php foreach ($kelompok as $row) : ?>
                                <option value="<?php echo $row->id_kelompok; ?>" <?= (($is_edit && $laporan->id_kelompok == $row->id_kelompok) || (!$is_edit && isset($default_kelompok) && $default_kelompok == $row->id_kelompok)) ? 'selected' : ''; ?>><?php echo $row->nama_kelompok; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulan">Bulan Laporan</label>
                                <select class="form-control" name="bulan" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    <?php 
                                    $months = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    foreach ($months as $num => $name): 
                                    ?>
                                        <option value="<?= $num ?>" <?= (($is_edit && $laporan->bulan == $num) || (!$is_edit && isset($default_bulan) && $default_bulan == $num) || (!$is_edit && !isset($default_bulan) && date('n') == $num)) ? 'selected' : '' ?>><?= $name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun">Tahun Laporan</label>
                                <input type="number" class="form-control" name="tahun" min="2020" max="<?= date('Y') + 1 ?>" value="<?= $is_edit ? $laporan->tahun : (isset($default_tahun) && !empty($default_tahun) ? $default_tahun : date('Y')); ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h5 class="text-primary font-weight-bold mb-3"><i class="fas fa-clipboard-list mr-1"></i> Detail Jumlah Produksi Pakan</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th>Jenis Pakan</th>
                                    <th style="width: 25%">Kategori</th>
                                    <th style="width: 30%">Jumlah Produksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $existing_details = [];
                                if ($is_edit && isset($detail)) {
                                    foreach ($detail as $d) {
                                        $existing_details[$d->id_jenis_pakan] = $d->jumlah_produksi;
                                    }
                                }
                                
                                $no = 1;
                                foreach ($jenis_pakan as $row) : 
                                    $value = isset($existing_details[$row->id_jenis_pakan]) ? $existing_details[$row->id_jenis_pakan] : '';
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($row->nama_jenis) ?></strong>
                                            <input type="hidden" name="id_jenis_pakan[]" value="<?= $row->id_jenis_pakan ?>">
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary"><?= htmlspecialchars($row->kategori) ?></span>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="jumlah_produksi[]" min="0" placeholder="Masukkan jumlah..." value="<?= $value ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><?= htmlspecialchars($row->satuan) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                
                <div class="card-footer">
                    <a href="<?= site_url('pakan/laporan_produksi') ?>" class="btn btn-default">Batal</a>
                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save mr-1"></i> Simpan Laporan</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>