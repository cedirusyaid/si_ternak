<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_vaksinasi extends CI_Model {

    private $_table = "laporan_vaksinasi_ternak";

    public function insert_batch($data)
    {
        // Menggunakan 'id' sebagai acuan untuk ON DUPLICATE KEY UPDATE
        // Ini akan meng-update data jika ID sudah ada, dan memasukkan data baru jika belum ada.
        // Ini adalah cara yang efisien untuk menangani impor ulang file yang sama atau file yang tumpang tindih.
        if (empty($data)) {
            return 0;
        }

        $this->db->trans_start();
        foreach ($data as $row) {
            $this->db->replace($this->_table, $row);
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_all()
    {
        return $this->db->get($this->_table)->result();
    }

    public function get_rekap_by_month()
    {
        $this->db->select(
            'YEAR(tanggal_vaksinasi) as tahun, 
             MONTH(tanggal_vaksinasi) as bulan, 
             COUNT(*) as total_vaksinasi, 
             COUNT(DISTINCT kecamatan) as jumlah_kecamatan, 
             COUNT(DISTINCT desa) as jumlah_desa, 
             COUNT(DISTINCT namapemilik) as jumlah_pemilik'
        );
        $this->db->from($this->_table);
        $this->db->group_by(['YEAR(tanggal_vaksinasi)', 'MONTH(tanggal_vaksinasi)']);
        $this->db->order_by('tahun DESC, bulan DESC');
        return $this->db->get()->result();
    }

    public function get_rekap_by_petugas($filters = [])
    {
        $this->db->select(
            'namapetugas, 
             COUNT(*) as total_vaksinasi, 
             COUNT(DISTINCT kecamatan) as jumlah_kecamatan, 
             COUNT(DISTINCT desa) as jumlah_desa, 
             MIN(tanggal_vaksinasi) as vaksinasi_pertama, 
             MAX(tanggal_vaksinasi) as vaksinasi_terakhir'
        );
        $this->db->from($this->_table);

        if (!empty($filters['bulan'])) {
            $this->db->where('MONTH(tanggal_vaksinasi)', $filters['bulan']);
        }
        if (!empty($filters['tahun'])) {
            $this->db->where('YEAR(tanggal_vaksinasi)', $filters['tahun']);
        }

        $this->db->group_by('namapetugas');
        $this->db->order_by('total_vaksinasi DESC');
        return $this->db->get()->result();
    }

    public function get_vaksinasi_distinct_periods()
    {
        $this->db->select('YEAR(tanggal_vaksinasi) as tahun, MONTH(tanggal_vaksinasi) as bulan');
        $this->db->from($this->_table);
        $this->db->group_by(['tahun', 'bulan']);
        $this->db->order_by('tahun DESC, bulan DESC');
        return $this->db->get()->result();
    }
}
