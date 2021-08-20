<?php

class Upload extends CI_Controller
{

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
        }

        //View upload form, clear error array
        public function index()
        {
                $this->load->view('upload_form', array('error' => ' '));
        }

        //Upload image function
        public function do_upload()
        {

                date_default_timezone_set('Europe/London');
                $id = $this->session->userdata('user_id');

                //Date format
                $image = date('dmy' . '-' . 'Gis') . '-' . $id;

                //Image config
                $config['upload_path']          = FCPATH . 'assets/images/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 10000;
                $config['max_width']            = 10024;
                $config['max_height']           = 7068;
                $config['file_name']           = $image;

                $this->load->library('upload', $config);

                //Load errors into array and redirect to view own profile if not successfull
                if (!$this->upload->do_upload('userfile')) {
                        $user['errors'] = array('error' => $this->upload->display_errors());
                        redirect('users/viewownprofile');
                } else {

                        $data = array('upload_data' => $this->upload->data());
                        $ext = $this->upload->data('file_ext');

                        //set custom name to prevent duplicated, name is day and time, user id and image extension.
                        $image = date('dmy' . '-' . 'Gis') . '-' . $id . $ext;
                        $this->user_model->profilepicture($image);
                        redirect('Home');
                }
        }
}
