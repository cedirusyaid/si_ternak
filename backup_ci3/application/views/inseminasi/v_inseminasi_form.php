<!-- application/views/inseminasi/v_inseminasi_form.php -->

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php 
                $is_edit = isset($ib);
                $action_url = $is_edit ? site_url('inseminasi/update_ib/' . $ib->id_ib) : site_url('inseminasi/store_ib');
            ?>
            <form action="<?= $action_url ?>" method="post" role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label for="id_hewan">Hewan Ternak (Betina)</label>
                        <select name="id_hewan" id="id_hewan" class="form-control" required>
                            <option value="">-- Pilih Hewan --</option>
                            <?php foreach ($hewan as $h): ?>
                                <option value="<?= $h->id_hewan ?>" <?= ($is_edit && $h->id_hewan == $ib->id_hewan) ? 'selected' : '' ?>><?= $h->id_hewan ?> - <?= $h->nama_hewan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_ib">Tanggal Inseminasi</label>
                        <input type="date" class="form-control" id="tanggal_ib" name="tanggal_ib" value="<?= $is_edit ? $ib->tanggal_ib : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_petugas">Petugas Inseminator</label>
                        <select name="id_petugas" id="id_petugas" class="form-control" required>
                            <option value="">-- Pilih Petugas --</option>
                            <?php foreach ($petugas as $p): ?>
                                <option value="<?= $p->id_petugas ?>" <?= ($is_edit && $p->id_petugas == $ib->id_petugas) ? 'selected' : '' ?>><?= $p->nama_petugas ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ib_ke">Inseminasi Ke-</label>
                        <input type="number" class="form-control" id="ib_ke" name="ib_ke" placeholder="Misal: 1" value="<?= $is_edit ? $ib->ib_ke : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_pejantan">ID Pejantan</label>
                        <input type="text" class="form-control" id="id_pejantan" name="id_pejantan" placeholder="Masukkan ID Pejantan" value="<?= $is_edit ? $ib->id_pejantan : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="bangsa_pejantan">Bangsa Pejantan</label>
                        <input type="text" class="form-control" id="bangsa_pejantan" name="bangsa_pejantan" placeholder="Contoh: Limousin" value="<?= $is_edit ? $ib->bangsa_pejantan : '' ?>">
                    </div>
                     <div class="form-group">
                        <label for="status">Status Awal</label>
                        <select name="status" id="status" class="form-control">
                            <option value="menunggu" <?= ($is_edit && $ib->status == 'menunggu') ? 'selected' : '' ?>>Menunggu</option>
                            <option value="berhasil" <?= ($is_edit && $ib->status == 'berhasil') ? 'selected' : '' ?>>Berhasil</option>
                            <option value="gagal" <?= ($is_edit && $ib->status == 'gagal') ? 'selected' : '' ?>>Gagal</option>
                        </select>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <a href="<?= site_url('inseminasi') ?>" class="btn btn-default">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
