<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('home_models');
        $this->load->helper('cookie');


        $config = array('server' => REST_URL,
                //'api_key'         => 'Setec_Astronomy'
                //'api_name'        => 'X-API-KEY'
                //'http_user'       => 'username',
                //'http_pass'       => 'password',
                //'http_auth'       => 'basic',
                //'ssl_verify_peer' => TRUE,
                //'ssl_cainfo'      => '/certs/cert.pem'
        );

        // Run some setup
        $this->rest->initialize($config);
        if ($this->session->has_userdata('login')) {
            $data = $this->session->userdata('login');
            $role = $data['data']['role'];
            if (isset($role) && $role == "adm") {
                // redirect(base_url().'admin/landing');
            } else if (isset($role) && $role == "sadm") {
                redirect(base_url() . 'superadmin/landing');
            } else {
                // echo json_encode($data);
                redirect(base_url() . 'home/landing');
            }
        }
    }

    public function index() {
        if ($this->session->has_userdata('login')) {
            redirect(base_url() . 'admin/landing');
        }
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->load->view('login');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $params['input'] = $this->input->post('user');
            $result = $this->rest->post('user/login', $params);
            $data['user'] = json_decode(json_encode($result), true);
            //echo json_encode($data['user']);

            if ($data['user']['status'] == TRUE) {
                $this->session->set_userdata('login', $data['user']);
                redirect(base_url() . 'admin/landing');
            } else {
                redirect(base_url() . 'admin');
            }
        }
    }

    public function removeBooked() {
        $this->session->unset_userdata('booked');
        redirect(base_url() . 'admin/landing');
    }

    public function logout() {
        if (!$this->session->has_userdata('login')) {
            redirect(base_url() . 'admin');
        }
        $this->session->unset_userdata();
        $this->session->sess_destroy();
        redirect(base_url() . 'admin');
    }

    public function paymentlist() {
        if (!$this->session->has_userdata('login')) {
            redirect(base_url() . 'home');
        }
        $data = [];
        $data['invoice'] = $this->rest->get('transaction/invoice');
        $data['invoice'] = json_decode(json_encode($data['invoice']), true);
        // echo json_encode($data['invoice']);
        $this->load->view('header', $data);
        $this->load->view('paymentlist');
        $this->load->view('footer');
    }

    public function landing() {
        if (!$this->session->has_userdata('login')) {
            redirect(base_url() . 'admin');
        }
        $this->load->library('cart');
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $time = $this->input->get('time');
            $id = $this->input->get('id');
            $date = $this->input->get('date');
            $location = $this->input->get('location');
            $name = $this->input->get('name');
            $book = [];
            if ($this->session->has_userdata('booked')) {
                $book = $this->session->booked;
                $data['book'] = $book;
            }
            if (!empty($id) && !empty($time) && !empty($location) && !empty($name)) {


                $array = [
                    'id' => $id,
                    'date' => $date,
                    'time' => $time,
                    'name' => $name,
                    'location' => $location
                ];
                if (!in_array($array, $book)) {

                    array_push($book, $array);
                }
                $data['book'] = $book;
                $this->session->set_userdata('booked', $data['book']);
                // $this->session->sess_destroy();
            }
            if (empty($date)) {
                $this->rest->format('application/json');
                $result = $this->rest->get('transaction/available?');
                $data['schedule'] = json_decode(json_encode($result), true);
            } else {
                $date = date("Y-m-d", strtotime($date));
                $data['date'] = $date;

                if (!empty($date)) {
                    $this->rest->format('application/json');
                    $result = $this->rest->get('transaction/available?input[t_date]=' . $date);
                    $data['schedule'] = json_decode(json_encode($result), true);
                    $data['time'] = [
                        '1:00', '2:00', '3:00', '4:00', '5:00', '6:00', '7:00', '8:00', '9:00',
                        '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '17:00',
                        '18:00', '19:00', '20:00', '21:00', '22:00', '23:00', '24:00',
                    ];
                }
            }

            $this->load->view('header', $data);
            $this->load->view('schedule');
            $this->load->view('footer');
        }
    }

    public function viewSchedule() {
        $this->load->view('header');
        $this->load->view('schedule');
        $this->load->view('footer');
    }

    public function invoice($id = NULL) {
        if (!$this->session->has_userdata('login')) {
            redirect(base_url() . 'home');
        }
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $i_id = $this->input->get('id');
            $extend = $this->input->get('extend');
            $action = $this->input->get('action');
            $voucher = $this->input->get('v_id');
            if (!empty($action) && $action == "removeExtend") {
                $this->session->unset_userdata('invoice_' . $i_id . '');
            }


            if (!empty($i_id)) {
                $invoice = $this->rest->get('transaction/invoice?filter[i_id]=' . $i_id);
                $transactions = $this->rest->get('transaction/data?input[t_invoice]=' . $i_id);
                $lease = $this->rest->get('lease/data/' . $i_id);
                $data['transactions'] = json_decode(json_encode($transactions), true);
                $lease = json_decode(json_encode($lease), true);
                $data['invoice'] = json_decode(json_encode($invoice[0]), true);
                $data['temp_payment'] = $data['invoice']['i_total_payment'];
                if (isset($lease['status']) && !$lease['status']) {
                    
                } else {
                    $this->session->set_userdata('invoice_' . $i_id . '', $lease);
                }
                // echo json_encode($lease);

                if ($this->session->has_userdata('invoice_' . $i_id . '') && $data['invoice']['i_status'] != "booked") {
                    $data['extend'] = $this->session->userdata('invoice_' . $i_id . '');
                    // echo json_encode($data['extend']);
                    if (!empty($extend)) {
                        array_push($data['extend'], $extend);
                        $this->session->set_userdata('invoice_' . $i_id . '', $data['extend']);
                        // echo json_encode($data['extend']);
                        // redirect(base_url().'admin/invoice?id='.$i_id);
                    }
                    // echo json_encode($data['extend']);
                    foreach ($data['extend'] as $key) {
                        $data['temp_payment'] = $data['temp_payment'] + $key['l_price'];
                    }
                } else {
                    $this->session->set_userdata('invoice_' . $i_id . '', array());
                    $data['extend'] = $this->session->userdata('invoice_' . $i_id . '', array());
                }
                if (!empty($voucher)) {
                    $extend_voucher = [
                        'v_id' => $voucher,
                    ];
                    $result = $this->rest->put('voucher/use_voucher/' . $i_id, $extend_voucher);
                    $result = json_decode(json_encode($result), true);
                    // echo json_encode($result);
                    // if ($result['status']) {
                    // 	echo 'alert("'.$result['message'].'")';
                    // }
                    // else{
                    // 	echo 'alert("'.$result['error'].'")';
                    // }
                }

                // $data['lease'] = json_decode(json_encode($lease), true);
                // echo json_encode($this->session->userdata('invoice_'.$i_id));
                $this->load->view('header', $data);
                $this->load->view('invoice');
                $this->load->view('footer');
            } else {
                redirect(base_url() . 'admin/paymentlist');
            }
        }
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data_update = $this->input->post(NULL, TRUE);
            if (!empty($id)) {


                $invoice = $this->rest->get('transaction/invoice?filter[i_id]=' . $id);
                $transactions = $this->rest->get('transaction/data?input[t_invoice]=' . $id);
                // $lease = $this->rest->get('lease/data');

                $data['transactions'] = json_decode(json_encode($transactions), true);
                $data['invoice'] = json_decode(json_encode($invoice[0]), true);
                $data['temp_payment'] = $data['invoice']['i_total_payment'];


                $extend = $this->session->userdata('invoice_' . $id . '');

                if ($data['invoice']['i_status'] == "paid" && isset($extend)) {
                    foreach ($extend as $key) {
                        $key['l_invoice'] = $id;
                        $result = $this->rest->post('lease/data', array('input' => $key));
                        // echo json_encode($result);
                    }
                    $this->session->unset_userdata('invoice_' . $id);
                }
                $invoice = $this->rest->put('transaction/invoice/' . $id, $data_update, '');
                $data['invoice']['i_status'] = $data_update['i_status'];
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'ssl://smtp.gmail.com';
                $config['smtp_port'] = '465';
                $config['smtp_timeout'] = '7';
                $config['smtp_user'] = 'rysmawidjaja@gmail.com';
                $config['smtp_pass'] = 'rysmaadityawidjaja19602';
                $config['charset'] = 'utf-8';
                $config['newline'] = "\r\n";
                $config['mailtype'] = 'html';
                $config['validation'] = TRUE;
                $this->email->initialize($config);
                $this->email->from('rysmawidjaja@gmail.com', 'Rysma Aditya W');
                $this->email->to('rysmawidjaja@gmail.com');
                $this->email->message($this->load->view('invoice', $data, TRUE));
                $this->email->subject('Test');
                $this->email->send();


                redirect(base_url() . 'admin/invoice?id=' . $id);
            } else {
                redirect(base_url() . 'admin/paymentlist');
            }
        }
    }

    public function checkout() {
        if (!$this->session->has_userdata('login')) {
            redirect(base_url() . 'home');
        }
        $data['booked'] = $this->session->userdata('booked');
        $data['total_biaya'] = 0;
        for ($i = 0; $i < count($data['booked']); $i++) {
            $time = gmdate("H:i:s", strtotime($data['booked'][$i]['time']));
            $price = $this->rest->get('transaction/price?date=' . $time . '');
            $price = json_decode(json_encode($price), true);
            // echo json_encode($price);
            $data['booked'][$i]['price'] = $price['p_price'];
            $data['total_biaya'] = $data['total_biaya'] + $price['p_price'];
        }
        // echo json_encode($data);

        $this->load->view('header', $data);
        $this->load->view('checkout');
        $this->load->view('footer');
    }

    public function confirm_payment() {
        if (!$this->session->has_userdata('login')) {
            redirect(base_url() . 'home');
        }
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $invoice = $this->input->post('invoice');
            $sess_booked = $this->session->userdata('booked');
            $booked = [];
            $invoice['i_total_payment'] = 0;
            for ($i = 0; $i < count($sess_booked); $i++) {
                $time = gmdate("H:i:s", strtotime($sess_booked[$i]['time']));
                $price = $this->rest->get('transaction/price?date=' . $time . '');
                $price = json_decode(json_encode($price), true);

                $invoice['i_total_payment'] = $invoice['i_total_payment'] + $price['p_price'];
                // array_push($key,['price'=> $price['p_price']]);
                $booked[$i]['t_field'] = $sess_booked[$i]['id'];
                $booked[$i]['t_date'] = $sess_booked[$i]['date'];
                $booked[$i]['t_start_booking'] = $sess_booked[$i]['time'];
                $booked[$i]['t_end_booking'] = gmdate("H:i", ($sess_booked[$i]['time'] + 1) * 3600);
                /*
                  echo json_encode($time);
                  echo json_encode($price);
                  echo json_encode($sess_booked[$i]['time']);
                 */
            }

            $params = [
                'invoice' => $invoice,
                'transaction' => $booked
            ];
            $result = $this->rest->post('transaction/payment', $params, '');
            $this->session->sess_destroy('booked');
            redirect(base_url() . 'admin/landing');

            // echo json_encode($result);
        }
    }

    function __encrip_password($password) {
        return md5($password);
    }

}