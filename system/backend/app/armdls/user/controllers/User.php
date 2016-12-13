<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// importing rest library
require_once APPPATH . '/libraries/REST_Controller.php';

class User extends REST_Controller {

// Load model in constructor
    public function __construct() {
        parent::__construct();
        // load models
        $this->load->model('User_model');
    }

// Server's Get user data
    public function data_get($id_param = NULL) {
        // retrieve data 'email' from get method
        $id = $this->input->get('email');
        // check $id value
        if ($id === NULL) {
            // set $id with id in parameter
            $id = $id_param;
        }
        // if $id still null
        if ($id === NULL) {
            // call method read from user_model
            $data = $this->User_model->read($id);
            // if return true
            if ($data) {
                // set success response header
                $this->response($data, REST_Controller::HTTP_OK);
            } else {
                // set failed response header
                $this->response([
                    'status' => FALSE,
                    'error' => 'No users were found'
                        ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
        // call method read from user_model
        $data = $this->User_model->read($id);
        // if return true
        if ($data) {
            // set success response header
            $this->set_response($data, REST_Controller::HTTP_OK);
        } else {
            // set failed response header
            $this->set_response([
                'status' => FALSE,
                'error' => 'Record could not be found'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

// Server's Post/Create user
    public function data_post() {
        // retrieve data 'input' from post method
        $input = $this->input->post('input');
        // call check_username from user_model
        $create = $this->User_model->check_username($input['email']);
        // if return true
        if ($create) {
            // set data equals to input
            $data = array(
                'u_email' => $input['email'],
                'u_password' => md5($input['password']),
                'u_role' => $input['role'],
                'u_name' => $input['name']
            );
            // call insert from user_model
            $this->User_model->insert($data);
            // set message as success
            $message = [
                'status' => TRUE,
                'message' => $data['u_email'] . ' created'
            ];
            // set response header http_created
            $this->set_response($message, REST_Controller::HTTP_CREATED);
        } else {
            // set message as failed
            $message = [
                'status' => FALSE,
                'message' => $input['email'] . ' already exist'
            ];
            // set response header http_ok
            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

// Server's Put/update user
    public function data_put() {
        $input = $this->input->input_stream('input');
        $this->User_model->update($input);
        $message = [
            'status' => TRUE,
            'message' => $data['u_name'] . ' updated'
        ];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

// Server's Delete user
    public function data_delete() {
        // retrieve data from segment 3 (/)
        $id = $this->input->get('input');
        $id = $id['u_email'];
        // if $id is null
        if ($id === NULL) {
            // set failed response header
            $this->set_response([
                'status' => FALSE,
                'error' => 'Email cannot be empty'
                    ], REST_Controller::HTTP_OK);
        }
        // call delete from user_model
        $data = $this->User_model->delete($id);
        // if return true
        if ($data) {
            // set success response header
            $this->set_response([
                'status' => TRUE,
                'message' => 'Data Deleted'
                    ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            // set failed response header
            $this->set_response([
                'status' => FALSE,
                'error' => 'Record could not be found'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

// Login with post method
    public function login_post() {
        $input = $this->input->post('input');
        $password = md5($input['u_password']);

        $data = array(
            'u_email' => $input['u_email'],
            'u_password' => $password
        );
        //$this->set_response($data, REST_Controller::HTTP_OK);
        // check if either $username or $password is null
        if ($input['u_email'] === NULL || $input['u_password'] === NULL) {

            $this->set_response([
                'status' => FALSE,
                'error' => 'username or password cannot be empty'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
        // call check_password from user_model
        $data = $this->User_model->check_password($input);
        // if return true
        if ($data) {
            // set message as true
            $user['role'] = $data[0]['u_role'];
            $user['email'] = $data[0]['u_email'];
            $user['name'] = $data[0]['u_name'];
            $message = [
                'status' => TRUE,
                'message' => 'Login success',
                'data' => $user
            ];
        } else {
            // set message as failed
            $message = [
                'status' => FALSE,
                'message' => 'Login failed'
            ];
        }
        // set response header
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function forgot_password_get() {
        $email = $this->input->get('email');
        $verif_code = $this->input->get('verif');
        if ($verif_code == NULL) {
            $this->sendEmail();
            $message = [
                'status' => TRUE,
                'message' => 'Check your email to reset password'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            if ($verif_code === '') {
                $data['u_password'] = "RANDOMSTRING";
                $this->User_model->update($data);
                $message = [
                    'status' => TRUE,
                    'message' => 'Password changed to' . $data['u_password']
                ];
                $this->sendEmail($email, $subject, $message['message']);
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'status' => FALSE,
                    'message' => 'Verif code false'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    public function sendEmail_post($to, $subject, $message) {

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => '587',
            'smtp_user' => 'aldendelfian@gmail.com',
            'smtp_pass' => 'xxxxxxxxx',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $this->email->from('aldendelfian@gmail.com', 'alden');
        $this->email->to($to);

        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            $message = [
                'status' => TRUE,
                'message' => 'Email Sucseffully Send'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $message = [
                'status' => FALSE,
                'message' => 'Email Not Send'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function sendEmailAll_post($subject, $message) {

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => '587',
            'smtp_user' => 'aldendelfian@gmail.com',
            'smtp_pass' => 'xxxxxxxxx',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $this->email->from('aldendelfian@gmail.com', 'alden');
        $to = $this->input->get('input');
        $data = $this->User_model->check_email($to);
        if ($data) {
            $this->email->to($to);
            $message = [
                'status' => TRUE,
                'message' => 'Get All Email'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $message = [
                'status' => FALSE,
                'message' => 'Email Not Found'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        }

        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            $message = [
                'status' => TRUE,
                'message' => 'Email Sucseffully Send'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $message = [
                'status' => FALSE,
                'message' => 'Email Not Send'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

}
