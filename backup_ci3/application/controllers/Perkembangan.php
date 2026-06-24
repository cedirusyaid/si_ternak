<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perkembangan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_kelompok_ternak');
        $this->load->model('M_laporan_bulanan');
        $this->load->model('M_wilayah');
    }

    // --- CRUD KELOMPOK TERNAK ---
    public function kelompok() {
        $data['title'] = "Data Kelompok Ternak";
        $data['kelompok_list'] = $this->M_kelompok_ternak->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('perkembangan/kelompok/v_index', $data);
        $this->load->view('template/footer');
    }
    
    public function kelompok_add() {
        $this->form_validation->set_rules('kode_kelompok', 'Kode Kelompok', 'required|is_unique[kelompok_ternak.kode_kelompok]');
        $this->form_validation->set_rules('nama_kelompok', 'Nama Kelompok', 'required');

        if ($this->form_validation->run()) {
            $this->M_kelompok_ternak->save();
            $this->session->set_flashdata('success', 'Data kelompok berhasil ditambahkan.');
            redirect('perkembangan/kelompok');
        }
        
    $data['title'] = "Tambah Kelompok Ternak";
    $data['kecamatan_list'] = $this->M_wilayah->get_all_kecamatan(); // <-- TAMBAHKAN INI
    $this->load->view('template/header', $data);
    $this->load->view('perkembangan/kelompok/v_form', $data);
    $this->load->view('template/footer');
    }

    public function kelompok_edit($id) {
        $this->form_validation->set_rules('nama_kelompok', 'Nama Kelompok', 'required');

        if ($this->form_validation->run()) {
            $this->M_kelompok_ternak->update();
            $this->session->set_flashdata('success', 'Data kelompok berhasil diperbarui.');
            redirect('perkembangan/kelompok');
        }

    $data['title'] = "Edit Kelompok Ternak";
    $data['kelompok'] = $this->M_kelompok_ternak->get_by_id($id);
    $data['kecamatan_list'] = $this->M_wilayah->get_all_kecamatan(); // <-- TAMBAHKAN INI
    $this->load->view('template/header', $data);
    $this->load->view('perkembangan/kelompok/v_form', $data);
    $this->load->view('template/footer');
    }

    public function kelompok_delete($id) {
        $this->M_kelompok_ternak->delete($id);
        $this->session->set_flashdata('success', 'Data kelompok berhasil dihapus.');
        redirect('perkembangan/kelompok');
    }
public function laporan() {
    $data['title'] = "Laporan Bulanan Perkembangan";
    
    // Ambil data untuk dropdown filter
    $data['periods'] = $this->M_laporan_bulanan->get_distinct_periods();
    
    $selected_period = $this->input->get('periode');
    
    // Logika baru: Hanya ambil data jika periode dipilih
    if ($selected_period && $selected_period != '') {
        // Pisahkan tahun dan bulan dari format 'YYYY-MM'
        list($filter_tahun, $filter_bulan) = explode('-', $selected_period);
        // Ambil data laporan yang difilter
        $data['laporan_list'] = $this->M_laporan_bulanan->get_all_with_kelompok($filter_tahun, $filter_bulan);
    } else {
        // Jika tidak ada periode yang dipilih, kirim array kosong
        $data['laporan_list'] = [];
    }
    
    // Kirim periode yang dipilih kembali ke view untuk menjaga pilihan dropdown
    $data['selected_period'] = $selected_period;
    
    $this->load->view('template/header', $data);
    $this->load->view('perkembangan/laporan/v_index', $data);
    $this->load->view('template/footer');
}
    public function laporan_add() {
        $this->form_validation->set_rules('kelompok_id', 'Kelompok Ternak', 'required');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required');
        
        if ($this->form_validation->run()) {
            $this->M_laporan_bulanan->save();
            $this->session->set_flashdata('success', 'Laporan bulanan berhasil ditambahkan.');
            redirect('perkembangan/laporan');
        }
        
        $data['title'] = "Input Laporan Bulanan";
        $data['kelompok_list'] = $this->M_kelompok_ternak->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('perkembangan/laporan/v_form', $data);
        $this->load->view('template/footer');
    }

    public function laporan_delete($id) {
        $this->M_laporan_bulanan->delete($id);
        $this->session->set_flashdata('success', 'Laporan bulanan berhasil dihapus.');
        redirect('perkembangan/laporan');
    }

public function get_desa_by_kecamatan() {
    // PERBAIKAN: Menerima 'kecamatan_id' dari AJAX
    $kecamatan_id = $this->input->post('kecamatan_id');
    $desa_list = $this->M_wilayah->get_desa_by_kecamatan($kecamatan_id);
    
    // Mengembalikan data dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($desa_list);
}

}