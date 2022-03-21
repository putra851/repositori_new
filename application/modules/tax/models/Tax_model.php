<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tax_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('tax_id', $params['id']);
        }

        if(isset($params['tax_name']))
        {
            $this->db->where('tax_name', $params['tax_name']);
        }

        if(isset($params['tax_number']))
        {
            $this->db->where('tax_number', $params['tax_number']);
        }


        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }
        if(isset($params['order_by']))
        {
            $this->db->order_by($params['order_by'], 'desc');
        }
        else
        {
            $this->db->order_by('tax_number', 'asc');
        }
        
        $this->db->select('tax_id, tax_name, tax_number');
        $res = $this->db->get('tax');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }

    function add($data = array()) {

        if (isset($data['tax_id'])) {
            $this->db->set('tax_id', $data['tax_id']);
        }

        if (isset($data['tax_name'])) {
            $this->db->set('tax_name', $data['tax_name']);
        }

        if (isset($data['tax_number'])) {
            $this->db->set('tax_number', $data['tax_number']);
        }

        if (isset($data['tax_id'])) {
            $this->db->where('tax_id', $data['tax_id']);
            $this->db->update('tax');
            $id = $data['tax_id'];
        } else {
            $this->db->insert('tax');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id) {
        $this->db->where('tax_id', $id);
        $this->db->delete('tax');
    }

}
