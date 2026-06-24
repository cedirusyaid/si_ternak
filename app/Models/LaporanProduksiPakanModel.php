<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanProduksiPakanModel extends Model
{
    protected $table      = 'laporan_produksi_pakan';
    protected $primaryKey = 'id_laporan';

    protected $returnType     = 'object';
    protected $allowedFields = ['id_kelompok', 'bulan', 'tahun', 'status', 'created_by', 'created_at'];

    public function get_all($filters = [])
    {
        $builder = $this->builder();
        $builder->select('laporan_produksi_pakan.*, kelompok_produksi_pakan.nama_kelompok, SUM(detail_produksi_pakan.jumlah_produksi) as total_produksi');
        $builder->join('kelompok_produksi_pakan', 'laporan_produksi_pakan.id_kelompok = kelompok_produksi_pakan.id_kelompok');
        $builder->join('detail_produksi_pakan', 'laporan_produksi_pakan.id_laporan = detail_produksi_pakan.id_laporan', 'left');

        if (!empty($filters['bulan'])) {
            $builder->where('laporan_produksi_pakan.bulan', $filters['bulan']);
        }
        if (!empty($filters['tahun'])) {
            $builder->where('laporan_produksi_pakan.tahun', $filters['tahun']);
        }

        $builder->groupBy('laporan_produksi_pakan.id_laporan');
        $builder->orderBy('laporan_produksi_pakan.tahun', 'DESC');
        $builder->orderBy('laporan_produksi_pakan.bulan', 'DESC');
        
        return $builder->get()->getResult();
    }

    public function get_distinct_periods()
    {
        $builder = $this->builder();
        $builder->select('tahun, bulan');
        $builder->groupBy(['tahun', 'bulan']);
        $builder->orderBy('tahun', 'DESC');
        $builder->orderBy('bulan', 'DESC');
        
        return $builder->get()->getResult();
    }

    public function get_by_id($id)
    {
        $builder = $this->builder();
        $builder->select('laporan_produksi_pakan.*, kelompok_produksi_pakan.nama_kelompok');
        $builder->join('kelompok_produksi_pakan', 'laporan_produksi_pakan.id_kelompok = kelompok_produksi_pakan.id_kelompok');
        $builder->where('id_laporan', $id);
        
        return $builder->get()->getRow();
    }

    public function get_production_report_data($filters = [])
    {
        if (empty($filters['bulan']) || empty($filters['tahun'])) {
            return [];
        }

        $db = \Config\Database::connect();
        $builder = $db->table('kelompok_produksi_pakan k');
        $builder->select('k.kecamatan, k.nama_kelompok, k.desa, j.nama_jenis, d.jumlah_produksi');
        $builder->join('laporan_produksi_pakan l', 'k.id_kelompok = l.id_kelompok', 'left');
        $builder->join('detail_produksi_pakan d', 'l.id_laporan = d.id_laporan', 'left');
        $builder->join('jenis_pakan j', 'd.id_jenis_pakan = j.id_jenis_pakan', 'left');

        $builder->where('l.bulan', $filters['bulan']);
        $builder->where('l.tahun', $filters['tahun']);
        $builder->orderBy('k.kecamatan', 'ASC');
        $builder->orderBy('k.nama_kelompok', 'ASC');

        return $builder->get()->getResultArray();
    }
}
