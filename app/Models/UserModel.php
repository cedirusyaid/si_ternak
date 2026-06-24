<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'username', 'password', 'nama_lengkap', 'email', 'nip', 'jabatan', 'role', 'is_active', 'last_login'
    ];

    // Dates
    protected $useTimestamps = false;

    // Mengambil semua data user
    public function get_all()
    {
        return $this->findAll();
    }

    // Mengambil data user berdasarkan ID
    public function get_by_id($id)
    {
        return $this->find($id);
    }

    // Mengambil data user berdasarkan username untuk login
    public function get_by_username($username)
    {
        return $this->where('username', $username)->first();
    }

    // Menyimpan data user baru
    public function save_user($post)
    {
        $data = [
            'username'     => $post['username'],
            'password'     => password_hash($post['password'], PASSWORD_BCRYPT),
            'nama_lengkap' => $post['nama_lengkap'],
            'email'        => $post['email'],
            'nip'          => $post['nip'],
            'jabatan'      => $post['jabatan'],
            'role'         => $post['role'],
            'is_active'    => $post['is_active']
        ];
        return $this->insert($data);
    }

    // Mengubah data user
    public function update_user($post)
    {
        $data = [
            'username'     => $post['username'],
            'nama_lengkap' => $post['nama_lengkap'],
            'email'        => $post['email'],
            'nip'          => $post['nip'],
            'jabatan'      => $post['jabatan'],
            'role'         => $post['role'],
            'is_active'    => $post['is_active']
        ];

        // Jika ada password baru, hash dan update passwordnya
        if (!empty($post['password'])) {
            $data['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
        }

        return $this->update($post['id'], $data);
    }

    // Menghapus data user
    public function delete_user($id)
    {
        return $this->delete($id);
    }

    // Update waktu login terakhir
    public function update_last_login($id)
    {
        return $this->update($id, ['last_login' => date('Y-m-d H:i:s')]);
    }
}
