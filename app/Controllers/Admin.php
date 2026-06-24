<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        return redirect()->to(base_url('admin/dashboard'));
    }

    public function dashboard()
    {
        $data = [
            'title'       => 'Dashboard',
            'page_title'  => 'Dashboard',
            'active_menu' => 'dashboard',
            'user_name'   => 'Administrator'
        ];

        return view('template/header', $data)
             . view('template/footer');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'));
    }
}
