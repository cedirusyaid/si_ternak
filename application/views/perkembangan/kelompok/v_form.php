<div class="card card-primary">
    <div class="card-header"><h3 class="card-title"><?php echo $title; ?></h3></div>
    <?php 
        $action = isset($kelompok) ? site_url('perkembangan/kelompok_edit/'.$kelompok->id) : site_url('perkembangan/kelompok_add');
        echo form_open($action); 
    ?>
    <?php if(isset($kelompok)) echo '<input type="hidden" name="id" value="'.$kelompok->id.'">'; ?>

    <div class="card-body">
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kode Kelompok</label>
                    <input type="text" class="form-control" name="kode_kelompok" value="<?php echo isset($kelompok) ? $kelompok->kode_kelompok : ''; ?>" <?php echo isset($kelompok) ? 'readonly' : 'required'; ?>>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Kelompok</label>
                    <input type="text" class="form-control" name="nama_kelompok" value="<?php echo isset($kelompok) ? $kelompok->nama_kelompok : ''; ?>" required>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kecamatan</label>
                    <select id="kecamatan" name="kecamatan_id" class="form-control" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        <?php foreach($kecamatan_list as $kec): ?>
                            <option 
                                value="<?php echo $kec->kecamatan_id; // Value adalah ID KECAMATAN ?>"
                                <?php if(isset($kelompok) && $kelompok->kecamatan_id == $kec->kecamatan_id) echo 'selected'; ?>>
                                <?php echo $kec->kecamatan_nama; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Desa</label>
                    <select id="desa" name="desa_id" class="form-control" required>
                        <option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>
                    </select>
                </div>
            </div>
        </div>

        
        <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea class="form-control" name="alamat_lengkap" rows="3"><?php echo isset($kelompok) ? $kelompok->alamat_lengkap : ''; ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <input type="number" class="form-control" name="tahun_anggaran" value="<?php echo isset($kelompok) ? $kelompok->tahun_anggaran : date('Y'); ?>">
                </div>
            </div>
            <div class="col-md-4">
                 <div class="form-group">
                    <label>Sumber Dana</label>
                    <select name="sumber_dana" class="form-control">
                        <?php $sd = isset($kelompok) ? $kelompok->sumber_dana : ''; ?>
                        <option value="APBN" <?php echo ($sd == 'APBN') ? 'selected' : ''; ?>>APBN</option>
                        <option value="APBD I" <?php echo ($sd == 'APBD I') ? 'selected' : ''; ?>>APBD I</option>
                        <option value="APBD II" <?php echo ($sd == 'APBD II') ? 'selected' : ''; ?>>APBD II</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Ras Ternak</label>
                    <select name="rasternak" class="form-control">
                        <?php $rt = isset($kelompok) ? $kelompok->rasternak : ''; ?>
                        <option value="Bali" <?php echo ($rt == 'Bali') ? 'selected' : ''; ?>>Bali</option>
                        <option value="Kambing" <?php echo ($rt == 'Kambing') ? 'selected' : ''; ?>>Kambing</option>
                        <option value="Sapi Perah" <?php echo ($rt == 'Sapi Perah') ? 'selected' : ''; ?>>Sapi Perah</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?php echo site_url('perkembangan/kelompok'); ?>" class="btn btn-secondary">Batal</a>
    </div>
    <?php echo form_close(); ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    function loadDesa(kecamatan_id, selected_desa_id = '') {
        var desa_dd = $('#desa');
        desa_dd.html('<option value="">Loading...</option>');
        
        $.ajax({
            url: "<?php echo site_url('perkembangan/get_desa_by_kecamatan'); ?>",
            type: 'POST',
            dataType: 'json',
            data: {kecamatan_id: kecamatan_id},
            success: function(response) {
                desa_dd.html('<option value="">-- Pilih Desa --</option>');
                $.each(response, function(key, value) {
                    var is_selected = (value.desa_id == selected_desa_id) ? 'selected' : '';
                    // PERBAIKAN: value adalah 'desa_id', text adalah 'desa_nama'
                    desa_dd.append('<option value="' + value.desa_id + '" ' + is_selected + '>' + value.desa_nama + '</option>');
                });
            },
            error: function() { desa_dd.html('<option value="">Gagal memuat data</option>'); }
        });
    }

    $('#kecamatan').on('change', function() {
        var kecamatan_id = $(this).val();
        if (kecamatan_id) {
            loadDesa(kecamatan_id);
        } else {
            $('#desa').html('<option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>');
        }
    });

    // PERBAIKAN: Untuk mode edit, gunakan ID
    <?php if (isset($kelompok) && !empty($kelompok->kecamatan_id)): ?>
        var selected_desa_id = "<?php echo $kelompok->desa_id; ?>";
        var kecamatan_id_on_load = $('#kecamatan').val();
        
        if(kecamatan_id_on_load){
             loadDesa(kecamatan_id_on_load, selected_desa_id);
        }
    <?php endif; ?>
});
</script>