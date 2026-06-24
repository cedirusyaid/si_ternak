<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
    protected $table      = 'petugas_lapangan';
    protected $primaryKey = 'id_petugas';

    protected $returnType     = 'object';
    protected $allowedFields = ['id_petugas', 'nama_petugas', 'nip', 'pangkat', 'jabatan', 'no_hp', 'is_active'];

    public function get_all()
    {
        return $this->findAll();
    }

    public function get_by_id($id)
    {
        return $this->find($id);
    }

    public function save_petugas($post)
    {
        $data = [
            'id_petugas'   => $post['id_petugas'],
            'nama_petugas' => $post['nama_petugas'],
            'nip'          => $post['nip'],
            'pangkat'      => $post['pangkat'],
            'jabatan'      => $post['jabatan'],
            'no_hp'         => $post['no_hp'],
            'is_active'    => $post['is_active']
        ];
        return $this->insert($data);
    }

    public function update_petugas($post)
    {
        $data = [
            'nama_petugas' => $post['nama_petugas'],
            'nip'          => $post['nip'],
            'pangkat'      => $post['pangkat'],
            'jabatan'      => $post['jabatan'],
            'no_hp'         => $post['no_hp'],
            'is_active'    => $post['is_active']
        ];
        return $this->update($post['id_petugas'], $data);
    }

    public function delete_petugas($id)
    {
        return $this->delete($id);
    }
}
