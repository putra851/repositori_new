<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Letter_hutang_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('letter_hutang.letter_hutang_id', $params['id']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('letter_hutang_id', 'desc');
        }
        $this->db->select('letter_hutang.letter_hutang_id, letter_hutang_number, letter_hutang_month, letter_hutang_year');       
        $res = $this->db->get('letter');

        if (isset($params['id']) OR (isset($params['limit']) AND $params['limit']==1))
        {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }
    
    // Insert some data to table
    function add($data = array()) {

        if (isset($data['letter_hutang_id'])) {
            $this->db->set('letter_hutang_id', $data['letter_hutang_id']);
        }

        if (isset($data['letter_hutang_number'])) {
            $this->db->set('letter_hutang_number', $data['letter_hutang_number']);
        }

        if (isset($data['letter_hutang_month'])) {
            $this->db->set('letter_hutang_month', $data['letter_hutang_month']);
        }

        if (isset($data['letter_hutang_year'])) {
            $this->db->set('letter_hutang_year', $data['letter_hutang_year']);
        }

        if (isset($data['letter_hutang_id'])) {
            $this->db->where('letter_hutang_id', $data['letter_hutang_id']);
            $this->db->update('letter');
            $id = $data['letter_hutang_id'];
        } else {
            $this->db->insert('letter');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

}
