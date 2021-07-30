<?php
	class Messages extends CI_Controller{

        public function getMessages($id){
            //check users are friends to prevent url altering
            $status = $this->user_model->getfriendstatus($id);
            if($status){
            $messages['Message']=$this->message_model->getMessages($id);
            $messages['friendid'] = $id;

            $this->load->view('templates/header');
			$this->load->view('pages/chat', $messages);
			$this->load->view('templates/footer');
            }
            //if users arent friends, redirect
            else{
                redirect("pages/view");
            }
        }

        public function getMessagesadmin($id){

            $messages['Message']=$this->message_model->getMessages($id);
            $messages['friendid'] = $id;

            $this->load->view('templates/header');
			$this->load->view('pages/chat', $messages);
			$this->load->view('templates/footer');

        }


        public function sendMessage(){
            $message = $this->input->post('message');
            $targetID = $this->input->post('targetId');
            $messagesend = array(
                'Posted_to' => $targetID,
                'Message' => $message,
                'User_id' => $this->session->userdata('user_id')
            );
            $this->message_model->sendMessage($messagesend);
            $this->getMessages($targetID);            
        }


    }

?>