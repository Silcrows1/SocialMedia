<?php
class User_model extends CI_model{
    public function login($username, $password){
        //Checks database to see where username and password match
        var_dump($username);
        var_dump($password);
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $result=$this->db->get('users');

        //If results from database are true, then return the Id of the user, else return false.
        if ($result->num_rows()==1) {
            return $result->row(0) ->User_id;
        }else{
            return false;
        }
    }

    ////////////////////Register new user function///////////////////
    public function register($password){

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

    
    $bool = $this->duplicate($data);

    if($bool == false){
        return false;
    }
    else
    {
        $this->db->insert('users', $data);
            //return the new user id
        $created_new = $this->db->insert_id();
        $created_id = (string)$created_new;

        //add user id to array to be used to create profile for user.
        $created = array(
            'User_id' => $created_id
            //'Bio' => $data('fname'.' '.'lname')
        );

        $this->db->insert('profiles', $created);
        return true;
    }
    }
    
    ////////////////////check for duplicate usernames function///////////////////
    public function duplicate($data)
    {
        $this->db->select('Username');
        $this->db->where('users.Username', $data['Username']);
        $found = $this->db->get('users');
    
    if ($found->num_rows()>=1) 
    {
        $msgText = "User already exsists with this username";
        $this->session->set_flashdata('userexsists', '<div class="alert alert-danger text-center">'.$msgText.'</div>');
        return false;
    }
    else
    {
        return true;
    }
    }
}



?>