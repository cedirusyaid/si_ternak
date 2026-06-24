<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <div class="box-body">
                <form action="<?= site_url('vaksinasi/rekap_petugas') ?>" method="get" class="form-inline mb-4">
                    <div class="form-group">
                        <label for="periode" class="mr-2">Periode:</label>
                        <select name="periode" id="periode" class="form-control mr-2">
                            <option value="">Semua Periode</option>
                            <?php 
                                $month_names = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                foreach ($grouped_periods as $tahun => $bulan_list):
                            ?>
                                <optgroup label="<?= $tahun ?>">
                                    <?php foreach ($bulan_list as $bulan):
                                        $period_val = $bulan . '-' . $tahun;
                                        $period_text = $month_names[(int)$bulan];
                                    ?>
                                        <option value="<?= $period_val ?>" <?= ($selected_period == $period_val) ? 'selected' : '' ?>><?= $period_text ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Petugas</th>
                                <th>Total Dosis Vaksinasi</th>
                                <th>Jangkauan Kecamatan</th>
                                <th>Jangkauan Desa</th>
                                <th>Vaksinasi Pertama</th>
                                <th>Vaksinasi Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rekap)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data laporan.</td>
                                </tr>
                            <?php else: 
                                $total_dosis = 0;
                                foreach ($rekap as $row): 
                                $total_dosis += $row->total_vaksinasi;
                            ?>
                                    <tr>
                                        <td><b><?= $row->namapetugas ?></b></td>
                                        <td><?= number_format($row->total_vaksinasi, 0, ',', '.') ?></td>
                                        <td><?= number_format($row->jumlah_kecamatan, 0, ',', '.') ?></td>
                                        <td><?= number_format($row->jumlah_desa, 0, ',', '.') ?></td>
                                        <td><?= date('d/m/Y', strtotime($row->vaksinasi_pertama)) ?></td>
                                        <td><?= date('d/m/Y', strtotime($row->vaksinasi_terakhir)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <?php if (!empty($rekap)): ?>
                        <tfoot>
                            <tr style="font-weight: bold;">
                                <td>JUMLAH TOTAL</td>
                                <td><?= number_format($total_dosis, 0, ',', '.') ?></td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
