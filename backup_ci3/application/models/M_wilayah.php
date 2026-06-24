<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_wilayah extends CI_Model {

    public function get_all_kecamatan() {
        $this->db->order_by('kecamatan_nama', 'ASC');
        return $this->db->get('kode_kecamatan')->result();
    }

    public function get_desa_by_kecamatan($kecamatan_id) {
        $this->db->where('kecamatan_id', $kecamatan_id);
        $this->db->order_by('desa_nama', 'ASC');
        return $this->db->get('kode_desa')->result();
    }
}