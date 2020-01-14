<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Precontroller_hook {

    private $CI;

    function __construct() {
        $this->CI = & get_instance();
        if ($this->CI->router->class == "User") {
            return;
        }
        if (!isset($this->CI->session)) {  //Check if session lib is loaded or not
            $this->CI->load->library('session');  //If not loaded, then load it here
        }
    }

    public function pre_requisites() {
        if (!isset($_SESSION['organisations']))
            redirect(base_url('organisation/add-new'));
    }

}
