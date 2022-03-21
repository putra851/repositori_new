<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Izin_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('izin_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('izin_period_id', $params['period_id']);
		}

		if (isset($params['date'])) {
			$this->db->where('izin_date', $params['date']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('izin_student_id', $params['student_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		if(isset($params['order_by'])){
		    $this->db->order_by($params['order_by'], 'desc');
		}else{
		    $this->db->order_by('izin_id', 'desc');
		}
        $this->db->where('majors_status', '1');

		$this->db->select('izin_id, izin_period_id, izin_date, izin_time');
		
		$this->db->join('student', 'student.student_id = izin.izin_student_id', 'left');
		
		$this->db->join('period', 'period.period_id = izin.izin_period_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('users', 'users.user_id = izin.izin_user_id', 'left');

		$res = $this->db->get('izin');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

    // Add and update to database
	function add($data = array()) {

		if(isset($data['izin_id'])) {
			$this->db->set('izin_id', $data['izin_id']);
		}

		if(isset($data['izin_date'])) {
			$this->db->set('izin_date', $data['izin_date']);
		}

		if(isset($data['izin_period_id'])) {
			$this->db->set('izin_period_id', $data['izin_period_id']);
		}

		if(isset($data['izin_time'])) {
			$this->db->set('izin_time', $data['izin_time']);
		}

		if(isset($data['izin_student_id'])) {
			$this->db->set('izin_student_id', $data['izin_student_id']);
		}

		if(isset($data['izin_user_id'])) {
			$this->db->set('izin_user_id', $data['izin_user_id']);
		}

		if (isset($data['izin_id'])) {
			$this->db->where('izin_id', $data['izin_id']);
			$this->db->update('izin');
			$id = $data['izin_id'];
		} else {
			$this->db->insert('izin');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete izin to database
	function delete($id) {
		$this->db->where('izin_id', $id);
		$this->db->delete('izin');
	}
	
	function get_sum($params = array()){
	    if(isset($params['id']))
		{
			$this->db->where('izin_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('izin_period_id', $params['period_id']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('izin_student_id', $params['student_id']);
		}
        
        $this->db->group_by('izin_student_id');
		
        $this->db->where('majors_status', '1');
        
        $this->db->select('student_id, student_full_name, student_nis');
        $this->db->select('class_id, class_name');
        $this->db->select('majors_id, majors_short_name, majors_name');
        $this->db->select('period_id');
		$this->db->select('COUNT(izin_id) AS izinSum');
		
		$this->db->join('student', 'student.student_id = izin.izin_student_id', 'left');
		
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('period', 'period.period_id = izin.izin_period_id', 'left');

		$res = $this->db->get('izin');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

}
