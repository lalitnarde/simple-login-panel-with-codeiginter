<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->output->enable_profiler(TRUE);
        if (!isset($_SESSION['login_user'])) {
            redirect(base_url());
        }
        if (!isset($_SESSION['user_profile'])) {
            redirect(base_url('profile'));
        }
        $this->load->model('user_model');
    }

    public function index() {
        $data = array(
            'menuitems' => 'hello'
        );
        $this->load->template('app/home', $data);
    }

}
