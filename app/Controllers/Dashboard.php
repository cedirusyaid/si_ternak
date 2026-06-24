<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $dashboardModel = new DashboardModel();

        $data['title'] = 'Dashboard';

        // Data untuk Info Boxes
        $data['total_kelompok']        = $dashboardModel->count_kelompok();
        $data['laporan_perkembangan'] = $dashboardModel->count_laporan_perkembangan();
        $data['total_ib']              = $dashboardModel->count_ib_bulan_ini();
        $data['laporan_pakan']         = $dashboardModel->count_laporan_pakan();
        $data['total_hewan']           = $dashboardModel->count_hewan();

        // Data untuk Chart
        $chart_data = $dashboardModel->get_pakan_chart_data();
        $labels     = [];
        $values     = [];
        $month_names = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

        foreach ($chart_data as $row) {
            $labels[] = $month_names[(int)$row['bulan']] . ' ' . $row['tahun'];
            $values[] = (int)$row['total_produksi'];
        }

        $data['chart_labels'] = json_encode($labels);
        $data['chart_values'] = json_encode($values);
        
        return view('template/header', $data)
             . view('dashboard/v_dashboard', $data)
             . view('template/footer');
    }
}
