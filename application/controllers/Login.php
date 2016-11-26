<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_login'); 
    }
    function index()
    {
        $session = $this->session->userdata('isLogin'); 
        if($session == FALSE) 
        {
            $this->load->view('login-form');
        }else 
        {
            redirect('dashboard');
        }
    }    
    function autentifikasi()
    {
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        
        $cek = $this->mod_login->cek_user($username,md5($password)); //pelajari metode enkripsi selain md5
        if(count($cek) == 1){
            foreach ($cek as $cek) {
                $level = $cek['level'];
            }
            $this->session->set_userdata(array(
                'isLogin'   => TRUE,
                'username'  => $username,
                'level'      => $level,
            ));
                
            redirect('dashboard','refresh');
        }else{
            echo "<script>alert('Username atau Password salah!')</script>";
            redirect('login','refresh');
        }
        
    }
}
