<?php
class User_model extends CI_model
{
    //Login function
    public function login($username, $password)
    {
        //Checks database to see where username and password match

        $this->db->where('username', $username);
        $query = $this->db->get('users');
        $result = $query->row_array();

        //If results from database are true, then return the Id of the user, else return false.
        if (!empty($result) && password_verify($password, $result['Password'])) {
            return $result['User_id'];
        } else {
            return false;
        }
    }

    //Register new user function
    public function register($password)
    {

        $data = array(
            'FirstName' => $this->input->post('fname'),
            'LastName' => $this->input->post('lname'),
            'Email' => $this->input->post('email'),
            'HelpRequired' => $this->input->post('support'),
            'Vision' => $this->input->post('fontpref'),
            'reminderquestion' => $this->input->post('question'),
            'Reminder' => $this->input->post('reminder'),
            'Username' => $this->input->post('username'),
            'password' => $password
        );

        //run duplicate function
        $bool = $this->duplicate($data);

        //if duplicate username found, return false
        if ($bool == false) {
            return false;
        }
        //if no duplicate username found, insert new user.
        else {
            $this->db->insert('users', $data);

            //return the new user id
            $created_new = $this->db->insert_id();
            $created_id = (string)$created_new;

            //add user id to array to be used to create profile for user.
            $created = array(
                'User_id' => $created_id,
                'gender' => $this->input->post('gender')
            );

            $this->db->insert('profiles', $created);
            return true;
        }
    }

    //Password reminder function
    public function passwordreminder($email)
    {
        $this->db->select('reminderquestion, Reminder');
        $this->db->from('users');
        $this->db->where('users.Email', $email);
        $user = $this->db->get();
        if ($user) {
            return $user->result_array();
        }
    }

    //View own profile function
    public function viewownprofile()
    {
        $this->db->select('*');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->where('users.User_id', $this->session->userdata('user_id'));
        $user = $this->db->get('users');
        return $user->result_array();
    }

    //Profile picture function for uploading
    public function profilepicture($url)
    {
        $data = array(
            'Picture' => $url
        );

        //get last profile picture name//
        $this->db->select('Picture');
        $this->db->from('profiles');
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        $file_name = $query->result_array();
        $filenamelink = $file_name[0]['Picture'];

        //if a file location exists, unlink the image (delete)//
        if ($file_name != NULL) {
            if (file_exists(FCPATH . '/assets/images/' . $filenamelink)) {
                var_dump($filenamelink);
                unlink(FCPATH . 'assets/images/' . $filenamelink);
            } else {
            }
        }
        $this->db->where('profiles.User_id', $this->session->userdata('user_id'));
        $this->db->update('profiles', $data);
        return;
    }

    //Friends function
    public function friends($id = NULL)
    {
        //Find friends that match the ID
        $this->db->select('Usertwo_id, users.FirstName, users.LastName, profiles.Picture');
        $this->db->from('friends');
        $this->db->join('users', 'users.user_id = friends.usertwo_id');
        $this->db->join('profiles', 'users.user_id = profiles.user_id');
        $this->db->where('friends.User_id', $id);
        $friends = $this->db->get();
        return $friends->result_array();
    }

    //Get friend status function
    public function getfriendstatus($id)
    {
        //find if user ID and session ID are friends
        $this->db->select('*');
        $this->db->from('friends');
        $this->db->where('friends.Usertwo_id', $id);
        $this->db->where('friends.User_id', $this->session->userdata('user_id'));
        $friends = $this->db->get();
        return $friends->result_array();
    }

    //View pending friend requests function
    public function viewpending()
    {
        $this->db->select('Usertwo_id, users.FirstName, users.LastName, Pending_id, submitted_by');
        $this->db->from('pending');
        $this->db->join('users', 'users.user_id = pending.usertwo_id');
        $this->db->where('pending.User_id', $this->session->userdata('user_id'));
        $friends = $this->db->get();
        return $friends->result_array();
    }

