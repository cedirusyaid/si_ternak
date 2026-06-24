<?php

namespace App\Controllers;

use App\Models\PetugasModel;
use App\Models\PeternakModel;
use App\Models\JenisPakanModel;
use App\Models\HewanModel;

class Master extends BaseController
{
    // --- CRUD PETUGAS ---
    public function petugas()
    {
        $petugasModel = new PetugasModel();
        $data['title'] = "Petugas Lapangan";
        $data['petugas_list'] = $petugasModel->get_all();

        return view('template/header', $data)
             . view('master/petugas/v_index', $data)
             . view('template/footer');
    }

    public function petugas_add()
    {
        $petugasModel = new PetugasModel();
        $rules = [
            'id_petugas'   => 'required|is_unique[petugas_lapangan.id_petugas]',
            'nama_petugas' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $petugasModel->save_petugas($this->request->getPost());
            session()->setFlashdata('success', 'Data berhasil ditambahkan.');
            return redirect()->to(base_url('master/petugas'));
        }

        $data['title'] = "Tambah Petugas";
        return view('template/header', $data)
             . view('master/petugas/v_form')
             . view('template/footer');
    }

    public function petugas_edit($id)
    {
        $petugasModel = new PetugasModel();
        $rules = [
            'nama_petugas' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $petugasModel->update_petugas($this->request->getPost());
            session()->setFlashdata('success', 'Data berhasil diperbarui.');
            return redirect()->to(base_url('master/petugas'));
        }

        $data['title'] = "Edit Petugas";
        $data['petugas'] = $petugasModel->get_by_id($id);
        return view('template/header', $data)
             . view('master/petugas/v_form', $data)
             . view('template/footer');
    }

    public function petugas_delete($id)
    {
        $petugasModel = new PetugasModel();
        $petugasModel->delete_petugas($id);
        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to(base_url('master/petugas'));
    }

    // --- CRUD PETERNAK ---
    public function peternak()
    {
        $peternakModel = new PeternakModel();
        $data['title'] = "Data Peternak";
        $data['peternak_list'] = $peternakModel->get_all();

        return view('template/header', $data)
             . view('master/peternak/v_index', $data)
             . view('template/footer');
    }
    
    public function peternak_add()
    {
        $peternakModel = new PeternakModel();
        $kelompokModel = new \App\Models\KelompokTernakModel();
        $rules = [
            'id_peternak'   => 'required|is_unique[peternak.id_peternak]',
            'nama_peternak' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $peternakModel->save_peternak($this->request->getPost());
            session()->setFlashdata('success', 'Data berhasil ditambahkan.');
            return redirect()->to(base_url('master/peternak'));
        }

        $data['title'] = "Tambah Peternak";
        $data['kelompok_list'] = $kelompokModel->findAll();
        return view('template/header', $data)
             . view('master/peternak/v_form', $data)
             . view('template/footer');
    }

    public function peternak_edit($id)
    {
        $peternakModel = new PeternakModel();
        $kelompokModel = new \App\Models\KelompokTernakModel();
        $rules = [
            'nama_peternak' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $peternakModel->update_peternak($this->request->getPost());
            session()->setFlashdata('success', 'Data berhasil diperbarui.');
            return redirect()->to(base_url('master/peternak'));
        }
        
        $data['title'] = "Edit Peternak";
        $data['peternak'] = $peternakModel->get_by_id($id);
        $data['kelompok_list'] = $kelompokModel->findAll();

        if (!$data['peternak']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('template/header', $data)
             . view('master/peternak/v_form', $data)
             . view('template/footer');
    }

    public function peternak_delete($id)
    {
        $peternakModel = new PeternakModel();
        $peternakModel->delete_peternak($id);
        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to(base_url('master/peternak'));
    }

    // --- CRUD JENIS PAKAN ---
    public function pakan()
    {
        return redirect()->to(base_url('pakan'));
    }
    
    public function pakan_add()
    {
        return redirect()->to(base_url('pakan/create'));
    }

    public function pakan_edit($id)
    {
        return redirect()->to(base_url('pakan/edit/' . $id));
    }
    
    public function pakan_delete($id)
    {
        return redirect()->to(base_url('pakan/delete/' . $id));
    }

    // --- CRUD HEWAN ---
    public function hewan()
    {
        $hewanModel = new HewanModel();
        $data['title'] = "Data Hewan";
        $data['hewan_list'] = $hewanModel->get_all();

        return view('template/header', $data)
             . view('master/hewan/v_index', $data)
             . view('template/footer');
    }

    public function hewan_add()
    {
        $hewanModel = new HewanModel();
        $peternakModel = new PeternakModel();

        $rules = [
            'id_hewan'    => 'required|is_unique[hewan.id_hewan]',
            'nama_hewan'  => 'required',
            'id_peternak' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $hewanModel->save_hewan($this->request->getPost());
            session()->setFlashdata('success', 'Data hewan berhasil ditambahkan.');
            return redirect()->to(base_url('master/hewan'));
        }

        $data['title'] = "Tambah Data Hewan";
        $data['peternak_list'] = $peternakModel->get_all();
        return view('template/header', $data)
             . view('master/hewan/v_form', $data)
             . view('template/footer');
    }

    public function hewan_edit($id)
    {
        $hewanModel = new HewanModel();
        $peternakModel = new PeternakModel();

        $rules = [
            'nama_hewan'  => 'required',
            'id_peternak' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $hewanModel->update_hewan($this->request->getPost());
            session()->setFlashdata('success', 'Data hewan berhasil diperbarui.');
            return redirect()->to(base_url('master/hewan'));
        }
        
        $data['title'] = "Edit Data Hewan";
        $data['hewan'] = $hewanModel->get_by_id($id);
        $data['peternak_list'] = $peternakModel->get_all();
        return view('template/header', $data)
             . view('master/hewan/v_form', $data)
             . view('template/footer');
    }

    public function hewan_delete($id)
    {
        $hewanModel = new HewanModel();
        $hewanModel->delete_hewan($id);
        session()->setFlashdata('success', 'Data hewan berhasil dihapus.');
        return redirect()->to(base_url('master/hewan'));
    }
}
