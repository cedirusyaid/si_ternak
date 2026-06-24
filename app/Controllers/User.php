<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data['title'] = "Manajemen Pengguna";
        $data['users'] = $userModel->get_all();
        
        return view('template/header', $data)
             . view('user/v_user_index', $data)
             . view('template/footer');
    }

    public function add()
    {
        $userModel = new UserModel();

        $rules = [
            'username'     => 'required|is_unique[users.username]',
            'password'     => 'required|min_length[5]',
            'nama_lengkap' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $userModel->save_user($this->request->getPost());
            session()->setFlashdata('success', 'Data user berhasil ditambahkan.');
            return redirect()->to(base_url('user'));
        }

        $data['title'] = "Tambah Pengguna";
        return view('template/header', $data)
             . view('user/v_user_form', $data)
             . view('template/footer');
    }

    public function edit($id = null)
    {
        if (!$id) {
            return redirect()->to(base_url('user'));
        }

        $userModel = new UserModel();
        $user      = $userModel->get_by_id($id);

        if (!$user) {
            return redirect()->to(base_url('user'));
        }

        // Rule untuk username, cek unik jika username diubah
        $is_unique = ($this->request->getPost('username') != $user->username) ? '|is_unique[users.username]' : '';
        $rules = [
            'username'     => 'required' . $is_unique,
            'nama_lengkap' => 'required'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($rules)) {
            $userModel->update_user($this->request->getPost());
            session()->setFlashdata('success', 'Data user berhasil diperbarui.');
            return redirect()->to(base_url('user'));
        }

        $data['title'] = "Edit Pengguna";
        $data['user']  = $user;
        return view('template/header', $data)
             . view('user/v_user_form', $data)
             . view('template/footer');
    }

    public function delete($id = null)
    {
        if (!$id) {
            return redirect()->to(base_url('user'));
        }

        $userModel = new UserModel();
        if ($userModel->delete_user($id)) {
            session()->setFlashdata('success', 'Data user berhasil dihapus.');
        }
        return redirect()->to(base_url('user'));
    }
}
