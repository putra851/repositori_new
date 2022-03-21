<?php
if (!defined('BASEPATH'))
        exit('No direct script access allowed');
    
    class Position_model extends CI_Model {
    
        function __construct() {
            parent::__construct();
        }
    
        function get($params = array())
        {
            if(isset($params['id']))
            {
                $this->db->where('position_id', $params['id']);
            }
    
            if(isset($params['position_code']))
            {
                $this->db->where('position_code', $params['position_code']);
            }
    
            if(isset($params['position_name']))
            {
                $this->db->where('position_name', $params['position_name']);
            }
    
            if(isset($params['majors_id']))
            {
                $this->db->where('position_majors_id', $params['majors_id']);
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
                $this->db->order_by('position_id', 'asc');
            }
            //$this->db->where('majors_status', '1');
            $this->db->select("position_id, position_code, position_name, IF(`majors_short_name` IS NULL,'Laiinnya',`majors_short_name`) as majors_short_name, `position_majors_id`, IF(`majors_id` IS NULL,'99',`majors_id`) as majors_id");
            
            $this->db->join('majors', 'majors_id=position_majors_id', 'left');
            $res = $this->db->get('position');
    
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

        if (isset($data['position_id'])) {
            $this->db->set('position_id', $data['position_id']);
        }

        if (isset($data['position_code'])) {
            $this->db->set('position_code', $data['position_code']);
        }

        if (isset($data['position_name'])) {
            $this->db->set('position_name', $data['position_name']);
        }

        if (isset($data['position_majors_id'])) {
            $this->db->set('position_majors_id', $data['position_majors_id']);
        }

        if (isset($data['position_id'])) {
            $this->db->where('position_id', $data['position_id']);
            $this->db->update('position');
            $id = $data['position_id'];
        } else {
            $this->db->insert('position');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    // Delete position to database
    function delete($id) {
        $this->db->where('position_id', $id);
        $this->db->delete('position');
    }
}