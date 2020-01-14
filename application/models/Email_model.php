<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_Model extends CI_Model {

    private function send_email($data) {

        $this->load->library('email');
        $config = array(
            'wordwrap' => TRUE,
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $this->email->initialize($config);

//        -----------------------------------------------------
        $this->email->from($data['from'], APP_NAME);
        $this->email->to($data['to']);

        $this->email->cc($data['cc']);
        $this->email->bcc($data['cc']);

        $this->email->subject($data['subject']);
        $this->email->message($data['content']);

        return $this->email->send();
    }

    public function send_password_reset_request($email_data) {
        $content = $this->load->view('templates/email/forgot-password', $email_data, TRUE);
        $data = array(
            'to' => $email_data['email'],
            'from' => 'noreply@abc.com',
            'cc' => null,
            'bcc' => null,
            'subject' => 'Reset your password',
            'content' => $content
        );
        return $this->send_email($data);
    }

}
