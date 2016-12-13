<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

class News extends REST_Controller{
public function __construct() {
parent::__construct();
$this->load->model('News_model');
}

public function data_get($id_param = NULL) {
$id = $this->input->get('email');
if ($id === NULL)
{
$id = $id_param;
}
if ($id===NULL)
{
$data = $this->News_model->read($id);
if ($data)
{
$this->response($data, REST_Controller::HTTP_OK);
}
else
{
$this->response([
'status' => FALSE,
 'error' => 'No news were found'
], REST_Controller::HTTP_NOT_FOUND);
}
}
$data = $this->News_model->read($id);
if ($data)
{
$this->set_response($data, REST_Controller::HTTP_OK);
}
else
{
$this->set_response([
'status' => FALSE,
 'error' => 'Record could not be found'
], REST_Controller::HTTP_NOT_FOUND);
}
}

public function data_post() {
$input = $this->input->post('input');

if ($create) {
$data = array(
'n_title' => $input['title'],
 'n_description' => $input['description'],
 'n_img' => $input['img']
);

$this->News_model->insert($data);

$message = [
'status' => TRUE,
 'message' => $data['n_title'].' created'
];
$this->set_response($message, REST_Controller::HTTP_CREATED);
}
else
{
$message = [
'status' => FALSE,
 'message' => $data['n_title'].' already exist'
];
$this->set_response($message, REST_Controller::HTTP_OK);
}

public function data_put(){
$data = $this->input->input_stream();
$this->User_model->update($data);
$message = [
'status' => TRUE,
 'message' => $data['n_id'].' updated'
];
$this->set_response($message, REST_Controller::HTTP_CREATED);
}

public function data_delete() {
$id = $this->input->get('input');
$id = $id['n_id'];

if ($id == NULL){
$this->set_response([
'status' => FALSE,
 'error' => 'ID cannot be empty'
], REST_Controller::HTTP_NOT_FOUND);
}
$data = $this->News_model->delete($id);
if ($data) {
$this->set_response($data, REST_Controller::HTTP_OK);
}
else
{
$this->set_response([
'status' => FALSE,
 'error' => 'Record could not be found'
], REST_Controller::HTTP_NOT_FOUND);
}
}
}
}
