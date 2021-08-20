<?php
class Comments extends CI_Controller
{

    //create comment function//
    public function createComment()
    {
        $id = NULL;
        $id = $this->input->post('id');
        $comment = $this->input->post('comment');
        $commentarray = array(
            'Post_id' => $id,
            'Comment' => $comment,
            'User_id' => $this->session->userdata('user_id')
        );
        //Insert array into database        
        $commentid = $this->comment_model->createComment($commentarray);
        //Get count of comments for post           
        $comments = $this->comment_model->getsingleCount($id);
        $Post_id = $id;
        $Comment = $comments['Comments'];
        //Echo back id, comment count and commentid
        echo json_encode(array($Post_id, $Comment, $commentid));
    }

    //get count of comments for post//
    public function getCommentCount($posts)
    {
        $commentsfound = $this->comment_model->getCommentCount($posts);
        return $commentsfound->result_array();
    }

    //retrieve comments for post//
    public function getComments()
    {
        $commentid = $this->input->post('id');
        $commentsfound = $this->comment_model->getComments($commentid);
        $i = 0;
        echo json_encode($commentsfound);
    }
    //delete comments function//
    public function delete()
    {

        $id = $this->input->post('commentid');
        $Post_id = $this->input->post('Post_id');
        $this->comment_model->deleteComment($id);
        $comments = $this->comment_model->getsingleCount($Post_id);
        $Comment = $comments['Comments'];
        echo json_encode(array($Post_id, $Comment));
    }
}
