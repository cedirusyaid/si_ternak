<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php echo form_open('pakan/laporan_produksi_store'); ?>
                <div class="form-group">
                    <label for="id_kelompok">Nama Kelompok</label>
                    <select class="form-control" name="id_kelompok">
                        <?php foreach ($kelompok as $row) : ?>
                            <option value="<?php echo $row->id_kelompok; ?>"><?php echo $row->nama_kelompok; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bulan">Bulan</label>
                    <input type="number" class="form-control" name="bulan" min="1" max="12">
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="number" class="form-control" name="tahun" min="2020">
                </div>
                <hr>
                <h5>Detail Produksi</h5>
                <div id="detail-produksi-container">
                    <div class="row detail-produksi-item">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_jenis_pakan[]">Jenis Pakan</label>
                                <select class="form-control" name="id_jenis_pakan[]">
                                    <?php foreach ($jenis_pakan as $row) : ?>
                                        <option value="<?php echo $row->id_jenis_pakan; ?>"><?php echo $row->nama_jenis; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_produksi[]">Jumlah Produksi</label>
                                <input type="number" class="form-control" name="jumlah_produksi[]">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-detail-item">Hapus</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success" id="add-detail-item">Tambah Detail</button>
                <hr>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo site_url('pakan/laporan_produksi'); ?>" class="btn btn-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('detail-produksi-container');
        const addButton = document.getElementById('add-detail-item');

        addButton.addEventListener('click', function () {
            const newItem = container.firstElementChild.cloneNode(true);
            newItem.querySelector('input[type="number"]').value = '';
            container.appendChild(newItem);
        });

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-detail-item')) {
                e.target.closest('.detail-produksi-item').remove();
            }
        });
    });
</script>