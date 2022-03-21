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
    
    function get_debit($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('pos_debit_id', $params['id']);
        }

        if(isset($params['item_id']))
        {
            $this->db->where('item_id', $params['item_id']);
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
            $this->db->order_by('account.account_code', 'asc');
            $this->db->order_by('pos_debit.pos_debit_id', 'asc');
        }
        
        $this->db->select('pos_debit_id, item_id, item_name, item_majors_id, account_code, account_description, majors_short_name');
        
        $this->db->join('item', 'item.item_id=pos_debit.pos_debit_item_id', 'left');
        $this->db->join('majors', 'majors.majors_id=item.item_majors_id', 'left');
        $this->db->join('account', 'account.account_id=pos_debit.pos_debit_account_id', 'left');
        
        $res = $this->db->get('pos_debit');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }
    
    function get_kredit($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('pos_kredit_id', $params['id']);
        }

        if(isset($params['item_id']))
        {
            $this->db->where('item_id', $params['item_id']);
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
            $this->db->order_by('account.account_code', 'asc');
            $this->db->order_by('pos_kredit.pos_kredit_id', 'asc');
        }
        
        $this->db->select('pos_kredit_id, item_id, item_name, item_majors_id, account_code, account_description, majors_short_name');
        
        $this->db->join('item', 'item.item_id=pos_kredit.pos_kredit_item_id', 'left');
        $this->db->join('majors', 'majors.majors_id=item.item_majors_id', 'left');
        $this->db->join('account', 'account.account_id=pos_kredit.pos_kredit_account_id', 'left');
        
        $res = $this->db->get('pos_kredit');

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

    function add_debit($data = array()) {

        if (isset($data['pos_debit_item_id'])) {
            $this->db->set('pos_debit_item_id', $data['pos_debit_item_id']);
        }

        if (isset($data['pos_debit_account_id'])) {
            $this->db->set('pos_debit_account_id', $data['pos_debit_account_id']);
        }

        if (isset($data['pos_debit_id'])) {
            $this->db->where('pos_debit_id', $data['pos_debit_id']);
            $this->db->update('pos_debit');
            $id = $data['pos_debit_id'];
        } else {
            $this->db->insert('pos_debit');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function add_kredit($data = array()) {

        if (isset($data['pos_kredit_item_id'])) {
            $this->db->set('pos_kredit_item_id', $data['pos_kredit_item_id']);
        }

        if (isset($data['pos_kredit_account_id'])) {
            $this->db->set('pos_kredit_account_id', $data['pos_kredit_account_id']);
        }

        if (isset($data['pos_kredit_id'])) {
            $this->db->where('pos_kredit_id', $data['pos_kredit_id']);
            $this->db->update('pos_kredit');
            $id = $data['pos_kredit_id'];
        } else {
            $this->db->insert('pos_kredit');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id) {
        $this->db->where('item_id', $id);
        $this->db->delete('item');   
    }

    function delete_debit($id) {
        $this->db->where('pos_debit_id', $id);
        $this->db->delete('pos_debit');   
    }

    function delete_kredit($id) {
        $this->db->where('pos_kredit_id', $id);
        $this->db->delete('pos_kredit');   
    }

}
