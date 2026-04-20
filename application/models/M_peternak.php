<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_peternak extends CI_Model {
    private $_table = "peternak";

    public function get_all() {
        $this->db->select('peternak.*, COUNT(hewan.id_hewan) as jumlah_hewan');
        $this->db->from($this->_table);
        $this->db->join('hewan', 'hewan.id_peternak = peternak.id_peternak AND hewan.status = \'aktif\'', 'left');
        $this->db->group_by('peternak.id_peternak');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->_table, ['id_peternak' => $id])->row();
    }

    public function save() {
        $post = $this->input->post();
        $data = [
            'id_peternak' => $post['id_peternak'],
            'nama_peternak' => $post['nama_peternak'],
            'alamat' => $post['alamat'],
            'desa' => $post['desa'],
            'kecamatan' => $post['kecamatan'],
            'no_hp' => $post['no_hp']
        ];
        return $this->db->insert($this->_table, $data);
    }

    public function update() {
        $post = $this->input->post();
        $data = [
            'nama_peternak' => $post['nama_peternak'],
            'alamat' => $post['alamat'],
            'desa' => $post['desa'],
            'kecamatan' => $post['kecamatan'],
            'no_hp' => $post['no_hp']
        ];
        return $this->db->update($this->_table, $data, ['id_peternak' => $post['id_peternak']]);
    }

    public function delete($id) {
        return $this->db->delete($this->_table, ['id_peternak' => $id]);
    }
}