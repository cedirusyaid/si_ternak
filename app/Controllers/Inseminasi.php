<?php

namespace App\Controllers;

use App\Models\InseminasiModel;

class Inseminasi extends BaseController
{
    //============================================
    // INSEMINASI BUATAN (IB)
    //============================================

    public function index()
    {
        $inseminasiModel = new InseminasiModel();
        $data['title'] = 'Data Inseminasi Buatan';
        $data['inseminasi'] = $inseminasiModel->get_inseminasi();

        return view('template/header', $data)
             . view('inseminasi/v_inseminasi_index', $data)
             . view('template/footer');
    }

    public function tambah_ib()
    {
        $inseminasiModel = new InseminasiModel();
        $data['title'] = 'Tambah Data IB';
        $data['petugas'] = $inseminasiModel->get_list_petugas();

        return view('template/header', $data)
             . view('inseminasi/v_inseminasi_form', $data)
             . view('template/footer');
    }

    public function store_ib()
    {
        $inseminasiModel = new InseminasiModel();
        $id_hewan = $this->request->getPost('id_hewan');
        
        $db = \Config\Database::connect();
        $hewan = $db->table('hewan')
                    ->select('hewan.id_hewan, peternak.kecamatan, peternak.desa')
                    ->join('peternak', 'hewan.id_peternak = peternak.id_peternak', 'left')
                    ->where('hewan.id_hewan', $id_hewan)
                    ->get()->getRow();

        $data = [
            'id_ib'           => 'IB' . time(),
            'id_hewan'        => $id_hewan,
            'tanggal_ib'      => $this->request->getPost('tanggal_ib'),
            'id_petugas'      => $this->request->getPost('id_petugas'),
            'ib_ke'           => $this->request->getPost('ib_ke'),
            'id_pejantan'     => $this->request->getPost('id_pejantan'),
            'bangsa_pejantan' => $this->request->getPost('bangsa_pejantan'),
            'status'          => $this->request->getPost('status') ?: 'menunggu',
            'kecamatan'       => $hewan ? $hewan->kecamatan : null,
            'desa'            => $hewan ? $hewan->desa : null,
            'created_by'      => session()->get('user_id')
        ];

        $inseminasiModel->insert_inseminasi($data);
        session()->setFlashdata('success', 'Data Inseminasi Buatan berhasil ditambahkan.');
        return redirect()->to(base_url('inseminasi'));
    }

