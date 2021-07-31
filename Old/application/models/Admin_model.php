<?php
class Admin_model extends CI_model{

    public function getSocialUsers(){
        $this->db->select('*');
        $this->db->where('HelpRequired', "1");
        $this->db->join('onlineusers', 'users.User_id = onlineusers.User_id');
        $this->db->order_by("users.LastContact", "DESC");
        $found = $this->db->get('users');
        $users = $found->result_array();
        return $users;
    }



}
?>