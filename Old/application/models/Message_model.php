<?php
class Message_model extends CI_model{

    public function getMessages($id){
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

    public function sendMessage($message){
        $this->db->insert('Messages', $message);

    }

}
?>