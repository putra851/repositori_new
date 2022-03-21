<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Presensi_pelajaran_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function check($param = array()) {
        
        if (isset($param['period_id'])) {
            $this->db->where('presensi_pelajaran_period_id', $param['period_id']);
        }
            
        if (isset($param['month_id'])) {
            $this->db->where('presensi_pelajaran_month_id', $param['month_id']);
        }
        
        if (isset($param['date'])) {
            $this->db->where('presensi_pelajaran_date', $param['date']);
        }
        
        if (isset($param['class_id'])) {
            $this->db->where('presensi_pelajaran_class_id', $param['class_id']);
        }
        
        if (isset($param['lesson_id'])) {
            $this->db->where('presensi_pelajaran_lesson_id', $param['lesson_id']);
        }
        
        $this->db->from('presensi_pelajaran');
        
        $res = $this->db->count_all_results();
        
        return $res;
    }
    
    function add($data = array()) {

        if (isset($data['presensi_pelajaran_id'])) {
            $this->db->set('presensi_pelajaran_id', $data['presensi_pelajaran_id']);
        }
        
        if (isset($data['presensi_pelajaran_period_id'])) {
            $this->db->set('presensi_pelajaran_period_id', $data['presensi_pelajaran_period_id']);
        }
            
        if (isset($data['presensi_pelajaran_month_id'])) {
            $this->db->set('presensi_pelajaran_month_id', $data['presensi_pelajaran_month_id']);
        }
        
        if (isset($data['presensi_pelajaran_date'])) {
            $this->db->set('presensi_pelajaran_date', $data['presensi_pelajaran_date']);
        }
        
        if (isset($data['presensi_pelajaran_class_id'])) {
            $this->db->set('presensi_pelajaran_class_id', $data['presensi_pelajaran_class_id']);
        }
        
        if (isset($data['presensi_pelajaran_lesson_id'])) {
            $this->db->set('presensi_pelajaran_lesson_id', $data['presensi_pelajaran_lesson_id']);
        }
        
        if (isset($data['presensi_pelajaran_student_id'])) {
            $this->db->set('presensi_pelajaran_student_id', $data['presensi_pelajaran_student_id']);
        }
        
        if (isset($data['presensi_pelajaran_status'])) {
            $this->db->set('presensi_pelajaran_status', $data['presensi_pelajaran_status']);
        }

        if (isset($data['presensi_pelajaran_id'])) {
            $this->db->where('presensi_pelajaran_id', $data['presensi_pelajaran_id']);
            $this->db->update('presensi_pelajaran');
            $id = $data['presensi_pelajaran_id'];
        } else {
            $this->db->insert('presensi_pelajaran');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    

}
