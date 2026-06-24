<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kelompok_ternak extends CI_Model {
    private $_table = "kelompok_ternak";

public function get_all() {
        $this->db->select(
            'kelompok_ternak.*, 
             kode_kecamatan.kecamatan_nama, 
             kode_desa.desa_nama'
        );
        $this->db->from($this->_table);
        $this->db->join('kode_kecamatan', 'kelompok_ternak.kecamatan_id = kode_kecamatan.kecamatan_id', 'left');
        $this->db->join('kode_desa', 'kelompok_ternak.desa_id = kode_desa.desa_id', 'left');
        $this->db->order_by('kelompok_ternak.id', 'DESC');
        return $this->db->get()->result();
    }
    public function get_by_id($id) {
        return $this->db->get_where($this->_table, ['id' => $id])->row();
    }

public function save() {
    $post = $this->input->post();
    $data = [
        'kode_kelompok' => $post['kode_kelompok'],
        'nama_kelompok' => $post['nama_kelompok'],
        'desa_id' => $post['desa_id'], // <-- PERBAIKAN
        'kecamatan_id' => $post['kecamatan_id'], // <-- PERBAIKAN
        'alamat_lengkap' => $post['alamat_lengkap'],
        'tahun_anggaran' => $post['tahun_anggaran'],
        'sumber_dana' => $post['sumber_dana'],
        'rasternak' => $post['rasternak']
    ];
    return $this->db->insert($this->_table, $data);
}

public function update() {
    $post = $this->input->post();
    $data = [
        'kode_kelompok' => $post['kode_kelompok'],
        'nama_kelompok' => $post['nama_kelompok'],
        'desa_id' => $post['desa_id'], // <-- PERBAIKAN
        'kecamatan_id' => $post['kecamatan_id'], // <-- PERBAIKAN
        'alamat_lengkap' => $post['alamat_lengkap'],
        'tahun_anggaran' => $post['tahun_anggaran'],
        'sumber_dana' => $post['sumber_dana'],
        'rasternak' => $post['rasternak']
    ];
    return $this->db->update($this->_table, $data, ['id' => $post['id']]);
}
    public function delete($id) {
        return $this->db->delete($this->_table, ['id' => $id]);
    }
}