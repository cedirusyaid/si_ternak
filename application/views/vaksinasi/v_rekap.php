<?php
$month_names = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Total Dosis Vaksinasi</th>
                                <th>Jumlah Kecamatan Terlayani</th>
                                <th>Jumlah Desa Terlayani</th>
                                <th>Jumlah Pemilik Ternak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rekap)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data laporan.</td>
                                </tr>
                            <?php else: 
                                $total_dosis = 0;
                                $total_kecamatan = 0;
                                $total_desa = 0;
                                $total_pemilik = 0;
                                foreach ($rekap as $row): 
                                    $total_dosis += $row->total_vaksinasi;
                                    $total_kecamatan += $row->jumlah_kecamatan;
                                    $total_desa += $row->jumlah_desa;
                                    $total_pemilik += $row->jumlah_pemilik;
                            ?>
                                    <tr>
                                        <td><b><?= $month_names[(int)$row->bulan] . ' ' . $row->tahun ?></b></td>
                                        <td><?= number_format($row->total_vaksinasi, 0, ',', '.') ?></td>
                                        <td><?= number_format($row->jumlah_kecamatan, 0, ',', '.') ?></td>
                                        <td><?= number_format($row->jumlah_desa, 0, ',', '.') ?></td>
                                        <td><?= number_format($row->jumlah_pemilik, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <?php if (!empty($rekap)): ?>
                        <tfoot>
                            <tr style="font-weight: bold;">
                                <td>JUMLAH TOTAL</td>
                                <td><?= number_format($total_dosis, 0, ',', '.') ?></td>
                                <td><?= number_format($total_kecamatan, 0, ',', '.') ?></td>
                                <td><?= number_format($total_desa, 0, ',', '.') ?></td>
                                <td><?= number_format($total_pemilik, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
