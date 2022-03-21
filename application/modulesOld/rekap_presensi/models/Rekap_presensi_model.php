<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rekap_presensi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('data_absensi.id', $params['id']);
        }

        if (isset($params['majors_id'])) {
            $this->db->where('employee.employee_majors_id', $params['majors_id']);
        }

        if (isset($params['employee_id'])) {
            $this->db->where('data_absensi.id_pegawai', $params['employee_id']);
        }

        if(isset($params['rekap_presensi_search']))
        {
            $this->db->where('employee.employee_name', $params['rekap_presensi_search']);
        }

        if(isset($params['tgl_awal']) || isset($params['tgl_akhir']))
        {
            $this->db->where('data_absensi.tanggal >=', $params['tgl_awal']);
            $this->db->where('data_absensi.tanggal <=', $params['tgl_akhir']);
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

        $this->db->select('data_absensi.*, employee.employee_name as nama_pegawai,area_absensi.nama_area as area_absen_nama');
        $this->db->join('employee', 'employee.employee_id = data_absensi.id_pegawai', 'left');
        $this->db->join('area_absensi', 'area_absensi.id_area = data_absensi.area_absen', 'left');
        $res = $this->db->get('data_absensi');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }

    }

    function get_rekap($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('data_absensi.id', $params['id']);
        }

        if (isset($params['majors_id'])) {
            $this->db->where('employee.employee_majors_id', $params['majors_id']);
        }

        if (isset($params['employee_id'])) {
            $this->db->where('data_absensi.id_pegawai', $params['employee_id']);
        }

        if(isset($params['rekap_presensi_search']))
        {
            $this->db->where('employee.employee_name', $params['rekap_presensi_search']);
        }

        if(isset($params['tgl_awal']) || isset($params['tgl_akhir']))
        {
            $this->db->where('data_absensi.tanggal >=', $params['tgl_awal']);
            $this->db->where('data_absensi.tanggal <=', $params['tgl_akhir']);
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

        $this->db->select('data_absensi.*, employee.employee_name as nama_pegawai,area_absensi.nama_area as area_absen_nama');
        $this->db->join('employee', 'employee.employee_id = data_absensi.id_pegawai', 'left');
        $this->db->join('area_absensi', 'area_absensi.id_area = data_absensi.area_absen', 'left');
        $res = $this->db->get('data_absensi');

        if (isset($params['id'])) {
            return $res->result_array();
        } else {
            return $res->result_array();
        }

    }

    // Get From Databases
    function rekap($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('employee.employee_id', $params['id']);
        }

        if (isset($params['majors_id'])) {
            $this->db->where('employee.employee_majors_id', $params['majors_id']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('employee_id', 'desc');
        }

        $this->db->where('employee.employee_status', 1);

        $this->db->select('employee.*,position.position_name as jabatan,majors.majors_name as nama_unit');
        $this->db->join('majors', 'majors.majors_id = employee.employee_majors_id', 'left');
        $this->db->join('position', 'position.position_id = employee.employee_position_id', 'left');
        $res = $this->db->get('employee');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }

    }

}
