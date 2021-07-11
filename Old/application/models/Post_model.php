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


    //view posts function
    public function viewPosts(){

            //SQL call for all posts that match session id in friends database

                $this->db->select('users.FirstName, users.LastName, posts.Content, users.user_id, profiles.Picture, posts.Posted, friends.Usertwo_id, posts.post_id');
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

    public function likePost($post_id){

        $data = array(
            'post_id' => $post_id,
            'user_id' => $this->session->userdata('user_id')
        );

        $this->db->select('*');
        $this->db->from('Interactions');
        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $liked=$this->db->get();
        $data2=$liked->result_array();

        if($data2==NULL){            
            $this->db->insert('Interactions', $data);
        }
        else{
            $this->db->where('Interaction_id', $data2[0]['Interaction_id']);
            $this->db->delete('Interactions', $data2[0]);
        }
    }

    public function getLikes($posts){

            $found = array();
            $i=0;
            $user="";
            foreach($posts as $post){
                foreach ($post as $entry){
                    $this->db->select('user_id');
                    $this->db->where('post_id', $entry['post_id']);
                    $liked = $this->db->get('Interactions');
                    $rows= $liked->num_rows();                   


                    $found2=array(
                        'Post_id' =>$entry['post_id'], 
                        'Likes' => $rows
                 
                    );
                    array_push($found, $found2);                    
                }                
            }
             return $found;
    }
    public function liked(){

        $this->db->select('interactions.post_id');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $liked=$this->db->get('interactions');

        return $liked->result_array();

}




}
?>