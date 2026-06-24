<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_petugas');
        $this->load->model('M_peternak');
        $this->load->model('M_jenis_pakan');
    }

    // --- CRUD PETUGAS ---
    public function petugas() {
        $data['title'] = "Petugas Lapangan";
        $data['petugas_list'] = $this->M_petugas->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('master/petugas/v_index', $data);
        $this->load->view('template/footer');
    }

    public function petugas_add() {
        $this->form_validation->set_rules('id_petugas', 'ID Petugas', 'required|is_unique[petugas_lapangan.id_petugas]');
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required');

        if ($this->form_validation->run()) {
            $this->M_petugas->save();
            $this->session->set_flashdata('success', 'Data berhasil ditambahkan.');
            redirect('master/petugas');
        }
        
        $data['title'] = "Tambah Petugas";
        $this->load->view('template/header', $data);
        $this->load->view('master/petugas/v_form');
        $this->load->view('template/footer');
    }

    public function petugas_edit($id) {
        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required');

        if ($this->form_validation->run()) {
            $this->M_petugas->update();
            $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
            redirect('master/petugas');
        }

        $data['title'] = "Edit Petugas";
        $data['petugas'] = $this->M_petugas->get_by_id($id);
        $this->load->view('template/header', $data);
        $this->load->view('master/petugas/v_form', $data);
        $this->load->view('template/footer');
    }

    public function petugas_delete($id) {
        $this->M_petugas->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('master/petugas');
    }

    // --- CRUD PETERNAK ---
    public function peternak() {
        $data['title'] = "Data Peternak";
        $data['peternak_list'] = $this->M_peternak->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('master/peternak/v_index', $data);
        $this->load->view('template/footer');
    }
    
    public function peternak_add() {
        $this->form_validation->set_rules('id_peternak', 'ID Peternak', 'required|is_unique[peternak.id_peternak]');
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required');

        if ($this->form_validation->run()) {
            $this->M_peternak->save();
            $this->session->set_flashdata('success', 'Data berhasil ditambahkan.');
            redirect('master/peternak');
        }

        $data['title'] = "Tambah Peternak";
        $this->load->view('template/header', $data);
        $this->load->view('master/peternak/v_form', $data);
        $this->load->view('template/footer');
    }

    public function peternak_edit($id) {
        $this->form_validation->set_rules('nama_peternak', 'Nama Peternak', 'required');

        if ($this->form_validation->run()) {
            $this->M_peternak->update();
            $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
            redirect('master/peternak');
        }
        
        $data['title'] = "Edit Peternak";
        $data['peternak'] = $this->M_peternak->get_by_id($id);
        $this->load->view('template/header', $data);
        $this->load->view('master/peternak/v_form', $data);
        $this->load->view('template/footer');
    }

    public function peternak_delete($id) {
        $this->M_peternak->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('master/peternak');
    }


    // --- CRUD JENIS PAKAN ---
    public function pakan() {
        $data['title'] = "Jenis Pakan";
        $data['pakan_list'] = $this->M_jenis_pakan->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('master/pakan/v_index', $data);
        $this->load->view('template/footer');
    }
    
    public function pakan_add() {
        $this->form_validation->set_rules('id_jenis_pakan', 'ID Jenis Pakan', 'required|is_unique[jenis_pakan.id_jenis_pakan]');
        $this->form_validation->set_rules('nama_jenis', 'Nama Jenis', 'required');

        if ($this->form_validation->run()) {
            $this->M_jenis_pakan->save();
            $this->session->set_flashdata('success', 'Data berhasil ditambahkan.');
            redirect('master/pakan');
        }

        $data['title'] = "Tambah Jenis Pakan";
        $this->load->view('template/header', $data);
        $this->load->view('master/pakan/v_form', $data);
        $this->load->view('template/footer');
    }

    public function pakan_edit($id) {
        $this->form_validation->set_rules('nama_jenis', 'Nama Jenis', 'required');

        if ($this->form_validation->run()) {
            $this->M_jenis_pakan->update();
            $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
            redirect('master/pakan');
        }
        
        $data['title'] = "Edit Jenis Pakan";
        $data['pakan'] = $this->M_jenis_pakan->get_by_id($id);
        $this->load->view('template/header', $data);
        $this->load->view('master/pakan/v_form', $data);
        $this->load->view('template/footer');
    }
    
    public function pakan_delete($id) {
        $this->M_jenis_pakan->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('master/pakan');
    }

    // --- CRUD HEWAN ---
    public function hewan() {
        $this->load->model('M_hewan');
        $data['title'] = "Data Hewan";
        $data['hewan_list'] = $this->M_hewan->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('master/hewan/v_index', $data);
        $this->load->view('template/footer');
    }

    public function hewan_add() {
        $this->load->model('M_hewan');
        $this->form_validation->set_rules('id_hewan', 'ID Hewan', 'required|is_unique[hewan.id_hewan]');
        $this->form_validation->set_rules('nama_hewan', 'Nama Hewan', 'required');
        $this->form_validation->set_rules('id_peternak', 'Pemilik', 'required');

        if ($this->form_validation->run()) {
            $this->M_hewan->save();
            $this->session->set_flashdata('success', 'Data hewan berhasil ditambahkan.');
            redirect('master/hewan');
        }

        $data['title'] = "Tambah Data Hewan";
        $data['peternak_list'] = $this->M_peternak->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('master/hewan/v_form', $data);
        $this->load->view('template/footer');
    }

    public function hewan_edit($id) {
        $this->load->model('M_hewan');
        $this->form_validation->set_rules('nama_hewan', 'Nama Hewan', 'required');
        $this->form_validation->set_rules('id_peternak', 'Pemilik', 'required');

        if ($this->form_validation->run()) {
            $this->M_hewan->update();
            $this->session->set_flashdata('success', 'Data hewan berhasil diperbarui.');
            redirect('master/hewan');
        }
        
        $data['title'] = "Edit Data Hewan";
        $data['hewan'] = $this->M_hewan->get_by_id($id);
        $data['peternak_list'] = $this->M_peternak->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('master/hewan/v_form', $data);
        $this->load->view('template/footer');
    }

    public function hewan_delete($id) {
        $this->load->model('M_hewan');
        $this->M_hewan->delete($id);
        $this->session->set_flashdata('success', 'Data hewan berhasil dihapus.');
        redirect('master/hewan');
    }
}