<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyakitModel extends Model
{
    protected $table            = 'mst_penyakit';
    protected $primaryKey       = 'id_penyakit';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'kode_penyakit',
        'nama_penyakit',
        'nama_ilmiah',
        'kelompok_hewan',
        'kategori_agen',
        'sifat_zoonosis',
        'spesies_rentan',
        'masa_inkubasi_hari',
        'warna_marker',
        'deskripsi_gejala',
        'prosedur_darurat'
    ];

    public function get_all($kelompok = null)
    {
        $builder = $this->builder();
        if (!empty($kelompok) && $kelompok !== 'all') {
            $builder->where('kelompok_hewan', $kelompok);
        }
        $builder->orderBy('nama_penyakit', 'ASC');
        return $builder->get()->getResult();
    }

    public function get_by_id($id)
    {
        return $this->find($id);
    }
}
