<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->output->enable_profiler(TRUE);
        if (!isset($_SESSION['login_user'])) {
            redirect(base_url());
        }
        $this->load->model('profile_model');
    }

    public function profile() {
        $user_profile = $this->profile_model->get_user_profile($_SESSION['login_user']['id']);
        $data = array(
            'user_profile' => $user_profile
        );
        $this->load->view('templates/header', $data);
        $this->load->view('app/profile_side_navigation', $data);
        $this->load->view('app/profile', $data);
        $this->load->view('templates/footer', $data);
    }

    public function update_own_profile() {
        $response = $this->profile_model->update_profile($_SESSION['login_user']['id']);
        echo json_encode($response);
    }

    public function update_password() {
        $data = array(
        );
        $this->load->view('templates/header', $data);
        $this->load->view('app/profile_side_navigation', $data);
        $this->load->view('app/update-password', $data);
        $this->load->view('templates/footer', $data);
    }

    public function login_history() {
        $data = array(
        );
        $this->load->view('templates/header', $data);
        $this->load->view('app/profile_side_navigation', $data);
        $this->load->view('app/login-history', $data);
        $this->load->view('templates/footer', $data);
    }

    public function do_update_password() {
        $response = $this->profile_model->do_update_password($_SESSION['login_user']['id']);
        echo json_encode($response);
    }

}
