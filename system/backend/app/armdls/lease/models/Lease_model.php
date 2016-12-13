<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lease_model extends CI_Model {

    public function read($id) {
        if ($id === NULL) {
            $replace = "";
        } else {
            $replace = "='" . $id . "'";
        }
        $query = $this->db->query("select * from lease where l_invoice" . $replace);
        return $query->result_array();
    }

    public function insert($data) {
        $this->db->insert('lease', $data);
        return TRUE;
    }

    public function update($data) {
        $id = $data['l_id'];
        $this->db->where('l_id', $id);
        $this->db->update('lease', $data);
    }

    public function delete($id) {
        $query = $this->db->query("delete from lease where l_id='" . $id . "'");
        $query = $this->db->affected_rows();
        if ($query >= 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_name($data) {
        if (!isset($data['l_name'])) {
            $replace = "";
        } else {
            $replace = "='" . $data['l_name'] . "'";
        }
        $query = $this->db->query("select * from lease where l_name" . $replace);
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
