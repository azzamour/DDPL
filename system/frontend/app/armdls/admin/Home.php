<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('home_models');
    }

    public function index() {

        $this->load->view('login');
    }

    function __encrip_password($password) {
        return md5($password);
    }

}
