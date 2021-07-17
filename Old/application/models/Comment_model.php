<?php
class Comment_model extends CI_model{
    
    public function createComment($comment){

        $this->db->insert('Comments', $comment);            
        
    }
    

    public function getCommentCount($posts){
  
        $found = array();
        $i=0;
        $user="";
        foreach($posts['posts'] as $post){

                $this->db->select('comment_id, Post_id');
                $this->db->where('Post_id', $post['post_id']);
                $comments = $this->db->get('comments');
                $rows= $comments->num_rows();                   


                $found2=array(
                    'Post_id' =>$post['post_id'], 
                    'Comments' => $rows
             
                );
                array_push($found, $found2);
               // echo '<script>console.log($found)</script>';                
                           
        }
         return $found;

    }

    public function getsingleCount($id){  


        $this->db->select('comment_id, Post_id');
        $this->db->where('Post_id', $id);
        $comments = $this->db->get('comments');
        $rows= $comments->num_rows();                 
    

        $found=array(
            'Post_id' =>$id, 
            'Comments' => $rows        
        );
        
         return $found;

    }

    public function getComments($post_id){            
        
        $this->db->select('comment_id, Post_id, comment, users.User_id, profiles.Picture, users.FirstName, users.LastName, comments.created_at');
        $this->db->join('users', 'users.User_id = comments.User_id');
        $this->db->join('profiles', 'profiles.User_id = users.User_id');
        $this->db->where('Post_id', $post_id);
        $this->db->order_by("comments.created_at", "desc");
        $comments = $this->db->get('comments');
        return $comments->result_array();    

    }
}
?>