<?php
	class Posts extends CI_Controller{

        public function createPost(){

        $this->post_model->createPost();
        $posts['posts'] = $this->post_model->viewposts();
        //$posts['pending'] = $this->post_model->viewpending();
        $posts['likes']=$this->post_model->getLikes($posts);
        $posts['liked']=$this->post_model->liked($posts);
        $this->load->view('templates/header');
        $this->load->view('pages/home', $posts);
        $this->load->view('templates/footer');
        }

        public function like($post_id){
            $this->post_model->likePost($post_id);
            redirect('Home');
        }


    }
?>