<?php

namespace App\Models;

use CodeIgniter\Model;

class HewanModel extends Model
{
    protected $table      = 'hewan';
    protected $primaryKey = 'id_hewan';

    protected $returnType     = 'object';
    protected $allowedFields = ['id_hewan', 'id_peternak', 'nama_hewan', 'bangsa_induk', 'jenis_kelamin', 'tanggal_lahir', 'status'];

    public function get_all()
    {
        $builder = $this->builder();
        $builder->select('hewan.*, peternak.nama_peternak');
        $builder->join('peternak', 'peternak.id_peternak = hewan.id_peternak', 'left');
        return $builder->get()->getResult();
    }

    public function get_by_id($id)
    {
        return $this->find($id);
    }

    public function save_hewan($post)
    {
        $data = [
            'id_hewan'      => $post['id_hewan'],
            'id_peternak'   => $post['id_peternak'],
            'nama_hewan'    => $post['nama_hewan'],
            'bangsa_induk'  => $post['bangsa_induk'],
            'jenis_kelamin' => $post['jenis_kelamin'],
            'tanggal_lahir' => $post['tanggal_lahir'],
            'status'        => $post['status']
        ];
        return $this->insert($data);
    }

    public function update_hewan($post)
    {
        $data = [
            'id_peternak'   => $post['id_peternak'],
            'nama_hewan'    => $post['nama_hewan'],
            'bangsa_induk'  => $post['bangsa_induk'],
            'jenis_kelamin' => $post['jenis_kelamin'],
            'tanggal_lahir' => $post['tanggal_lahir'],
            'status'        => $post['status']
        ];
        return $this->update($post['id_hewan'], $data);
    }

    public function delete_hewan($id)
    {
        return $this->delete($id);
    }
}
