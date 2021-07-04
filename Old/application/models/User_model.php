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
    //insert data into a table
    return $this->db->insert('users', $data);
    }
}
?>