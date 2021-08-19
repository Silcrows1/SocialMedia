<?php
class Admins extends CI_controller
{
    //View users function for users that opted to be contacted that are online//
    public function viewUsers(){
        if ($this->session->userdata('UserType')== 'Admin'){
        $users['users']= $this->admin_model->getSocialUsers();        
        $this->load->view('templates/header');
        $this->load->view('admins/panel', $users);
        $this->load->view('templates/footer');    
        }
        else{
            redirect('Home');
        }    
    }

    //search through users function for users that opted to be contacted that are online//
    public function search()
    {
        if ($this->session->userdata('UserType')== 'Admin'){
        $form_data = $this->input->post('keyword');
        $users['users'] = $this->admin_model->search($form_data);
        $this->load->view('templates/header');
        $this->load->view('admins/panel', $users);
        $this->load->view('templates/footer');
    }
    else{
        redirect('Home');
    }    
    }
}
