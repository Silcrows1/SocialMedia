<?php
class Post_model extends CI_model{

    public function __construct(){
        $this->load->database();
    }

    public function createPost(){
        $data = array(
            "Content" => $this->input->post('postContent'),
            "User_id" => $this->session->userdata('user_id')
        );

        $this->db->insert('posts', $data);

        
    }
    //Find friends function
    public function friends(){
        $this->db->select('Usertwo_id');
        $this->db->from('friends');
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $friends=$this->db->get();    
        return $friends->result_array();

         
    }
    //view posts function
    public function viewPosts(){

            //SQL call for all posts that match session id in friends database

                $this->db->select('users.FirstName, users.LastName, posts.Content, users.user_id, posts.Posted, friends.Usertwo_id');
                $this->db->from('friends');
                $this->db->join('users', 'users.User_id = friends.Usertwo_id');
                $this->db->join('profiles', 'users.User_id = profiles.User_id');
                $this->db->join('posts', 'posts.User_id = profiles.User_id');
                
                $this->db->where('friends.User_id = '. $this->session->userdata('user_id'));
                $this->db->order_by('posts.Posted', 'DESC');
                $posts = $this->db->get();
                $posts->result_array();

            return $posts->result_array();
                
    }

    public function viewaPost($id){

        $this->db->select('users.FirstName, users.LastName, posts.Content, posts.Posted');
        $this->db->from('users');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->join('posts', 'posts.User_id = profiles.User_id');
        $this->db->where('users.User_id', $id);
        $this->db->order_by('posts.Posted', 'DESC');
        $posts=$this->db->get();
        return $posts->result_array();
    }




}
?>