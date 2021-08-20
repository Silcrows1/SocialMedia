<?php
class Users extends CI_controller
{
    //Register user function
    public function register()
    {
        //remove login failed error 
        unset($_SESSION['login_failed']);

        //form validation
        $this->form_validation->set_rules('fname', 'FName', 'required');
        $this->form_validation->set_rules('lname', 'LName', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('reminder', 'Reminder', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'required', 'matches[password]');

        //Load page if form validation isnt run
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('users/register');
            $this->load->view('templates/footer');
        } else {
            $password = $this->input->post('password');

            //Create hashed password
            $hashed = $this->hash_password($password);

            //register user sending hashed password
            $bool = $this->user_model->register($hashed);

            //if true, user was successfully created
            if ($bool == true) {
                redirect('users/login');
            }

            //if false, duplicate was found, redirect back to register page
            else if ($bool == false) {
                redirect('users/register');
            }
        }
    }

    //hash password function
    private function hash_password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    //Login user function
    public function login()
    {
        //form validation
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        //Load page if form validation isnt run
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('users/login');
            $this->load->view('templates/footer');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            //Compare username and password against database
            $user = $this->user_model->login($username, $password);

            //if result found create session
            if ($user) {
                $profile = $this->user_model->viewaccount($user);
                $user_data = array(
                    'user_id' => $user,
                    'username' => ucfirst($username),
                    'logged_in' => true,
                    'Picture' => $profile[0]['Picture'],
                    'FirstName' => $profile[0]['FirstName'],
                    'LastName' => $profile[0]['LastName'],
                    'UserType' => $profile[0]['UserType'],
                    'TextSize' => $profile[0]['Vision'],
                );
                $this->session->set_userdata($user_data);
                $this->user_model->gettextsize();
                redirect('pages/view');
            } else {
                //If no result found, return to login page
                redirect('users/login');
            }
        }
    }

    //delete user account//
    public function deleteAccount()
    {
        $id = $this->input->post('accountID');
        $this->user_model->deleteAccount($id);
        $this->logout();
    }

    //Add friend function
    public function addfriend($id)
    {
        $this->user_model->addfriend($id);
        redirect('pages/view');
    }

    //Accept friend request function
    public function acceptrequest($id)
    {
        $this->user_model->acceptrequest($id);
        redirect('pages/view');
    }

    //View account function
    public function viewaccount()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        } else {
            $user['users'] = $this->user_model->viewownaccount();
            $this->load->view('templates/header');
            $this->load->view('users/account', $user);
            $this->load->view('templates/footer');
        }
    }

    //View friend requests function
    public function requests()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        } else {
            $user['requests'] = $this->user_model->viewpending();
            $this->load->view('templates/header');
            $this->load->view('users/requests', $user);
            $this->load->view('templates/footer');
        }
    }

    //View own account function
    public function viewownprofile()
    {

        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        } else {
            $id = $this->session->userdata('user_id');
            $this->load->library('upload');

            //Load all posts, comments and likes
            $user['errors'] = array('error' => $this->upload->display_errors());
            $user['users'] = $this->user_model->viewownaccount();
            $user['friends'] = $this->user_model->friends($id);
            $user['requests'] = $this->user_model->viewpending();
            $user['posts'] = $this->post_model->viewownPosts();
            $user['likes'] = $this->post_model->getprofileLikes($user);
            $user['liked'] = $this->post_model->Liked($user);
            $user['comments'] = $this->comment_model->getCommentCount($user);

            $this->load->view('templates/header');
            $this->load->view('users/profile', $user);
            $this->load->view('templates/footer');
        }
    }

    //View a profile with ID
    public function viewprofile($id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        } else {
            $this->load->library('upload');
            //Load all posts, comments and likes of user
            $user['errors'] = array('error' => $this->upload->display_errors());
            $user['users'] = $this->user_model->viewaccount($id);
            $user['friends'] = $this->user_model->friends($id);
            $user['posts'] = $this->post_model->viewownPosts($id);
            $user['likes'] = $this->post_model->getprofileLikes($user);
            $user['liked'] = $this->post_model->Liked($user);
            $user['requests'] = $this->user_model->viewpending();
            $user['comments'] = $this->comment_model->getCommentCount($user);

            $this->load->view('templates/header');
            $this->load->view('users/profile', $user);
            $this->load->view('templates/footer');
        }
    }
    //edit account with ID
    public function editaccount($id)
    {
        //form validation
        $this->form_validation->set_rules('fname', 'FName', 'required');
        $this->form_validation->set_rules('lname', 'LName', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

        $user['users'] = $this->user_model->viewaccount($id);

        //Check user id matches id trying to edit
        if ($this->session->userdata('user_id') == $id) {

            //Load page if no form validation
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('templates/header');
                $this->load->view('users/editaccount', $user);
                $this->load->view('templates/footer');
            } else {
                //edit account
                $this->user_model->editaccount($id);
                $this->viewaccount();
            }
        } else {
            //if user id doesnt match, redirect home
            redirect('Home');
        }
    }

    //Search users function
    public function search()
    {
        if ($this->input->post('keyword') != NULL) {
            $form_data = $this->input->post('keyword');
            $users['users'] = $this->user_model->search($form_data);
            $this->load->view('templates/header');
            $this->load->view('users/search', $users);
            $this->load->view('templates/footer');
        } else {
            redirect('Home');
        }
    }

    //Get friends function
    public function getFriends()
    {
        $friendsoff = $this->user_model->getFriends();
        echo json_encode($friendsoff);
    }


    //Remove Friend function
    public function removeFriend()
    {
        $friendid = $this->input->post('friendID');
        $this->user_model->removeFriend($friendid);
        return;
    }

    //Get online friends function
    public function getOnlineFriends()
    {
        $friends = $this->user_model->getOnlineFriends();
        echo json_encode($friends);
    }

    //Decline friend request function
    public function declinerequest($id)
    {
        $this->user_model->declinerequest($id);
        redirect('Home');
    }

    //Edit profile function
    public function editprofile()
    {
        //form validation
        $this->form_validation->set_rules('Bio', 'Bio', 'required');

        $id = $this->session->userdata('user_id');
        $user['users'] = $this->user_model->viewaccount($id);

        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        } else {
            //if no form validation, load page
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('templates/header');
                $this->load->view('users/editprofile', $user);
                $this->load->view('templates/footer');
            } else {
                //edit profile
                $this->user_model->editprofile();
                $this->viewprofile($id);
            }
        }
    }

    //Log out function
    public function logout()
    {
        //unset user data from session
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        redirect('users/login');
    }

    //Online function to Set user as online
    public function online($id)
    {
        $this->user_model->online($id);
        return true;
    }

    //Offline function to Set user as offline
    public function offline($id)
    {
        $this->user_model->offline($id);
        return true;
    }

    //Password reminder function
    public function passwordreminder()
    {
        $email = $this->input->post('email');
        $reminder = $this->user_model->passwordreminder($email);
        echo json_encode($reminder);
    }
}
