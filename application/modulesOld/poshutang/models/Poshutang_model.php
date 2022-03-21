<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Poshutang_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    // Get poshutang from database
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('poshutang_id', $params['id']);
        }

        if(isset($params['poshutang_name']))
        {
            $this->db->like('poshutang_name', $params['poshutang_name']);
        }
        
        if(isset($params['account_id']))
        {
            $this->db->where('poshutang.poshutang_account_id', $params['account_id']);
        }
        
        if(isset($params['account_majors_id']))
        {
            $this->db->where('majors_id', $params['account_majors_id']);
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
            $this->db->order_by('poshutang_id', 'desc');
        }
        
        $this->db->where('majors_status', '1');

        $this->db->select('poshutang_id, poshutang_name, poshutang_description, a.account_id as account_id, a.account_code as account_code, a.account_description as account_description');
        
        $this->db->join('account as a', 'a.account_id = poshutang.poshutang_account_id', 'left');
        $this->db->join('majors', 'majors.majors_id = a.account_majors_id', 'left');
        
        $res = $this->db->get('poshutang');

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
        
         if(isset($data['poshutang_id'])) {
            $this->db->set('poshutang_id', $data['poshutang_id']);
        }
        
         if(isset($data['poshutang_name'])) {
            $this->db->set('poshutang_name', $data['poshutang_name']);
        }

        if(isset($data['poshutang_description'])) {
            $this->db->set('poshutang_description', $data['poshutang_description']);
        }
        
        if(isset($data['poshutang_account_id'])) {
            $this->db->set('poshutang_account_id', $data['poshutang_account_id']);
        }
        
        if (isset($data['poshutang_id'])) {
            $this->db->where('poshutang_id', $data['poshutang_id']);
            $this->db->update('poshutang');
            $id = $data['poshutang_id'];
        } else {
            $this->db->insert('poshutang');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    // Delete poshutang to database
    function delete($id) {
        $this->db->where('poshutang_id', $id);
        $this->db->delete('poshutang');
    }
    
}
