<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan_bulanan extends CI_Model {
    private $_table = "laporan_bulanan";

    /**
     * Mengambil semua laporan, dengan opsi filter berdasarkan tahun dan bulan.
     */
    public function get_all_with_kelompok($tahun = null, $bulan = null) {
        $this->db->select('laporan_bulanan.*, kelompok_ternak.nama_kelompok, kelompok_ternak.kode_kelompok');
        $this->db->from($this->_table);
        $this->db->join('kelompok_ternak', 'laporan_bulanan.kelompok_id = kelompok_ternak.id');
        
        // Menambahkan filter jika ada
        if ($tahun && $bulan) {
            $this->db->where('laporan_bulanan.tahun', $tahun);
            $this->db->where('laporan_bulanan.bulan', $bulan);
        }

        $this->db->order_by('laporan_bulanan.tahun DESC, laporan_bulanan.bulan DESC');
        return $this->db->get()->result();
    }

    /**
     * Fungsi baru untuk mengambil daftar unik Tahun & Bulan yang ada datanya.
     */
    public function get_distinct_periods() {
        $this->db->select('tahun, bulan');
        $this->db->distinct();
        $this->db->from($this->_table);
        $this->db->order_by('tahun DESC, bulan DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->_table, ['id' => $id])->row();
    }

    public function save() {
        $post = $this->input->post();
        $data = [
            'kelompok_id' => $post['kelompok_id'],
            'bulan' => $post['bulan'],
            'tahun' => $post['tahun'],
            'populasi_awal_dewasa_jt' => $post['populasi_awal_dewasa_jt'],
            'populasi_awal_dewasa_bt' => $post['populasi_awal_dewasa_bt'],
            'populasi_awal_anak_jt' => $post['populasi_awal_anak_jt'],
            'populasi_awal_anak_bt' => $post['populasi_awal_anak_bt'],
            'lahir_jt' => $post['lahir_jt'],
            'lahir_bt' => $post['lahir_bt'],
            'mati_dewasa_jt' => $post['mati_dewasa_jt'],
            'mati_dewasa_bt' => $post['mati_dewasa_bt'],
            'mati_anak_jt' => $post['mati_anak_jt'],
            'mati_anak_bt' => $post['mati_anak_bt'],
            'jual_jt' => $post['jual_jt'],
            'jual_bt' => $post['jual_bt'],
            'keterangan' => $post['keterangan']
        ];
        return $this->db->insert($this->_table, $data);
    }
    
    public function delete($id) {
        return $this->db->delete($this->_table, ['id' => $id]);
    }
}