<?php
class Messages extends CI_Controller
{

    //get Messages function for chat
    public function getMessages($id)
    {
        //check users are friends to prevent url altering
        $status = $this->user_model->getfriendstatus($id);
        if ($status) {
            $messages['Message'] = $this->message_model->getMessages($id);
            $messages['friendid'] = $id;

            $this->load->view('templates/header');
            $this->load->view('pages/chat', $messages);
            $this->load->view('templates/footer');
        }
        //if users arent friends, redirect
        else {
            redirect("pages/view");
        }
    }
    //Get messages admin function, does not require friends
    public function getMessagesadmin($id)
    {

        $messages['Message'] = $this->message_model->getMessages($id);
        $messages['friendid'] = $id;
        $this->user_model->updatecontact($id);

        $this->load->view('templates/header');
        $this->load->view('pages/chat', $messages);
        $this->load->view('templates/footer');
    }

    //Send message function, called from jQuery in chat window
    public function sendMessage()
    {
        if ($this->input->post('message') != NULL) {
            $message = $this->input->post('message');
            $targetID = $this->input->post('targetId');
            $messagesend = array(
                'Posted_to' => $targetID,
                'Message' => $message,
                'User_id' => $this->session->userdata('user_id')
            );
            $this->message_model->sendMessage($messagesend);
        }
    }
}
