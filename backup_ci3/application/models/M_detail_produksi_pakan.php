<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_detail_produksi_pakan extends CI_Model {
    private $_table = "detail_produksi_pakan";

    public function insert($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function get_by_laporan($id_laporan)
    {
        $this->db->select('detail_produksi_pakan.*, jenis_pakan.nama_jenis');
        $this->db->from($this->_table);
        $this->db->join('jenis_pakan', 'detail_produksi_pakan.id_jenis_pakan = jenis_pakan.id_jenis_pakan');
        $this->db->where('id_laporan', $id_laporan);
        return $this->db->get()->result();
    }

    public function delete_by_laporan($id_laporan)
    {
        return $this->db->delete($this->_table, ['id_laporan' => $id_laporan]);
    }
}