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

    public function viewPosts(){


        //SELECT `FirstName`, `LastName`, `posts`.`Content` FROM `users`
        //JOIN `profiles` ON `users`.`User_id` = `profiles`.`User_id`
        //JOIN `posts` ON `posts`.`User_id` = `profiles`.`User_id`
        //WHERE `users`.`User_id` = '25'

        //SELECT `users`.`FirstName`, `users`.`LastName`, `posts`.`Content` 
        //JOIN `profiles` ON `users`.`User_id` = `profiles`.`User_id` 
        //JOIN `posts` ON `posts`.`User_id` = `profiles`.`User_id` 
        //WHERE `users`.`User_id` = '25'

        $this->db->select('users.FirstName, users.LastName, posts.Content, users.user_id, posts.Posted');
        $this->db->from('users');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->join('posts', 'posts.User_id = profiles.User_id');
        $this->db->order_by('posts.Posted', 'DESC');

        //$this->db->join('posts', 'profiles.Users_id = posts.User_id');
        //$this->db->where('users.User_id', $this->session->userdata('user_id'));
        //$user = $this->db->get('users');
        $posts=$this->db->get();
        return $posts->result_array();
    }

    public function viewaPost($id){


        //SELECT `FirstName`, `LastName`, `posts`.`Content` FROM `users`
        //JOIN `profiles` ON `users`.`User_id` = `profiles`.`User_id`
        //JOIN `posts` ON `posts`.`User_id` = `profiles`.`User_id`
        //WHERE `users`.`User_id` = '25'

        //SELECT `users`.`FirstName`, `users`.`LastName`, `posts`.`Content` 
        //JOIN `profiles` ON `users`.`User_id` = `profiles`.`User_id` 
        //JOIN `posts` ON `posts`.`User_id` = `profiles`.`User_id` 
        //WHERE `users`.`User_id` = '25'

        $this->db->select('users.FirstName, users.LastName, posts.Content, posts.Posted');
        $this->db->from('users');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->join('posts', 'posts.User_id = profiles.User_id');
        //$this->db->join('posts', 'profiles.Users_id = posts.User_id');
        $this->db->where('users.User_id', $id);
        $this->db->order_by('posts.Posted', 'DESC');
        //$user = $this->db->get('users');
        $posts=$this->db->get();
        return $posts->result_array();
    }




}
?>