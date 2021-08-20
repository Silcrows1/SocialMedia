<?php
class Comment_model extends CI_model
{
    //Create comment function
    public function createComment($comment)
    {
        $this->db->insert('Comments', $comment);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    //Get comment count function
    public function getCommentCount($posts)
    {

        $found = array();

        //Cycle through posts to load
        foreach ($posts['posts'] as $post) {

            $this->db->select('comment_id, Post_id');
            $this->db->where('Post_id', $post['post_id']);
            $comments = $this->db->get('comments');
            $rows = $comments->num_rows();

            //create array with post id and number of rows in comments
            $found2 = array(
                'Post_id' => $post['post_id'],
                'Comments' => $rows
            );
            //push array into container array
            array_push($found, $found2);
        }
        return $found;
    }

    //get single count function
    public function getsingleCount($id)
    {


        $this->db->select('comment_id, Post_id');
        $this->db->where('Post_id', $id);
        $comments = $this->db->get('comments');
        $rows = $comments->num_rows();

        //create array with post id and number of rows in comments
        $found = array(
            'Post_id' => $id,
            'Comments' => $rows
        );

        return $found;
    }

    //Get comments function
    public function getComments($post_id)
    {
        //Select comments and profile information for users commenting
        $this->db->distinct();
        $this->db->select('comment_id, comments.Post_id, comment, users.User_id, profiles.Picture, users.FirstName, users.LastName, comments.created_at, posts.User_id AS posterid');
        $this->db->join('users', 'users.User_id = comments.User_id');
        $this->db->join('profiles', 'profiles.User_id = users.User_id');
        $this->db->join('posts', 'posts.Post_id = comments.Post_id');
        $this->db->where('comments.Post_id', $post_id);
        $this->db->order_by("comments.created_at", "desc");
        $comments = $this->db->get('comments');
        return $comments->result_array();
    }

    //Delete comment function
    public function deleteComment($id)
    {

        $this->db->where('comments.Comment_id', $id);
        $this->db->delete('comments');
        return;
    }
}
