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
        if ($this->form_validation->run() == FALSE) {
            echo "<script>alert('Masukan data dengan benar');</script>";
			$this->login();
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            //cek apakah username tersebut terdaftar atau tidak
            $data_user = $this->m_admin->getDataUser($username);
            //jika terdaftar
            if ($data_user) {
                //cek apakah passwordnya benar
                if (password_verify($password, $data_user->password)) {
                    $data = array (
                        'username' => $data_user->username,
                        'nama'     => $data_user->nama_admin,
                        'role'     => 'Admin'
                      );
                      $this->session->set_userdata($data);
                      redirect('control');
                // jika tidak benar    
                } else {
                    echo "<script>alert('Username / password salah')</script>";
                    // diredirect ke page /landing
                    redirect('landing', 'refresh');    
                }
            //jika tidak terdaftar
            } else {
                echo "<script>alert('Data tidak ditemukan')</script>";
                // diredirect ke page /landing
                redirect('landing', 'refresh');
            }
            
        }
        
        
    }

}

?>