<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Controller ini mewarisi MY_Controller, bukan CI_Controller
class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_user');
    }

    public function index() {
        $data['title'] = "Manajemen Pengguna";
        $data['users'] = $this->M_user->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('user/v_user_index', $data);
        $this->load->view('template/footer');
    }

    public function add() {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        
        if ($this->form_validation->run()) {
            $this->M_user->save();
            $this->session->set_flashdata('success', 'Data user berhasil ditambahkan.');
            redirect('user');
        }
        
        $data['title'] = "Tambah Pengguna";
        $this->load->view('template/header', $data);
        $this->load->view('user/v_user_form', $data);
        $this->load->view('template/footer');
    }

    public function edit($id = null) {
        if (!isset($id)) redirect('user');
        
        $user = $this->M_user->get_by_id($id);
        if (!$user) redirect('user');

        // Rule untuk username, cek unik jika username diubah
        $is_unique = ($this->input->post('username') != $user->username) ? '|is_unique[users.username]' : '';
        $this->form_validation->set_rules('username', 'Username', 'required' . $is_unique);
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');

        if ($this->form_validation->run()) {
            $this->M_user->update();
            $this->session->set_flashdata('success', 'Data user berhasil diperbarui.');
            redirect('user');
        }

        $data['title'] = "Edit Pengguna";
        $data['user'] = $user;
        $this->load->view('template/header', $data);
        $this->load->view('user/v_user_form', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null) {
        if (!isset($id)) redirect('user');
        
        if ($this->M_user->delete($id)) {
            $this->session->set_flashdata('success', 'Data user berhasil dihapus.');
            redirect('user');
        }
    }
}