<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_Model extends CI_Model {

    public function get_user_profile($user_master_id) {
        $this->db->where('user_master_id', $user_master_id);
        $query = $this->db->get('user_profile');
//        echo "<pre>";print_r($query->result_array());die;
        $user_profile = $query->result_array();
        return (count($user_profile) > 0 ? $user_profile[0] : null);
    }

    public function update_profile($user_master_id) {
        $data['status'] = false;
        $rules = array(
            array(
                'field' => 'inputFirstName',
                'label' => 'First name',
                'rules' => 'required|min_length[1]|max_length[64]'
            ),
            array(
                'field' => 'inputLastName',
                'label' => 'Last name',
                'rules' => 'required|min_length[1]|max_length[64]'
            ),
            array(
                'field' => 'inputMobile',
                'label' => 'Mobile',
                'rules' => 'required|trim|min_length[10]|numeric'
            ),
            array(
                'field' => 'inputAlternateNumber',
                'label' => 'Alternate number',
                'rules' => 'trim|min_length[10]|numeric'
            ),
            array(
                'field' => 'inputCity',
                'label' => 'City',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $data['errors'] = array(
                'inputFirstName' => form_error('inputFirstName'),
                'inputLastName' => form_error('inputLastName'),
                'inputMobile' => form_error('inputMobile'),
                'inputAlternateNumber' => form_error('inputAlternateNumber'),
                'inputCity' => form_error('inputCity'),
            );
        } else {
            $this->db->where('user_master_id', $user_master_id);
            $query = $this->db->get('user_profile');
            $input_data = array(
                'first_name' => $this->input->post('inputFirstName'),
                'last_name' => $this->input->post('inputLastName'),
                'mobile_number' => $this->input->post('inputMobile'),
                'alternate_number' => $this->input->post('inputAlternateNumber'),
                'city' => $this->input->post('inputCity')
            );
            if ($query->num_rows() > 0) {
                $this->db->where('user_master_id', $user_master_id);
                $input_data['updated_on'] = date('Y-m-d H:i:s');
                $this->db->update('user_profile', $input_data);
            } else {
                $input_data['user_master_id'] = $user_master_id;
                $this->db->insert('user_profile', $input_data);
            }
            if ($this->db->affected_rows() == '1') {
                $_SESSION['user_profile'] = $input_data;
                $data['status'] = true;
                $data['success'] = array(
                    'generic' => 'User profile updated'
                );
            } else {
                $data['errors'] = array(
                    'generic' => 'Could not update user profile. Please contact administrator.',
                );
            }
        }
        return $data;
    }

    public function do_update_password($user_master_id) {
        $data['status'] = false;
        $rules = array(
            array(
                'field' => 'inputCurrentPassword',
                'label' => 'Current password',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'inputNewPassword',
                'label' => 'New password',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'inputConfirmPassword',
                'label' => 'Confirm new password',
                'rules' => 'trim|required|matches[inputNewPassword]'
            )
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $data['errors'] = array(
                'inputCurrentPassword' => form_error('inputCurrentPassword'),
                'inputNewPassword' => form_error('inputNewPassword'),
                'inputConfirmPassword' => form_error('inputConfirmPassword')
            );
        } else {
            $this->load->model('user_model');
            $encrypted_current_password = $this->user_model->encrypt_password($this->input->post('inputCurrentPassword'));
            $where = array(
                'id' => $_SESSION['login_user']['id'],
                'password' => $encrypted_current_password,
                'disabled' => 0,
                'deleted' => 0
            );
            $encrypted_new_password = $this->user_model->encrypt_password($this->input->post('inputNewPassword'));
            $update_data = array(
                'password' => $encrypted_new_password,
                'updated_on' => date('Y-m-d H:i:s')
            );
            $this->db->where($where);
            $this->db->update('user_master', $update_data);
            if ($this->db->affected_rows() < 1) {
                $data['errors'] = array(
                    'generic' => 'Please input a valid current password',
                );
            } else {
                $data['status'] = true;
                $data['success'] = array(
                    'generic' => 'User password updated'
                );
            }
        }
        return $data;
    }

}
