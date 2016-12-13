<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {

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
            // echo json_encode($data);
            if (isset($role) && $role == "adm") {
                redirect(base_url() . 'admin/landing');
            } else if (isset($role) && $role == "sadm") {
                //redirect(base_url().'superadmin/landing');
            } else {
                redirect(base_url() . 'home/landing');
            }
        }
    }

    public function index() {

        if ($this->session->has_userdata('login')) {
            redirect(base_url() . 'superadmin/landing');
        }
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->load->view('login');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $params['input'] = $this->input->post('user');
            $result = $this->rest->post('user/login', $params);
            $data['user'] = json_decode(json_encode($result), true);

            // echo json_encode($data['user']);
            if ($data['user']['status']) {
                $this->session->set_userdata('login', $data['user']);
                redirect(base_url() . 'superadmin/landing');
            } else {
                redirect(base_url() . 'superadmin');
            }
        }
    }

    public function showUser() {
        
    }

    public function addUser() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $params['input'] = $this->input->post('input');
            $result = $this->rest->post('user/data', $params);
            echo json_encode($result);
            redirect(base_url() . 'superadmin/landing');
        }
    }

    public function addVoucher() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $params['input'] = $this->input->post('input');
            $result = $this->rest->post('voucher/data', $params);
            echo json_encode($result);
            redirect(base_url() . 'superadmin/landing');
        }
    }

    public function logout() {
        $this->session->unset_userdata('login');
        $this->session->sess_destroy();
        redirect(base_url() . 'superadmin');
    }

    public function managerial() {
        $user = $this->rest->get('voucher/data');
        $data['voucher'] = json_decode(json_encode($user), TRUE);
        $user = $this->rest->get('user/data');
        $data['user'] = json_decode(json_encode($user), TRUE);
        // echo json_encode($user);

        $this->load->view('header');
        $this->load->view('manage', $data);
        $this->load->view('footer');
    }

    public function landing() {
        if (!$this->session->has_userdata('login')) {
            redirect(base_url() . 'superadmin');
        }
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->load->view('header');
            $this->load->view('landing');
            $this->load->view('footer');
        }
    }

    function __encrip_password($password) {
        return md5($password);
    }

}
