<?php
class Message_model extends CI_model{

    public function sgetMessages($id){
        $this->db->distinct();
        $this->db->select('Message, Posted_to, Posted_at, users.FirstName, users.LastName');
        $this->db->from('Messages');
        $this->db->join('Users', 'Messages.User_id = Users.User_id');
        $this->db->where('Posted_to', $id);
        $this->db->or_where('Messages.User_id', $id);
        $this->db->order_by("Messages.Posted_at", "DESC");
        $messages=$this->db->get();

        return $messages->result_array();

    }

    public function getMessages($id){


        $this->db->distinct();
        $this->db->select('Message, Posted_to, Posted_at, users.FirstName, users.LastName');
        $this->db->from('Messages');
        $this->db->join('Users', 'Messages.User_id = Users.User_id');
        $this->db->where('Posted_to', $id);
        $this->db->where('Messages.User_id', $this->session->userdata('user_id'));
        $messages=$this->db->get();
        $query1 = $this->db->last_query();


        $this->db->select('Message, Posted_to, Posted_at, users.FirstName, users.LastName');
        $this->db->from('Messages');
        $this->db->join('Users', 'Messages.User_id = Users.User_id');
        $this->db->or_where('Posted_to', $this->session->userdata('user_id'));
        $this->db->where('Messages.User_id', $id);
        $messages2=$this->db->get();
        $query2 = $this->db->last_query();

        $messages = $this->db->query("select * from ($query1 UNION ALL $query2) as unionTable ORDER BY Posted_at DESC");        

        return $messages->result_array();
    }

    public function sendMessage($message){
        $this->db->insert('Messages', $message);

    }

}
?>