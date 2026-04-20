<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengguna Sistem</h3>
        <div class="card-tools">
            <a href="<?php echo site_url('user/add'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah User</a>
        </div>
    </div>
    <div class="card-body">
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Sukses!</h5>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php endif; ?>

        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($users as $user): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($user->nama_lengkap, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo ucfirst($user->role); ?></td>
                    <td>
                        <?php if($user->is_active == 1): ?>
                            <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Tidak Aktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo site_url('user/edit/'.$user->id); ?>" class="btn btn-info btn-xs"><i class="fas fa-edit"></i> Edit</a>
                        <a href="<?php echo site_url('user/delete/'.$user->id); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>