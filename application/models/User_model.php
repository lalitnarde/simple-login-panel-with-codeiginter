<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {

    function do_login() {
        $rules = array(
            array(
                'field' => 'inputEmail',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email',
                'errors' => array(
                    'required' => '%s is required',
                    'valid_email' => 'Please enter a valid %s'
                )
            ),
            array(
                'field' => 'inputPassword',
                'label' => 'Password',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Please enter your %s'
                )
            )
        );
        $this->form_validation->set_rules($rules);
        $data['status'] = false;
        if ($this->form_validation->run() == FALSE) {
            $data['errors'] = array(
                'inputEmail' => form_error('inputEmail'),
                'inputPassword' => form_error('inputPassword'),
            );
        } else {
            $encrypted_password = $this->encrypt_password($this->input->post('inputPassword'));
            $where = array(
                'email' => $this->input->post('inputEmail'),
                'password' => $encrypted_password,
                'deleted' => 0
            );
            $this->db->where($where);
            $query = $this->db->get('user_master');
            $result = $query->result_array();
            if (count($result) < 1) {
                $data['errors'] = array(
                    'generic' => 'Email or password is incorrect',
                );
            } else {
                if ($result[0]['disabled'] == 1) {
                    $data['errors'] = array(
                        'generic' => 'Access for this user is denied',
                    );
                } else {
                    $this->set_user_session($result[0]['id']);
                    $data['status'] = true;
                    $data['redirect_url'] = base_url('home');
                }
            }
        }
        $this->log_user_details();
        return $data;
    }

    public function encrypt_password($password) {
        //implement your own encryption algorithm
        return $password;
    }

    private function set_user_session($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('user_master');
        $result = $query->result_array();
        $_SESSION['login_user'] = array(
            'id' => $user_id,
            'email' => $result[0]['email'],
            'disabled' => $result[0]['disabled'],
            'deleted' => $result[0]['deleted']
        );
        $this->load->model('profile_model');
        $user_profile = $this->profile_model->get_user_profile($user_id);
        if ($user_profile != null) {
            $_SESSION['user_profile'] = $user_profile;
        }
    }

    private function log_user_details() {
        $insert_data = array(
            'user_master_id' => (isset($_SESSION['login_user']) ? $_SESSION['login_user']['id'] : ''),
            'ip_address' => $this->input->ip_address(),
            'login_time' => date('Y-m-d H:i:s'),
            'login_success' => (isset($_SESSION['login_user']) ? 1 : 0)
        );
        $this->db->insert('user_login_log', $insert_data);
        $insert_id = $this->db->insert_id();
        if (isset($_SESSION['login_user'])) {
            $_SESSION['login_user']['user_login_log_id'] = $insert_id;
        }
    }

    public function do_logout() {
        if (isset($_SESSION['login_user'])) {
            $update_data = array(
                'logout_time' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', $_SESSION['login_user']['user_login_log_id']);
            $this->db->update('user_login_log', $update_data);
        }
        session_destroy();
        redirect(base_url());
    }

    public function request_password_reset() {
        $this->load->model('email_model');
        $rules = array(
            array(
                'field' => 'inputEmail',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email',
                'errors' => array(
                    'required' => '%s is required',
                    'valid_email' => 'Please enter a valid %s'
                )
            )
        );
        $this->form_validation->set_rules($rules);
        $data['status'] = false;
        if ($this->form_validation->run() == FALSE) {
            $data['errors'] = array(
                'inputEmail' => form_error('inputEmail')
            );
        } else {
//            -----------logic for password reset email-----------
            $where = array(
                'email' => $this->input->post('inputEmail'),
                'deleted' => 0,
                'disabled' => 0
            );

//          get user profile
            $this->db->where($where);
            $this->db->select('um.id,um.email,up.first_name,up.mobile_number,up.city');
            $this->db->from('user_master um');
            $this->db->join('user_profile up', 'up.user_master_id = um.id', 'left');
            $query = $this->db->get();
            $result = $query->result_array();


            if (count($result) < 1) {
                //user not found
                $data['errors'] = array(
                    'generic' => 'No such user exists'
                );
            } else {
                //user found
                //close all open password reset request
                $where = array(
                    'user_master_id' => $result[0]['id']
                );
                $prl_update_data = array(
                    'is_active' => 0
                );
                $this->db->update('password_reset_log', $prl_update_data);

                //create new password reset request

                $password_reset_code = random_string('alnum', 128);
                $password_reset_link = $this->get_password_reset_link($password_reset_code);
                $prl1_insert_data = array(
                    'user_master_id' => $result[0]['id'],
                    'password_reset_code' => $password_reset_code,
                    'code_generated_time' => date('Y-m-d H:i:s'),
                    'is_active' => 1
                );
                $this->db->insert('password_reset_log', $prl1_insert_data);
                if ($this->db->affected_rows() != '1') {
                    $data['errors'] = array(
                        'generic' => 'Could not process your request'
                    );
                } else {
                    $mail_data = array(
                        'email' => $result[0]['email'],
                        'product_name' => APP_NAME,
                        'operating_system' => $this->agent->platform(),
                        'browser' => $this->agent->browser(),
                        'ip_address' => $this->input->ip_address(),
                        'name' => isset($result[0]['first_name']) ? $result[0]['first_name'] : 'there',
                        'password_reset_link' => $password_reset_link
                    );
                    $mail_sent = $this->email_model->send_password_reset_request($mail_data);
                    if ($mail_sent == true) {
                        $data['status'] = true;
                        $data['success'] = array(
                            'generic' => 'Please check your inbox. We have a sent a password reset link to your registered Mail Id.'
                        );
                    } else {
                        $data['errors'] = array(
                            'generic' => 'Could not process your request'
                        );
                    };
                }
            }
        }
        return $data;
    }

    private function get_password_reset_link($password_reset_code) {
        return base_url('reset-password?key=' . $password_reset_code);
    }

    public function get_password_reset_user($key) {
        $where = array(
            'password_reset_code' => $key,
            'is_active' => 1
        );
        $this->db->where($where);
        $this->db->select('um.id,um.email,prl.password_reset_code,prl.code_generated_time,prl.is_active');
        $this->db->from('user_master um');
        $this->db->join('password_reset_log prl', 'prl.user_master_id=um.id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function do_reset_password() {
        $data['status'] = false;
        if (!$this->input->post('inputEmail') || !$this->input->post('inputKey')) {
            $data['errors'] = array(
                'generic' => 'Invalid request'
            );
        } else {
            $rules = array(
                array(
                    'field' => 'inputPassword',
                    'label' => 'Password',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'inputConfirmPassword',
                    'label' => 'Confirm password',
                    'rules' => 'trim|required|matches[inputPassword]'
                )
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $data['errors'] = array(
                    'inputPassword' => form_error('inputPassword'),
                    'inputConfirmPassword' => form_error('inputConfirmPassword'),
                );
            } else {
                $encrypted_password = $this->encrypt_password($this->input->post('inputPassword'));
                $update_data = array(
                    'password' => $encrypted_password,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $where = array(
                    'email' => $this->input->post('inputEmail')
                );
                $this->db->where($where);
                $this->db->update('user_master', $update_data);
                if ($this->db->affected_rows() > 0) {
                    $prl_where = array(
                        'password_reset_code' => $this->input->post('inputKey')
                    );
                    $prl_udpate_data = array(
                        'is_active' => 0,
                        'is_successful' => 1,
                        'password_reset_time' => date('Y-m-d H:i:s')
                    );
                    $this->db->where($prl_where);
                    $this->db->update('password_reset_log', $prl_udpate_data);
                    $data['status'] = true;
                    $data['redirect_url'] = base_url('?msg=sign-in-again-using-your-new-password-to-continue');
                } else {
                    $data['errors'] = array(
                        'generic' => 'Could not update your password'
                    );
                }
            }
        }
        return $data;
    }

}