    //decline friend request function
    public function declinerequest($id)
    {
        $this->db->select('pending.User_id, Usertwo_id, users.FirstName, users.LastName');
        $this->db->from('pending');
        $this->db->join('users', 'users.user_id = pending.usertwo_id');
        $this->db->where('pending.Pending_id', $id);
        $friends = $this->db->get();
        $array = (array)$friends->row();

        $id1 = $array['User_id'];
        $id2 = $array['Usertwo_id'];

        //delete pending friend 1 
        $this->db->select('*');
        $this->db->from('pending');
        $this->db->where('pending.User_id', $id1);
        $this->db->where('pending.Usertwo_id', $id2);
        $this->db->delete();

        //delete pending friend 2
        $this->db->select('*');
        $this->db->from('pending');
        $this->db->where('pending.User_id', $id2);
        $this->db->where('pending.Usertwo_id', $id1);
        $this->db->delete();

        return;
    }

    //Accept friend request function
    public function acceptrequest($id)
    {
        $this->db->select('pending.User_id, Usertwo_id, users.FirstName, users.LastName');
        $this->db->from('pending');
        $this->db->join('users', 'users.user_id = pending.usertwo_id');
        $this->db->where('pending.Pending_id', $id);
        $friends = $this->db->get();
        $array = (array)$friends->row();

        $id1 = $array['User_id'];
        $id2 = $array['Usertwo_id'];

        //delete pending friend 1 
        $this->db->select('*');
        $this->db->from('pending');
        $this->db->where('pending.User_id', $id1);
        $this->db->where('pending.Usertwo_id', $id2);
        $this->db->delete();

        //delete pending friend 2
        $this->db->select('*');
        $this->db->from('pending');
        $this->db->where('pending.User_id', $id2);
        $this->db->where('pending.Usertwo_id', $id1);
        $this->db->delete();

        $data = array(
            'User_id' => $id1,
            'Usertwo_id' => $id2
        );

        $data2 = array(
            'Usertwo_id' => $id1,
            'User_id' => $id2
        );

        //Add friend 1
        $this->db->insert('friends', $data);
        //Add friend 2
        $this->db->insert('friends', $data2);

        return;
    }

    //Add friend function
    public function addfriend($id)
    {
        //data array one for friend request to id
        $data = array(
            'User_id' => $this->session->userdata('user_id'),
            'Usertwo_id' => $id,
            'submitted_by' => $this->session->userdata('user_id')
        );

        //data array two for friend request from session holder
        $data2 = array(
            'User_id' => $id,
            'Usertwo_id' => $this->session->userdata('user_id'),
            'submitted_by' => $this->session->userdata('user_id')
        );

        $this->db->insert('pending', $data2);
        return $this->db->insert('pending', $data);
    }

    //Remove friend function
    public function removeFriend($id)
    {
        $this->db->where('User_id', $id);
        $this->db->where('Usertwo_id', $this->session->userdata('user_id'));
        $this->db->delete('friends');

        $this->db->where('Usertwo_id', $id);
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $this->db->delete('friends');
        return;
    }

    //Edit profile function
    public function editprofile()
    {

        $data = array(
            'Bio' => $this->input->post('Bio')
        );
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $this->db->set($data);
        return $this->db->update('profiles', $data);
    }

    //View own account function
    public function viewownaccount()
    {
        $this->db->select('*');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->where('users.User_id', $this->session->userdata('user_id'));
        $user = $this->db->get('users');
        return $user->result_array();
    }

    //Delete account function
    public function deleteAccount($profileID)
    {
        if ($this->session->userdata('user_id') == $profileID) {

            //delete other users interactions with users posts//
            $this->db->query('DELETE FROM interactions WHERE interactions.post_id = ANY(SELECT interactions.post_id FROM interactions 
            JOIN posts ON interactions.post_id = posts.Post_id WHERE posts.User_id = ' . $profileID . ')');

            //Delete user account//
            $this->db->where('users.User_id', $profileID);
            $this->db->delete('users');

            //delete profile from user//
            $this->db->where('profiles.User_id', $profileID);
            $this->db->delete('profiles');

            //delete comments from user//
            $this->db->where('comments.User_id', $profileID);
            $this->db->delete('comments');

            //delete chat from user//
            $this->db->where('messages.User_id', $profileID);
            $this->db->delete('messages');

            //delete friends from user//
            $this->db->where('friends.User_id', $profileID);
            $this->db->delete('friends');

            $this->db->where('friends.Usertwo_id', $profileID);
            $this->db->delete('friends');

            //delete all posts from user//
            $this->db->where('posts.User_id', $profileID);
            $this->db->delete('posts');
        } else {
        }
    }

    //View account with id function
    public function viewaccount($id)
    {
        $this->db->select('*');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->where('users.User_id', $id);
        $user = $this->db->get('users');
        return $user->result_array();
    }

