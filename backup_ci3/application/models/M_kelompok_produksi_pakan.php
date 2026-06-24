<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kelompok_produksi_pakan extends CI_Model {
    private $_table = "kelompok_produksi_pakan";

    public function get_all()
    {
        return $this->db->get($this->_table)->result();
    }
}