<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanBulananModel extends Model
{
    protected $table      = 'laporan_bulanan';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $allowedFields = [
        'kelompok_id', 'bulan', 'tahun',
        'populasi_awal_dewasa_jt', 'populasi_awal_dewasa_bt',
        'populasi_awal_anak_jt', 'populasi_awal_anak_bt',
        'lahir_jt', 'lahir_bt',
        'mati_dewasa_jt', 'mati_dewasa_bt',
        'mati_anak_jt', 'mati_anak_bt',
        'jual_jt', 'jual_bt',
        'keterangan'
    ];

    public function get_all_with_kelompok($tahun = null, $bulan = null)
    {
        $builder = $this->builder();
        $builder->select('laporan_bulanan.*, kelompok_ternak.nama_kelompok, kelompok_ternak.kode_kelompok');
        $builder->join('kelompok_ternak', 'laporan_bulanan.kelompok_id = kelompok_ternak.id');
        
        if ($tahun && $bulan) {
            $builder->where('laporan_bulanan.tahun', $tahun);
            $builder->where('laporan_bulanan.bulan', $bulan);
        }

        $builder->orderBy('laporan_bulanan.tahun', 'DESC');
        $builder->orderBy('laporan_bulanan.bulan', 'DESC');
        return $builder->get()->getResult();
    }

    public function get_distinct_periods()
    {
        $builder = $this->builder();
        $builder->select('tahun, bulan');
        $builder->distinct();
        $builder->orderBy('tahun', 'DESC');
        $builder->orderBy('bulan', 'DESC');
        return $builder->get()->getResult();
    }

    public function get_by_id($id)
    {
        return $this->find($id);
    }

    public function save_laporan($post)
    {
        $data = [
            'kelompok_id'              => $post['kelompok_id'],
            'bulan'                    => $post['bulan'],
            'tahun'                    => $post['tahun'],
            'populasi_awal_dewasa_jt'  => $post['populasi_awal_dewasa_jt'],
            'populasi_awal_dewasa_bt'  => $post['populasi_awal_dewasa_bt'],
            'populasi_awal_anak_jt'    => $post['populasi_awal_anak_jt'],
            'populasi_awal_anak_bt'    => $post['populasi_awal_anak_bt'],
            'lahir_jt'                 => $post['lahir_jt'],
            'lahir_bt'                 => $post['lahir_bt'],
            'mati_dewasa_jt'           => $post['mati_dewasa_jt'],
            'mati_dewasa_bt'           => $post['mati_dewasa_bt'],
            'mati_anak_jt'             => $post['mati_anak_jt'],
            'mati_anak_bt'             => $post['mati_anak_bt'],
            'jual_jt'                  => $post['jual_jt'],
            'jual_bt'                  => $post['jual_bt'],
            'keterangan'               => $post['keterangan']
        ];
        return $this->insert($data);
    }

    public function delete_laporan($id)
    {
        return $this->delete($id);
    }
}
