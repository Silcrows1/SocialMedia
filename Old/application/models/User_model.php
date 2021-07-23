<?php
class User_model extends CI_model
{
    public function login($username, $password)
    {
        //Checks database to see where username and password match
        var_dump($username);
        var_dump($password);
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $result = $this->db->get('users');

        //If results from database are true, then return the Id of the user, else return false.
        if ($result->num_rows() == 1) {
            return $result->row(0)->User_id;
        } else {
            return false;
        }
    }

    ////////////////////Register new user function///////////////////
    public function register($password)
    {

        var_dump($password);
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
    public function viewownprofile()
    {
        $this->db->select('*');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->where('users.User_id', $this->session->userdata('user_id'));
        $user = $this->db->get('users');
        return $user->result_array();
    }
    public function profilepicture($url)
    {
        $data = array(
            'Picture' => $url
        );
        $this->db->where('profiles.User_id', $this->session->userdata('user_id'));
        $user = $this->db->update('profiles', $data);
        return;
    }
    public function friends($id = NULL)
    {
        $this->db->select('Usertwo_id, users.FirstName, users.LastName, profiles.Picture');
        $this->db->from('friends');
        $this->db->join('users', 'users.user_id = friends.usertwo_id');
        $this->db->join('profiles', 'users.user_id = profiles.user_id');
        $this->db->where('friends.User_id', $id);
        $friends = $this->db->get();
        return $friends->result_array();
    }
    public function viewpending()
    {
        $this->db->select('Usertwo_id, users.FirstName, users.LastName, Pending_id, submitted_by');
        $this->db->from('pending');
        $this->db->join('users', 'users.user_id = pending.usertwo_id');
        $this->db->where('pending.User_id', $this->session->userdata('user_id'));
        $friends = $this->db->get();
        return $friends->result_array();
    }

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
    public function addfriend($id)
    {

        $data = array(
            'User_id' => $this->session->userdata('user_id'),
            'Usertwo_id' => $id,
            'submitted_by' => $this->session->userdata('user_id')
        );

        $data2 = array(
            'User_id' => $id,
            'Usertwo_id' => $this->session->userdata('user_id'),
            'submitted_by' => $this->session->userdata('user_id')
        );

        $this->db->insert('pending', $data2);
        return $this->db->insert('pending', $data);
    }
    public function editprofile()
    {

        $data = array(
            'Bio' => $this->input->post('Bio')
        );
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $this->db->set($data);
        return $this->db->update('profiles', $data);
    }

    public function viewownaccount()
    {
        $this->db->select('*');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->where('users.User_id', $this->session->userdata('user_id'));
        $user = $this->db->get('users');
        return $user->result_array();
    }

    public function viewaccount($id)
    {
        $this->db->select('*');
        $this->db->join('profiles', 'users.User_id = profiles.User_id');
        $this->db->where('users.User_id', $id);
        $user = $this->db->get('users');
        return $user->result_array();
    }
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
        $data2 = array(
            'Gender' => $this->input->post('gender')
        );
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $this->db->set($data);
        $this->db->update('users', $data);
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $this->db->set($data2);
        return $this->db->update('profiles', $data2);
    }
    public function search($form_data)
    {

        $sql = "CONCAT(FirstName,' ', LastName) LIKE '%$form_data%'";
        $this->db->select('FirstName, LastName, User_id');
        $this->db->where($sql);
        $found = $this->db->get('users');

        return $found->result_array();
    }

    public function getFriends()
    {

        $this->db->select('users.FirstName, users.LastName, friends.Usertwo_id');
        $this->db->from('users');
        $this->db->join('friends', 'users.User_id = friends.Usertwo_id');
        $this->db->where('friends.User_id', $this->session->userdata('user_id'));
        $friends = $this->db->get();
        return $friends->result_array();
    }

    ////////////////////check for duplicate usernames function///////////////////
    public function duplicate($data)
    {
        //retireve all users that match username entered.
        $this->db->select('Username');
        $this->db->where('users.Username', $data['Username']);
        $found = $this->db->get('users');

        //if username is found in database, create flashdata for user exsists.
        if ($found->num_rows() >= 1) {
            $msgText = "User already exsists with this username";
            $this->session->set_flashdata('userexsists', '<div class="alert alert-danger text-center">' . $msgText . '</div>');
            return false;
        } else {
            return true;
        }
    }

    public function gettextsize()
    {
        $this->db->select('vision');
        $this->db->where('User_id', $this->session->userdata('user_id'));
        $text = $this->db->get('users');
    }
}
