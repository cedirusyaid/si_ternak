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
        return view('template/header', $data)
             . view('master/peternak/v_form', $data)
             . view('template/footer');
    }

    public function peternak_edit($id)
    {
        $peternakModel = new PeternakModel();
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
        $jenisPakanModel = new JenisPakanModel();
        $data['title'] = "Jenis Pakan";
        $data['pakan_list'] = $jenisPakanModel->get_all();

        return view('template/header', $data)
             . view('master/pakan/v_index', $data)
             . view('template/footer');
    }
    
    public function pakan_add()
    {
        $jenisPakanModel = new JenisPakanModel();
        $rules = [
            'id_jenis_pakan' => 'required|is_unique[jenis_pakan.id_jenis_pakan]',
            'nama_jenis'     => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $jenisPakanModel->save_pakan($this->request->getPost());
            session()->setFlashdata('success', 'Data berhasil ditambahkan.');
            return redirect()->to(base_url('master/pakan'));
        }

        $data['title'] = "Tambah Jenis Pakan";
        return view('template/header', $data)
             . view('master/pakan/v_form', $data)
             . view('template/footer');
    }

    public function pakan_edit($id)
    {
        $jenisPakanModel = new JenisPakanModel();
        $rules = [
            'nama_jenis' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $jenisPakanModel->update_pakan($this->request->getPost());
            session()->setFlashdata('success', 'Data berhasil diperbarui.');
            return redirect()->to(base_url('master/pakan'));
        }
        
        $data['title'] = "Edit Jenis Pakan";
        $data['pakan'] = $jenisPakanModel->get_by_id($id);
        return view('template/header', $data)
             . view('master/pakan/v_form', $data)
             . view('template/footer');
    }
    
    public function pakan_delete($id)
    {
        $jenisPakanModel = new JenisPakanModel();
        $jenisPakanModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to(base_url('master/pakan'));
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
