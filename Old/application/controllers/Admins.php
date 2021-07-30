<?php
class Admins extends CI_controller
{
    public function viewUsers(){
        $users['users']= $this->admin_model->getSocialUsers();
        
        $this->load->view('templates/header');
        $this->load->view('admins/panel', $users);
        $this->load->view('templates/footer');
        
    }
}
?>