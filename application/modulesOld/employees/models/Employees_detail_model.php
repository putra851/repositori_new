<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employees_detail_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_education($x) {
        $data = $this->db->query("SELECT d.* FROM employee_education d LEFT JOIN employee e ON d.education_employee_id = e.employee_id WHERE e.employee_id = '$x' ORDER BY education_start ASC")->result_array();
        
        return $data;
        
    }
    
    function get_workshop($x) {
        $data = $this->db->query("SELECT d.* FROM workshop_history d LEFT JOIN employee e ON d.workshop_employee_id = e.employee_id WHERE e.employee_id = '$x' ORDER BY workshop_start ASC")->result_array();
        
        return $data;
        
    }
    
    function get_family($x) {
        $data = $this->db->query("SELECT d.* FROM employee_fam d LEFT JOIN employee e ON d.fam_employee_id = e.employee_id WHERE e.employee_id = '$x' ORDER BY fam_desc ASC")->result_array();
        
        return $data;
        
    }
    
    function get_position($x) {
        $data = $this->db->query("SELECT d.* FROM position_history d LEFT JOIN employee e ON d.poshistory_employee_id = e.employee_id WHERE e.employee_id = '$x' ORDER BY poshistory_start ASC")->result_array();
        
        return $data;
        
    }
    
    function get_teaching($x) {
        $data = $this->db->query("SELECT d.* FROM teaching_history d LEFT JOIN employee e ON d.teaching_employee_id = e.employee_id WHERE e.employee_id = '$x' ORDER BY teaching_start ASC")->result_array();
        
        return $data;
        
    }
    
    function get_achievement($x) {
        $data = $this->db->query("SELECT d.* FROM employee_achievement d LEFT JOIN employee e ON d.achievement_employee_id = e.employee_id WHERE e.employee_id = '$x' ORDER BY achievement_year ASC")->result_array();
        
        return $data;
        
    }

    function add_education($data = array()) {

        if (isset($data['education_id'])) {
            $this->db->set('education_id', $data['education_id']);
        }

        if (isset($data['education_start'])) {
            $this->db->set('education_start', $data['education_start']);
        }

        if (isset($data['education_end'])) {
            $this->db->set('education_end', $data['education_end']);
        }

        if (isset($data['education_name'])) {
            $this->db->set('education_name', $data['education_name']);
        }

        if (isset($data['education_location'])) {
            $this->db->set('education_location', $data['education_location']);
        }

        if (isset($data['education_employee_id'])) {
            $this->db->set('education_employee_id', $data['education_employee_id']);
        }
        
        if (isset($data['education_id'])) {
            $this->db->where('education_id', $data['education_id']);
            $this->db->update('employee_education');
            $id = $data['education_id'];
        } else {
            $this->db->insert('employee_education');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    function add_workshop($data = array()) {

        if (isset($data['workshop_id'])) {
            $this->db->set('workshop_id', $data['workshop_id']);
        }

        if (isset($data['workshop_start'])) {
            $this->db->set('workshop_start', $data['workshop_start']);
        }

        if (isset($data['workshop_end'])) {
            $this->db->set('workshop_end', $data['workshop_end']);
        }

        if (isset($data['workshop_organizer'])) {
            $this->db->set('workshop_organizer', $data['workshop_organizer']);
        }

        if (isset($data['workshop_location'])) {
            $this->db->set('workshop_location', $data['workshop_location']);
        }

        if (isset($data['workshop_employee_id'])) {
            $this->db->set('workshop_employee_id', $data['workshop_employee_id']);
        }
        
        if (isset($data['workshop_id'])) {
            $this->db->where('workshop_id', $data['workshop_id']);
            $this->db->update('workshop_history');
            $id = $data['workshop_id'];
        } else {
            $this->db->insert('workshop_history');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    function add_family($data = array()) {

        if (isset($data['fam_id'])) {
            $this->db->set('fam_id', $data['fam_id']);
        }

        if (isset($data['fam_name'])) {
            $this->db->set('fam_name', $data['fam_name']);
        }

        if (isset($data['fam_desc'])) {
            $this->db->set('fam_desc', $data['fam_desc']);
        }

        if (isset($data['fam_employee_id'])) {
            $this->db->set('fam_employee_id', $data['fam_employee_id']);
        }
        
        if (isset($data['fam_id'])) {
            $this->db->where('fam_id', $data['fam_id']);
            $this->db->update('employee_fam');
            $id = $data['fam_id'];
        } else {
            $this->db->insert('employee_fam');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    function add_position($data = array()) {

        if (isset($data['poshistory_id'])) {
            $this->db->set('poshistory_id', $data['poshistory_id']);
        }

        if (isset($data['poshistory_start'])) {
            $this->db->set('poshistory_start', $data['poshistory_start']);
        }

        if (isset($data['poshistory_end'])) {
            $this->db->set('poshistory_end', $data['poshistory_end']);
        }

        if (isset($data['poshistory_desc'])) {
            $this->db->set('poshistory_desc', $data['poshistory_desc']);
        }
        
        if (isset($data['poshistory_employee_id'])) {
            $this->db->set('poshistory_employee_id', $data['poshistory_employee_id']);
        }
        
        if (isset($data['poshistory_id'])) {
            $this->db->where('poshistory_id', $data['poshistory_id']);
            $this->db->update('position_history');
            $id = $data['poshistory_id'];
        } else {
            $this->db->insert('position_history');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    function add_teaching($data = array()) {

        if (isset($data['teaching_id'])) {
            $this->db->set('teaching_id', $data['teaching_id']);
        }

        if (isset($data['teaching_start'])) {
            $this->db->set('teaching_start', $data['teaching_start']);
        }

        if (isset($data['teaching_end'])) {
            $this->db->set('teaching_end', $data['teaching_end']);
        }

        if (isset($data['teaching_desc'])) {
            $this->db->set('teaching_desc', $data['teaching_desc']);
        }
        
        if (isset($data['teaching_lesson'])) {
            $this->db->set('teaching_lesson', $data['teaching_lesson']);
        }
        
        if (isset($data['teaching_employee_id'])) {
            $this->db->set('teaching_employee_id', $data['teaching_employee_id']);
        }
        
        if (isset($data['teaching_id'])) {
            $this->db->where('teaching_id', $data['teaching_id']);
            $this->db->update('teaching_history');
            $id = $data['teaching_id'];
        } else {
            $this->db->insert('teaching_history');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    function add_achievement($data = array()) {

        if (isset($data['achievement_id'])) {
            $this->db->set('achievement_id', $data['achievement_id']);
        }

        if (isset($data['achievement_year'])) {
            $this->db->set('achievement_year', $data['achievement_year']);
        }

        if (isset($data['achievement_name'])) {
            $this->db->set('achievement_name', $data['achievement_name']);
        }
        
        if (isset($data['achievement_employee_id'])) {
            $this->db->set('achievement_employee_id', $data['achievement_employee_id']);
        }
        
        if (isset($data['achievement_id'])) {
            $this->db->where('achievement_id', $data['achievement_id']);
            $this->db->update('employee_achievement');
            $id = $data['achievement_id'];
        } else {
            $this->db->insert('employee_achievement');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    function delete_education($id) {
        $this->db->where('education_id', $id);
        $this->db->delete('employee_education');
    }
    
    function delete_workshop($id) {
        $this->db->where('workshop_id', $id);
        $this->db->delete('workshop_history');
    }
    
    function delete_family($id) {
        $this->db->where('fam_id', $id);
        $this->db->delete('employee_fam');
    }
    
    function delete_position($id) {
        $this->db->where('poshistory_id', $id);
        $this->db->delete('position_history');
    }
    
    function delete_teaching($id) {
        $this->db->where('teaching_id', $id);
        $this->db->delete('teaching_history');
    }
    
    function delete_achievement($id) {
        $this->db->where('achievement_id', $id);
        $this->db->delete('employee_achievement');
    }
}
