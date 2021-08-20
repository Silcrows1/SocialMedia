<?php
class Post_model extends CI_model
{

    public function __construct()
    {
        $this->load->database();
    }

    //Create Post function
    public function createPost()
    {
        //Check that post request isnt blank
        if ($this->input->post('postContent') != NULL) {
            $data = array(
                "Content" => $this->input->post('postContent'),
                "User_id" => $this->session->userdata('user_id')
            );

            $this->db->insert('posts', $data);
        }
    }

    //view posts function
    public function viewPosts()
    {
        //SQL call for all posts that match session id in friends and match user id in users database

        $this->db->distinct();
        $this->db->select('users.FirstName, users.LastName, posts.Content, users.user_id, 
                profiles.Picture, posts.Posted, friends.Usertwo_id, posts.post_id');
        $this->db->from('friends');
        $this->db->join('users', 'users.User_id = friends.Usertwo_id');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->join('posts', 'posts.User_id = profiles.User_id');
        $this->db->where('friends.User_id = ' . $this->session->userdata('user_id'));
        $this->db->or_where('users.User_id = ' . $this->session->userdata('user_id'));
        $this->db->order_by('posts.Posted', 'DESC');

        $posts = $this->db->get();
        $posts->result_array();

        return $posts->result_array();
    }

    //view own posts function
    public function viewownPosts($id = NULL)
    {
        if ($id == NULL) {
            $id = $this->session->userdata('user_id');
        }
        //view posts, user and profile information for session holder
        $this->db->select('users.FirstName, users.LastName, posts.Content, users.user_id, profiles.Picture, posts.Posted,  posts.post_id');
        $this->db->from('posts');
        $this->db->join('users', 'users.User_id = posts.User_id');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->where('users.User_id = ' . $id);
        $this->db->order_by('posts.Posted', 'DESC');
        $posts = $this->db->get();
        $posts->result_array();

        return $posts->result_array();
    }

    //Like post function
    public function likePost($post_id)
    {
        $data = array(
            'post_id' => $post_id,
            'user_id' => $this->session->userdata('user_id')
        );
        //Check if user had previously liked post
        $this->db->select('*');
        $this->db->from('Interactions');
        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $liked = $this->db->get();
        $data2 = $liked->result_array();

        //if post wasnt previously liked, add a like
        if ($data2 == NULL) {
            $this->db->insert('Interactions', $data);
        } else {

            //if it was previously liked, remove like
            $this->db->where('Interaction_id', $data2[0]['Interaction_id']);
            $this->db->delete('Interactions', $data2[0]);
        }
    }
    //Get likes function
    public function getLikes($posts)
    {
        $found = array();
        $i = 0;
        $user = "";
        foreach ($posts as $post) {
            foreach ($post as $entry) {
                $this->db->select('user_id');
                $this->db->where('post_id', $entry['post_id']);
                $liked = $this->db->get('Interactions');
                $rows = $liked->num_rows();

                //Get post ID and number of likes and add to an array
                $found2 = array(
                    'Post_id' => $entry['post_id'],
                    'Likes' => $rows
                );

                //Add likes count array to container array
                array_push($found, $found2);            
            }
        }
        return $found;
    }

    //seperate get likes function due to different nesting
    public function getLikes2($posts)
    {

        $found = array();
        $i = 0;
        $user = "";

        foreach ($posts as $post) {

            $this->db->select('user_id');
            $this->db->where('post_id', $post['post_id']);
            $liked = $this->db->get('Interactions');
            $rows = $liked->num_rows();


            $found2 = array(
                'Post_id' => $post['post_id'],
                'Likes' => $rows

            );
            array_push($found, $found2);
        }

        return $found;
    }
    
    //Get Profile likes function
    public function getprofileLikes($posts)
    {

        $found = array();
        $i = 0;
        $user = "";

        foreach ($posts['posts'] as $post['posts']) {
            $this->db->select('user_id');
            $this->db->where('post_id', $post['posts']['post_id']);
            $liked = $this->db->get('Interactions');
            $rows = $liked->num_rows();



            $found2 = array(
                'Post_id' => $post['posts']['post_id'],
                'Likes' => $rows

            );
            array_push($found, $found2);
        }
        return $found;
    }
    
    //Liked function
    public function liked()
    {
        $this->db->select('interactions.post_id');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $liked = $this->db->get('interactions');

        return $liked->result_array();
    }

    //delete post function
    public function deletePost($id)
    {
        //delete post
        $this->db->where('posts.Post_id', $id);
        $this->db->delete('posts');

        //delete comments for post
        $this->db->where('comments.Post_id', $id);
        $this->db->delete('comments');
    }
}
