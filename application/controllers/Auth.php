<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_user');
    }

    public function index() {
        // Jika sudah login, alihkan ke dashboard

        // echo password_hash('admin123', PASSWORD_BCRYPT); die();


        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/v_login');
    }

    public function login() {
        // Alias untuk method index
        $this->index();
    }

    public function process_login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/v_login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->M_user->get_by_username($username);

            // Cek jika user ada dan aktif
            if ($user && $user->is_active == 1) {
                // Cek password
                if (password_verify($password, $user->password)) {
                    // Buat session
                    $session_data = [
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'nama_lengkap' => $user->nama_lengkap,
                        'role' => $user->role,
                        'logged_in' => TRUE
                    ];
                    $this->session->set_userdata($session_data);

                    // Update last_login
                    $this->M_user->update_last_login($user->id);

                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Password salah!');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Username tidak ditemukan atau tidak aktif!');
                redirect('auth/login');
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}