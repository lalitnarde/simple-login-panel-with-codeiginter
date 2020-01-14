<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->output->enable_profiler(TRUE);
        $this->load->model('user_model');
    }

    public function index() {
        if (isset($_SESSION['login_user'])) {
            redirect(base_url('home'));
        }
        $data = array(
            'string' => 'hello'
        );
        $this->load->template('app/login', $data);
    }

    public function do_login() {
        $response = $this->user_model->do_login();
        echo json_encode($response);
    }

    public function do_logout() {
        $response = $this->user_model->do_logout();
        echo json_encode($response);
    }

    public function forgot_password() {
        if (isset($_SESSION['login_user'])) {
            redirect(base_url('home'));
        }
        $data = array(
            'string' => 'hello'
        );
        $this->load->template('app/forgot-password', $data);
    }

    public function request_password_reset() {
        $response = $this->user_model->request_password_reset();
        echo json_encode($response);
    }

    public function reset_password() {
        if (!$this->input->get('key')) {
            redirect(base_url());
        }
        $password_reset_user = $this->user_model->get_password_reset_user($this->input->get('key'));
        if ($password_reset_user != null) {
            $code_generated_date = new DateTime($password_reset_user[0]['code_generated_time']);
            $current_date = new DateTime();
            $diffDays = $current_date->diff($code_generated_date);
            if ($diffDays->days >= 1) {
                redirect(base_url('forgot-password?msg=request-expired'));
            }

            $this->load->template('app/reset-password', $password_reset_user[0]);
            return;
        }
        redirect(base_url('forgot-password?msg=invalid-request'));
    }

    public function do_reset_password() {
        $response = $this->user_model->do_reset_password();
        echo json_encode($response);
    }

    public function email() {
        $this->load->view('templates/email/forgot-password');
    }

}
