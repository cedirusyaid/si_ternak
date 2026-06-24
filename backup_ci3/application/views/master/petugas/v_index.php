<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Petugas Lapangan</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('master/petugas_add'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Petugas</a>
        </div>
    </div>
    <div class="card-body">
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php endif; ?>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID Petugas</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($petugas_list as $item): ?>
                <tr>
                    <td><?php echo $item->id_petugas; ?></td>
                    <td><?php echo $item->nama_petugas; ?></td>
                    <td><?php echo $item->nip; ?></td>
                    <td><?php echo $item->jabatan; ?></td>
                    <td><?php echo $item->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>'; ?></td>
                    <td>
                        <a href="<?php echo site_url('master/petugas_edit/'.$item->id_petugas); ?>" class="btn btn-info btn-xs"><i class="fas fa-edit"></i> Edit</a>
                        <a href="<?php echo site_url('master/petugas_delete/'.$item->id_petugas); ?>" onclick="return confirm('Yakin hapus data?');" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>