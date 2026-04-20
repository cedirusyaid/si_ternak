<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_hewan extends CI_Model {
    private $_table = "hewan";

    public function get_all() {
        $this->db->select('hewan.*, peternak.nama_peternak');
        $this->db->from($this->_table);
        $this->db->join('peternak', 'peternak.id_peternak = hewan.id_peternak', 'left');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->_table, ['id_hewan' => $id])->row();
    }

    public function save() {
        $post = $this->input->post();
        $data = [
            'id_hewan' => $post['id_hewan'],
            'id_peternak' => $post['id_peternak'],
            'nama_hewan' => $post['nama_hewan'],
            'bangsa_induk' => $post['bangsa_induk'],
            'jenis_kelamin' => $post['jenis_kelamin'],
            'tanggal_lahir' => $post['tanggal_lahir'],
            'status' => $post['status']
        ];
        return $this->db->insert($this->_table, $data);
    }

    public function update() {
        $post = $this->input->post();
        $data = [
            'id_peternak' => $post['id_peternak'],
            'nama_hewan' => $post['nama_hewan'],
            'bangsa_induk' => $post['bangsa_induk'],
            'jenis_kelamin' => $post['jenis_kelamin'],
            'tanggal_lahir' => $post['tanggal_lahir'],
            'status' => $post['status']
        ];
        return $this->db->update($this->_table, $data, ['id_hewan' => $post['id_hewan']]);
    }

    public function delete($id) {
        return $this->db->delete($this->_table, ['id_hewan' => $id]);
    }
}
