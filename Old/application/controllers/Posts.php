<?php
	class Posts extends CI_Controller{

        public function createPost(){

        $this->post_model->createPost();
        $posts['posts'] = $this->post_model->viewposts();
        $this->load->view('templates/header');
        $this->load->view('pages/home', $posts);
        $this->load->view('templates/footer');
        }
    }
?>