<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load helpers
        $this->load->helper('url');
        // Add authentication check here
    }

    public function index() {
        redirect('admin/dashboard');
    }

    public function dashboard() {
        $data = array(
            'title' => 'Dashboard',
            'page_title' => 'Dashboard',
            'active_menu' => 'dashboard',
            'user_name' => 'Administrator'
        );

        $this->load->view('template/header', $data);
        // $this->load->view('admin/dashboard');
        $this->load->view('template/footer');
    }

    public function logout() {
        // Logout logic here
        redirect('login');
    }
}
?>