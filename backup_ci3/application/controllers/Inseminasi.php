<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inseminasi extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_inseminasi');
        // Tambahkan model lain jika diperlukan, misal M_hewan, M_petugas
    }

    //============================================
    // INSEMINASI BUATAN (IB)
    //============================================

    public function index()
    {
        $data['title'] = 'Data Inseminasi Buatan';
        $data['inseminasi'] = $this->M_inseminasi->get_inseminasi();
        $this->load->view('template/header', $data);
        $this->load->view('inseminasi/v_inseminasi_index', $data);
        $this->load->view('template/footer');
    }

    public function tambah_ib()
    {
        $data['title'] = 'Tambah Data IB';
        $data['hewan'] = $this->M_inseminasi->get_list_hewan();
        $this->load->view('template/header', $data);
        $this->load->view('inseminasi/v_inseminasi_form', $data);
        $this->load->view('template/footer');
    }

    public function store_ib()
    {
        $data = [
            'id_ib' => 'IB'.time(), // Contoh ID unik
            'id_hewan' => $this->input->post('id_hewan'),
            'tanggal_ib' => $this->input->post('tanggal_ib'),
            'id_petugas' => $this->input->post('id_petugas'),
            'ib_ke' => $this->input->post('ib_ke'),
            'id_pejantan' => $this->input->post('id_pejantan'),
            'bangsa_pejantan' => $this->input->post('bangsa_pejantan'),
            'status' => $this->input->post('status'),
            'created_by' => $this->session->userdata('user_id') // Asumsi user_id disimpan di session
        ];

        $this->M_inseminasi->insert_inseminasi($data);
        $this->session->set_flashdata('success', 'Data Inseminasi Buatan berhasil ditambahkan.');
        redirect('inseminasi');
    }

    public function edit_ib($id)
    {
        $data['title'] = 'Edit Data IB';
        $data['ib'] = $this->M_inseminasi->get_inseminasi($id);
        $data['hewan'] = $this->M_inseminasi->get_list_hewan();
        $data['petugas'] = $this->M_inseminasi->get_list_petugas();

        if (!$data['ib']) {
            show_404();
        }

        $this->template->load('template/template', 'inseminasi/v_inseminasi_form', $data);
    }

    public function update_ib($id)
    {
        $data = [
            'id_hewan' => $this->input->post('id_hewan'),
            'tanggal_ib' => $this->input->post('tanggal_ib'),
            'id_petugas' => $this->input->post('id_petugas'),
            'ib_ke' => $this->input->post('ib_ke'),
            'id_pejantan' => $this->input->post('id_pejantan'),
            'bangsa_pejantan' => $this->input->post('bangsa_pejantan'),
            'status' => $this->input->post('status'),
        ];

        $this->M_inseminasi->update_inseminasi($id, $data);
        $this->session->set_flashdata('success', 'Data Inseminasi Buatan berhasil diperbarui.');
        redirect('inseminasi');
    }

    public function destroy_ib($id)
    {
        $this->M_inseminasi->delete_inseminasi($id);
        $this->session->set_flashdata('success', 'Data Inseminasi Buatan berhasil dihapus.');
        redirect('inseminasi');
    }

    //============================================
    // KELAHIRAN
    //============================================

    public function tambah_kelahiran()
    {
        $data['title'] = 'Tambah Data Kelahiran';
        $data['hewan'] = $this->M_inseminasi->get_list_hewan();
        $data['petugas'] = $this->M_inseminasi->get_list_petugas();
        $this->load->view('template/header', $data);
        $this->load->view('inseminasi/v_kelahiran_form', $data);
        $this->load->view('template/footer');
    }

    public function store_kelahiran()
    {
        $data = $this->input->post();
        $this->M_inseminasi->insert_kelahiran($data);
        $this->session->set_flashdata('success', 'Data kelahiran berhasil ditambahkan.');
        redirect('inseminasi/kelahiran');
    }

    public function edit_kelahiran($id)
    {
        $data['title'] = 'Edit Data Kelahiran';
        $data['kelahiran'] = $this->M_inseminasi->get_kelahiran($id);
        $data['hewan'] = $this->M_inseminasi->get_list_hewan();
        $data['petugas'] = $this->M_inseminasi->get_list_petugas();
        $this->load->view('template/header', $data);
        $this->load->view('inseminasi/v_kelahiran_form', $data);
        $this->load->view('template/footer');
    }

    public function update_kelahiran($id)
    {
        $data = $this->input->post();
        $this->M_inseminasi->update_kelahiran($id, $data);
        $this->session->set_flashdata('success', 'Data kelahiran berhasil diperbarui.');
        redirect('inseminasi/kelahiran');
    }

    public function destroy_kelahiran($id)
    {
        $this->M_inseminasi->delete_kelahiran($id);
        $this->session->set_flashdata('success', 'Data kelahiran berhasil dihapus.');
        redirect('inseminasi/kelahiran');
    }

    //============================================
    // PEMERIKSAAN KEBUNTINGAN (PKB)
    //============================================

    public function tambah_pkb()
    {
        $data['title'] = 'Tambah Data PKB';
        $data['hewan'] = $this->M_inseminasi->get_list_hewan();
        $data['petugas'] = $this->M_inseminasi->get_list_petugas();
        $this->load->view('template/header', $data);
        $this->load->view('inseminasi/v_pkb_form', $data);
        $this->load->view('template/footer');
    }

    public function store_pkb()
    {
        $data = $this->input->post();
        $this->M_inseminasi->insert_pkb($data);
        $this->session->set_flashdata('success', 'Data PKB berhasil ditambahkan.');
        redirect('inseminasi/pkb');
    }

    public function edit_pkb($id)
    {
        $data['title'] = 'Edit Data PKB';
        $data['pkb'] = $this->M_inseminasi->get_pkb($id);
        $data['hewan'] = $this->M_inseminasi->get_list_hewan();
        $data['petugas'] = $this->M_inseminasi->get_list_petugas();
        $this->load->view('template/header', $data);
        $this->load->view('inseminasi/v_pkb_form', $data);
        $this->load->view('template/footer');
    }

    public function update_pkb($id)
    {
        $data = $this->input->post();
        $this->M_inseminasi->update_pkb($id, $data);
        $this->session->set_flashdata('success', 'Data PKB berhasil diperbarui.');
        redirect('inseminasi/pkb');
    }

    public function destroy_pkb($id)
    {
        $this->M_inseminasi->delete_pkb($id);
        $this->session->set_flashdata('success', 'Data PKB berhasil dihapus.');
        redirect('inseminasi/pkb');
    }

    public function pkb()
    {
        $data['title'] = 'Data Pemeriksaan Kebuntingan';
        $data['pkb'] = $this->M_inseminasi->get_pkb();
        $this->load->view('template/header', $data);
        $this->load->view('inseminasi/v_pkb_index', $data);
        $this->load->view('template/footer');
    }
}
