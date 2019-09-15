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

    public function user_list()
    {
        $status = $this->session->userdata('role');
        if ($status == "Admin") {
            /* uri segment ini maksudnya dari parameter urlnya 
            * contoh ini kan localhost/simple-crud-codeigniter/control/user_list/test
            * nahh /test itu uri->segment(3)
            * kalau ada lanjutannya misal localhost/simple-crud-codeigniter/control/user_list/test/testing
            * nah /testing itu uri->segment(4)
            * nah kalo bikin folder baru dan isinya controller lanjutannya jadi beda lagi
            * misal bikin folder baru namanya api nah berarti function dari classnya jadi urisegment(3) nya
            */
            if ($this->uri->segment(3) == NULL) {
                $data = array(
                    'title'        => "List User",
                    'profile_data' => $this->m_admin->getDataUser($this->session->userdata('username')),
                    'list_user'    => $this->m_admin->getDataUser()->result()
                );
                $this->load->view('templates/header', $data);
                $this->load->view('pages/users-list', $data);
                $this->load->view('templates/footer');
            } else if ($this->uri->segment(3) == 'edit') {
                if ($this->uri->segment(4) != NULL) {
                    if ($_POST) {
                        $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                        $name = $this->input->post('name');
                        $data = array(
                            'username' => $this->uri->segment(4),
                            'password' => $password,
                            'name' => $name,
                        );
                        $query = $this->m_admin->updateData('user', $data, array('username' => $this->uri->segment(4)));
                        if ($query) {
                            redirect('control/user_list', 'refresh');
                        } else {
                            echo "<script>alert('gagal update data')</script>";
                            redirect('control/user_list', 'refresh');
                        }
                    } else {
                        $data = array(
                            'title'        => "Update User",
                            'profile_data' => $this->m_admin->getDataUser($this->session->userdata('username'))
                        );
                        $this->load->view('templates/header', $data);
                        $this->load->view('pages/user-edit', $data);
                        $this->load->view('templates/footer');
                    }
                } else {
                    show_404();
                }
            } else if ($this->uri->segment(3) == 'delete') {
                if ($this->uri->segment(4) != NULL) {
                    $this->m_admin->deleteData('user', array('username' => $this->uri->segment(4) ));
                    redirect('control/user_list','refresh');
                } else {
                    show_404();
                }
            } else if ($this->uri->segment(3) == 'add') {
                if ($_POST) {
                    $username = $this->input->post('username');
                    $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                    $name = $this->input->post('name');
                    $data = array(
                        'username' => $username,
                        'password' => $password,
                        'name' => $name,
                    );
                    $result = $this->m_admin->addMember($username);
                    if ($result == "ada") {
                        echo "
                        <script>
                        alert('email / username telah ada');
                        document.location.href='add'
                        </script>
                        ";
                    } else {
                        $query = $this->db->insert('user', $data);
                        if ($query) {
                            redirect('control/user_list', 'refresh');
                        } else {
                            echo "<script>alert('gagal insert data')</script>";
                            redirect('control/user_list', 'refresh');
                        }
                    }
                } else {
                    $data = array(
                        'title'        => "List User",
                        'profile_data' => $this->m_admin->getDataUser($this->session->userdata('username'))
                    );
                    $this->load->view('templates/header', $data);
                    $this->load->view('pages/user-add', $data);
                    $this->load->view('templates/footer');
                }
            }
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