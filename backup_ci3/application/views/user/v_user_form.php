<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo $title; ?></h3>
    </div>
    <?php 
        // Menentukan action form, apakah untuk add atau edit
        $action = isset($user) ? site_url('user/edit/'.$user->id) : site_url('user/add');
        echo form_open($action); 
    ?>
    <?php if (isset($user)) : ?>
        <input type="hidden" name="id" value="<?php echo $user->id; ?>">
    <?php endif; ?>

    <div class="card-body">
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" value="<?php echo isset($user) ? $user->nama_lengkap : set_value('nama_lengkap'); ?>" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Masukkan Username" value="<?php echo isset($user) ? $user->username : set_value('username'); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password">
            <?php if (isset($user)) : ?>
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" value="<?php echo isset($user) ? $user->email : set_value('email'); ?>">
        </div>

        <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" class="form-control" name="nip" placeholder="Masukkan NIP" value="<?php echo isset($user) ? $user->nip : set_value('nip'); ?>">
        </div>
        
        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" placeholder="Masukkan Jabatan" value="<?php echo isset($user) ? $user->jabatan : set_value('jabatan'); ?>">
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control" required>
                <?php $role = isset($user) ? $user->role : set_value('role'); ?>
                <option value="admin" <?php echo ($role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="operator" <?php echo ($role == 'operator') ? 'selected' : ''; ?>>Operator</option>
                <option value="penandatangan" <?php echo ($role == 'penandatangan') ? 'selected' : ''; ?>>Penandatangan</option>
                <option value="petugas" <?php echo ($role == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
            </select>
        </div>

        <div class="form-group">
            <label for="is_active">Status</label>
            <select name="is_active" class="form-control" required>
                <?php $status = isset($user) ? $user->is_active : set_value('is_active'); ?>
                <option value="1" <?php echo ($status == '1') ? 'selected' : ''; ?>>Aktif</option>
                <option value="0" <?php echo ($status == '0') ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>
        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?php echo site_url('user'); ?>" class="btn btn-secondary">Batal</a>
    </div>
    <?php echo form_close(); ?>
</div>