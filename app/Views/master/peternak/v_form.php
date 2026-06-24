<!-- application/views/master/peternak/v_form.php -->

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <?php 
                $is_edit = isset($peternak);
                $action_url = $is_edit ? site_url('master/peternak_edit/' . $peternak->id_peternak) : site_url('master/peternak_add');
            ?>
            <form action="<?= $action_url ?>" method="post" role="form">
                <?= csrf_field() ?>
                <div class="box-body">
                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="id_peternak">ID Peternak</label>
                        <input type="text" class="form-control" id="id_peternak" name="id_peternak" 
                               value="<?= $is_edit ? $peternak->id_peternak : set_value('id_peternak') ?>" 
                               <?= $is_edit ? 'readonly' : '' ?> required>
                    </div>
                    <div class="form-group">
                        <label for="nama_peternak">Nama Peternak</label>
                        <input type="text" class="form-control" id="nama_peternak" name="nama_peternak" 
                               value="<?= $is_edit ? $peternak->nama_peternak : set_value('nama_peternak') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No. HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" 
                               value="<?= $is_edit ? $peternak->no_hp : set_value('no_hp') ?>">
                    </div>
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" 
                               value="<?= $is_edit ? $peternak->kecamatan : set_value('kecamatan') ?>">
                    </div>
                    <div class="form-group">
                        <label for="desa">Desa/Kelurahan</label>
                        <input type="text" class="form-control" id="desa" name="desa" 
                               value="<?= $is_edit ? $peternak->desa : set_value('desa') ?>">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $is_edit ? $peternak->alamat : set_value('alamat') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="id_kelompok">Kelompok Ternak</label>
                        <select name="id_kelompok" id="id_kelompok" class="form-control">
                            <option value="">-- Pilih Kelompok (Opsional) --</option>
                            <?php foreach ($kelompok_list as $k): ?>
                                <option value="<?= $k->id ?>" <?= ($is_edit && $k->id == $peternak->id_kelompok) ? 'selected' : '' ?>><?= $k->nama_kelompok ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun_anggaran">Tahun Anggaran Bantuan</label>
                        <input type="number" class="form-control" id="tahun_anggaran" name="tahun_anggaran" placeholder="Contoh: <?= date('Y') ?>" value="<?= $is_edit ? $peternak->tahun_anggaran : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="sumber_dana">Sumber Dana Bantuan</label>
                        <select name="sumber_dana" id="sumber_dana" class="form-control">
                            <option value="">-- Pilih Sumber Dana (Opsional) --</option>
                            <option value="APBN" <?= ($is_edit && $peternak->sumber_dana == 'APBN') ? 'selected' : '' ?>>APBN</option>
                            <option value="APBD I" <?= ($is_edit && $peternak->sumber_dana == 'APBD I') ? 'selected' : '' ?>>APBD I</option>
                            <option value="APBD II" <?= ($is_edit && $peternak->sumber_dana == 'APBD II') ? 'selected' : '' ?>>APBD II</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ras_ternak">Ras Ternak Bantuan</label>
                        <select name="ras_ternak" id="ras_ternak" class="form-control">
                            <option value="">-- Pilih Ras Ternak (Opsional) --</option>
                            <option value="Bali" <?= ($is_edit && $peternak->ras_ternak == 'Bali') ? 'selected' : '' ?>>Bali</option>
                            <option value="Kambing" <?= ($is_edit && $peternak->ras_ternak == 'Kambing') ? 'selected' : '' ?>>Kambing</option>
                            <option value="Sapi Perah" <?= ($is_edit && $peternak->ras_ternak == 'Sapi Perah') ? 'selected' : '' ?>>Sapi Perah</option>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <a href="<?= site_url('master/peternak') ?>" class="btn btn-default">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
