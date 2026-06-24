<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisPakanModel extends Model
{
    protected $table      = 'jenis_pakan';
    protected $primaryKey = 'id_jenis_pakan';

    protected $returnType     = 'object';
    protected $allowedFields = ['id_jenis_pakan', 'nama_jenis', 'kategori', 'satuan'];

    public function get_all()
    {
        return $this->findAll();
    }

    public function get_by_id($id)
    {
        return $this->find($id);
    }

    public function save_pakan($post)
    {
        $data = [
            'id_jenis_pakan' => $post['id_jenis_pakan'],
            'nama_jenis'     => $post['nama_jenis'],
            'kategori'       => $post['kategori'],
            'satuan'         => $post['satuan']
        ];
        return $this->insert($data);
    }

    public function update_pakan($post)
    {
        $data = [
            'nama_jenis'     => $post['nama_jenis'],
            'kategori'       => $post['kategori'],
            'satuan'         => $post['satuan']
        ];
        return $this->update($post['id_jenis_pakan'], $data);
    }
}
