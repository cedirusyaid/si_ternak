<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    // Menghitung total kelompok ternak
    public function count_kelompok()
    {
        $db = \Config\Database::connect();
        return $db->table('kelompok_ternak')->countAllResults();
    }

    // Menghitung laporan perkembangan bulan ini
    public function count_laporan_perkembangan()
    {
        $db = \Config\Database::connect();
        return $db->table('laporan_bulanan')
                  ->where('bulan', date('m'))
                  ->where('tahun', date('Y'))
                  ->countAllResults();
    }

    // Menghitung inseminasi buatan bulan ini
    public function count_ib_bulan_ini()
    {
        $db = \Config\Database::connect();
        return $db->table('inseminasi')
                  ->where('MONTH(tanggal_ib)', date('m'))
                  ->where('YEAR(tanggal_ib)', date('Y'))
                  ->countAllResults();
    }
    
    // Menghitung laporan pakan bulan ini
    public function count_laporan_pakan()
    {
        $db = \Config\Database::connect();
        return $db->table('laporan_produksi_pakan')
                  ->where('bulan', date('m'))
                  ->where('tahun', date('Y'))
                  ->countAllResults();
    }

    // Menghitung total hewan aktif
    public function count_hewan()
    {
        $db = \Config\Database::connect();
        return $db->table('hewan')
                  ->where('status', 'aktif')
                  ->countAllResults();
    }

    // Mengambil data untuk grafik produksi pakan 6 bulan terakhir
    public function get_pakan_chart_data()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('laporan_produksi_pakan');
        $builder->select('
            laporan_produksi_pakan.tahun, 
            laporan_produksi_pakan.bulan, 
            SUM(detail_produksi_pakan.jumlah_produksi) as total_produksi
        ');
        $builder->join('detail_produksi_pakan', 'laporan_produksi_pakan.id_laporan = detail_produksi_pakan.id_laporan');
        $builder->groupBy(['tahun', 'bulan']);
        $builder->orderBy('tahun', 'DESC');
        $builder->orderBy('bulan', 'DESC');
        $builder->limit(6);
        
        $result = $builder->get()->getResultArray();
        return array_reverse($result); // Dibalik agar urutan bulan dari terlama ke terbaru
    }
}
