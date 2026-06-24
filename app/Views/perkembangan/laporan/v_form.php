<div class="card card-primary">
    <div class="card-header"><h3 class="card-title"><?php echo $title; ?></h3></div>
    <?php echo form_open('perkembangan/laporan_add'); ?>
    <div class="card-body">
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Kelompok Ternak</label>
                    <select name="kelompok_id" class="form-control" required>
                        <option value="">-- Pilih Kelompok --</option>
                        <?php foreach($kelompok_list as $k): ?>
                            <option value="<?php echo $k->id; ?>"><?php echo $k->nama_kelompok; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Bulan</label>
                    <select name="bulan" class="form-control" required>
                        <?php
                        $bulan_sekarang = date('n'); // Ambil angka bulan ini (1-12)
                        for ($i = 1; $i <= 12; $i++) {
                            $selected = ($i == $bulan_sekarang) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                 <div class="form-group">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="<?php echo date('Y'); ?>" required>
                </div>
            </div>
        </div>

        <hr>
        <h5><i class="fas fa-edit"></i> Detail Laporan</h5>
        
        <div class="card card-outline card-info">
            <div class="card-header"><h3 class="card-title">A. Populasi Awal Bulan</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <div class="form-group">
                            <label>Dewasa Jantan</label>
                            <input type="number" name="populasi_awal_dewasa_jt" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            <label>Anak Jantan</label>
                            <input type="number" name="populasi_awal_anak_jt" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Dewasa Betina</label>
                            <input type="number" name="populasi_awal_dewasa_bt" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            <label>Anak Betina</label>
                            <input type="number" name="populasi_awal_anak_bt" class="form-control" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card card-outline card-success">
            <div class="card-header"><h3 class="card-title">B. Perkembangan</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <label>1. Kelahiran</label>
                        <div class="form-group">
                            <label class="font-weight-normal">Jantan</label>
                            <input type="number" name="lahir_jt" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-normal">Betina</label>
                            <input type="number" name="lahir_bt" class="form-control" value="0">
                        </div>
                        <hr>
                        <label>2. Kematian Dewasa</label>
                        <div class="form-group">
                            <label class="font-weight-normal">Jantan</label>
                            <input type="number" name="mati_dewasa_jt" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-normal">Betina</label>
                            <input type="number" name="mati_dewasa_bt" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>3. Kematian Anak</label>
                        <div class="form-group">
                            <label class="font-weight-normal">Jantan</label>
                            <input type="number" name="mati_anak_jt" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-normal">Betina</label>
                            <input type="number" name="mati_anak_bt" class="form-control" value="0">
                        </div>
                        <hr>
                        <label>4. Ternak Dijual</label>
                        <div class="form-group">
                            <label class="font-weight-normal">Jantan</label>
                            <input type="number" name="jual_jt" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-normal">Betina</label>
                            <input type="number" name="jual_bt" class="form-control" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" name="keterangan"></textarea>
        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan Laporan</button>
        <a href="<?php echo site_url('perkembangan/laporan'); ?>" class="btn btn-secondary">Batal</a>
    </div>
    <?php echo form_close(); ?>
</div>