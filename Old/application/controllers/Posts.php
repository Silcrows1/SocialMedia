<?php
	class Posts extends CI_Controller{

        public function createPost(){

        $this->post_model->createPost();
        $posts['posts']=$this->post_model->viewposts();
        $posts['likes']=$this->post_model->getLikes($posts);
        $posts['liked']=$this->post_model->Liked($posts);
        $posts['comments']=$this->comment_model->getCommentCount($posts);
        $this->load->view('templates/header');
        $this->load->view('pages/home', $posts);
        $this->load->view('templates/footer');
        }

        /////////////////////////////////////////////
        /////////////not in use//////////////////////
        public function like($post_id){
            var_dump($post_id);
           $this->post_model->likePost($post_id);
            redirect('Home');
        }
        /////////////not in use//////////////////////
        /////////////////////////////////////////////

        public function like2(){
            $id = $this->input->post('id');
            $posts2['post'] = array(
                'post_id'=> $id,
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );        
            $this->post_model->likePost($id);            
            
            $posts['likes']=$this->post_model->getLikes2($posts2);
            
            $like = $posts['likes'][0]['Likes'];
            $id = $posts['likes'][0]['Post_id'];
            
            echo json_encode(array($like, $id));
            
        }

        public function getLikes($post){

           $posts['likes']=$this->post_model->getLikes($post);

            $like = $posts['likes'][0]['Likes'];
            $id = $posts['likes'][0]['Post_id'];
            echo json_encode(array($like, $id));
            
        }      

    }
?>