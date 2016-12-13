<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model {

    public function read($data) {
        if (!isset($data['t_id'])) {
            $id = "";
        } else {
            $id = "='" . $data['t_id'] . "'";
        }
        if (!isset($data['t_invoice'])) {
            $invoice = "";
        } else {
            $invoice = "='" . $data['t_invoice'] . "'";
        }

        if (!isset($data['t_date'])) {
            $date = "";
            // return false;
        } else {
            $date = "='" . $data['t_date'] . "'";
        }

        $query = $this->db->query("
                              select * from transaction
                               inner join price
                              on price.p_price = (transaction.t_price/transaction.t_time_length)
                               inner join field
                              on field.f_id = transaction.t_field
                              where t_id" . $id .
                " AND t_date" . $date .
                " AND t_invoice" . $invoice . "
                              GROUP BY transaction.t_id
                              ORDER BY price.p_start_booking ASC");
        return $query->result_array();
    }

    public function read_field($id) {
        if ($id === NULL) {
            $replace = "";
        } else {
            $replace = "=$id";
        }
        $query = $this->db->query("select * from field where f_id" . $replace);
        return $query->result_array();
    }

    public function read_invoice($data) {
        if ($data['i_id'] === NULL) {
            $replace = "";
        } else {
            $replace = "=" . $data['i_id'];
        }
        $query = $this->db->query("select * from invoice where i_id" . $replace);
        return $query->result_array();
    }

    public function update_invoice($data) {
        $this->db->where('i_id', $data['i_id']);
        return $this->db->update('invoice', $data);
    }

    public function insert($data) {
        $this->db->insert('transaction', $data);
        return TRUE;
    }

    public function update($data) {
        $id = $data['t_id'];
        $this->db->where('t_id', $id);
        $this->db->update('transaction', $data);
    }

    public function delete($id) {
        $query = $this->db->query("delete from transaction where t_id='" . $id . "'");
        $query = $this->db->affected_rows();
        if ($query >= 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_time($data) {
        if ($data === NULL) {
            $replace = "";
        } else {
            $replace = "='" . $data . "'";
        }
        $query = $this->db->query("select * from transaction where month(t_date)" . $replace);
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_field($data) {
        if ($data === NULL) {
            $replace = "";
        } else {
            $replace = "='" . $data . "'";
        }
        $query = $this->db->query("select transaction.t_field, field.f_name from transaction inner join field
                               on transaction.t_field=field.f_name where t_field" . $replace);
        if ($query->num_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_data_payment($datas) {
        $check = FALSE;
        foreach ($datas as $data) {
            $query = $this->db->query("select * from transaction where t_start_booking ='" . $data['t_start_booking'] . "' AND t_date ='" . $data['t_date'] . "'");
            if ($query->num_rows() == 0) {
                $check = TRUE;
            } else {
                $check = FALSE;
            }
        }
        return $check;
    }

    public function check_payment($datas, $invoice) {
        $invoice['i_status'] = 'booked';
        $invoice['i_date'] = date("Y-m-d");
        $this->db->insert('invoice', $invoice);
        $i_id = $this->db->insert_id();
        $check = FALSE;
        foreach ($datas as $data) {
            $query = $this->db->query("select * from price where p_start_booking <= '" . $data['t_start_booking'] . "' ORDER BY p_start_booking DESC LIMIT 1");
            $query = $query->result_array();
            // $data['t_end_booking'] = gmdate("H:i:s", ($data['t_start_booking']+1)*3600);
            $data['t_time_length'] = $data['t_end_booking'] - $data['t_start_booking'];
            $data['t_price'] = $query[0]['p_price'] * intval($data['t_time_length']);

            $data['t_invoice'] = $i_id;
            $data['t_status'] = "Belum bayar";
            $check = $this->insert($data);
            // if (intval($data['t_current_payment'] <= $data['t_price']) && intval($data['t_current_payment'] >= 1/2* $query[0]['p_price']) ) {
            if ($check) {
                
            } else {
                $check = FALSE;
            }
        }
        return $check;
    }

    public function check_available_schedule($data) {
        $query = $this->db->query("select transaction.t_field, field.f_name from transaction inner join field
                               on transaction.t_field=field.f_name where t_field=" . $data['f_location']);
    }

    public function get_price($date) {
        //$time = gmdate("H:i:s", strtotime($date));
        $query = $this->db->query("select * from price where p_start_booking <= '" . $date . "' ORDER BY p_start_booking DESC LIMIT 1");
        $query = $query->result_array();
        return $query[0];
    }

}
