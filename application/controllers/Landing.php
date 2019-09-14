<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_admin');
    }

    public function index() {
        //ini untuk buat session dengan nama session 'role'
        $status = $this->session->userdata('role');
        //jika 'role' => 'Admin'
        if ($status == "Admin") {
			redirect('control');
		} else {
			$this->login();
		}
    }

    public function login() {
        $status = $this->session->userdata('role');
        if ($status == "Admin") {
            redirect('control');
        } else {
            $data['title'] = "Login";
            $this->load->view('templates/header', $data);
            $this->load->view('pages/login');
            $this->load->view('templates/footer');
        }
        
    }

    public function login_validation() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
    }

}

?>