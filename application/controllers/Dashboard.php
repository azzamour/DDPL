<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller{
 function __construct(){
 parent::__construct();
 $this->load->model('mod_login');
 $this->auth->cek_auth();
 
 }
 function index()
 {
 $ambil_akun = $this->mod_login->ambil_user($this->session->userdata('username'));
 $data = array(
 'user' => $ambil_akun,
 );
 $stat = $this->session->userdata('level');
 if($stat==1){
 $this->load->view('dashboard_admin',$data);
 }else{ 
 $this->load->view('dashboard_user',$data);
 }
 
 }
 function login()
 {
 $session = $this->session->userdata('isLogin');
     if($session == FALSE)
     {
       $this->load->view('login_form');
     }else
     {
       redirect('dashboard');
     }
 }
 function logout()
 {
 $this->session->sess_destroy();
 redirect('login','refresh');
 }
}
