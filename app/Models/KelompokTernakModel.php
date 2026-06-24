<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokTernakModel extends Model
{
    protected $table      = 'kelompok_ternak';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $allowedFields = [
        'kode_kelompok', 'nama_kelompok', 'desa_id', 'kecamatan_id',
        'alamat_lengkap', 'tahun_anggaran', 'sumber_dana', 'rasternak'
    ];

    public function get_all()
    {
        $builder = $this->builder();
        $builder->select('
            kelompok_ternak.*, 
            kode_kecamatan.kecamatan_nama, 
            kode_desa.desa_nama
        ');
        $builder->join('kode_kecamatan', 'kelompok_ternak.kecamatan_id = kode_kecamatan.kecamatan_id', 'left');
        $builder->join('kode_desa', 'kelompok_ternak.desa_id = kode_desa.desa_id', 'left');
        $builder->orderBy('kelompok_ternak.id', 'DESC');
        $result = $builder->get()->getResult();

        $db = \Config\Database::connect();
        foreach ($result as $row) {
            // Get rekap breed per orang di kelompok ini
            $rekap = $db->table('peternak')
                        ->select('ras_ternak, COUNT(id_peternak) as jumlah')
                        ->where('id_kelompok', $row->id)
                        ->where('ras_ternak IS NOT NULL')
                        ->groupBy('ras_ternak')
                        ->get()->getResultArray();
            
            if (!empty($rekap)) {
                $rekap_arr = [];
                foreach ($rekap as $r) {
                    $rekap_arr[] = $r['ras_ternak'] . ' (' . $r['jumlah'] . ')';
                }
                $row->rasternak = implode(', ', $rekap_arr);
            } else {
                $row->rasternak = '-';
            }
        }

        return $result;
    }

    public function get_by_id($id)
    {
        return $this->find($id);
    }

    public function save_kelompok($post)
    {
        $data = [
            'kode_kelompok'  => $post['kode_kelompok'],
            'nama_kelompok'  => $post['nama_kelompok'],
            'desa_id'        => $post['desa_id'],
            'kecamatan_id'   => $post['kecamatan_id'],
            'alamat_lengkap' => $post['alamat_lengkap'],
            'tahun_anggaran' => $post['tahun_anggaran'] ?? null,
            'sumber_dana'    => $post['sumber_dana'] ?? null,
            'rasternak'      => $post['rasternak'] ?? null
        ];
        return $this->insert($data);
    }

    public function update_kelompok($post)
    {
        $data = [
            'kode_kelompok'  => $post['kode_kelompok'],
            'nama_kelompok'  => $post['nama_kelompok'],
            'desa_id'        => $post['desa_id'],
            'kecamatan_id'   => $post['kecamatan_id'],
            'alamat_lengkap' => $post['alamat_lengkap'],
            'tahun_anggaran' => $post['tahun_anggaran'] ?? null,
            'sumber_dana'    => $post['sumber_dana'] ?? null,
            'rasternak'      => $post['rasternak'] ?? null
        ];
        return $this->update($post['id'], $data);
    }

    public function delete_kelompok($id)
    {
        return $this->delete($id);
    }
}
