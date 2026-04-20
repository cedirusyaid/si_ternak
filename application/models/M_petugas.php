<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_petugas extends CI_Model {
    private $_table = "petugas_lapangan";

    public function get_all() {
        return $this->db->get($this->_table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->_table, ['id_petugas' => $id])->row();
    }

    public function save() {
        $post = $this->input->post();
        $data = [
            'id_petugas' => $post['id_petugas'],
            'nama_petugas' => $post['nama_petugas'],
            'nip' => $post['nip'],
            'pangkat' => $post['pangkat'],
            'jabatan' => $post['jabatan'],
            'no_hp' => $post['no_hp'],
            'is_active' => $post['is_active']
        ];
        return $this->db->insert($this->_table, $data);
    }

    public function update() {
        $post = $this->input->post();
        $data = [
            'nama_petugas' => $post['nama_petugas'],
            'nip' => $post['nip'],
            'pangkat' => $post['pangkat'],
            'jabatan' => $post['jabatan'],
            'no_hp' => $post['no_hp'],
            'is_active' => $post['is_active']
        ];
        return $this->db->update($this->_table, $data, ['id_petugas' => $post['id_petugas']]);
    }

    public function delete($id) {
        return $this->db->delete($this->_table, ['id_petugas' => $id]);
    }
}