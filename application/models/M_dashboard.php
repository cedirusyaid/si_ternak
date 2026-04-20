<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

    // Menghitung total kelompok ternak
    public function count_kelompok() {
        return $this->db->count_all('kelompok_ternak');
    }

    // Menghitung laporan perkembangan bulan ini
    public function count_laporan_perkembangan() {
        return $this->db->where('bulan', date('m'))
                        ->where('tahun', date('Y'))
                        ->count_all_results('laporan_bulanan');
    }

    // Menghitung inseminasi buatan bulan ini
    public function count_ib_bulan_ini() {
        return $this->db->where('MONTH(tanggal_ib)', date('m'))
                        ->where('YEAR(tanggal_ib)', date('Y'))
                        ->count_all_results('inseminasi');
    }
    
    // Menghitung laporan pakan bulan ini
    public function count_laporan_pakan() {
        return $this->db->where('bulan', date('m'))
                        ->where('tahun', date('Y'))
                        ->count_all_results('laporan_produksi_pakan');
    }

    // Menghitung total hewan aktif
    public function count_hewan() {
        return $this->db->where('status', 'aktif')->count_all_results('hewan');
    }

    // Mengambil data untuk grafik produksi pakan 6 bulan terakhir
    public function get_pakan_chart_data() {
        $this->db->select('
            laporan_produksi_pakan.tahun, 
            laporan_produksi_pakan.bulan, 
            SUM(detail_produksi_pakan.jumlah_produksi) as total_produksi
        ');
        $this->db->from('laporan_produksi_pakan');
        $this->db->join('detail_produksi_pakan', 'laporan_produksi_pakan.id_laporan = detail_produksi_pakan.id_laporan');
        $this->db->group_by('tahun, bulan');
        $this->db->order_by('tahun DESC, bulan DESC');
        $this->db->limit(6);
        $query = $this->db->get();
        return array_reverse($query->result_array()); // Dibalik agar urutan bulan dari terlama ke terbaru
    }
}