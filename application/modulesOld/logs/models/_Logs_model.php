<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logs_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('logs.log_id', $params['id']);
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
            $this->db->order_by('log_id', 'desc');
        }
        $this->db->select('logs.log_id, log_date, log_action, log_module, log_info, logs.user_id');
        $this->db->select('user_full_name');

        $this->db->join('users', 'users.user_id = logs.user_id', 'left');
        $res = $this->db->get('logs');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['log_id'])) {
            $this->db->set('log_id', $data['log_id']);
        }

        if (isset($data['log_date'])) {
            $this->db->set('log_date', $data['log_date']);
        }

        if (isset($data['log_action'])) {
            $this->db->set('log_action', $data['log_action']);
        }

        if (isset($data['log_module'])) {
            $this->db->set('log_module', $data['log_module']);
        }

        if (isset($data['log_info'])) {
            $this->db->set('log_info', $data['log_info']);
        }

        if (isset($data['user_id'])) {
            $this->db->set('user_id', $data['user_id']);
        }

        if (isset($data['log_id'])) {
            $this->db->where('log_id', $data['log_id']);
            $this->db->update('logs');
            $id = $data['log_id'];
        } else {
            $this->db->insert('logs');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    // Get From table ltrx
    function get_trx($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('ltrx.ltrx_id', $params['id']);
        }
        
        
        if (isset($params['mulai_tanggal']) && isset($params['sampai_tanggal']))
        {
            $this->db->where('date(ltrx.ltrx_date) <=', $params['mulai_tanggal']);
            $this->db->where('date(ltrx.ltrx_date) >=', $params['sampai_tanggal']);
        } else {
            $this->db->where('date(ltrx.ltrx_date)', date('Y-m-d'));
        }
        
        
        if (isset($params['module'])) {
            $this->db->where('ltrx.ltrx_module', $params['module']);
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
            $this->db->order_by('ltrx_id', 'desc');
        }
        
        $this->db->select('ltrx.ltrx_id, ltrx_date, ltrx_action, ltrx_module, ltrx_info, ltrx_browser, ltrx_version, ltrx_os, ltrx_ip, ltrx.user_id');
        $this->db->select('user_full_name');

        $this->db->join('users', 'users.user_id = ltrx.user_id', 'left');
        $res = $this->db->get('ltrx');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table ltrx
    function add_trx($data = array()) {

        if (isset($data['ltrx_id'])) {
            $this->db->set('ltrx_id', $data['ltrx_id']);
        }

        if (isset($data['ltrx_date'])) {
            $this->db->set('ltrx_date', $data['ltrx_date']);
        }

        if (isset($data['ltrx_action'])) {
            $this->db->set('ltrx_action', $data['ltrx_action']);
        }

        if (isset($data['ltrx_module'])) {
            $this->db->set('ltrx_module', $data['ltrx_module']);
        }

        if (isset($data['ltrx_info'])) {
            $this->db->set('ltrx_info', $data['ltrx_info']);
        }

        if (isset($data['ltrx_browser'])) {
            $this->db->set('ltrx_browser', $data['ltrx_browser']);
        }

        if (isset($data['ltrx_version'])) {
            $this->db->set('ltrx_version', $data['ltrx_version']);
        }

        if (isset($data['ltrx_os'])) {
            $this->db->set('ltrx_os', $data['ltrx_os']);
        }

        if (isset($data['ltrx_ip'])) {
            $this->db->set('ltrx_ip', $data['ltrx_ip']);
        }

        if (isset($data['user_id'])) {
            $this->db->set('user_id', $data['user_id']);
        }

        if (isset($data['ltrx_id'])) {
            $this->db->where('ltrx_id', $data['ltrx_id']);
            $this->db->update('ltrx');
            $id = $data['ltrx_id'];
        } else {
            $this->db->insert('ltrx');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

}
