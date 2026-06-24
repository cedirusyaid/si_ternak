<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Laporan Perkembangan</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('perkembangan/laporan_add'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Input Laporan</a>
        </div>
    </div>
    <div class="card-body">
        
        <div class="row mb-3">
            <div class="col-md-4">
                <form action="<?php echo site_url('perkembangan/laporan'); ?>" method="get">
                    <div class="input-group">
                        <select name="periode" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Pilih Periode Laporan --</option>
                            <?php 
                            $nama_bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                            foreach($periods as $p): 
                                $period_value = $p->tahun . '-' . $p->bulan;
                                $period_text = $nama_bulan[(int)$p->bulan] . ' ' . $p->tahun;
                                $is_selected = ($period_value == $selected_period) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $period_value; ?>" <?php echo $is_selected; ?>>
                                    <?php echo $period_text; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <?php endif; ?>

        <?php if (!empty($laporan_list)): ?>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="2" class="align-middle text-center">No.</th>
                        <th rowspan="2" class="align-middle text-center">Nama Kelompok</th>
                        <th colspan="5" class="text-center">Perkembangan Populasi</th>
                        <th rowspan="2" class="align-middle text-center">Aksi</th>
                    </tr>
                    <tr>
                        <th class="text-center">Awal</th>
                        <th class="text-center">Lahir</th>
                        <th class="text-center">Mati</th>
                        <th class="text-center">Jual</th>
                        <th class="text-center">Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($laporan_list as $item): ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo $item->nama_kelompok; ?></td>
                        <td class="text-center">
                            <?php echo ($item->populasi_awal_dewasa_jt + $item->populasi_awal_dewasa_bt + $item->populasi_awal_anak_jt + $item->populasi_awal_anak_bt); ?>
                        </td>
                        <td class="text-center"><?php echo ($item->lahir_jt + $item->lahir_bt); ?></td>
                        <td class="text-center">
                            <?php echo ($item->mati_dewasa_jt + $item->mati_dewasa_bt + $item->mati_anak_jt + $item->mati_anak_bt); ?>
                        </td>
                        <td class="text-center"><?php echo ($item->jual_jt + $item->jual_bt); ?></td>
                        <td class="text-center">
                            <?php 
                                $populasi_awal = $item->populasi_awal_dewasa_jt + $item->populasi_awal_dewasa_bt + $item->populasi_awal_anak_jt + $item->populasi_awal_anak_bt;
                                $kelahiran = $item->lahir_jt + $item->lahir_bt;
                                $kematian = $item->mati_dewasa_jt + $item->mati_dewasa_bt + $item->mati_anak_jt + $item->mati_anak_bt;
                                $penjualan = $item->jual_jt + $item->jual_bt;
                                echo ($populasi_awal + $kelahiran - $kematian - $penjualan);
                            ?>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo site_url('perkembangan/laporan_delete/'.$item->id); ?>" onclick="return confirm('Yakin hapus data?');" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Silakan pilih periode laporan untuk menampilkan data.
            </div>
        <?php endif; ?>

    </div>
</div>