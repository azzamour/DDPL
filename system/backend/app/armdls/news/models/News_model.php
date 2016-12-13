<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model {

    public function read($id) {
        if ($id === NULL) {
            $replace = "";
        } else {
            $replace = "=$id";
        }
        $query = $this->db->query("select * from news where n_id" . $replace);
        return $query->result_array();
    }

    public function insert($data) {
        $this->db->insert('news', $data);
        return TRUE;
    }

    public function update($data) {
        $id = $data['id'];
        $this->db->where('n_id', $id);
        $this->db->update('news', $data);
    }

    public function delete($id) {
        $query = $this->db->query("delete from news where n_id='" . $id . "'");
        $query = $this->db->affected_rows();
        if ($query >= 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    