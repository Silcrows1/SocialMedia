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
                    
                    $bool = $this->user_model->register($password);
                    
                    //if true, user was successfully created
                    if ($bool == true){
                    redirect('users/login');
                    }

                    //if false, duplicate was found, redirect back to register page
                    else if ($bool == false) {
                    redirect('users/register');    
                    }
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

        public function addfriend($id){

            $this->user_model->addfriend($id);

            redirect('pages/view');
        
        }

        public function acceptrequest($id){
            $this->user_model->acceptrequest($id);
            redirect('pages/view');
        }

        public function viewaccount(){
            $user['users']=$this->user_model->viewownaccount();
            $this->load->view('templates/header');
            $this->load->view('users/account', $user);
            $this->load->view('templates/footer');        
        }

        public function requests(){
            $user['requests']=$this->user_model->viewpending();
            $this->load->view('templates/header');
            $this->load->view('users/requests', $user);
            $this->load->view('templates/footer');    
        }

        public function viewownprofile(){
            $user['users']=$this->user_model->viewownaccount();
            $user['friends']=$this->user_model->friends();
            $user['requests']=$this->user_model->viewpending();
            $this->load->view('templates/header');
            $this->load->view('users/profile', $user);
            $this->load->view('templates/footer');        
        }

        public function viewprofile($id){
            $user['users']=$this->user_model->viewaccount($id);
            $this->load->view('templates/header');
            $this->load->view('users/profile', $user);
            $this->load->view('templates/footer');        
        }

        public function editaccount($id){

            $this->form_validation->set_rules('fname','FName','required');
            $this->form_validation->set_rules('lname','LName','required');
            $this->form_validation->set_rules('email','Email','required');
            $user['users']=$this->user_model->viewaccount($id);
            

            if($this->form_validation->run()===FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/editaccount', $user);
                $this->load->view('templates/footer');
            }
            else{              
                $this->user_model->editaccount($id);
                $this->viewaccount();
            }
        
        }
        
        public function search(){
            $form_data = $this->input->post('keyword');
            $users['users']=$this->user_model->search($form_data);            
            $this->load->view('templates/header');
            $this->load->view('users/search', $users);
            $this->load->view('templates/footer');
        }


        public function editprofile(){

            $this->form_validation->set_rules('Bio','Bio','required');

            $id=$this->session->userdata('user_id');
            $user['users']=$this->user_model->viewaccount($id);
            

            if($this->form_validation->run()===FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/editprofile', $user);
                $this->load->view('templates/footer');
            }
            else{              
                $this->user_model->editprofile();
                $this->viewprofile($id);
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