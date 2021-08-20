<?php
class Message_model extends CI_model{


    //Get messages function
    public function getMessages($id){

        //Get all messages to id
        $this->db->distinct();
        $this->db->select('Message, Posted_to, Posted_at, users.FirstName, users.LastName');
        $this->db->from('Messages');
        $this->db->join('Users', 'Messages.User_id = Users.User_id');
        $this->db->where('Posted_to', $id);
        $this->db->where('Messages.User_id', $this->session->userdata('user_id'));
        $messages=$this->db->get();
        $query1 = $this->db->last_query();

        //Get all messages from id to Session id holder
        $this->db->select('Message, Posted_to, Posted_at, users.FirstName, users.LastName');
        $this->db->from('Messages');
        $this->db->join('Users', 'Messages.User_id = Users.User_id');
        $this->db->or_where('Posted_to', $this->session->userdata('user_id'));
        $this->db->where('Messages.User_id', $id);
        $messages2=$this->db->get();
        $query2 = $this->db->last_query();

        //Union messages together and order by posted date DESC
        $messages = $this->db->query("select * from ($query1 UNION ALL $query2) as unionTable ORDER BY Posted_at DESC");        

        return $messages->result_array();
    }

    //Send message function
    public function sendMessage($message){

        $this->db->insert('Messages', $message);

    }

}
?>