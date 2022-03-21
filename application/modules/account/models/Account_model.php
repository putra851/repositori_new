<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Account_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    // Get account from database
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('account_id', $params['id']);
        }

        if(isset($params['account_code']))
        {
            $this->db->like('account_code', $params['account_code']);
        }
        
        if(isset($params['account_category']))
        {
            $this->db->where('account_category', $params['account_category']);
        }
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('account_majors_id', $params['account_majors_id']);
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
            $this->db->order_by('account_id', 'desc');
        }

        $this->db->where('majors_status', '1');

        $this->db->select('account_id, account_code, account_description, account_note, account_category, account_majors_id, majors_id, majors_short_name');
        $this->db->join('majors', 'majors.majors_id = account.account_majors_id', 'left');
        $res = $this->db->get('account');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }
    
    // Add and update to database
    function add($data = array()) {
        
         if(isset($data['account_id'])) {
            $this->db->set('account_id', $data['account_id']);
        }
        
         if(isset($data['account_code'])) {
            $this->db->set('account_code', $data['account_code']);
        }

        if(isset($data['account_description'])) {
            $this->db->set('account_description', $data['account_description']);
        }

        if(isset($data['account_note'])) {
            $this->db->set('account_note', $data['account_note']);
        }

        if(isset($data['account_category'])) {
            $this->db->set('account_category', $data['account_category']);
        }

        if(isset($data['account_majors_id'])) {
            $this->db->set('account_majors_id', $data['account_majors_id']);
        }
        
        if (isset($data['account_id'])) {
            $this->db->where('account_id', $data['account_id']);
            $this->db->update('account');
            $id = $data['account_id'];
        } else {
            $this->db->insert('account');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    // Delete account to database
    function delete($id) {
        $this->db->where('account_id', $id);
        $this->db->delete('account');
    }
    
}
