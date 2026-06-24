<?php

namespace App\Models;

use CodeIgniter\Model;

class VaksinasiModel extends Model
{
    protected $table      = 'laporan_vaksinasi_ternak';
    protected $primaryKey = 'id'; // checking if primary key is ID or auto_increment, replace uses primary/unique key.

    protected $returnType     = 'object';
    protected $allowedFields = [
        'id', 'nikpemilik', 'namapemilik', 'nokartu', 'alamatpemilik', 'kecamatan', 'desa',
        'eartag', 'hewan', 'bangsa', 'sex', 'umur', 'kondisi', 'tujuanpemeliharaan',
        'tanggal_vaksinasi', 'vaksin', 'batch', 'namapetugas', 'nip_petugas'
    ];

    public function insert_batch($data)
    {
        if (empty($data)) {
            return 0;
        }

        $db = \Config\Database::connect();
        $db->transStart();
        foreach ($data as $row) {
            $db->table($this->table)->replace($row);
        }
        $db->transComplete();

        return $db->transStatus();
    }

    public function get_all()
    {
        return $this->findAll();
    }

    public function get_rekap_by_month()
    {
        $builder = $this->builder();
        $builder->select(
            'YEAR(tanggal_vaksinasi) as tahun, 
             MONTH(tanggal_vaksinasi) as bulan, 
             COUNT(*) as total_vaksinasi, 
             COUNT(DISTINCT kecamatan) as jumlah_kecamatan, 
             COUNT(DISTINCT desa) as jumlah_desa, 
             COUNT(DISTINCT namapemilik) as jumlah_pemilik'
        );
        $builder->groupBy(['YEAR(tanggal_vaksinasi)', 'MONTH(tanggal_vaksinasi)']);
        $builder->orderBy('tahun', 'DESC');
        $builder->orderBy('bulan', 'DESC');
        return $builder->get()->getResult();
    }

    public function get_rekap_by_petugas($filters = [])
    {
        $builder = $this->builder();
        $builder->select(
            'namapetugas, 
             COUNT(*) as total_vaksinasi, 
             COUNT(DISTINCT kecamatan) as jumlah_kecamatan, 
             COUNT(DISTINCT desa) as jumlah_desa, 
             MIN(tanggal_vaksinasi) as vaksinasi_pertama, 
             MAX(tanggal_vaksinasi) as vaksinasi_terakhir'
        );

        if (!empty($filters['bulan'])) {
            $builder->where('MONTH(tanggal_vaksinasi)', $filters['bulan']);
        }
        if (!empty($filters['tahun'])) {
            $builder->where('YEAR(tanggal_vaksinasi)', $filters['tahun']);
        }

        $builder->groupBy('namapetugas');
        $builder->orderBy('total_vaksinasi', 'DESC');
        return $builder->get()->getResult();
    }

    public function get_vaksinasi_distinct_periods()
    {
        $builder = $this->builder();
        $builder->select('YEAR(tanggal_vaksinasi) as tahun, MONTH(tanggal_vaksinasi) as bulan');
        $builder->groupBy(['YEAR(tanggal_vaksinasi)', 'MONTH(tanggal_vaksinasi)']);
        $builder->orderBy('tahun', 'DESC');
        $builder->orderBy('bulan', 'DESC');
        return $builder->get()->getResult();
    }
}
