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
			$posts=NULL;
			$posts['posts']=$this->post_model->viewposts();	
			$this->load->view('templates/header');
			$this->load->view('pages/home', $posts);
			$this->load->view('templates/footer');
            }
		}
	}