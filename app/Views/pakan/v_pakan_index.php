<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?php echo site_url('pakan/create'); ?>" class="btn btn-primary">Tambah Jenis Pakan</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Jenis Pakan</th>
                            <th>Nama Jenis</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pakan as $row) : ?>
                            <tr>
                                <td><?php echo $row->id_jenis_pakan; ?></td>
                                <td><?php echo $row->nama_jenis; ?></td>
                                <td><?php echo $row->kategori; ?></td>
                                <td><?php echo $row->satuan; ?></td>
                                <td>
                                    <a href="<?php echo site_url('pakan/edit/' . $row->id_jenis_pakan); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?php echo site_url('pakan/delete/' . $row->id_jenis_pakan); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>