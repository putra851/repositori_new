<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jam_pelajaran_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('jam_pelajaran_id', $params['id']);
        }
        
        if(isset($params['id']))
        {
            $this->db->where('jam_pelajaran_id', $params['id']);
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
            $this->db->order_by('jam_pelajaran.jam_pelajaran_start', 'ASC');
        }
        
        $this->db->select('jam_pelajaran_id, jam_pelajaran_name, jam_pelajaran_start, jam_pelajaran_end');
        $res = $this->db->get('jam_pelajaran');

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

        if (isset($data['jam_pelajaran_id'])) {
            $this->db->set('jam_pelajaran_id', $data['jam_pelajaran_id']);
        }

        if (isset($data['jam_pelajaran_name'])) {
            $this->db->set('jam_pelajaran_name', $data['jam_pelajaran_name']);
        }

        if (isset($data['jam_pelajaran_start'])) {
            $this->db->set('jam_pelajaran_start', $data['jam_pelajaran_start']);
        }

        if (isset($data['jam_pelajaran_end'])) {
            $this->db->set('jam_pelajaran_end', $data['jam_pelajaran_end']);
        }

        if (isset($data['jam_pelajaran_id'])) {
            $this->db->where('jam_pelajaran_id', $data['jam_pelajaran_id']);
            $this->db->update('jam_pelajaran');
            $id = $data['jam_pelajaran_id'];
        } else {
            $this->db->insert('jam_pelajaran');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id) {
        $this->db->where('jam_pelajaran_id', $id);
        $this->db->delete('jam_pelajaran');
    }

}
