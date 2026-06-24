<?php

namespace App\Models;

use CodeIgniter\Model;

class WilayahModel extends Model
{
    public function get_all_kecamatan()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('kode_kecamatan');
        $builder->orderBy('kecamatan_nama', 'ASC');
        return $builder->get()->getResult();
    }

    public function get_desa_by_kecamatan($kecamatan_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('kode_desa');
        $builder->where('kecamatan_id', $kecamatan_id);
        $builder->orderBy('desa_nama', 'ASC');
        return $builder->get()->getResult();
    }
}
