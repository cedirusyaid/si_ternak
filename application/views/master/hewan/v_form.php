<!-- application/views/master/hewan/v_form.php -->

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <?php 
                $is_edit = isset($hewan);
                $action_url = $is_edit ? site_url('master/hewan_edit/' . $hewan->id_hewan) : site_url('master/hewan_add');
            ?>
            <form action="<?= $action_url ?>" method="post" role="form">
                <div class="box-body">
                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="id_hewan">ID Hewan / Eartag</label>
                        <input type="text" class="form-control" id="id_hewan" name="id_hewan" 
                               value="<?= $is_edit ? $hewan->id_hewan : set_value('id_hewan') ?>" 
                               <?= $is_edit ? 'readonly' : '' ?> required>
                    </div>
                    <div class="form-group">
                        <label for="nama_hewan">Nama Hewan</label>
                        <input type="text" class="form-control" id="nama_hewan" name="nama_hewan" 
                               value="<?= $is_edit ? $hewan->nama_hewan : set_value('nama_hewan') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_peternak">Pemilik</label>
                        <select name="id_peternak" id="id_peternak" class="form-control" required>
                            <option value="">-- Pilih Peternak --</option>
                            <?php foreach ($peternak_list as $p): ?>
                                <option value="<?= $p->id_peternak ?>" <?= ($is_edit && $p->id_peternak == $hewan->id_peternak) ? 'selected' : '' ?>><?= $p->nama_peternak ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" 
                               value="<?= $is_edit ? $hewan->tanggal_lahir : set_value('tanggal_lahir') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="bangsa_induk">Rumpun / Bangsa</label>
                        <input type="text" class="form-control" id="bangsa_induk" name="bangsa_induk" 
                               value="<?= $is_edit ? $hewan->bangsa_induk : set_value('bangsa_induk') ?>">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="jantan" <?= ($is_edit && $hewan->jenis_kelamin == 'jantan') ? 'selected' : '' ?>>Jantan</option>
                            <option value="betina" <?= ($is_edit && $hewan->jenis_kelamin == 'betina') ? 'selected' : '' ?>>Betina</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="aktif" <?= ($is_edit && $hewan->status == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                            <option value="mati" <?= ($is_edit && $hewan->status == 'mati') ? 'selected' : '' ?>>Mati</option>
                            <option value="terjual" <?= ($is_edit && $hewan->status == 'terjual') ? 'selected' : '' ?>>Terjual</option>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <a href="<?= site_url('master/hewan') ?>" class="btn btn-default">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
