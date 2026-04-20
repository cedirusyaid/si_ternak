<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cek apakah session 'logged_in' tidak ada
        if (!$this->session->userdata('logged_in')) {
            // Beri pesan flash
            $this->session->set_flashdata('error', 'Anda harus login terlebih dahulu!');
            // Alihkan ke controller Auth
            redirect('auth/login');
        }
    }
}