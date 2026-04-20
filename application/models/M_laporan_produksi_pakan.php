<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan_produksi_pakan extends CI_Model {
    private $_table = "laporan_produksi_pakan";

    public function get_all($filters = [])
    {
        $this->db->select('laporan_produksi_pakan.*, kelompok_produksi_pakan.nama_kelompok, SUM(detail_produksi_pakan.jumlah_produksi) as total_produksi');
        $this->db->from($this->_table);
        $this->db->join('kelompok_produksi_pakan', 'laporan_produksi_pakan.id_kelompok = kelompok_produksi_pakan.id_kelompok');
        $this->db->join('detail_produksi_pakan', 'laporan_produksi_pakan.id_laporan = detail_produksi_pakan.id_laporan', 'left');

        if (!empty($filters['bulan'])) {
            $this->db->where('laporan_produksi_pakan.bulan', $filters['bulan']);
        }
        if (!empty($filters['tahun'])) {
            $this->db->where('laporan_produksi_pakan.tahun', $filters['tahun']);
        }

        $this->db->group_by('laporan_produksi_pakan.id_laporan');
        $this->db->order_by('laporan_produksi_pakan.tahun DESC, laporan_produksi_pakan.bulan DESC');
        return $this->db->get()->result();
    }

    public function get_distinct_periods()
    {
        $this->db->select($this->_table . '.tahun, ' . $this->_table . '.bulan');
        $this->db->from($this->_table);
        $this->db->group_by([$this->_table . '.tahun', $this->_table . '.bulan']);
        $this->db->order_by($this->_table . '.tahun DESC, ' . $this->_table . '.bulan DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('laporan_produksi_pakan.*, kelompok_produksi_pakan.nama_kelompok');
        $this->db->from($this->_table);
        $this->db->join('kelompok_produksi_pakan', 'laporan_produksi_pakan.id_kelompok = kelompok_produksi_pakan.id_kelompok');
        $this->db->where('id_laporan', $id);
        return $this->db->get()->row();
    }

    public function get_production_report_data($filters = [])
    {
        $this->db->select(
            'k.kecamatan, k.nama_kelompok, k.desa, j.nama_jenis, d.jumlah_produksi'
        );
        $this->db->from('kelompok_produksi_pakan k');
        $this->db->join('laporan_produksi_pakan l', 'k.id_kelompok = l.id_kelompok', 'left');
        $this->db->join('detail_produksi_pakan d', 'l.id_laporan = d.id_laporan', 'left');
        $this->db->join('jenis_pakan j', 'd.id_jenis_pakan = j.id_jenis_pakan', 'left');

        if (!empty($filters['bulan']) && !empty($filters['tahun'])) {
            $this->db->where('l.bulan', $filters['bulan']);
            $this->db->where('l.tahun', $filters['tahun']);
        } else {
            // Jika tidak ada filter, mungkin tampilkan data bulan terakhir atau kosong
            return [];
        }

        $this->db->order_by('k.kecamatan ASC, k.nama_kelompok ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}