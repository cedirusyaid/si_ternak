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
                <?= csrf_field() ?>
                <div class="box-body">
                    <div class="form-group" style="position: relative;">
                        <label for="search_peternak">Pemilik (Peternak)</label>
                        <input type="text" class="form-control" id="search_peternak" placeholder="Ketik nama atau ID Peternak..." value="<?= $is_edit ? ($ib->nama_peternak . ' (' . $ib->id_peternak . ')') : '' ?>" autocomplete="off">
                        <input type="hidden" name="id_peternak" id="id_peternak" value="<?= $is_edit ? $ib->id_peternak : '' ?>">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <label for="search_hewan">Hewan Ternak (Betina)</label>
                        <input type="text" class="form-control" id="search_hewan" placeholder="Ketik nama atau ID Hewan..." value="<?= $is_edit ? ($ib->nama_hewan . ' (' . $ib->id_hewan . ')') : '' ?>" autocomplete="off" required>
                        <input type="hidden" name="id_hewan" id="id_hewan" value="<?= $is_edit ? $ib->id_hewan : '' ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kecamatan Pemilik</label>
                                <input type="text" id="peternak_kecamatan" class="form-control" value="<?= $is_edit ? $ib->peternak_kecamatan : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Desa Pemilik</label>
                                <input type="text" id="peternak_desa" class="form-control" value="<?= $is_edit ? $ib->peternak_desa : '' ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat Pemilik</label>
                        <textarea id="peternak_alamat" class="form-control" rows="2" readonly><?= $is_edit ? $ib->alamat : '' ?></textarea>
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
                    <?php if ($is_edit): ?>
                     <div class="form-group">
                        <label for="status">Status Awal</label>
                        <select name="status" id="status" class="form-control">
                            <option value="menunggu" <?= ($ib->status == 'menunggu') ? 'selected' : '' ?>>Menunggu</option>
                            <option value="berhasil" <?= ($ib->status == 'berhasil') ? 'selected' : '' ?>>Berhasil</option>
                            <option value="gagal" <?= ($ib->status == 'gagal') ? 'selected' : '' ?>>Gagal</option>
                        </select>
                    </div>
                    <?php endif; ?>

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

<script src="<?php echo base_url('assets/admin_template/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>
<script>
$(document).ready(function() {
    var listStyle = 'position: absolute; z-index: 1000; width: 100%; max-height: 200px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: 1px solid #ccc; background: white;';
    $('#search_peternak').after('<div id="peternak_results" class="list-group" style="' + listStyle + ' display: none;"></div>');
    $('#search_hewan').after('<div id="hewan_results" class="list-group" style="' + listStyle + ' display: none;"></div>');

    // Search peternak
    $('#search_peternak').on('keyup input', function() {
        var query = $(this).val();
        if (query.length < 1) {
            $('#peternak_results').hide().empty();
            $('#id_peternak').val('');
            return;
        }
        $.ajax({
            url: "<?= site_url('inseminasi/ajax_search_peternak') ?>",
            type: 'GET',
            dataType: 'json',
            data: { query: query },
            success: function(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(key, val) {
                        html += '<a href="#" class="list-group-item list-group-item-action select-peternak" data-id="' + val.id_peternak + '" data-nama="' + val.nama_peternak + '" data-alamat="' + (val.alamat || '') + '" data-desa="' + (val.desa || '') + '" data-kecamatan="' + (val.kecamatan || '') + '">' + val.nama_peternak + ' (' + val.id_peternak + ')</a>';
                    });
                    $('#peternak_results').html(html).show();
                } else {
                    $('#peternak_results').html('<div class="list-group-item text-muted">Peternak tidak ditemukan</div>').show();
                }
            }
        });
    });

    // Select peternak
    $(document).on('click', '.select-peternak', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var alamat = $(this).data('alamat');
        var desa = $(this).data('desa');
        var kecamatan = $(this).data('kecamatan');

        $('#search_peternak').val(nama + ' (' + id + ')');
        $('#id_peternak').val(id);
        $('#peternak_alamat').val(alamat);
        $('#peternak_desa').val(desa);
        $('#peternak_kecamatan').val(kecamatan);

        $('#search_hewan').val('');
        $('#id_hewan').val('');
        $('#peternak_results').hide().empty();
    });

    // Search hewan
    $('#search_hewan').on('keyup input', function() {
        var query = $(this).val();
        var id_peternak = $('#id_peternak').val();
        if (query.length < 1 && id_peternak.length < 1) {
            $('#hewan_results').hide().empty();
            $('#id_hewan').val('');
            return;
        }
        $.ajax({
            url: "<?= site_url('inseminasi/ajax_search_hewan') ?>",
            type: 'GET',
            dataType: 'json',
            data: { query: query, id_peternak: id_peternak },
            success: function(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(key, val) {
                        html += '<a href="#" class="list-group-item list-group-item-action select-hewan" data-id="' + val.id_hewan + '" data-nama="' + val.nama_hewan + '" data-peternak-id="' + val.id_peternak + '" data-peternak-nama="' + val.nama_peternak + '" data-alamat="' + (val.alamat || '') + '" data-desa="' + (val.desa || '') + '" data-kecamatan="' + (val.kecamatan || '') + '">' + val.id_hewan + ' - ' + val.nama_hewan + ' (Pemilik: ' + val.nama_peternak + ')</a>';
                    });
                    $('#hewan_results').html(html).show();
                } else {
                    $('#hewan_results').html('<div class="list-group-item text-muted">Hewan betina aktif tidak ditemukan</div>').show();
                }
            }
        });
    });

    // Select hewan
    $(document).on('click', '.select-hewan', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var pId = $(this).data('peternak-id');
        var pNama = $(this).data('peternak-nama');
        var alamat = $(this).data('alamat');
        var desa = $(this).data('desa');
        var kecamatan = $(this).data('kecamatan');

        $('#search_hewan').val(nama + ' (' + id + ')');
        $('#id_hewan').val(id);
        $('#search_peternak').val(pNama + ' (' + pId + ')');
        $('#id_peternak').val(pId);
        $('#peternak_alamat').val(alamat);
        $('#peternak_desa').val(desa);
        $('#peternak_kecamatan').val(kecamatan);

        $('#hewan_results').hide().empty();
    });

    // Hide lists on click outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#search_peternak, #peternak_results').length) {
            $('#peternak_results').hide();
        }
        if (!$(e.target).closest('#search_hewan, #hewan_results').length) {
            $('#hewan_results').hide();
        }
    });
});
</script>
