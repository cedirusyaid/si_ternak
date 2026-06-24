<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

    private $_table = "users";

    // Mengambil semua data user
    public function get_all() {
        return $this->db->get($this->_table)->result();
    }

    // Mengambil data user berdasarkan ID
    public function get_by_id($id) {
        return $this->db->get_where($this->_table, ['id' => $id])->row();
    }
    
    // Mengambil data user berdasarkan username untuk login
    public function get_by_username($username) {
        return $this->db->get_where($this->_table, ['username' => $username])->row();
    }
    
    // Menyimpan data user baru
    public function save() {
        $post = $this->input->post();
        $data = [
            'username' => $post['username'],
            'password' => password_hash($post['password'], PASSWORD_BCRYPT),
            'nama_lengkap' => $post['nama_lengkap'],
            'email' => $post['email'],
            'nip' => $post['nip'],
            'jabatan' => $post['jabatan'],
            'role' => $post['role'],
            'is_active' => $post['is_active']
        ];
        return $this->db->insert($this->_table, $data);
    }

    // Mengubah data user
    public function update() {
        $post = $this->input->post();
        $data = [
            'username' => $post['username'],
            'nama_lengkap' => $post['nama_lengkap'],
            'email' => $post['email'],
            'nip' => $post['nip'],
            'jabatan' => $post['jabatan'],
            'role' => $post['role'],
            'is_active' => $post['is_active']
        ];

        // Jika ada password baru, hash dan update passwordnya
        if (!empty($post['password'])) {
            $data['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
        }

        return $this->db->update($this->_table, $data, ['id' => $post['id']]);
    }

    // Menghapus data user
    public function delete($id) {
        return $this->db->delete($this->_table, ['id' => $id]);
    }

    // Update waktu login terakhir
    public function update_last_login($id) {
        $this->db->where('id', $id);
        $this->db->update($this->_table, ['last_login' => date('Y-m-d H:i:s')]);
    }
}