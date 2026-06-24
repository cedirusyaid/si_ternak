<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pakan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_jenis_pakan');
    }

    public function index()
    {
        $data['title'] = 'Data Jenis Pakan';
        $data['pakan'] = $this->M_jenis_pakan->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('pakan/v_pakan_index', $data);
        $this->load->view('template/footer');
    }

    public function create()
    {
        $data['title'] = 'Tambah Jenis Pakan';
        $this->load->view('template/header', $data);
        $this->load->view('pakan/v_pakan_form');
        $this->load->view('template/footer');
    }

    public function store()
    {
        $data = array(
            'id_jenis_pakan' => $this->input->post('id_jenis_pakan'),
            'nama_jenis' => $this->input->post('nama_jenis'),
            'kategori' => $this->input->post('kategori'),
            'satuan' => $this->input->post('satuan')
        );
        $this->M_jenis_pakan->insert($data);
        redirect('pakan');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Jenis Pakan';
        $data['pakan'] = $this->M_jenis_pakan->get_by_id($id);
        $this->load->view('template/header', $data);
        $this->load->view('pakan/v_pakan_form', $data);
        $this->load->view('template/footer');
    }

    public function update($id)
    {
        $data = array(
            'nama_jenis' => $this->input->post('nama_jenis'),
            'kategori' => $this->input->post('kategori'),
            'satuan' => $this->input->post('satuan')
        );
        $this->M_jenis_pakan->update($id, $data);
        redirect('pakan');
    }

    public function delete($id)
    {
        $this->M_jenis_pakan->delete($id);
        redirect('pakan');
    }

    public function laporan_produksi()
    {
        $this->load->model('M_laporan_produksi_pakan');
        $data['title'] = 'Daftar Laporan Produksi Pakan';
        $data['laporan'] = $this->M_laporan_produksi_pakan->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('pakan/v_laporan_produksi_index', $data);
        $this->load->view('template/footer');
    }

    public function laporan_produksi_create()
    {
        $this->load->model('M_kelompok_produksi_pakan');
        $this->load->model('M_jenis_pakan');
        $data['title'] = 'Tambah Laporan Produksi Pakan';
        $data['kelompok'] = $this->M_kelompok_produksi_pakan->get_all();
        $data['jenis_pakan'] = $this->M_jenis_pakan->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('pakan/v_laporan_produksi_form', $data);
        $this->load->view('template/footer');
    }

    public function laporan_produksi_store()
    {
        $this->load->model('M_laporan_produksi_pakan');
        $this->load->model('M_detail_produksi_pakan');

        $laporan_data = array(
            'id_kelompok' => $this->input->post('id_kelompok'),
            'bulan' => $this->input->post('bulan'),
            'tahun' => $this->input->post('tahun'),
            'status' => 'draft'
        );
        $id_laporan = $this->M_laporan_produksi_pakan->insert($laporan_data);

        $id_jenis_pakan = $this->input->post('id_jenis_pakan');
        $jumlah_produksi = $this->input->post('jumlah_produksi');

        for ($i = 0; $i < count($id_jenis_pakan); $i++) {
            $detail_data = array(
                'id_laporan' => $id_laporan,
                'id_jenis_pakan' => $id_jenis_pakan[$i],
                'jumlah_produksi' => $jumlah_produksi[$i]
            );
            $this->M_detail_produksi_pakan->insert($detail_data);
        }

        redirect('pakan/laporan_produksi');
    }

    public function laporan_produksi_detail($id)
    {
        $this->load->model('M_laporan_produksi_pakan');
        $this->load->model('M_detail_produksi_pakan');

        $data['title'] = 'Detail Laporan Produksi Pakan';
        $data['laporan'] = $this->M_laporan_produksi_pakan->get_by_id($id);
        $data['detail'] = $this->M_detail_produksi_pakan->get_by_laporan($id);

        $this->load->view('template/header', $data);
        $this->load->view('pakan/v_laporan_produksi_detail', $data);
        $this->load->view('template/footer');
    }

    public function laporan_produksi_edit($id)
    {
        $this->load->model('M_laporan_produksi_pakan');
        $this->load->model('M_detail_produksi_pakan');
        $this->load->model('M_kelompok_produksi_pakan');
        $this->load->model('M_jenis_pakan');

        $data['title'] = 'Edit Laporan Produksi Pakan';
        $data['laporan'] = $this->M_laporan_produksi_pakan->get_by_id($id);
        $data['detail'] = $this->M_detail_produksi_pakan->get_by_laporan($id);
        $data['kelompok'] = $this->M_kelompok_produksi_pakan->get_all();
        $data['jenis_pakan'] = $this->M_jenis_pakan->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('pakan/v_laporan_produksi_form_edit', $data);
        $this->load->view('template/footer');
    }

    public function laporan_bulanan()
    {
        $this->load->model('M_laporan_produksi_pakan');
        $this->load->model('M_jenis_pakan');

        $data['title'] = 'Laporan Bulanan Produksi Pakan';
        $data['all_jenis_pakan'] = $this->M_jenis_pakan->get_all();

        $selected_period = $this->input->get('periode');
        $filters = [];
        if ($selected_period) {
            list($filters['bulan'], $filters['tahun']) = explode('-', $selected_period);
        }

        $raw_data = $this->M_laporan_produksi_pakan->get_production_report_data($filters);
        
        $processed_data = [];
        foreach ($raw_data as $row) {
            $kecamatan = $row['kecamatan'];
            $kelompok = $row['nama_kelompok'];
            $jenis_pakan = $row['nama_jenis'];
            $jumlah = $row['jumlah_produksi'];

            if (!isset($processed_data[$kecamatan])) {
                $processed_data[$kecamatan] = [];
            }
            if (!isset($processed_data[$kecamatan][$kelompok])) {
                $processed_data[$kecamatan][$kelompok]['alamat'] = $row['desa'];
                foreach ($data['all_jenis_pakan'] as $jp) {
                    $processed_data[$kecamatan][$kelompok][$jp->nama_jenis] = 0;
                }
            }
            if ($jenis_pakan) {
                $processed_data[$kecamatan][$kelompok][$jenis_pakan] = $jumlah;
            }
        }

        $periods = $this->M_laporan_produksi_pakan->get_distinct_periods();
        $grouped_periods = [];
        foreach ($periods as $p) {
            if (!isset($grouped_periods[$p->tahun])) {
                $grouped_periods[$p->tahun] = [];
            }
            $grouped_periods[$p->tahun][] = $p->bulan;
        }

        $data['laporan'] = $processed_data;
        $data['grouped_periods'] = $grouped_periods;
        $data['selected_period'] = $selected_period;
        $data['selected_bulan'] = !empty($filters['bulan']) ? $filters['bulan'] : date('m');
        $data['selected_tahun'] = !empty($filters['tahun']) ? $filters['tahun'] : date('Y');

        $this->load->view('template/header', $data);
        $this->load->view('pakan/v_laporan_bulanan_index', $data);
        $this->load->view('template/footer');
    }
}