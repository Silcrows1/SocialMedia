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

    public function search($form_data)
    {
        $sql = "CONCAT(FirstName,' ', LastName) LIKE '%$form_data%'";
        $this->db->select('FirstName, LastName, users.User_id, Email');
        $this->db->from('users');
        $this->db->join('onlineusers', 'onlineusers.User_id = users.User_id');
        $this->db->where($sql);
        $found = $this->db->get();

        return $found->result_array();
    }



}
?>