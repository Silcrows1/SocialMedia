<?php
class Admins extends CI_controller
{
    //View users function for users that opted to be contacted that are online//
    public function viewUsers(){
        $users['users']= $this->admin_model->getSocialUsers();        
        $this->load->view('templates/header');
        $this->load->view('admins/panel', $users);
        $this->load->view('templates/footer');        
    }

    //search through users function for users that opted to be contacted that are online//
    public function search()
    {
        $form_data = $this->input->post('keyword');
        $users['users'] = $this->admin_model->search($form_data);
        $this->load->view('templates/header');
        $this->load->view('admins/panel', $users);
        $this->load->view('templates/footer');
    }
}
?>