<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller {


    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('m_admin');
        
    }
    

    public function index()
    {
        $status = $this->session->userdata('role');
        if ($status == "Admin") {
            $data = array(
                'title'        => "Dashboard",
                'profile_data' => $this->m_admin->getDataUser($this->session->userdata('username')),
            );
            $this->load->view('templates/header', $data);
            $this->load->view('pages/dashboard', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('landing','refresh');
        }
    }

    public function logout() {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('nama');
	    $this->session->unset_userdata('role');
	    $this->index();
    }

}

/* End of file Control.php */

?>