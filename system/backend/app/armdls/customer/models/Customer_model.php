<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

    public function read($id) {
        if ($id === NULL) {
            $replace = "";
        } else {
            $replace = '=$id';
        }
        $query = $this->db->query("select * from customer where c_email " . $replace);
        return $query->result_array();
    }

    public function insert($data) {
        $this->db->insert('customer', $data);
        return TRUE;
    }

    public function update($data) {
        $id = $data['c_email'];
        $this->db->where('c_email', $id);
        $this->db->update('customer', $data);
    }

    public function delete($id) {
        $query = $this->db->query("delete from customer where c_email='" . $id . "'");
        $query = $this->db->affected_rows();
        if ($query >= 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_username($username) {
        if ($username === NULL) {
            $replace = "";
        } else {
            $replace = "='" . $username . "'";
        }

        $query = $this->db->query("select * from customer where c_email " . $replace);

        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_password($data) {
        if ($data === NULL) {
            $username = "";
        } else {
            $username = "='" . $data['c_email'] . "'";
        }
        if ($data === NULL) {
            $password = "";
        } else {
            $password = "='" . md5($data['c_password']) . "'";
        }
        // query get data from table users
        $query = $this->db->query("select * from customer where c_email" . $username . " AND c_password " . $password);
        // check if query result is not 1 row
        if ($query->num_rows() != 1) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
