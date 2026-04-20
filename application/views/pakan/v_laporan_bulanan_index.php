<?php
$month_names = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$nama_bulan = isset($selected_bulan) ? $month_names[(int)$selected_bulan] : '';
$nama_tahun = isset($selected_tahun) ? $selected_tahun : '';

// Inisialisasi total kolom
$column_totals = [];
foreach ($all_jenis_pakan as $jp) {
    $column_totals[$jp->nama_jenis] = 0;
}
$grand_total_jumlah = 0;
?>

<style>
    .report-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .report-header h4, .report-header h5, .report-header p {
        margin: 0;
    }
    .table-report th, .table-report td {
        text-align: center;
        vertical-align: middle !important;
    }
    .text-left {
        text-align: left !important;
    }
    .font-weight-bold {
        font-weight: bold;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <form action="<?= site_url('pakan/laporan_bulanan') ?>" method="get" class="form-inline">
                        <div class="form-group">
                            <label for="periode" class="mr-2">Periode:</label>
                            <select name="periode" id="periode" class="form-control mr-2">
                                <option value="">-- Pilih Periode --</option>
                                <?php foreach ($grouped_periods as $tahun => $bulan_list): ?>
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
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>
                    <button onclick="window.print();" class="btn btn-success"><i class="fa fa-print"></i> Cetak</button>
                </div>

                <?php if (!empty($selected_period)): ?>
                <div class="report-header">
                    <h5><b>PEMERINTAH KABUPATEN SINJAI</b></h5>
                    <h4><b>DINAS PETERNAKAN DAN KESEHATAN HEWAN</b></h4>
                    <p>Laporan Produksi Pakan pada Unit Pengolahan Pakan Silase dan Konsentrat</p>
                    <p>Bulan: <?= $nama_bulan ?> <?= $nama_tahun ?></p>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-report">
                        <thead>
                            <tr>
                                <th rowspan="2">NO</th>
                                <th rowspan="2">KECAMATAN</th>
                                <th rowspan="2">NAMA KELOMPOK</th>
                                <th rowspan="2">ALAMAT</th>
                                <th colspan="<?= count($all_jenis_pakan) ?>">PRODUKSI (KG)</th>
                                <th rowspan="2">JUMLAH (KG)</th>
                            </tr>
                            <tr>
                                <?php foreach ($all_jenis_pakan as $jp): ?>
                                    <th><?= strtoupper($jp->nama_jenis) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($laporan)): ?>
                                <tr>
                                    <td colspan="<?= 5 + count($all_jenis_pakan) ?>">Data tidak ditemukan untuk periode yang dipilih.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($laporan as $kecamatan => $kelompok_list): ?>
                                    <?php $first_row = true; foreach ($kelompok_list as $kelompok => $data): ?>
                                        <tr>
                                            <?php if ($first_row): ?>
                                                <td rowspan="<?= count($kelompok_list) ?>"><?= $no++ ?></td>
                                                <td rowspan="<?= count($kelompok_list) ?>"><?= $kecamatan ?></td>
                                            <?php endif; ?>
                                            <td class="text-left"><?= $kelompok ?></td>
                                            <td class="text-left"><?= $data['alamat'] ?></td>
                                            <?php 
                                                $row_total = 0;
                                                foreach ($all_jenis_pakan as $jp) {
                                                    $jumlah = isset($data[$jp->nama_jenis]) ? $data[$jp->nama_jenis] : 0;
                                                    echo '<td>' . number_format($jumlah, 0, ',', '.') . '</td>';
                                                    $row_total += $jumlah;
                                                    $column_totals[$jp->nama_jenis] += $jumlah;
                                                }
                                                $grand_total_jumlah += $row_total;
                                            ?>
                                            <td class="font-weight-bold"><?= number_format($row_total, 0, ',', '.') ?></td>
                                        </tr>
                                    <?php $first_row = false; endforeach; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td colspan="4">JUMLAH</td>
                                <?php foreach ($all_jenis_pakan as $jp): ?>
                                    <td><?= number_format($column_totals[$jp->nama_jenis], 0, ',', '.') ?></td>
                                <?php endforeach; ?>
                                <td><?= number_format($grand_total_jumlah, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
