<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Presensi_harian_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function check($param = array()) {
        
        if (isset($param['period_id'])) {
            $this->db->where('presensi_harian_period_id', $param['period_id']);
        }
            
        if (isset($param['month_id'])) {
            $this->db->where('presensi_harian_month_id', $param['month_id']);
        }
        
        if (isset($param['date'])) {
            $this->db->where('presensi_harian_date', $param['date']);
        }
        
        if (isset($param['class_id'])) {
            $this->db->where('presensi_harian_class_id', $param['class_id']);
        }
        
        $this->db->from('presensi_harian');
        
        $res = $this->db->count_all_results();
        
        return $res;
    }
    
    function add($data = array()) {

        if (isset($data['presensi_harian_id'])) {
            $this->db->set('presensi_harian_id', $data['presensi_harian_id']);
        }
        
        if (isset($data['presensi_harian_period_id'])) {
            $this->db->set('presensi_harian_period_id', $data['presensi_harian_period_id']);
        }
            
        if (isset($data['presensi_harian_month_id'])) {
            $this->db->set('presensi_harian_month_id', $data['presensi_harian_month_id']);
        }
        
        if (isset($data['presensi_harian_date'])) {
            $this->db->set('presensi_harian_date', $data['presensi_harian_date']);
        }
        
        if (isset($data['presensi_harian_class_id'])) {
            $this->db->set('presensi_harian_class_id', $data['presensi_harian_class_id']);
        }
        
        if (isset($data['presensi_harian_student_id'])) {
            $this->db->set('presensi_harian_student_id', $data['presensi_harian_student_id']);
        }
        
        if (isset($data['presensi_harian_status'])) {
            $this->db->set('presensi_harian_status', $data['presensi_harian_status']);
        }

        if (isset($data['presensi_harian_id'])) {
            $this->db->where('presensi_harian_id', $data['presensi_harian_id']);
            $this->db->update('presensi_harian');
            $id = $data['presensi_harian_id'];
        } else {
            $this->db->insert('presensi_harian');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    

}
