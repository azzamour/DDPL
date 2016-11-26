<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mod_login extends CI_Model{
 function __construct()
 {
 parent::__construct();
 $this->tbl = "tb_users"; // untuk membuat variabel tbl yang mewakili nama tabel yang digunakan dibawah sesuai dengan database
 }
 
 function cek_user($username="",$password="")
 {
 $query = $this->db->get_where($this->tbl,array('username' => $username, 'password' => $password));
 $query = $query->result_array();
 return $query;
 }
 function ambil_user($username)
        {
        $query = $this->db->get_where($this->tbl, array('username' => $username));
        $query = $query->result_array();
        if($query){
            return $query[0];
        }
    }
}
