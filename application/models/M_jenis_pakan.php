<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jenis_pakan extends CI_Model {
    private $_table = "jenis_pakan";

    public function get_all()
    {
        return $this->db->get($this->_table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->_table, ['id_jenis_pakan' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->_table, $data, ['id_jenis_pakan' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, ['id_jenis_pakan' => $id]);
    }
}