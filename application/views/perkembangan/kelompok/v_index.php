<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Kelompok Ternak</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('perkembangan/kelompok_add'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Kelompok</a>
        </div>
    </div>
    <div class="card-body">
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <?php endif; ?>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Kelompok</th>
                    <th>Kecamatan</th>
                    <th>Desa</th>
                    <th>Ras Ternak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($kelompok_list as $item): ?>
                <tr>
                    <td><?php echo $item->kode_kelompok; ?></td>
                    <td><?php echo $item->nama_kelompok; ?></td>
                    <td><?php echo $item->kecamatan_nama; ?></td>
                    <td><?php echo $item->desa_nama; ?></td>
                    <td><?php echo $item->rasternak; ?></td>
                    <td>
                        <a href="<?php echo site_url('perkembangan/kelompok_edit/'.$item->id); ?>" class="btn btn-info btn-xs"><i class="fas fa-edit"></i> Edit</a>
                        <a href="<?php echo site_url('perkembangan/kelompok_delete/'.$item->id); ?>" onclick="return confirm('Yakin hapus data?');" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>