    //edit account function
    public function editaccount()
    {
        $data = array(
            'FirstName' => $this->input->post('fname'),
            'LastName' => $this->input->post('lname'),
            'Email' => $this->input->post('email'),
            'HelpRequired' => $this->input->post('support'),
            'Vision' => $this->input->post('fontpref'),
            'Username' => $this->input->post('username')
        );

        $newfont = $this->input->post('fontpref');
        $this->session->set_userdata('TextSize', $newfont);


        $password = $this->input->post('password');
        $password2 = $this->input->post('password2');

        //If new password inserted, hash new password
        if ($password != NULL) {
            $hashed = $this->hash_password($password2);
            $this->db->select('Password');
            $this->db->from('users');
            $this->db->where('User_id', $this->session->userdata('user_id'));
            $query = $this->db->get();
            $query->result_array();
            $result = $query->row_array();

            $newpw = array(
                'Password' => $hashed,
            );
            //compare old password from input and database
            if (password_verify($password, $result['Password'])) {
                //If match, set new hashed password
                $this->db->where('User_id', $this->session->userdata('user_id'));
                $this->db->set('Password', $newpw);
                $this->db->update('users', $newpw);
            }
        }

        $data2 = array(
            'Gender' => $this->input->post('gender')
        );
        //Update users
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $this->db->set($data);
        $this->db->update('users', $data);

        //Update profiles
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $this->db->set($data2);
        return $this->db->update('profiles', $data2);
    }

    //Hash password function
    private function hash_password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    //Search users function
    public function search($form_data)
    {
        //SQL to concat first name and last name to compare against form data.
        $sql = "CONCAT(FirstName,' ', LastName) LIKE '%$form_data%'";
        $this->db->select('FirstName, LastName, users.User_id, Picture');
        $this->db->from('users');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->where($sql);
        $found = $this->db->get();

        return $found->result_array();
    }

    //Get friends function (offline)
    public function getFriends()
    {
        $this->db->select('users.FirstName, users.LastName, friends.Usertwo_id');
        $this->db->from('users');
        $this->db->join('friends', 'users.User_id = friends.Usertwo_id');
        $this->db->where('friends.User_id', $this->session->userdata('user_id'));
        $this->db->where('users.User_id NOT IN (select User_id FROM onlineusers)');

        $friendsoff = $this->db->get();
        return $friendsoff->result_array();
    }
    //Get Online friends function
    public function getOnlineFriends()
    {

        $this->db->select('users.FirstName, users.LastName, friends.Usertwo_id');
        $this->db->from('users');
        $this->db->join('friends', 'users.User_id = friends.Usertwo_id');
        $this->db->join('onlineusers', 'users.User_id = onlineusers.User_id');
        $this->db->where('friends.User_id', $this->session->userdata('user_id'));
        $friends = $this->db->get();
        return $friends->result_array();
    }

    //check for duplicate usernames function
    public function duplicate($data)
    {
        //retireve all users that match username entered.
        $this->db->select('Username');
        $this->db->where('users.Username', $data['Username']);
        $found = $this->db->get('users');

        if ($found->num_rows() < 1) {
            $this->db->select('Email');
            $this->db->where('users.Email', $data['Email']);
            $found = $this->db->get('users');
        }

        //if username is found in database, create flashdata for user exsists.
        if ($found->num_rows() >= 1) {
            $msgText = "User already exists with this username or email";
            $this->session->set_flashdata('userexsists', '<div class="alert alert-danger text-center">' . $msgText . '</div>');
            return false;
        } else {
            return true;
        }
    }

    //Update contact function
    public function updatecontact($id)
    {
        // Set array with date time
        date_default_timezone_set('Europe/London');
        $now = date('Y-m-d H:i:s');
        $contact = array(
            'LastContact' =>  $now
        );

        //update users Last Contact column when talking with a volunteer
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $this->db->update('users', $contact);
    }

    //Get Text Size function
    public function gettextsize()
    {
        $this->db->select('vision');
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $text = $this->db->get('users');
    }

    //Online function to Add users as online
    public function online($id)
    {
        $users = array(
            'User_id' => $id,
        );
        $this->db->insert('onlineUsers', $users);
    }

    //Offline function to Add users as offline
    public function offline($id)
    {
        $users = array(
            'User_id' => $id,
        );
        $this->db->delete('onlineUsers', $users);
    }
}
