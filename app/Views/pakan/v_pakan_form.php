<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php echo isset($pakan) ? form_open('pakan/update/' . $pakan->id_jenis_pakan) : form_open('pakan/store'); ?>
                <div class="form-group">
                    <label for="id_jenis_pakan">ID Jenis Pakan</label>
                    <input type="text" class="form-control" name="id_jenis_pakan" value="<?php echo isset($pakan) ? $pakan->id_jenis_pakan : ''; ?>" <?php echo isset($pakan) ? 'readonly' : ''; ?>>
                </div>
                <div class="form-group">
                    <label for="nama_jenis">Nama Jenis</label>
                    <input type="text" class="form-control" name="nama_jenis" value="<?php echo isset($pakan) ? $pakan->nama_jenis : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select class="form-control" name="kategori">
                        <option value="Silase" <?php echo (isset($pakan) && $pakan->kategori == 'Silase') ? 'selected' : ''; ?>>Silase</option>
                        <option value="Konsentrat" <?php echo (isset($pakan) && $pakan->kategori == 'Konsentrat') ? 'selected' : ''; ?>>Konsentrat</option>
                        <option value="Limbah" <?php echo (isset($pakan) && $pakan->kategori == 'Limbah') ? 'selected' : ''; ?>>Limbah</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <input type="text" class="form-control" name="satuan" value="<?php echo isset($pakan) ? $pakan->satuan : 'KG'; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo site_url('pakan'); ?>" class="btn btn-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>