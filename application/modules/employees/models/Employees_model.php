<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employees_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('employee.employee_id', $params['id']);
        }
        if (isset($params['employee_id'])) {
            $this->db->where('employee.employee_id', $params['employee_id']);
        }

        if (isset($params['multiple_id'])) {
            $this->db->where_in('employee.employee_id', $params['employee_id']);
        }

        if(isset($params['employee_search']))
        {
            $this->db->where('employee_nip', $params['employee_search']);
            $this->db->or_like('employee_name', $params['employee_search']);
        }

        if (isset($params['employee_nip'])) {
            $this->db->where('employee.employee_nip', $params['employee_nip']);
        }

        if (isset($params['employee_position_id'])) {
            $this->db->where('employee.employee_position_id', $params['employee_position_id']);
        }

        if (isset($params['nip'])) {
            $this->db->like('employee_nip', $params['nip']);
        }

        if (isset($params['password'])) {
            $this->db->like('employee_password', $params['password']);
        }

        if (isset($params['employee_name'])) {
            $this->db->where('employee.employee_name', $params['employee_name']);
        }

        if (isset($params['status'])) {
            $this->db->where('employee.employee_status', $params['status']);
        }

        if (isset($params['majors_id'])) {
            $this->db->where('employee.employee_majors_id', $params['majors_id']);
        }
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }

        if(isset($params['group']))
        {

            $this->db->group_by('majors.majors_id'); 

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
            $this->db->order_by('employee_nip', 'asc');
        }

        $this->db->select('employee.employee_id, employee_nip, employee_name, employee_password, employee_email, employee_gender, employee_phone, employee_address, employee_born_place, employee_born_date, employee_photo, employee_status, employee_strata, employee.employee_majors_id, employee_position_id, employee_start, employee_end, employee_category, employee_input_date, employee_last_update,get_status_absen(employee.status_absen_temp,employee.status_absen) validasi,employee.jarak_radius,employee.area_absen,"PEGAWAI" as employee_role_id_name');
        $this->db->select("position_id, position_code, position_name, IF(`majors_short_name` IS NULL,'Laiinnya',`majors_short_name`) as majors_short_name, majors_name, `position_majors_id`, IF(`majors_id` IS NULL,'99',`majors_id`) as majors_id");
        $this->db->select('employee.employee_position_id, position.position_id, position.position_code, position_name, majors_status');
        $this->db->join('position', 'position.position_id = employee.employee_position_id', 'left');
        $this->db->join('majors', 'majors.majors_id = employee.employee_majors_id', 'left');

        $res = $this->db->get('employee');

        if (isset($params['id'])) {
            return $res->row_array();
        } else if (isset($params['employee_nip'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }

    }

    function add($data = array()) {

        if (isset($data['employee_id'])) {
            $this->db->set('employee_id', $data['employee_id']);
        }

        if (isset($data['employee_nip'])) {
            $this->db->set('employee_nip', $data['employee_nip']);
        }

        if (isset($data['employee_strata'])) {
            $this->db->set('employee_strata', $data['employee_strata']);
        }

        if (isset($data['employee_password'])) {
            $this->db->set('employee_password', $data['employee_password']);
        }

        if (isset($data['employee_gender'])) {
            $this->db->set('employee_gender', $data['employee_gender']);
        }

        if (isset($data['employee_phone'])) {
            $this->db->set('employee_phone', $data['employee_phone']);
        }

        if (isset($data['employee_email'])) {
            $this->db->set('employee_email', $data['employee_email']);
        }

        if (isset($data['employee_position_id'])) {
            $this->db->set('employee_position_id', $data['employee_position_id']);
        }

        if (isset($data['employee_category'])) {
            $this->db->set('employee_category', $data['employee_category']);
        }

        if (isset($data['employee_address'])) {
            $this->db->set('employee_address', $data['employee_address']);
        }

        if (isset($data['employee_majors_id'])) {
            $this->db->set('employee_majors_id', $data['employee_majors_id']);
        }

        if (isset($data['employee_name'])) {
            $this->db->set('employee_name', $data['employee_name']);
        }

        if (isset($data['employee_photo'])) {
            $this->db->set('employee_photo', $data['employee_photo']);
        }

        if (isset($data['employee_born_place'])) {
            $this->db->set('employee_born_place', $data['employee_born_place']);
        }

        if (isset($data['employee_born_date'])) {
            $this->db->set('employee_born_date', $data['employee_born_date']);
        }

        if (isset($data['employee_name_of_mother'])) {
            $this->db->set('employee_name_of_mother', $data['employee_name_of_mother']);
        }

        if (isset($data['employee_start'])) {
            $this->db->set('employee_start', $data['employee_start']);
        }

        if (isset($data['employee_end'])) {
            $this->db->set('employee_end', $data['employee_end']);
        }

        if (isset($data['employee_status'])) {
            $this->db->set('employee_status', $data['employee_status']);
        }

        if (isset($data['employee_input_date'])) {
            $this->db->set('employee_input_date', $data['employee_input_date']);
        }

        if (isset($data['employee_last_update'])) {
            $this->db->set('employee_last_update', $data['employee_last_update']);
        }

        if (isset($data['employee_id'])) {
            $this->db->where('employee_id', $data['employee_id']);
            $this->db->update('employee');
            $id = $data['employee_id'];
        } else {
            $this->db->insert('employee');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    function delete($id) {
        $this->db->where('employee_id', $id);
        $this->db->delete('employee');
    }
/*
    public function is_exist($field, $value)
    {
        $this->db->where($field, $value);        

        return $this->db->count_all_results('employee') > 0 ? TRUE : FALSE;
    }
*/
    function change_password($id, $params) {
        $this->db->where('employee_id', $id);
        $this->db->update('employee', $params);
    }

}
