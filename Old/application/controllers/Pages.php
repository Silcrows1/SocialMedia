<?php
	class Pages extends CI_Controller{

		public function view($page = 'home'){
			if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
				show_404();
			}

            if (!$this->session->userdata('logged_in')) {
                redirect('users/login');
            }
            else{
				$limitStart = 0;
			$posts['posts']=$this->post_model->viewposts($limitStart);
			$posts['likes']=$this->post_model->getLikes($posts);
			$posts['liked']=$this->post_model->Liked($posts);
			$posts['comments']=$this->comment_model->getCommentCount($posts);

			$this->load->view('templates/header');
			$this->load->view('pages/home', $posts);
			$this->load->view('templates/footer');
            }
		}

		public function textResize(){
			$resize=$this->user_model->gettextsize();

		}
	}