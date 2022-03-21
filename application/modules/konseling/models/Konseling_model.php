<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konseling_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('konseling_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('konseling_period_id', $params['period_id']);
		}

		if (isset($params['date'])) {
			$this->db->where('konseling_date', $params['date']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('konseling_student_id', $params['student_id']);
		}
        
        if($this->session->userdata('umajorsid') != '0')
        {
            $this->db->where('majors_id', $this->session->userdata('umajorsid'));
        }
		
		if(isset($params['order_by'])){
		    $this->db->order_by($params['order_by'], 'desc');
		}else{
		    $this->db->order_by('konseling_id', 'desc');
		}
        $this->db->where('majors_status', '1');

		$this->db->select('konseling_id, konseling_period_id, konseling_date, konseling_foul, konseling_action, konseling_poin, konseling_note');
		
		$this->db->join('student', 'student.student_id = konseling.konseling_student_id', 'left');
		
		$this->db->join('period', 'period.period_id = konseling.konseling_period_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('users', 'users.user_id = konseling.konseling_user_id', 'left');

		$res = $this->db->get('konseling');

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

		if(isset($data['konseling_id'])) {
			$this->db->set('konseling_id', $data['konseling_id']);
		}

		if(isset($data['konseling_date'])) {
			$this->db->set('konseling_date', $data['konseling_date']);
		}

		if(isset($data['konseling_period_id'])) {
			$this->db->set('konseling_period_id', $data['konseling_period_id']);
		}

		if(isset($data['konseling_foul'])) {
			$this->db->set('konseling_foul', $data['konseling_foul']);
		}

		if(isset($data['konseling_action'])) {
			$this->db->set('konseling_action', $data['konseling_action']);
		}

		if(isset($data['konseling_poin'])) {
			$this->db->set('konseling_poin', $data['konseling_poin']);
		}

		if(isset($data['konseling_note'])) {
			$this->db->set('konseling_note', $data['konseling_note']);
		}

		if(isset($data['konseling_student_id'])) {
			$this->db->set('konseling_student_id', $data['konseling_student_id']);
		}

		if(isset($data['konseling_user_id'])) {
			$this->db->set('konseling_user_id', $data['konseling_user_id']);
		}

		if (isset($data['konseling_id'])) {
			$this->db->where('konseling_id', $data['konseling_id']);
			$this->db->update('konseling');
			$id = $data['konseling_id'];
		} else {
			$this->db->insert('konseling');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete konseling to database
	function delete($id) {
		$this->db->where('konseling_id', $id);
		$this->db->delete('konseling');
	}
	
	function get_sum($params = array()){
	    if(isset($params['id']))
		{
			$this->db->where('konseling_id', $params['id']);
		}

		if (isset($params['period_id'])) {
			$this->db->where('konseling_period_id', $params['period_id']);
		}

		if (isset($params['student_id'])) {
			$this->db->where('konseling_student_id', $params['student_id']);
		}
        
        $this->db->group_by('konseling_student_id');
		
        $this->db->where('majors_status', '1');
        
        $this->db->select('student_id, student_full_name, student_nis');
        $this->db->select('class_id, class_name');
        $this->db->select('majors_id, majors_short_name, majors_name');
        $this->db->select('period_id');
		$this->db->select('SUM(konseling_poin) AS konselingSum');
		
		$this->db->join('student', 'student.student_id = konseling.konseling_student_id', 'left');
		
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
		
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
		
        $this->db->join('period', 'period.period_id = konseling.konseling_period_id', 'left');

		$res = $this->db->get('konseling');

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
