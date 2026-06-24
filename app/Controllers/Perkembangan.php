<?php

namespace App\Controllers;

use App\Models\KelompokTernakModel;
use App\Models\LaporanBulananModel;
use App\Models\WilayahModel;

class Perkembangan extends BaseController
{
    // --- CRUD KELOMPOK TERNAK ---
    public function kelompok()
    {
        $kelompokModel = new KelompokTernakModel();
        $data['title'] = "Data Kelompok Ternak";
        $data['kelompok_list'] = $kelompokModel->get_all();

        return view('template/header', $data)
             . view('perkembangan/kelompok/v_index', $data)
             . view('template/footer');
    }
    
    public function kelompok_add()
    {
        $kelompokModel = new KelompokTernakModel();
        $wilayahModel = new WilayahModel();

        $rules = [
            'kode_kelompok' => 'required|is_unique[kelompok_ternak.kode_kelompok]',
            'nama_kelompok' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $kelompokModel->save_kelompok($this->request->getPost());
            session()->setFlashdata('success', 'Data kelompok berhasil ditambahkan.');
            return redirect()->to(base_url('perkembangan/kelompok'));
        }
        
        $data['title'] = "Tambah Kelompok Ternak";
        $data['kecamatan_list'] = $wilayahModel->get_all_kecamatan();
        return view('template/header', $data)
             . view('perkembangan/kelompok/v_form', $data)
             . view('template/footer');
    }

    public function kelompok_edit($id)
    {
        $kelompokModel = new KelompokTernakModel();
        $wilayahModel = new WilayahModel();

        $rules = [
            'nama_kelompok' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $kelompokModel->update_kelompok($this->request->getPost());
            session()->setFlashdata('success', 'Data kelompok berhasil diperbarui.');
            return redirect()->to(base_url('perkembangan/kelompok'));
        }

        $data['title'] = "Edit Kelompok Ternak";
        $data['kelompok'] = $kelompokModel->get_by_id($id);
        $data['kecamatan_list'] = $wilayahModel->get_all_kecamatan();
        return view('template/header', $data)
             . view('perkembangan/kelompok/v_form', $data)
             . view('template/footer');
    }

    public function kelompok_delete($id)
    {
        $kelompokModel = new KelompokTernakModel();
        $kelompokModel->delete_kelompok($id);
        session()->setFlashdata('success', 'Data kelompok berhasil dihapus.');
        return redirect()->to(base_url('perkembangan/kelompok'));
    }

    public function laporan()
    {
        $laporanModel = new LaporanBulananModel();
        $data['title'] = "Laporan Bulanan Perkembangan";
        
        $data['periods'] = $laporanModel->get_distinct_periods();
        $selected_period = $this->request->getGet('periode');
        
        if ($selected_period && $selected_period != '') {
            list($filter_tahun, $filter_bulan) = explode('-', $selected_period);
            $data['laporan_list'] = $laporanModel->get_all_with_kelompok($filter_tahun, $filter_bulan);
        } else {
            $data['laporan_list'] = [];
        }
        
        $data['selected_period'] = $selected_period;
        
        return view('template/header', $data)
             . view('perkembangan/laporan/v_index', $data)
             . view('template/footer');
    }

    public function laporan_add()
    {
        $laporanModel = new LaporanBulananModel();
        $kelompokModel = new KelompokTernakModel();

        $rules = [
            'kelompok_id' => 'required',
            'bulan'       => 'required',
            'tahun'       => 'required'
        ];
        
        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $laporanModel->save_laporan($this->request->getPost());
            session()->setFlashdata('success', 'Laporan bulanan berhasil ditambahkan.');
            return redirect()->to(base_url('perkembangan/laporan'));
        }
        
        $data['title'] = "Input Laporan Bulanan";
        $data['kelompok_list'] = $kelompokModel->get_all();
        return view('template/header', $data)
             . view('perkembangan/laporan/v_form', $data)
             . view('template/footer');
    }

    public function laporan_delete($id)
    {
        $laporanModel = new LaporanBulananModel();
        $laporanModel->delete_laporan($id);
        session()->setFlashdata('success', 'Laporan bulanan berhasil dihapus.');
        return redirect()->to(base_url('perkembangan/laporan'));
    }

    public function get_desa_by_kecamatan()
    {
        $wilayahModel = new WilayahModel();
        $kecamatan_id = $this->request->getPost('kecamatan_id');
        $desa_list = $wilayahModel->get_desa_by_kecamatan($kecamatan_id);
        
        return $this->response->setJSON($desa_list);
    }
}
