<?php
class Pages extends CI_Controller
{
	//view home page function
	public function view($page = 'home')
	{
		if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
			show_404();
		}
		//Redirect to login if no session
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		} else {
			//retrieve posts, likes and comment counts
			$posts['posts'] = $this->post_model->viewposts();
			if ($posts['posts'] == NULL) {
				$posts['posts'] = $this->post_model->viewownposts();
			}
			$posts['likes'] = $this->post_model->getLikes($posts);
			$posts['liked'] = $this->post_model->Liked($posts);
			$posts['comments'] = $this->comment_model->getCommentCount($posts);
			//Load home page
			$this->load->view('templates/header');
			$this->load->view('pages/home', $posts);
			$this->load->view('templates/footer');
		}
	}
	//get text size preference from DB
	public function textResize()
	{
		$resize = $this->user_model->gettextsize();
	}
}
