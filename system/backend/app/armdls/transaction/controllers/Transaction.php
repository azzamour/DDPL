<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transaction_model');
    }

    public function data_get() {
        $data = $this->input->get('input');
        if (!empty($data)) {

            $data = $this->Transaction_model->read($data);

            if ($data) {
                $this->response($data, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'error' => 'No Transaction were found'
                        ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'error' => 'No data'
                    ], REST_Controller::HTTP_OK);
        }
    }

    public function data_put() {
        $input = $this->input->input_stream('input');
        $this->Transaction_model->update($input);
        $message = [
            'status' => TRUE,
            'message' => $data['t_id'] . ' updated'
        ];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function data_delete() {
        // retrieve data from segment 3 (/)
        $id = $this->input->get('input');
        $id = $id['t_id'];
        // if $id is null
        if ($id === NULL) {
            // set failed response header
            $this->set_response([
                'status' => FALSE,
                'error' => 'Id transaction cannot be empty'
                    ], REST_Controller::HTTP_OK);
        }
        // call delete from user_model
        $data = $this->Transaction_model->delete($id);
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

    public function price_get() {
        $date = $this->input->get('date');
        $price = $this->Transaction_model->get_price($date);
        $this->set_response($price, REST_Controller::HTTP_OK);
    }

    public function invoice_get() {
        $filter = $this->input->get('filter');
        $data = $this->Transaction_model->read_invoice($filter);
        $this->set_response($data, REST_Controller::HTTP_OK);
    }

    public function invoice_put($id = NULL) {
        $data = $this->input->input_stream();
        $data['i_id'] = $id;

        $this->set_response($data, REST_Controller::HTTP_OK);
        $result = $this->Transaction_model->update_invoice($data);
        if ($result) {
            $this->set_response([
                'status' => TRUE,
                'message' => 'Updated'
                    ], REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => FALSE,
                'error' => 'Error'
                    ], REST_Controller::HTTP_OK);
        }
    }

    public function available_get() {
        $data = $this->input->get('input');

        $transactions = $this->Transaction_model->read($data);
        $fields = $this->Transaction_model->read_field(NULL);
        if (empty($data['t_date'])) {
            $this->set_response(['status' => FALSE,
                'error' => 'Please specified your date'
                    ], REST_Controller::HTTP_OK);
        } else {

            for ($i = 0; $i < count($fields); $i++) {
                $fields[$i]['available_time'] = [];
                $starttime = "00:00:00";
                $endtime = "00:00:00";
                for ($j = 0; $j < count($transactions); $j++) {
                    if ($fields[$i]['f_name'] == $transactions[$j]['f_name'] && $fields[$i]['f_location'] == $transactions[$j]['f_location']) {
                        $endtime = $transactions[$j]['t_start_booking'];
                        $time['start_time'] = $starttime;
                        $time['end_time'] = $endtime;
                        $starttime = $transactions[$j]['t_end_booking'];
                        $dif = $time['end_time'] - $time['start_time'];
                        for ($u = 0; $u < $dif; $u++) {
                            $timespec['start_time'] = gmdate("H:i", ($time['start_time'] + $u) * 3600);
                            $timespec['status'] = 'Available';
                            array_push($fields[$i]['available_time'], $timespec);
                        }
                    }
                }
                $endtime = "24:00:00";
                $time['start_time'] = $starttime;
                $time['end_time'] = $endtime;
                if ($time['end_time'] != $time['start_time']) {
                    $dif = $time['end_time'] - $time['start_time'];
                    for ($u = 0; $u < $dif; $u++) {
                        $timespec['start_time'] = gmdate("H:i", ($time['start_time'] + $u) * 3600);
                        $timespec['status'] = 'Available';
                        array_push($fields[$i]['available_time'], $timespec);
                    }
                }
            }
            $this->set_response($fields, REST_Controller::HTTP_CREATED);
        }
    }

    public function history_post() {
        $data = $this->input->post('input');
        $message = [];

        $create = $this->Transaction_model->check_date_history($input);

        if ($create) {
            $message = [
                'status' => TRUE,
                'message' => 'History Created'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $message = [
                'status' => FALSE,
                'message' => 'Record could not be found'
            ];
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function payment_post() {
        $transactions = $this->input->post('transaction');
        $invoice = $this->input->post('invoice');
        $message = [];
        $create = FALSE;
        if (isset($transactions)) {

            // $this->set_response($transactions,REST_Controller::HTTP_CREATED);
            $create = $this->Transaction_model->check_data_payment($transactions);
        }
        if ($create) {
            // 		$message = [
            // 			'status' => TRUE,
            // 			'message' => 'Booking available'
            // 		];
            // 		$this->set_response($message, REST_Controller::HTTP_OK);

            $create = $this->Transaction_model->check_payment($transactions, $invoice);

            if ($create) {

                $message = [
                    'status' => TRUE,
                    'message' => 'Payment created'
                ];
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            } else {
                $message = [
                    'status' => FALSE,
                    'message' => 'Order not available'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        } else {
            $message = [
                'status' => FALSE,
                'message' => 'Booking not available'
            ];
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

}
