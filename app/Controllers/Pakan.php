<?php

namespace App\Controllers;

use App\Models\JenisPakanModel;
use App\Models\LaporanProduksiPakanModel;
use App\Models\KelompokProduksiPakanModel;
use App\Models\DetailProduksiPakanModel;

class Pakan extends BaseController
{
    public function index()
    {
        $jenisPakanModel = new JenisPakanModel();
        $data['title'] = 'Data Jenis Pakan';
        $data['pakan'] = $jenisPakanModel->get_all();

        return view('template/header', $data)
             . view('pakan/v_pakan_index', $data)
             . view('template/footer');
    }

    public function create()
    {
        $data['title'] = 'Tambah Jenis Pakan';
        return view('template/header', $data)
             . view('pakan/v_pakan_form')
             . view('template/footer');
    }

    public function store()
    {
        $jenisPakanModel = new JenisPakanModel();
        $data = [
            'id_jenis_pakan' => $this->request->getPost('id_jenis_pakan'),
            'nama_jenis'     => $this->request->getPost('nama_jenis'),
            'kategori'       => $this->request->getPost('kategori'),
            'satuan'         => $this->request->getPost('satuan')
        ];
        $jenisPakanModel->insert($data);
        return redirect()->to(base_url('pakan'));
    }

    public function edit($id)
    {
        $jenisPakanModel = new JenisPakanModel();
        $data['title'] = 'Edit Jenis Pakan';
        $data['pakan'] = $jenisPakanModel->get_by_id($id);

        return view('template/header', $data)
             . view('pakan/v_pakan_form', $data)
             . view('template/footer');
    }

    public function update($id)
    {
        $jenisPakanModel = new JenisPakanModel();
        $data = [
            'nama_jenis'     => $this->request->getPost('nama_jenis'),
            'kategori'       => $this->request->getPost('kategori'),
            'satuan'         => $this->request->getPost('satuan')
        ];
        $jenisPakanModel->update($id, $data);
        return redirect()->to(base_url('pakan'));
    }

    public function delete($id)
    {
        $jenisPakanModel = new JenisPakanModel();
        $jenisPakanModel->delete($id);
        return redirect()->to(base_url('pakan'));
    }

    public function laporan_produksi()
    {
        $laporanModel = new LaporanProduksiPakanModel();
        
        $default_bulan = date('n', strtotime('first day of last month'));
        $default_tahun = date('Y', strtotime('first day of last month'));
        
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');
        
        if ($bulan === null) {
            $bulan = $default_bulan;
        }
        if ($tahun === null) {
            $tahun = $default_tahun;
        }
        
        $filters = [];
        if ($bulan !== 'all') {
            $filters['bulan'] = $bulan;
        }
        if ($tahun !== 'all') {
            $filters['tahun'] = $tahun;
        }

        $data['title'] = 'Daftar Laporan Produksi Pakan';
        $data['laporan'] = $laporanModel->get_all($filters);
        $data['selected_bulan'] = $bulan;
        $data['selected_tahun'] = $tahun;

        return view('template/header', $data)
             . view('pakan/v_laporan_produksi_index', $data)
             . view('template/footer');
    }

    public function laporan_produksi_create()
    {
        $kelompokModel = new KelompokProduksiPakanModel();
        $jenisPakanModel = new JenisPakanModel();

        $data['title'] = 'Tambah Laporan Produksi Pakan';
        $data['kelompok'] = $kelompokModel->get_all();
        $data['jenis_pakan'] = $jenisPakanModel->get_all();
        
        $data['default_kelompok'] = $this->request->getGet('id_kelompok');
        $data['default_bulan'] = $this->request->getGet('bulan');
        $data['default_tahun'] = $this->request->getGet('tahun');

        return view('template/header', $data)
             . view('pakan/v_laporan_produksi_form', $data)
             . view('template/footer');
    }

    public function laporan_produksi_store()
    {
        $laporanModel = new LaporanProduksiPakanModel();
        $detailModel = new DetailProduksiPakanModel();

        $laporan_data = [
            'id_kelompok' => $this->request->getPost('id_kelompok'),
            'bulan'       => $this->request->getPost('bulan'),
            'tahun'       => $this->request->getPost('tahun'),
            'status'      => 'draft',
            'created_by'  => session()->get('user_id')
        ];
        $id_laporan = $laporanModel->insert($laporan_data);

        $id_jenis_pakan = $this->request->getPost('id_jenis_pakan');
        $jumlah_produksi = $this->request->getPost('jumlah_produksi');

        if (is_array($id_jenis_pakan)) {
            for ($i = 0; $i < count($id_jenis_pakan); $i++) {
                $jumlah = $jumlah_produksi[$i];
                if ($jumlah !== '' && $jumlah !== null && $jumlah > 0) {
                    $detail_data = [
                        'id_laporan'      => $id_laporan,
                        'id_jenis_pakan'   => $id_jenis_pakan[$i],
                        'jumlah_produksi' => $jumlah
                    ];
                    $detailModel->insert($detail_data);
                }
            }
        }

        session()->setFlashdata('success', 'Laporan Produksi Pakan berhasil disimpan.');
        return redirect()->to(base_url('pakan/laporan_produksi'));
    }

