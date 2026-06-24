<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/v_login');
    }

    public function login()
    {
        return $this->index();
    }

    public function process_login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return view('auth/v_login');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user      = $userModel->get_by_username($username);

        if ($user && $user->is_active == 1) {
            if (password_verify($password, $user->password)) {
                $session_data = [
                    'user_id'      => $user->id,
                    'username'     => $user->username,
                    'nama_lengkap' => $user->nama_lengkap,
                    'role'         => $user->role,
                    'logged_in'    => true
                ];
                session()->set($session_data);

                $userModel->update_last_login($user->id);

                return redirect()->to(base_url('dashboard'));
            } else {
                session()->setFlashdata('error', 'Password salah!');
                return redirect()->to(base_url('auth/login'));
            }
        } else {
            session()->setFlashdata('error', 'Username tidak ditemukan atau tidak aktif!');
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'));
    }
}
