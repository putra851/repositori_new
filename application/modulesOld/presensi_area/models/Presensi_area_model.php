<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Presensi_area_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('id_pegawai', $params['id']);
        }
        if (isset($params['employee_id'])) {
            $this->db->where('id_pegawai', $params['employee_id']);
        }

        if (isset($params['multiple_id'])) {
            $this->db->where_in('id_pegawai', $params['employee_id']);
        }

        if(isset($params['presensi_area_search']))
        {
            $this->db->where('nip', $params['presensi_area_search']);
            $this->db->or_like('nama_pegawai', $params['presensi_area_search']);
        }

        if (isset($params['employee_nip'])) {
            $this->db->where('nip', $params['employee_nip']);
        }

        if (isset($params['employee_position_id']) && $params['employee_position_id']!=='all') {
            $this->db->where('id_jabatan', $params['employee_position_id']);
        }

        if (isset($params['nip'])) {
            $this->db->like('nip', $params['nip']);
        }

        if (isset($params['employee_name'])) {
            $this->db->where('nama_pegawai', $params['employee_name']);
        }

        if (isset($params['majors_id'])) {
            $this->db->where('id_unit', $params['majors_id']);
        }
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('id_unit', $this->session->userdata('umajorsid'));
        }

        if(isset($params['group']))
        {

            $this->db->group_by('id_unit'); 

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
            $this->db->order_by('nip', 'asc');
        }

        $this->db->select('id_pegawai,nip,nama_pegawai,id_unit,id_jabatan,status_absen,status_absen_temp,area_absen,jarak_radius');
        $this->db->select("position_name, IF(`majors_short_name` IS NULL,'Laiinnya',`majors_short_name`) as majors_short_name,nama_area as area_absen_nama");
        $this->db->join('position', 'position.position_id = presensi_area_v.id_jabatan', 'left');
        $this->db->join('majors', 'majors.majors_id = presensi_area_v.id_unit', 'left');
        $this->db->join('area_absensi', 'area_absensi.id_area = presensi_area_v.area_absen', 'left');

        $res = $this->db->get('presensi_area_v');

        if (isset($params['id'])) {
            return $res->row_array();
        } else if (isset($params['employee_nip'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }

    }

    function edit($id,$data) {

        $this->db->where('employee_id', $id);
        $this->db->update('employee',$data);

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function get_area_absen(){
        $this->db->order_by('id_area','asc');
        $this->db->select('id_area,nama_area');
        $res = $this->db->get('area_absensi');
        return $res->result_array();
    }

    function act_lock($id, $params) {
        $this->db->where('employee_id', $id);
        $this->db->update('employee', $params);
    }

}