    public function laporan_produksi_detail($id)
    {
        $laporanModel = new LaporanProduksiPakanModel();
        $detailModel = new DetailProduksiPakanModel();

        $data['title'] = 'Detail Laporan Produksi Pakan';
        $data['laporan'] = $laporanModel->get_by_id($id);
        $data['detail'] = $detailModel->get_by_laporan($id);

        return view('template/header', $data)
             . view('pakan/v_laporan_produksi_detail', $data)
             . view('template/footer');
    }

    public function laporan_produksi_detail_json($id)
    {
        $laporanModel = new LaporanProduksiPakanModel();
        $detailModel = new DetailProduksiPakanModel();

        $laporan = $laporanModel->get_by_id($id);
        $detail = $detailModel->get_by_laporan($id);

        return $this->response->setJSON([
            'laporan' => $laporan,
            'detail'  => $detail
        ]);
    }

    public function laporan_produksi_edit($id)
    {
        $laporanModel = new LaporanProduksiPakanModel();
        $detailModel = new DetailProduksiPakanModel();
        $kelompokModel = new KelompokProduksiPakanModel();
        $jenisPakanModel = new JenisPakanModel();

        $data['title'] = 'Edit Laporan Produksi Pakan';
        $data['laporan'] = $laporanModel->get_by_id($id);
        $data['detail'] = $detailModel->get_by_laporan($id);
        $data['kelompok'] = $kelompokModel->get_all();
        $data['jenis_pakan'] = $jenisPakanModel->get_all();

        return view('template/header', $data)
             . view('pakan/v_laporan_produksi_form', $data)
             . view('template/footer');
    }

    public function laporan_produksi_update($id)
    {
        $laporanModel = new LaporanProduksiPakanModel();
        $detailModel = new DetailProduksiPakanModel();

        $laporan_data = [
            'id_kelompok' => $this->request->getPost('id_kelompok'),
            'bulan'       => $this->request->getPost('bulan'),
            'tahun'       => $this->request->getPost('tahun'),
        ];
        $laporanModel->update($id, $laporan_data);

        // Delete old details first
        $detailModel->delete_by_laporan($id);

        $id_jenis_pakan = $this->request->getPost('id_jenis_pakan');
        $jumlah_produksi = $this->request->getPost('jumlah_produksi');

        if (is_array($id_jenis_pakan)) {
            for ($i = 0; $i < count($id_jenis_pakan); $i++) {
                $jumlah = $jumlah_produksi[$i];
                if ($jumlah !== '' && $jumlah !== null && $jumlah > 0) {
                    $detail_data = [
                        'id_laporan'      => $id,
                        'id_jenis_pakan'   => $id_jenis_pakan[$i],
                        'jumlah_produksi' => $jumlah
                    ];
                    $detailModel->insert($detail_data);
                }
            }
        }

        session()->setFlashdata('success', 'Laporan Produksi Pakan berhasil diperbarui.');
        return redirect()->to(base_url('pakan/laporan_produksi'));
    }

    public function laporan_produksi_delete($id)
    {
        $laporanModel = new LaporanProduksiPakanModel();
        $detailModel = new DetailProduksiPakanModel();

        $detailModel->delete_by_laporan($id);
        $laporanModel->delete($id);

        session()->setFlashdata('success', 'Laporan Produksi Pakan berhasil dihapus.');
        return redirect()->to(base_url('pakan/laporan_produksi'));
    }

    public function laporan_bulanan()
    {
        $laporanModel = new LaporanProduksiPakanModel();
        $jenisPakanModel = new JenisPakanModel();

        $data['title'] = 'Laporan Bulanan Produksi Pakan';
        $data['all_jenis_pakan'] = $jenisPakanModel->get_all();

        $selected_period = $this->request->getGet('periode');
        $filters = [];
        if ($selected_period) {
            list($filters['bulan'], $filters['tahun']) = explode('-', $selected_period);
        }

        $raw_data = $laporanModel->get_production_report_data($filters);
        
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

        $periods = $laporanModel->get_distinct_periods();
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

        return view('template/header', $data)
             . view('pakan/v_laporan_bulanan_index', $data)
             . view('template/footer');
    }
}
