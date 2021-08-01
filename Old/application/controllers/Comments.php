<?php
	class Comments extends CI_Controller{

        public function createComment(){
            $id = NULL;
            $id = $this->input->post('id');
            $comment = $this->input->post('comment');
            $commentarray = array(
                'Post_id' => $id,
                'Comment' => $comment,
                'User_id' => $this->session->userdata('user_id')
            );         
            $this->comment_model->createComment($commentarray);
            
            $comments = $this->comment_model->getsingleCount($id);

            $Post_id = $id; 
            $Comment = $comments['Comments'];
            echo json_encode(array($Post_id, $Comment));

        }

        public function getCommentCount($posts){            
            
            $commentsfound = $this->comment_model->getCommentCount($posts);
            return $commentsfound ->result_array();
        }

        public function getComments(){            
            $commentid = $this->input->post('id');
            
            $commentsfound = $this->comment_model->getComments($commentid);
            $i=0;

            echo json_encode($commentsfound);

        }

        public function delete($id){            
            
            $this->comment_model->deleteComment($id);
            redirect('Home');

            
        //echo $commentsfound;
        }

    }
?>