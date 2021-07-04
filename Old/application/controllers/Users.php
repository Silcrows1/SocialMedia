<?php 
    class Users extends CI_controller{
        public function login(){
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if($this->form_validation->run()===FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/login');
                $this->load->view('templates/footer');
            } else {
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                $user = $this->user_model->login($username, $password);

                if($user){
                    $user_data = array(
                        'user_id' => $user,
                        'username' => ucfirst($username),
                        'logged_in' => true
                    );
                    $this->session->set_userdata($user_data);
                    redirect('pages/view');
                }else{
                    redirect('users/login');
                  }   
            }
        }
    
        public function logout(){
            //unset user data from session
            $this->session->unset_userdata('logged_in');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('username');
            //flash data to alert user, issues around it never dissapearing so commented out
            //$this->session->set_flashdata('user_loggedout', 'You are now logged out');
            redirect('users/login');
        }
    }
?>