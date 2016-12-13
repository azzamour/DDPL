<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_model extends CI_Model {

    public function read($id) {
        if ($id === NULL) {
            $replace = "";
        } else {
            $replace = "='" . $id . "'";
        }
        $query = $this->db->query("select * from voucher where v_id" . $replace);
        return $query->result_array();
    }

    public function insert($data) {
        // $this->db->set('v_id', ''.uniqid().'', FALSE);
        $this->db->insert('voucher', $data);
        return TRUE;
    }

    public function update($data) {
        $id = $data['l_id'];
        $this->db->where('l_id', $id);
        $this->db->update('voucher', $data);
    }

    public function delete($id) {
        $query = $this->db->query("delete from voucher where v_id='" . $id . "'");
        $query = $this->db->affected_rows();
        if ($query >= 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_voucher($i_id, $amount, $v_id) {
        $this->db->where('i_id', $i_id);
        $this->db->set('i_total_payment', 'i_total_payment - ' . $amount . '', FALSE);
        $result = $this->db->update('invoice');
        if ($this->db->affected_rows() > 0) {
            $this->db->where('v_id', $v_id);
            $this->db->set('v_status', '1');
            $result = $this->db->update('voucher');

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
