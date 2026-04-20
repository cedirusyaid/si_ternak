<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_dashboard');
    }

    public function index() {
        $data['title'] = 'Dashboard';

        // Data untuk Info Boxes
        $data['total_kelompok'] = $this->M_dashboard->count_kelompok();
        $data['laporan_perkembangan'] = $this->M_dashboard->count_laporan_perkembangan();
        $data['total_ib'] = $this->M_dashboard->count_ib_bulan_ini();
        $data['laporan_pakan'] = $this->M_dashboard->count_laporan_pakan();
        $data['total_hewan'] = $this->M_dashboard->count_hewan();

        // Data untuk Chart
        $chart_data = $this->M_dashboard->get_pakan_chart_data();
        $labels = [];
        $values = [];
        $month_names = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

        foreach ($chart_data as $row) {
            $labels[] = $month_names[(int)$row['bulan']] . ' ' . $row['tahun'];
            $values[] = (int)$row['total_produksi'];
        }

        $data['chart_labels'] = json_encode($labels);
        $data['chart_values'] = json_encode($values);
        
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/v_dashboard', $data);
        $this->load->view('template/footer');
    }
}