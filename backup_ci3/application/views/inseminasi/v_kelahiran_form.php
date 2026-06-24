<!-- application/views/inseminasi/v_kelahiran_form.php -->

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <?php 
                $is_edit = isset($kelahiran);
                $action_url = $is_edit ? site_url('inseminasi/update_kelahiran/' . $kelahiran->id_laporan) : site_url('inseminasi/store_kelahiran');
            ?>
            <form action="<?= $action_url ?>" method="post" role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label for="tgl_laporan">Tanggal Laporan</label>
                        <input type="date" class="form-control" name="tgl_laporan" value="<?= $is_edit ? $kelahiran->tgl_laporan : date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_kelahiran">Tanggal Kelahiran</label>
                        <input type="date" class="form-control" name="tgl_kelahiran" value="<?= $is_edit ? $kelahiran->tgl_kelahiran : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_hewan">Induk</label>
                        <select name="id_hewan" class="form-control" required>
                            <option value="">-- Pilih Induk --</option>
                            <?php foreach ($hewan as $h): ?>
                                <option value="<?= $h->id_hewan ?>" <?= ($is_edit && $h->id_hewan == $kelahiran->id_hewan) ? 'selected' : '' ?>><?= $h->id_hewan ?> - <?= $h->nama_hewan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin Anak</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="jantan" <?= ($is_edit && $kelahiran->jenis_kelamin == 'jantan') ? 'selected' : '' ?>>Jantan</option>
                            <option value="betina" <?= ($is_edit && $kelahiran->jenis_kelamin == 'betina') ? 'selected' : '' ?>>Betina</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="metode_kawin">Metode Kawin</label>
                        <select name="metode_kawin" class="form-control" required>
                            <option value="IB" <?= ($is_edit && $kelahiran->metode_kawin == 'IB') ? 'selected' : '' ?>>IB (Inseminasi Buatan)</option>
                            <option value="Kawin Alam" <?= ($is_edit && $kelahiran->metode_kawin == 'Kawin Alam') ? 'selected' : '' ?>>Kawin Alam</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_petugas">Petugas Pelapor</label>
                        <select name="id_petugas" class="form-control" required>
                            <option value="">-- Pilih Petugas --</option>
                            <?php foreach ($petugas as $p): ?>
                                <option value="<?= $p->id_petugas ?>" <?= ($is_edit && $p->id_petugas == $kelahiran->id_petugas) ? 'selected' : '' ?>><?= $p->nama_petugas ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <a href="<?= site_url('inseminasi/kelahiran') ?>" class="btn btn-default">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