    public function detail_ib($id)
    {
        $inseminasiModel = new InseminasiModel();
        $data['title'] = 'Detail Inseminasi Buatan';
        $data['ib'] = $inseminasiModel->get_inseminasi($id);

        if (!$data['ib']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('template/header', $data)
             . view('inseminasi/v_inseminasi_detail', $data)
             . view('template/footer');
    }

    public function edit_ib($id)
    {
        $inseminasiModel = new InseminasiModel();
        $data['title'] = 'Edit Data IB';
        $data['ib'] = $inseminasiModel->get_inseminasi($id);
        $data['petugas'] = $inseminasiModel->get_list_petugas();

        if (!$data['ib']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('template/header', $data)
             . view('inseminasi/v_inseminasi_form', $data)
             . view('template/footer');
    }

    public function update_ib($id)
    {
        $inseminasiModel = new InseminasiModel();
        $id_hewan = $this->request->getPost('id_hewan');
        
        $db = \Config\Database::connect();
        $hewan = $db->table('hewan')
                    ->select('hewan.id_hewan, peternak.kecamatan, peternak.desa')
                    ->join('peternak', 'hewan.id_peternak = peternak.id_peternak', 'left')
                    ->where('hewan.id_hewan', $id_hewan)
                    ->get()->getRow();

        $data = [
            'id_hewan'        => $id_hewan,
            'tanggal_ib'      => $this->request->getPost('tanggal_ib'),
            'id_petugas'      => $this->request->getPost('id_petugas'),
            'ib_ke'           => $this->request->getPost('ib_ke'),
            'id_pejantan'     => $this->request->getPost('id_pejantan'),
            'bangsa_pejantan' => $this->request->getPost('bangsa_pejantan'),
            'status'          => $this->request->getPost('status') ?: 'menunggu',
            'kecamatan'       => $hewan ? $hewan->kecamatan : null,
            'desa'            => $hewan ? $hewan->desa : null,
        ];

        $inseminasiModel->update_inseminasi($id, $data);
        session()->setFlashdata('success', 'Data Inseminasi Buatan berhasil diperbarui.');
        return redirect()->to(base_url('inseminasi'));
    }

    public function ajax_search_peternak()
    {
        $q = $this->request->getGet('query');
        $db = \Config\Database::connect();
        $builder = $db->table('peternak');
        if (!empty($q)) {
            $builder->like('nama_peternak', $q)
                    ->orLike('id_peternak', $q);
        }
        $builder->limit(10);
        $results = $builder->get()->getResultArray();
        return $this->response->setJSON($results);
    }

    public function ajax_search_hewan()
    {
        $q = $this->request->getGet('query');
        $id_peternak = $this->request->getGet('id_peternak');
        
        $db = \Config\Database::connect();
        $builder = $db->table('hewan');
        $builder->select('hewan.id_hewan, hewan.nama_hewan, peternak.id_peternak, peternak.nama_peternak, peternak.alamat, peternak.desa, peternak.kecamatan');
        $builder->join('peternak', 'hewan.id_peternak = peternak.id_peternak', 'left');
        $builder->where('hewan.jenis_kelamin', 'betina');
        $builder->where('hewan.status', 'aktif');
        
        if (!empty($id_peternak)) {
            $builder->where('hewan.id_peternak', $id_peternak);
        }
        
        if (!empty($q)) {
            $builder->groupStart()
                        ->like('hewan.id_hewan', $q)
                        ->orLike('hewan.nama_hewan', $q)
                    ->groupEnd();
        }
        
        $builder->limit(10);
        $results = $builder->get()->getResultArray();
        return $this->response->setJSON($results);
    }

    public function destroy_ib($id)
    {
        $inseminasiModel = new InseminasiModel();
        $inseminasiModel->delete_inseminasi($id);
        session()->setFlashdata('success', 'Data Inseminasi Buatan berhasil dihapus.');
        return redirect()->to(base_url('inseminasi'));
    }

    //============================================
    // KELAHIRAN
    //============================================

    public function kelahiran()
    {
        $inseminasiModel = new InseminasiModel();
        $data['title'] = 'Data Kelahiran';
        $data['kelahiran'] = $inseminasiModel->get_kelahiran();

        return view('template/header', $data)
             . view('inseminasi/v_kelahiran_index', $data)
             . view('template/footer');
    }

    public function tambah_kelahiran()
    {
        $inseminasiModel = new InseminasiModel();
        $data['title'] = 'Tambah Data Kelahiran';
        $data['hewan'] = $inseminasiModel->get_list_hewan();
        $data['petugas'] = $inseminasiModel->get_list_petugas();

        return view('template/header', $data)
             . view('inseminasi/v_kelahiran_form', $data)
             . view('template/footer');
    }

    public function store_kelahiran()
    {
        $inseminasiModel = new InseminasiModel();
        $data = $this->request->getPost();
        $inseminasiModel->insert_kelahiran($data);
        session()->setFlashdata('success', 'Data kelahiran berhasil ditambahkan.');
        return redirect()->to(base_url('inseminasi/kelahiran'));
    }

    public function edit_kelahiran($id)
    {
        $inseminasiModel = new InseminasiModel();
        $data['title'] = 'Edit Data Kelahiran';
        $data['kelahiran'] = $inseminasiModel->get_kelahiran($id);
        $data['hewan'] = $inseminasiModel->get_list_hewan();
        $data['petugas'] = $inseminasiModel->get_list_petugas();

        return view('template/header', $data)
             . view('inseminasi/v_kelahiran_form', $data)
             . view('template/footer');
    }

    public function update_kelahiran($id)
    {
        $inseminasiModel = new InseminasiModel();
        $data = $this->request->getPost();
        $inseminasiModel->update_kelahiran($id, $data);
        session()->setFlashdata('success', 'Data kelahiran berhasil diperbarui.');
        return redirect()->to(base_url('inseminasi/kelahiran'));
    }

    public function destroy_kelahiran($id)
    {
        $inseminasiModel = new InseminasiModel();
        $inseminasiModel->delete_kelahiran($id);
        session()->setFlashdata('success', 'Data kelahiran berhasil dihapus.');
        return redirect()->to(base_url('inseminasi/kelahiran'));
    }

    //============================================
    // PEMERIKSAAN KEBUNTINGAN (PKB)
    //============================================

    public function pkb()
    {
        $inseminasiModel = new InseminasiModel();
        $data['title'] = 'Data Pemeriksaan Kebuntingan';
        $data['pkb'] = $inseminasiModel->get_pkb();

        return view('template/header', $data)
             . view('inseminasi/v_pkb_index', $data)
             . view('template/footer');
    }

    public function tambah_pkb()
    {
        $inseminasiModel = new InseminasiModel();
        $data['title'] = 'Tambah Data PKB';
        $data['hewan'] = $inseminasiModel->get_list_hewan();
        $data['petugas'] = $inseminasiModel->get_list_petugas();

        return view('template/header', $data)
             . view('inseminasi/v_pkb_form', $data)
             . view('template/footer');
    }

    public function store_pkb()
    {
        $inseminasiModel = new InseminasiModel();
        $data = $this->request->getPost();
        $inseminasiModel->insert_pkb($data);
        session()->setFlashdata('success', 'Data PKB berhasil ditambahkan.');
        return redirect()->to(base_url('inseminasi/pkb'));
    }

    public function edit_pkb($id)
    {
        $inseminasiModel = new InseminasiModel();
        $data['title'] = 'Edit Data PKB';
        $data['pkb'] = $inseminasiModel->get_pkb($id);
        $data['hewan'] = $inseminasiModel->get_list_hewan();
        $data['petugas'] = $inseminasiModel->get_list_petugas();

        return view('template/header', $data)
             . view('inseminasi/v_pkb_form', $data)
             . view('template/footer');
    }

    public function update_pkb($id)
    {
        $inseminasiModel = new InseminasiModel();
        $data = $this->request->getPost();
        $inseminasiModel->update_pkb($id, $data);
        session()->setFlashdata('success', 'Data PKB berhasil diperbarui.');
        return redirect()->to(base_url('inseminasi/pkb'));
    }

    public function destroy_pkb($id)
    {
        $inseminasiModel = new InseminasiModel();
        $inseminasiModel->delete_pkb($id);
        session()->setFlashdata('success', 'Data PKB berhasil dihapus.');
        return redirect()->to(base_url('inseminasi/pkb'));
    }
}
