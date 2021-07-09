<?php

class Upload extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
        }

        public function index()
        {
                $this->load->view('upload_form', array('error' => ' ' ));
        }

        public function do_upload()
        {

                 date_default_timezone_set('Europe/London');                 
                $id = $this->session->userdata('user_id');
                
                        
                $image = date('dmy'.'-'.'Gis').'-'.$id;

                $config['upload_path']          = FCPATH . 'assets/images/'; 
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 10000;
                $config['max_width']            = 10024;
                $config['max_height']           = 7068;
                $config['file_name']           = $image;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $user['errors'] = array('error' => $this->upload->display_errors());
                        $user['users']=$this->user_model->viewownaccount();
                        $user['friends']=$this->user_model->friends();
                        $user['requests']=$this->user_model->viewpending();
                        $this->load->view('templates/header');
                        $this->load->view('users/profile', $user);
                        $this->load->view('templates/footer'); 
                            }
                else
                { 
                        $data = array('upload_data' => $this->upload->data()); 
                        $ext = $this->upload->data('file_ext');                       
                        $image = date('dmy'.'-'.'Gis').'-'.$id.$ext;
                        $this->user_model->profilepicture($image);
                        $this->load->view('templates/header');
                        $this->load->view('pages/upload_success', $data);
                        $this->load->view('templates/footer');
                }
        }
}
?>