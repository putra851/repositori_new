<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Presensi_data_area_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('id_area', $params['id']);
        }

        if(isset($params['presensi_data_area_search']))
        {
            $this->db->where('nama_area', $params['presensi_data_area_search']);
            $this->db->or_like('longi', $params['presensi_data_area_search']);
            $this->db->or_like('lati', $params['presensi_data_area_search']);
        }

        if(isset($params['group']))
        {

            $this->db->group_by('id_area'); 

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
            $this->db->order_by('id_area', 'desc');
        }

        $this->db->select('area_absensi.*,(select user_full_name from users where user_id = area_absensi.created_by) created_by,(select user_full_name from users where user_id = area_absensi.updated_by) updated_by');
        $res = $this->db->get('area_absensi');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }

    }

    function add($data = array()) {

        if (isset($data['id_area'])) {
            $this->db->set('id_area', $data['id_area']);
        }

        if (isset($data['nama_area'])) {
            $this->db->set('nama_area', $data['nama_area']);
        }
        if (isset($data['longi'])) {
            $this->db->set('longi', $data['longi']);
        }
        if (isset($data['lati'])) {
            $this->db->set('lati', $data['lati']);
        }

        if (isset($data['remark'])) {
            $this->db->set('remark', $data['remark']);
        }
        
        if (isset($data['created_by'])) {
            $this->db->set('created_by', $data['created_by']);
        }

        if (isset($data['created_date'])) {
            $this->db->set('created_date', $data['created_date']);
        }

        if (isset($data['updated_by'])) {
            $this->db->set('updated_by', $data['updated_by']);
        }

        if (isset($data['updated_date'])) {
            $this->db->set('updated_date', $data['updated_date']);
        }

        if (isset($data['id_area'])) {
            $this->db->where('id_area', $data['id_area']);
            $this->db->update('area_absensi');
            $id = $data['id_area'];
        } else {
            $this->db->insert('area_absensi');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function hapus($id=null){
        $this->db->where('id_area',$id);
        $this->db->delete('area_absensi');
    }

}
