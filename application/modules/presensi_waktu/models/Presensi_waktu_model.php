<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Presensi_waktu_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['data_waktu_id'])) {
            $this->db->where('data_waktu_id', $params['data_waktu_id']);
        }

        if (isset($params['data_waktu_majors_id'])) {
            $this->db->where('data_waktu_majors_id', $params['data_waktu_majors_id']);
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
            $this->db->order_by('data_waktu_id', 'ASC');
        }

        $this->db->select('*');
        
        $this->db->join('majors', 'majors.majors_id = data_waktu.data_waktu_majors_id', 'left');
        $this->db->join('day', 'day.day_id = data_waktu.data_waktu_day_id', 'left');
        
        $res = $this->db->get('data_waktu');

        if (isset($params['data_waktu_id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }

    }

    function add($data = array()) {

        $this->db->where('data_waktu_day_id',$data['data_waktu_day_id']);
        $this->db->delete('data_waktu');

        if (isset($data['data_waktu_id'])) {
            $this->db->set('data_waktu_id', $data['data_waktu_id']);
        }

        if (isset($data['data_waktu_majors_id'])) {
            $this->db->set('data_waktu_majors_id', $data['data_waktu_majors_id']);
        }

        if (isset($data['data_waktu_day_id'])) {
            $this->db->set('data_waktu_day_id', $data['data_waktu_day_id']);
        }
        
        if (isset($data['data_waktu_masuk'])) {
            $this->db->set('data_waktu_masuk', $data['data_waktu_masuk']);
        }
        
        if (isset($data['data_waktu_pulang'])) {
            $this->db->set('data_waktu_pulang', $data['data_waktu_pulang']);
        }

        if (isset($data['data_waktu_id'])) {
            $this->db->where('data_waktu_id', $data['data_waktu_id']);
            $this->db->update('data_waktu');
            $id = $data['data_waktu_id'];
        } else {
            $this->db->insert('data_waktu');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function hapus($id=null){
        $this->db->where('data_waktu_id',$id);
        $this->db->delete('data_waktu');
    }

}
