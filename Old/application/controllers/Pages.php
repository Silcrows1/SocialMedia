<?php
	class Pages extends CI_Controller{
		//set page to home, if home.php doesnt exsist, show 404
		public function view($page = 'home'){
			if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
				show_404();
			}
            //If userdata doesnt contain logged_in, redirect to login page.
            if (!$this->session->userdata('logged_in')) {
                redirect('users/login');
            }
            else{
			//sets title and sets first letter to uppercase
			$data['title'] = ucfirst($page);
			//loads page
			$this->load->view('templates/header');
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/footer');
            }
		}
	}