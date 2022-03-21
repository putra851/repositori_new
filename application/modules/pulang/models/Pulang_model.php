<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pulang_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('pulang_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('pulang_period_id', $params['period_id']);
		}

		if (isset($params['date'])) {
			$this->db->where('pulang_date', $params['date']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('pulang_student_id', $params['student_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		if(isset($params['order_by'])){
		    $this->db->order_by($params['order_by'], 'desc');
		}else{
		    $this->db->order_by('pulang_id', 'desc');
		}
        $this->db->where('majors_status', '1');

		$this->db->select('pulang_id, pulang_period_id, pulang_date, pulang_days, pulang_note');
		
		$this->db->join('student', 'student.student_id = pulang.pulang_student_id', 'left');
		
		$this->db->join('period', 'period.period_id = pulang.pulang_period_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('users', 'users.user_id = pulang.pulang_user_id', 'left');

		$res = $this->db->get('pulang');

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

		if(isset($data['pulang_id'])) {
			$this->db->set('pulang_id', $data['pulang_id']);
		}

		if(isset($data['pulang_date'])) {
			$this->db->set('pulang_date', $data['pulang_date']);
		}

		if(isset($data['pulang_period_id'])) {
			$this->db->set('pulang_period_id', $data['pulang_period_id']);
		}

		if(isset($data['pulang_days'])) {
			$this->db->set('pulang_days', $data['pulang_days']);
		}

		if(isset($data['pulang_note'])) {
			$this->db->set('pulang_note', $data['pulang_note']);
		}

		if(isset($data['pulang_student_id'])) {
			$this->db->set('pulang_student_id', $data['pulang_student_id']);
		}

		if(isset($data['pulang_user_id'])) {
			$this->db->set('pulang_user_id', $data['pulang_user_id']);
		}

		if (isset($data['pulang_id'])) {
			$this->db->where('pulang_id', $data['pulang_id']);
			$this->db->update('pulang');
			$id = $data['pulang_id'];
		} else {
			$this->db->insert('pulang');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete pulang to database
	function delete($id) {
		$this->db->where('pulang_id', $id);
		$this->db->delete('pulang');
	}
	
	function get_sum($params = array()){
	    if(isset($params['id']))
		{
			$this->db->where('pulang_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('pulang_period_id', $params['period_id']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('pulang_student_id', $params['student_id']);
		}
        
        $this->db->group_by('pulang_student_id');
		
        $this->db->where('majors_status', '1');
        
        $this->db->select('student_id, student_full_name, student_nis');
        $this->db->select('class_id, class_name');
        $this->db->select('majors_id, majors_short_name, majors_name');
        $this->db->select('period_id');
		$this->db->select('SUM(pulang_days) AS pulangSum');
		
		$this->db->join('student', 'student.student_id = pulang.pulang_student_id', 'left');
		
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('period', 'period.period_id = pulang.pulang_period_id', 'left');

		$res = $this->db->get('pulang');

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
