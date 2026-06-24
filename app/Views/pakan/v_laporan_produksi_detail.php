<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ID Laporan: <?php echo $laporan->id_laporan; ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Kelompok:</strong> <?php echo $laporan->nama_kelompok; ?></p>
                    <p><strong>Bulan:</strong> <?php echo $laporan->bulan; ?></p>
                    <p><strong>Tahun:</strong> <?php echo $laporan->tahun; ?></p>
                    <p><strong>Status:</strong> <?php echo $laporan->status; ?></p>
                </div>
            </div>
            <hr>
            <h5>Detail Produksi</h5>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Jenis Pakan</th>
                            <th>Jumlah Produksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $row) : ?>
                            <tr>
                                <td><?php echo $row->nama_jenis; ?></td>
                                <td><?php echo $row->jumlah_produksi; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <a href="<?php echo site_url('pakan/laporan_produksi'); ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>