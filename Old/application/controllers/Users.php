<?php 
    class Users extends CI_controller{

        public function register(){
            unset($_SESSION['login_failed']);
                $data['title']='Sign Up';

                $this->form_validation->set_rules('fname','FName','required');
                $this->form_validation->set_rules('lname','LName','required');
                $this->form_validation->set_rules('email','Email','required');
                $this->form_validation->set_rules('reminder','Reminder','required');
                $this->form_validation->set_rules('password','Password','required');
                $this->form_validation->set_rules('password2','Confirm Password','required', 'matches[password]');
    
                if($this->form_validation->run()===FALSE){
                    $this->load->view('templates/header');
                    $this->load->view('users/register', $data);
                    $this->load->view('templates/footer');
                }
                else{
                    $password = $this->input->post('password');
                    //ADD HASHING
                    var_dump($password);
                    $this->user_model->register($password);    
                    redirect('users/login');
                }
            }

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
            redirect('users/login');
        }
    }
?>