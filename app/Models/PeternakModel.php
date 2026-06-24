<?php

namespace App\Models;

use CodeIgniter\Model;

class PeternakModel extends Model
{
    protected $table      = 'peternak';
    protected $primaryKey = 'id_peternak';

    protected $returnType     = 'object';
    protected $allowedFields = ['id_peternak', 'id_kelompok', 'nama_peternak', 'alamat', 'desa', 'kecamatan', 'no_hp', 'tahun_anggaran', 'sumber_dana', 'ras_ternak'];

    public function get_all()
    {
        $builder = $this->builder();
        $builder->select('peternak.*, COUNT(hewan.id_hewan) as jumlah_hewan, kelompok_ternak.nama_kelompok');
        $builder->join('hewan', 'hewan.id_peternak = peternak.id_peternak AND hewan.status = \'aktif\'', 'left');
        $builder->join('kelompok_ternak', 'peternak.id_kelompok = kelompok_ternak.id', 'left');
        $builder->groupBy('peternak.id_peternak');
        return $builder->get()->getResult();
    }

    public function get_by_id($id)
    {
        return $this->find($id);
    }

    public function save_peternak($post)
    {
        $data = [
            'id_peternak'    => $post['id_peternak'],
            'id_kelompok'    => empty($post['id_kelompok']) ? null : $post['id_kelompok'],
            'nama_peternak'  => $post['nama_peternak'],
            'alamat'         => $post['alamat'],
            'desa'           => $post['desa'],
            'kecamatan'      => $post['kecamatan'],
            'no_hp'          => $post['no_hp'],
            'tahun_anggaran' => empty($post['tahun_anggaran']) ? null : $post['tahun_anggaran'],
            'sumber_dana'    => empty($post['sumber_dana']) ? null : $post['sumber_dana'],
            'ras_ternak'     => empty($post['ras_ternak']) ? null : $post['ras_ternak']
        ];
        return $this->insert($data);
    }

    public function update_peternak($post)
    {
        $data = [
            'id_kelompok'    => empty($post['id_kelompok']) ? null : $post['id_kelompok'],
            'nama_peternak'  => $post['nama_peternak'],
            'alamat'         => $post['alamat'],
            'desa'           => $post['desa'],
            'kecamatan'      => $post['kecamatan'],
            'no_hp'          => $post['no_hp'],
            'tahun_anggaran' => empty($post['tahun_anggaran']) ? null : $post['tahun_anggaran'],
            'sumber_dana'    => empty($post['sumber_dana']) ? null : $post['sumber_dana'],
            'ras_ternak'     => empty($post['ras_ternak']) ? null : $post['ras_ternak']
        ];
        return $this->update($post['id_peternak'], $data);
    }


    public function delete_peternak($id)
    {
        return $this->delete($id);
    }
}
