<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

    public function getDataUser($username = NULL) {
        if ($username == NULL) {
            return $this->db->get('user');
        } else {
            $this->db->where('username', $username);
            $result = $this->db->get('user');
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return false;
            }
        } 
    }

  public function addMember($username = NULL)
  {
    $this->db->where('username', $username);
    $result = $this->db->get('user');
    if ($result->num_rows() > 0) {
      return "ada";
    } else {
      return "kosong";
    }
  }

  public function updateData($tabel,$data,$where = '')
  {
    return $this->db->update($tabel,$data,$where);
  }

  public function deleteData($tabel,$where = '')
  {
    return $this->db->delete($tabel,$where);
  }

}

/* End of file M_admin.php */

?>