<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('validate_email')) {

    function validate_email($email = '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Please enter a valid email";
        }
        return $emailErr;
    }

}