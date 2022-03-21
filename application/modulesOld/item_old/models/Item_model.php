<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Item_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('item_id', $params['id']);
        }

        if(isset($params['item_name']))
        {
            $this->db->where('item_name', $params['item_name']);
        }

        if(isset($params['majors_id']))
        {
            $this->db->where('item.item_majors_id', $params['majors_id']);
        }

        if(isset($param['majors_id']))
        {
            $this->db->where('item.item_majors_id', $params['majors_id']);
        }
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
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
            $this->db->order_by('item.item_majors_id', 'asc');
            $this->db->order_by('item.item_name', 'asc');
        }
        
        $this->db->where('majors_status', '1');
        
        $this->db->select('item_id, item_name, item_majors_id, majors_short_name');
        $this->db->join('majors', 'majors.majors_id=item.item_majors_id', 'left');
        $res = $this->db->get('item');

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

        if (isset($data['item_id'])) {
            $this->db->set('item_id', $data['item_id']);
        }

        if (isset($data['item_name'])) {
            $this->db->set('item_name', $data['item_name']);
        }

        if (isset($data['item_majors_id'])) {
            $this->db->set('item_majors_id', $data['item_majors_id']);
        }

        if (isset($data['item_id'])) {
            $this->db->where('item_id', $data['item_id']);
            $this->db->update('item');
            $id = $data['item_id'];
        } else {
            $this->db->insert('item');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id) {
        $this->db->where('item_id', $id);
        $this->db->delete('item');   
    }

}
