<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Customer extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_model');
    }

    public function data_get($id_param = NULL) {
        $id = $this->input->get('email');
        if ($id === NULL) {
            $id = $id_param;
        }
        if ($id === NULL) {
            $data = $this->Customer_model->read($id);
            if ($data) {
                $this->response($data, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'error' => 'No customer were found'
                        ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
        $data = $this->Customer_model->read($id);
        if ($data) {
            $this->set_response($data, REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => FALSE,
                'error' => 'Record could not be found'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function data_post() {
        $input = $this->input->post('input');
        $create = $this->Customer_model->check_username($input['email']);

        if ($create) {
            $data = array(
                'c_email' => $input['email'],
                'c_name' => $input['name'],
                'c_password' => md5($input['password']),
                'c_tlp' => $input['telp']
            );

            $this->Customer_model->insert($data);

            $message = [
                'status' => TRUE,
                'message' => $data['c_email'] . ' created'
            ];
            $this->set_response($message, REST_Controller::HTTP_CREATED);
        } else {
            $message = [
                'status' => FALSE,
                'message' => $data['c_email'] . ' already exist'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function data_put() {
        $input = $this->input->input_stream('input');
        $this->Customer_model->update($input);
        $message = [
            'status' => TRUE,
            'message' => $data['c_name'] . ' updated'
        ];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function data_delete() {
        $id = $this->input->get('input');
        $id = $id['c_email'];

        if ($id == NULL) {
            $this->set_response([
                'status' => FALSE,
                'error' => 'Email cannot be empty'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
        $data = $this->Customer_model->delete($id);
        if ($data) {
            $this->set_response([
                'status' => TRUE,
                'error' => 'Data deleted'
                    ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->set_response([
                'status' => FALSE,
                'error' => 'Record could not be found'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function login_post() {
        $input = $this->input->post('input');

        $data = array(
            'c_email' => $input['c_email'],
            'c_password' => md5($input['c_password'])
        );

        // check if either $username or $password is null
        if ($input['c_email'] === NULL || $input['c_password'] === NULL) {

            $this->set_response([
                'status' => FALSE,
                'error' => 'username or password cannot be empty'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
        // call check_password from user_model
        $data = $this->Customer_model->check_password($input);
        // if return true
        if ($data) {
            // set message as true
            $message = [
                'status' => TRUE,
                'message' => 'Login success'
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

}
