<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

class Lease extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Lease_model');
    }

    public function data_get($id_param = NULL) {
        $id = $this->input->get('id');
        if ($id === NULL) {
            $id = $id_param;
        }
        if ($id === NULL) {
            $data = $this->Lease_model->read($id);
            if ($data) {
                $this->response($data, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'error' => 'No item were found'
                        ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
        $data = $this->Lease_model->read($id);
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
        $create = $this->Lease_model->check_name($input);
        //  	if ($create) {
        //  		$data = array(
        //  			'l_name' => $input['l_name'],
        //  	// 		'l_qty' => $input['qty'],
        //  			'l_price' => $input['l_price']
        //  		);
        //
 //  	}
        $result = $this->Lease_model->insert($input);
        if ($result) {
            $message = [
                'status' => TRUE,
                'message' => $data['l_name'] . ' created'
            ];
        } else {
            $message = [
                'status' => FALSE,
                'message' => 'fail created'
            ];
        }

        $this->set_response($message, REST_Controller::HTTP_CREATED);
        //  	else
        //  	{
        //  		$message = [
        //  			'status' => FALSE,
        //  			'message' => $input['l_name'].' already exist'
        //  		];
        //  		$this->set_response($message, REST_Controller::HTTP_OK);
        //  	}
    }

    public function data_put() {
        $input = $this->input->input_stream('input');
        $this->Lease_model->update($input);
        $message = [
            'status' => TRUE,
            'message' => $input['l_id'] . ' updated'
        ];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function data_delete() {
        $id = $this->input->get('input');
        $id = $id['l_id'];
        if ($id === NULL) {
            $this->set_response([
                'status' => FALSE,
                'error' => 'Id cannot be empty'
                    ], REST_Controller::HTTP_OK);
        }
        $data = $this->Lease_model->delete($id);
        if ($data) {
            $this->set_response([
                'status' => TRUE,
                'message' => 'Data Deleted'
                    ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->set_response([
                'status' => FALSE,
                'error' => 'Record could not be found'
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

}
