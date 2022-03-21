<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Presensi_data_libur_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('id', $params['id']);
        }

        if(isset($params['presensi_data_libur_search']))
        {
            $this->db->where('hari', $params['presensi_data_libur_search']);
            $this->db->or_like('keterangan', $params['presensi_data_libur_search']);
        }

        if(isset($params['group']))
        {

            $this->db->group_by($params['group']); 

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
            $this->db->order_by('id', 'desc');
        }

        $this->db->select('data_hari_libur.*,(select user_full_name from users where user_id = data_hari_libur.created_by) created_by,(select user_full_name from users where user_id = data_hari_libur.updated_by) updated_by');
        $res = $this->db->get('data_hari_libur');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }

    }

    function add($data = array()) {

        $this->db->where('hari',$data['hari']);
        $this->db->delete('data_hari_libur');

        if (isset($data['id'])) {
            $this->db->set('id', $data['id']);
        }

        if (isset($data['hari'])) {
            $this->db->set('hari', $data['hari']);
        }
        if (isset($data['keterangan'])) {
            $this->db->set('keterangan', $data['keterangan']);
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

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('data_hari_libur');
            $id = $data['id'];
        } else {
            $this->db->insert('data_hari_libur');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function hapus($id=null){
        $this->db->where('id',$id);
        $this->db->delete('data_hari_libur');
    }

}
