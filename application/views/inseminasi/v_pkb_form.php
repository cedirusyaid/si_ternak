<!-- application/views/inseminasi/v_pkb_form.php -->

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <?php 
                $is_edit = isset($pkb);
                $action_url = $is_edit ? site_url('inseminasi/update_pkb/' . $pkb->id_pkb) : site_url('inseminasi/store_pkb');
            ?>
            <form action="<?= $action_url ?>" method="post" role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label for="tanggal_pkb">Tanggal Pemeriksaan</label>
                        <input type="date" class="form-control" name="tanggal_pkb" value="<?= $is_edit ? $pkb->tanggal_pkb : date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_hewan">Hewan</label>
                        <select name="id_hewan" class="form-control" required>
                            <option value="">-- Pilih Hewan --</option>
                            <?php foreach ($hewan as $h): ?>
                                <option value="<?= $h->id_hewan ?>" <?= ($is_edit && $h->id_hewan == $pkb->id_hewan) ? 'selected' : '' ?>><?= $h->id_hewan ?> - <?= $h->nama_hewan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_ib">Tanggal IB Terakhir (Jika Ada)</label>
                        <input type="date" class="form-control" name="tanggal_ib" value="<?= $is_edit ? $pkb->tanggal_ib : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="hasil_kebuntingan">Hasil Pemeriksaan</label>
                        <select name="hasil_kebuntingan" class="form-control" required>
                            <option value="Bunting" <?= ($is_edit && $pkb->hasil_kebuntingan == 'Bunting') ? 'selected' : '' ?>>Bunting</option>
                            <option value="Tidak Bunting" <?= ($is_edit && $pkb->hasil_kebuntingan == 'Tidak Bunting') ? 'selected' : '' ?>>Tidak Bunting</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="umur_kebuntingan">Umur Kebuntingan (Hari)</label>
                        <input type="number" class="form-control" name="umur_kebuntingan" value="<?= $is_edit ? $pkb->umur_kebuntingan : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="id_petugas">Petugas Pemeriksa</label>
                        <select name="id_petugas" class="form-control" required>
                            <option value="">-- Pilih Petugas --</option>
                            <?php foreach ($petugas as $p): ?>
                                <option value="<?= $p->id_petugas ?>" <?= ($is_edit && $p->id_petugas == $pkb->id_petugas) ? 'selected' : '' ?>><?= $p->nama_petugas ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <a href="<?= site_url('inseminasi/pkb') ?>" class="btn btn-default">Batal</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
