<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Presensi_khusus_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('absensi_khusus.id', $params['id']);
        }

        if(isset($params['presensi_data_area_search']))
        {
            $this->db->where('area_absensi.nama_area', $params['presensi_data_area_search']);
            $this->db->or_like('employee.employee_name', $params['presensi_data_area_search']);
            $this->db->or_like('absensi_khusus.tanggal', $params['presensi_data_area_search']);
        }

        if(isset($params['group']))
        {

            $this->db->group_by('id'); 

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

        $this->db->select('absensi_khusus.*,(select user_full_name from users where user_id = absensi_khusus.created_by) created_by,(select user_full_name from users where user_id = absensi_khusus.updated_by) updated_by,employee.employee_name nama_pegawai,area_absensi.nama_area nama_area');
        $this->db->join('employee', 'employee.employee_id = absensi_khusus.id_pegawai', 'left');
        $this->db->join('area_absensi', 'area_absensi.id_area = absensi_khusus.lokasi_absen', 'left');
        $res = $this->db->get('absensi_khusus');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }

    }

    function add($data = array()) {

        if (isset($data['id'])) {
            $this->db->set('id', $data['id']);
        }

        if (isset($data['tanggal'])) {
            $this->db->set('tanggal', $data['tanggal']);
        }
        if (isset($data['id_pegawai'])) {
            $this->db->set('id_pegawai', $data['id_pegawai']);
        }
        if (isset($data['lokasi_absen'])) {
            $this->db->set('lokasi_absen', $data['lokasi_absen']);
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

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('absensi_khusus');
            $id = $data['id'];
        } else {
            $this->db->insert('absensi_khusus');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function hapus($id=null){
        $this->db->where('id',$id);
        $this->db->delete('absensi_khusus');
    }

}
