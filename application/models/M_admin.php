<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

    public function getDataUser($username = NULL)
  {
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

}

/* End of file M_admin.php */

?>