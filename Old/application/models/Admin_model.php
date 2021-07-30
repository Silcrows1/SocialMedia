<?php
class Admin_model extends CI_model{

    public function getSocialUsers(){
        $this->db->select('*');
        $this->db->where('HelpRequired', "1");
        $found = $this->db->get('users');
        $users = $found->result_array();
        return $users;
    }



}
?>