<div class="card card-primary">
    <div class="card-header"><h3 class="card-title"><?php echo $title; ?></h3></div>
    <?php 
        $action = isset($petugas) ? base_url('master/petugas_edit/'.$petugas->id_petugas) : base_url('master/petugas_add');
        echo form_open($action); 
    ?>
    <div class="card-body">
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
        <div class="form-group">
            <label for="id_petugas">ID Petugas</label>
            <input type="text" class="form-control" name="id_petugas" value="<?php echo isset($petugas) ? $petugas->id_petugas : ''; ?>" <?php echo isset($petugas) ? 'readonly' : 'required'; ?>>
        </div>
        <div class="form-group">
            <label for="nama_petugas">Nama Petugas</label>
            <input type="text" class="form-control" name="nama_petugas" value="<?php echo isset($petugas) ? $petugas->nama_petugas : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" class="form-control" name="nip" value="<?php echo isset($petugas) ? $petugas->nip : ''; ?>">
        </div>
        <div class="form-group">
            <label for="pangkat">Pangkat</label>
            <input type="text" class="form-control" name="pangkat" value="<?php echo isset($petugas) ? $petugas->pangkat : ''; ?>">
        </div>
        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" value="<?php echo isset($petugas) ? $petugas->jabatan : ''; ?>">
        </div>
        <div class="form-group">
            <label for="no_hp">No. HP</label>
            <input type="text" class="form-control" name="no_hp" value="<?php echo isset($petugas) ? $petugas->no_hp : ''; ?>">
        </div>
        <div class="form-group">
            <label for="is_active">Status</label>
            <select name="is_active" class="form-control">
                <option value="1" <?php echo (isset($petugas) && $petugas->is_active == 1) ? 'selected' : ''; ?>>Aktif</option>
                <option value="0" <?php echo (isset($petugas) && $petugas->is_active == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?php echo site_url('master/petugas'); ?>" class="btn btn-secondary">Batal</a>
    </div>
    <?php echo form_close(); ?>
</div>