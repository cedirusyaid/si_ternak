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
                </div>
                <div class="box-footer">
                    <a href="<?= site_url('master/peternak') ?>" class="btn btn-default">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
